<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_login_cookies($userid = 0, $use_old_hash = 0) {

  global $account, $cs_main;
  $lifetime = empty($userid) ? 1 : $cs_main['cookie']['lifetime'];
  $thistime = empty($userid) ? '' : cs_time();
  $thishash = empty($use_old_hash) ? '' : $use_old_hash;

  if(!empty($userid) AND empty($use_old_hash)) {
    $pattern = '1234567890abcdefghijklmnpqrstuvwxyz';
    for($i=0;$i<34;$i++) { $thishash .= $pattern{rand(0,34)}; }

    $cells = array('users_cookietime', 'users_cookiehash');
    $content = array($thistime, $thishash);
    cs_sql_update(__FILE__,'users',$cells,$content,$userid, 0, 0);
  }
  elseif(!empty($userid) AND $use_old_hash == true) {
    $thistime = $account['users_cookietime'];
    $thishash = $account['users_cookiehash'];

    if(empty($thistime) OR empty($thishash)) {
      cs_login_cookies($userid);
      return true;
    }
  }

  setcookie('cs_userid', $userid, $lifetime, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
  setcookie('cs_cookietime', $thistime, $lifetime, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
  setcookie('cs_cookiehash', $thishash, $lifetime, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
}

global $cs_lang, $cs_main, $login;

$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

$login   = array('mode' => FALSE, 'error' => '', 'cookie' => 0);
$noacc   = array('users_id' => 0, 'users_pwd' => '', 'users_cookiehash' => '', 'users_cookietime' => 0);
$account = $noacc;

# Send cookie only by http protocol (available in PHP 5.2.0 or higher)
if(version_compare(phpversion(),'5.2.0','>'))
  session_set_cookie_params(0,$cs_main['cookie']['path'],$cs_main['cookie']['domain'],FALSE,TRUE);
else
  session_set_cookie_params(0,$cs_main['cookie']['path'],$cs_main['cookie']['domain']);

session_name('cs' . md5($cs_main['cookie']['domain'])); 
session_start();

# xsrf protection
if($cs_main['xsrf_protection']===TRUE && !empty($_POST)) {
  $needed_keys = isset($_SESSION['cs_xsrf_keys']) ? $_SESSION['cs_xsrf_keys'] : array();
  $given_key = isset($_POST['cs_xsrf_key']) ? $_POST['cs_xsrf_key'] : '';
  if(empty($given_key) || !in_array($given_key, $needed_keys)) {
    $_SESSION['cs_xsrf_keys'] = array();
    $referer = empty($_SERVER['HTTP_REFERER']) ? 'empty' : $_SERVER['HTTP_REFERER'];

    if(!empty($cs_main['developer']))
      cs_error(__FILE__, 'XSRF Protection triggered: Array(' . implode(', ', $needed_keys) . ') does not include "' . $given_key . '", Referer: ' . $referer);

    cs_redirect(false, $cs_main['def_mod'], $cs_main['def_action']);
  }
}

if(empty($_SESSION['users_id'])) {

  if(isset($_POST['login'])) {
    $login['method'] = 'form';
    $login['nick'] = $_POST['nick'];
    $login['password'] = $_POST['password'];
    if($cs_db['hash']=='md5') {
      $login['securepw'] = md5($login['password']);
    }
    if($cs_db['hash']=='sha1') {
      $login['securepw'] = sha1($login['password']);
    }
    if(isset($_POST['cookie'])) {
      $login['cookie'] = $_POST['cookie'];
    }
    $data['options'] = cs_sql_option(__FILE__,'users');
    $login_where = "users_nick = '" . cs_sql_escape($login['nick']) . "'";
    if($data['options']['login'] == 'email') {
      $login_where = "users_email = '" . cs_sql_escape($login['nick']) . "'";
    }
  }
  elseif(isset($_COOKIE['cs_userid']) AND isset($_COOKIE['cs_cookietime']) AND isset($_COOKIE['cs_cookiehash'])) {
    $login['method'] = 'cookie';
    $login['userid'] = (int) $_COOKIE['cs_userid'];
    $login['cookietime'] = (int) $_COOKIE['cs_cookietime'];
    $login['cookiehash'] = $_COOKIE['cs_cookiehash'];
    $login_where = 'users_id = ' . (int) $login['userid'];
  }

  if(isset($login['method'])) {
    $login_db = cs_sql_select(__FILE__,'users','*',$login_where);

    if(!empty($login_db['users_pwd']) AND ($login['method'] == 'cookie' OR $login_db['users_pwd'] == $login['securepw'])) {
      if(empty($login_db['users_active']) || !empty($login_db['users_delete']))
        $login['error'] = 'closed'; 
      elseif($login['method'] == 'cookie' AND ($login['cookietime'] < $login_db['users_cookietime'] OR $login['cookietime'] > cs_time()))
        $login['error'] = 'user_login_notfound';
      elseif($login['method'] == 'cookie' AND $login_db['users_cookiehash'] != $login['cookiehash'])
        $login['error'] = 'user_login_notfound';
      else {
        $login['mode'] = TRUE;

        $_SESSION['users_id'] = $login_db['users_id'];
        $_SESSION['users_ip'] = cs_getip();
        $_SESSION['users_agent'] = $user_agent;
        $_SESSION['users_pwd'] = $login_db['users_pwd'];
      }
    }
    elseif(!empty($login_db['users_id']))
      $login['error'] = 'user_login_notfound';
    else
      $login['error'] = 'user_login_notfound';

    if(!empty($login['cookie']) AND !empty($login['mode'])) {
      $login['method'] = 'form_cookie';
      cs_login_cookies($login_db['users_id'], true);
    }
  session_regenerate_id(session_id());
    unset($login_db);
  }
}

if(!empty($_SESSION['users_id'])) {

  if (empty($login['method'])) $login['method'] = 'session';
  $login['mode'] = TRUE;

  $acc_wr = 'users_id = ' . (int) $_SESSION['users_id'] . ' AND users_active = 1 AND users_delete = 0';
  $account = cs_sql_select(__FILE__, 'users', '*', $acc_wr);
  if (empty($account) OR ($account['users_pwd'] != $_SESSION['users_pwd'])) {
    session_destroy();
    $login['mode'] = FALSE;
    $account = $noacc;
  }
  if (empty($cs_main['ajax'])) $account['users_ajax'] = 0;
}

if(isset($_COOKIE['cs_userid'])) {
  # refresh cookie lifetime after a while
  if(isset($_COOKIE['cs_cookiehash']) AND isset($_COOKIE['cs_cookietime']) AND $_COOKIE['cs_cookietime'] < ($cs_main['cookie']['lifetime'] - 43200))
    cs_login_cookies($_COOKIE['cs_userid'], $_COOKIE['cs_cookiehash']);

  # empty old and bad cookie data
  if(empty($_COOKIE['cs_cookiehash']) OR $_COOKIE['cs_cookiehash'] != $account['users_cookiehash'])
    cs_login_cookies();
}

$time = cs_time();
if(!empty($account['users_id'])) {
  if($_SESSION['users_ip'] != cs_getip() OR $_SESSION['users_agent'] != $user_agent) {
    session_destroy();
    $login['mode'] = FALSE;
  }
  elseif($cs_main['mod'] == 'users' AND $cs_main['action'] == 'logout') {
    cs_login_cookies();
    session_destroy();
    $login['mode'] = FALSE;
  }
  elseif($time > ($account['users_laston'] + 30)) {
    $cells = array('users_laston');
    $content = array($time);
    cs_sql_update(__FILE__,'users',$cells,$content,$account['users_id'], 0, 0);
  }
}
else
  $account = array('access_id' => 1, 'users_id' => 0, 'users_lang' => $cs_main['def_lang'], 'users_limit' => $cs_main['data_limit'],
                   'users_timezone' => $cs_main['def_timezone'], 'users_dstime' => $cs_main['def_dstime'], 'access_clansphere' => 0);

$gma = cs_sql_select(__FILE__,'access','*','access_id = ' . (int) $account['access_id'], 0,0,1, 'access_' . $account['access_id']);
if(is_array($gma))
  $account = array_merge($account,$gma);

if(empty($cs_main['maintenance_access']))
  $cs_main['maintenance_access'] = 3;

if(empty($cs_main['public']) AND !empty($account['users_id']) AND $account['access_clansphere'] < $cs_main['maintenance_access']) {
  cs_login_cookies();
  session_destroy();
  $login['mode'] = FALSE;
  $login['error'] = 'not_public'; 
}

if($account['users_limit'] < 0) $account['users_limit'] = $cs_main['data_limit'];
unset($account['users_pwd'], $account['users_cookiehash'], $account['users_cookietime']);