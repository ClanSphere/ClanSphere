<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

global $_COOKIE, $_POST, $cs_lang_main, $login; 

$domain = (strpos($_SERVER['HTTP_HOST'], '.') !== FALSE) ? $_SERVER['HTTP_HOST'] : '';
$cookie = array('lifetime' => (cs_time() + 2592000), 'path' => '/', 'domain' => $domain);

$login = array('mode' => FALSE, 'error' => '', 'cookie' => 0);
$account = array('users_id' => 0);

if(version_compare(PHP_VERSION,'5.2.0','>')) {
  # Send cookie only by http protocol (available in PHP 5.2.0 or higher)
  session_set_cookie_params(0,$cookie['path'],$cookie['domain'],FALSE,TRUE);
} else {
  session_set_cookie_params(0,$cookie['path'],$cookie['domain']);
}
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
      if(empty($login_db['users_active'])) {
        $login['error'] = 'closed'; 
      }
      else {
        $login['mode'] = TRUE;
     
        $_SESSION['users_id'] = $login_db['users_id'];
        $_SESSION['users_ip'] = cs_getip();
        $_SESSION['users_agent'] = $_SERVER['HTTP_USER_AGENT'];
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
      setcookie('cs_userid',$login_db['users_id'], $cookie['lifetime'], $cookie['path'], $cookie['domain']);
      setcookie('cs_securepw',$login['securepw'], $cookie['lifetime'], $cookie['path'], $cookie['domain']);
    }
  }
}

if(!empty($_SESSION['users_id'])) {

  if (empty($login['method'])) $login['method'] = 'session';
  $login['mode'] = TRUE;
  $acc_sc = 'users_id, users_nick, users_lang, access_id, users_limit, users_view, users_timezone, users_dstime, users_ajax, users_tpl, users_pwd';
  $account = cs_sql_select(__FILE__,'users',$acc_sc,'users_id = \'' . (int)$_SESSION['users_id'] . '\' AND users_pwd = \''.$_SESSION['users_pwd'].'\' AND users_active = 1');
  if (empty($account) ) {
    session_destroy();
    $login['mode'] = FALSE;
  }
  if (empty($cs_main['ajax'])) $account['users_ajax'] = 0;
}

if(!empty($_COOKIE['cs_userid'])) { 
  setcookie('cs_userid',$account['users_id'], $cookie['lifetime'], $cookie['path'], $cookie['domain']);
  setcookie('cs_securepw',array_pop($account), $cookie['lifetime'], $cookie['path'], $cookie['domain']);  
}
if(!empty($account['users_id'])) { 
  if($_SESSION['users_ip'] != cs_getip() OR $_SESSION['users_agent'] != $_SERVER['HTTP_USER_AGENT']) {
    session_destroy();
    $login['mode'] = FALSE;
  }
  elseif($cs_main['mod']=='users' AND $cs_main['action']=='logout') {
    setcookie('cs_userid', '', 1, $cookie['path'], $cookie['domain']);
    setcookie('cs_securepw', '', 1, $cookie['path'], $cookie['domain']);
    session_destroy();
    $login['mode'] = FALSE;
    if (!empty($account['users_ajax'])) ajax_js('window.location.reload()');;
  }
  else {
    $cells = array('users_laston');
    $content = array(cs_time());
    cs_sql_update(__FILE__,'users',$cells,$content,$account['users_id']);
  }
}
else {
  $account = array('access_id' => 1, 'users_id' => 0, 'users_lang' => $cs_main['def_lang'], 'users_limit' => 20, 'users_timezone' => $cs_main['def_timezone'], 'users_dstime' => $cs_main['def_dstime']);
}

if(!empty($_GET['lang']) OR empty($account['users_id']) AND !empty($_COOKIE['cs_lang'])) {

  $languages = cs_checkdirs('lang');
  $cookie_lang = empty($_COOKIE['cs_lang']) ? '' : $_COOKIE['cs_lang'];
  $cs_user['users_lang'] = empty($_GET['lang']) ? $cookie_lang : $_GET['lang'];
  $allow = 0;

  foreach($languages as $mod) {
    if($mod['dir'] == $cs_user['users_lang']) { $allow++; }
  }
  $cs_user['users_lang'] = empty($allow) ? $cs_main['def_lang'] : $cs_user['users_lang'];

  if(empty($account['users_id']) AND $cookie_lang != $cs_user['users_lang']) {
    setcookie('cs_lang',$cs_user['users_lang'], $cookie['lifetime'], $cookie['path'], $cookie['domain']);
  }
  elseif(!empty($account['users_id']) AND $account['users_lang'] != $cs_user['users_lang']) {
    $users_cells = array_keys($cs_user);
    $users_save = array_values($cs_user);
    cs_sql_update(__FILE__,'users',$users_cells,$users_save,$account['users_id']);
  }
  $account['users_lang'] = $cs_user['users_lang'];
}

$lang = empty($account['users_lang']) ? 'English' : $account['users_lang'];
require_once('lang/' . $lang . '/system/comlang.php');

$gma = cs_sql_select(__FILE__,'access','*',"access_id = " . (int)$account['access_id']);
if(is_array($gma)) {
  $account = array_merge($account,$gma);
}

if(empty($cs_main['public']) AND !empty($account['users_id']) AND $account['access_clansphere'] < 3) {
    setcookie('cs_userid', '', 1, $cookie['path'], $cookie['domain']);
    setcookie('cs_securepw', '', 1, $cookie['path'], $cookie['domain']);
    session_destroy();
    $login['mode'] = FALSE;
    $login['error'] = 'not_public'; 
}

$cs_lang_main = cs_translate();

?>