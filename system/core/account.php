<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

global $_COOKIE, $_POST, $cs_lang, $cs_main, $login;

$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

$login = array('mode' => FALSE, 'error' => '', 'cookie' => 0);
$account = array('users_id' => 0);

# Send cookie only by http protocol (available in PHP 5.2.0 or higher)
if(version_compare(PHP_VERSION,'5.2.0','>'))
  session_set_cookie_params(0,$cs_main['cookie']['path'],$cs_main['cookie']['domain'],FALSE,TRUE);
else
  session_set_cookie_params(0,$cs_main['cookie']['path'],$cs_main['cookie']['domain']);
session_start();

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
    $login_where = "users_nick = '" . cs_sql_escape($login['nick']) . "'";
  }
  elseif(isset($_COOKIE['cs_userid']) AND isset($_COOKIE['cs_securepw'])) {
    $login['method'] = 'cookie';
    $login['userid'] = (int)$_COOKIE['cs_userid'];
    $login['securepw'] = $_COOKIE['cs_securepw'];
    $login_where = "users_id = '" . $login['userid'] . "'";
  }

  if(isset($login['method'])) {
    $login_db = cs_sql_select(__FILE__,'users','users_id, users_pwd, users_active, users_ajax',$login_where);
    if(!empty($login_db['users_pwd']) AND $login_db['users_pwd'] == $login['securepw']) { 
      if(empty($login_db['users_active']) || !empty($login_db['users_delete'])) {
        $login['error'] = 'closed'; 
      }
      else {
        $login['mode'] = TRUE;

        $_SESSION['users_id'] = $login_db['users_id'];
        $_SESSION['users_ip'] = cs_getip();
        $_SESSION['users_agent'] = $user_agent;
        $_SESSION['users_pwd'] = $login['securepw'];
        if (!empty($login_db['users_ajax']) && !empty($cs_main['ajax']))
          empty($cs_main['mod_rewrite']) ? header('Location: index.php') : header('Location: ../../index.php');
      }
    }
    elseif(!empty($login_db['users_id'])) { 
      $login['error'] = 'wrong_pwd';
    }
    else {
      $login['error'] = 'user_notfound';
    }

    if(!empty($login['cookie']) AND !empty($login['mode'])) {
      $login['method'] = 'form_cookie';
      setcookie('cs_userid',$login_db['users_id'], $cs_main['cookie']['lifetime'], $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
      setcookie('cs_securepw',$login['securepw'], $cs_main['cookie']['lifetime'], $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
    }
  }
}

if(!empty($_SESSION['users_id'])) {

  if (empty($login['method'])) $login['method'] = 'session';
  $login['mode'] = TRUE;
  $acc_sc = 'users_id, users_nick, users_lang, access_id, users_limit, users_view, users_timezone, users_dstime, users_ajax, users_tpl, users_pwd';
  $account = cs_sql_select(__FILE__, 'users', $acc_sc, "users_id = '" . (int) $_SESSION['users_id'] . "' AND users_active = 1 AND users_delete = 0");
  if (empty($account) OR ($account['users_pwd'] != $_SESSION['users_pwd'])) {
    session_destroy();
    $login['mode'] = FALSE;
    $account = array('users_id' => 0);
  }
  if (empty($cs_main['ajax'])) $account['users_ajax'] = 0;
}

if(!empty($_COOKIE['cs_userid'])) {
  setcookie('cs_userid',$account['users_id'], $cs_main['cookie']['lifetime'], $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
  setcookie('cs_securepw',array_pop($account), $cs_main['cookie']['lifetime'], $cs_main['cookie']['path'], $cs_main['cookie']['domain']);  
}
if(!empty($account['users_id'])) {
  if($_SESSION['users_ip'] != cs_getip() OR $_SESSION['users_agent'] != $user_agent) {
    session_destroy();
    $login['mode'] = FALSE;
  }
  elseif($cs_main['mod']=='users' AND $cs_main['action']=='logout') {
    setcookie('cs_userid', '', 1, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
    setcookie('cs_securepw', '', 1, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
    session_destroy();
    $login['mode'] = FALSE;
    if (!empty($account['users_ajax']) AND !empty($cs_main['ajax'])) die(ajax_js('window.location.reload()'));
  }
  else {
    $cells = array('users_laston');
    $content = array(cs_time());
    cs_sql_update(__FILE__,'users',$cells,$content,$account['users_id']);
  }
}
else {
  $account = array('access_id' => 1, 'users_id' => 0, 'users_lang' => $cs_main['def_lang'], 'users_limit' => $cs_main['data_limit'], 'users_timezone' => $cs_main['def_timezone'], 'users_dstime' => $cs_main['def_dstime']);
}

$gma = cs_sql_select(__FILE__,'access','*','access_id = "' . (int) $account['access_id'] . '"', 0,0,1, 'access_' . $account['access_id']);
if(is_array($gma))
  $account = array_merge($account,$gma);

if(empty($cs_main['maintenance_access']))
  $cs_main['maintenance_access'] = 3;

if(empty($cs_main['public']) AND !empty($account['users_id']) AND $account['access_clansphere'] < $cs_main['maintenance_access']) {
  setcookie('cs_userid', '', 1, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
  setcookie('cs_securepw', '', 1, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
  session_destroy();
  $login['mode'] = FALSE;
  $login['error'] = 'not_public'; 
}