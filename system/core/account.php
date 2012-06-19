<?php
// ClanSphere 2010 - www.clansphere.net
// Andrew Tajsic 2012 - www.atajsic.com
// $Id$

global $cs_lang, $cs_main, $login;

$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

$login   = array('mode' => FALSE, 'error' => '', 'cookie' => 0);
$noacc   = array('users_id' => 0, 'users_pwd' => '');
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

//Removal of all cookies > 30 days old.
$remove_time = time() - 2592000;
$remove_query = "DELETE FROM {pre}_sessions WHERE sessions_cookietime < " . $remove_time;
cs_sql_query(__FILE__, $remove_query);


//If there is no current session
if(empty($_SESSION['users_id'])) {
	
  //If a user has submitted a login form
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
  //Else If there is a saved cookie...
  elseif(isset($_COOKIE['cs_userid']) AND isset($_COOKIE['cs_cookietime']) AND isset($_COOKIE['cs_cookiehash'])) {
    $login['method'] = 'cookie';
    $login['userid'] = (int) cs_secure($_COOKIE['cs_userid']);
    $login['cookietime'] = (int) cs_secure($_COOKIE['cs_cookietime']);
    $login['cookiehash'] = cs_secure($_COOKIE['cs_cookiehash']);
    $login_where = 'users_id = ' . (int) $login['userid'];
  }



  //One of the past if statements passed thus...
  if(isset($login['method'])) {
    $login_db = cs_sql_select(__FILE__,'users','*',$login_where);
	
	$session_db = array();
	$session_db_count = 0;
	if($login['method'] == 'cookie'){
		$session_where = "users_id = " . (int) $login['userid'] . " AND sessions_cookiehash = '" . $login['cookiehash'] . "'";
		$session_db = cs_sql_select(__FILE__,'sessions','*',$session_where);
		$session_db_count = cs_sql_count(__FILE__, 'sessions', $session_where);
		//if the stored IP differs to the current IP - update the cookie.
		if($session_db['sessions_ip'] != cs_getip()){
			cs_cookies_update($login['userid'], $login['cookiehash']);
		}
	}
	
    if(!empty($login_db['users_pwd']) AND ($login['method'] == 'cookie' OR $login_db['users_pwd'] == $login['securepw'])) {
	  //ensure user is active.
      if(empty($login_db['users_active']) || !empty($login_db['users_delete']))
        $login['error'] = 'closed'; 
	  //cookie checks
	  elseif($login['method'] == 'cookie' AND $session_db_count == 0){
	    $login['error'] = 'user_login_notfound';
		cs_cookies_null();
	  }
      elseif($login['method'] == 'cookie' AND ($login['cookietime'] != $session_db['sessions_cookietime'])){
		$login['error'] = 'user_login_notfound';
		cs_cookies_null();
	  }
      else {
        $login['mode'] = TRUE;
        $_SESSION['users_id'] = $login_db['users_id'];
        $_SESSION['users_ip'] = cs_getip();
        $_SESSION['users_agent'] = $user_agent;
        $_SESSION['users_pwd'] = $login_db['users_pwd'];
      }
    }
    else
      $login['error'] = 'user_login_notfound';
	
	//if the user has chosen to remember their login
    if(!empty($login['cookie']) AND !empty($login['mode'])) {
      $login['method'] = 'form_cookie';
      $hash = cs_cookies_newhash();
	  cs_cookies_create($login_db['users_id'], $hash);
    }
  session_regenerate_id(session_id());
    unset($login_db);
	unset($session_db);
  }
}




//If there IS a current session
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

//if there IS a current cookie
if(isset($_COOKIE['cs_userid'])) {
  //Refresh cookie time every 30 minutes.
  $time = cs_time() - 60*30;
  if(isset($_COOKIE['cs_cookiehash']) AND isset($_COOKIE['cs_cookietime']) AND ($_COOKIE['cs_cookietime'] < $time)){
	  $userid = cs_secure($_COOKIE['cs_userid']);
	  $hash = cs_secure($_COOKIE['cs_cookiehash']);
      cs_cookies_update($userid, $hash);
  }
}

$time = cs_time();
if(!empty($account['users_id'])) {
  if($_SESSION['users_ip'] != cs_getip() OR $_SESSION['users_agent'] != $user_agent) {
	  if(isset($_COOKIE['cs_userid']) AND isset($_COOKIE['cs_cookiehash']) AND isset($_COOKIE['cs_cookietime'])) {
		  $userid = cs_secure($_COOKIE['cs_userid']);
		  $hash = cs_secure($_COOKIE['cs_cookiehash']);
		  cs_cookies_update($userid, $hash);
	  }
    session_destroy(); //this doesn't log you out - just basically creates a new session with the correct IP.
    $login['mode'] = FALSE;
  }
  elseif($cs_main['mod'] == 'users' AND $cs_main['action'] == 'logout') {
	cs_cookies_null();
    if(isset($_COOKIE['cs_cookiehash'])){
		$hash = cs_secure($_COOKIE['cs_cookiehash']);
		cs_cookies_delete($account['users_id'], $hash);
	}
    session_destroy();
    $login['mode'] = FALSE;
  }
  //update user last on every 30 seconds.
  elseif($time > ($account['users_laston'] + 30)) {
    $cells = array('users_laston');
    $content = array($time);
    cs_sql_update(__FILE__,'users',$cells,$content,$account['users_id'], 0, 0);
  }
}
else
  $account = array('access_id' => 1, 'users_id' => 0, 'users_lang' => $cs_main['def_lang'], 'users_limit' => $cs_main['data_limit'],
                   'users_timezone' => $cs_main['def_timezone'], 'users_dstime' => $cs_main['def_dstime'], 'access_clansphere' => 0);

$gma = cs_sql_select(__FILE__,'access','*','access_id = "' . (int) $account['access_id'] . '"', 0,0,1, 'access_' . $account['access_id']);
if(is_array($gma))
  $account = array_merge($account,$gma);

if(empty($cs_main['maintenance_access']))
  $cs_main['maintenance_access'] = 3;

if(empty($cs_main['public']) AND !empty($account['users_id']) AND $account['access_clansphere'] < $cs_main['maintenance_access']) {
  session_destroy();
  $login['mode'] = FALSE;
  $login['error'] = 'not_public'; 
}

if($account['users_limit'] < 0) $account['users_limit'] = $cs_main['data_limit'];
unset($account['users_pwd']);

function cs_cookies_create($userid, $hash){
	global $cs_main;
	$lifetime = $cs_main['cookie']['lifetime'];
	$thistime = cs_time();
	$thisip = cs_getip();
	
	$cells = array('users_id', 'sessions_cookiehash', 'sessions_cookietime', 'sessions_ip');

	$content = array($userid, $hash, $thistime, $thisip);
	cs_sql_insert(__FILE__,'sessions',$cells,$content);
	
	setcookie('cs_userid', $userid, $lifetime, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
	setcookie('cs_cookietime', $thistime, $lifetime, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
	setcookie('cs_cookiehash', $hash, $lifetime, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
}

function cs_cookies_delete($userid, $hash){
	$query = "DELETE FROM {pre}_sessions WHERE users_id = " . $userid . " AND sessions_cookiehash = '" . $hash . "'";
	cs_sql_query(__FILE__, $query);
}

function cs_cookies_newhash(){
	$ret = "";
	$pattern = '1234567890abcdefghijklmnpqrstuvwxyz';
    for($i=0;$i<34;$i++) { $ret .= $pattern{rand(0,34)}; }
	return $ret;
}

function cs_cookies_update($userid, $hash){
	global $cs_main;
	$lifetime = $cs_main['cookie']['lifetime'];
	$thistime = cs_time();
	$thisip = cs_getip();
	
	$query = "UPDATE {pre}_sessions" .
	" SET sessions_cookietime = '" . $thistime . "', sessions_ip = '" . $thisip . "'" .
	" WHERE users_id = " . $userid . " AND sessions_cookiehash = '" . $hash . "'";
	cs_sql_query(__FILE__, $query);
	
	setcookie('cs_userid', $userid, $lifetime, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
	setcookie('cs_cookietime', $thistime, $lifetime, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
	setcookie('cs_cookiehash', $hash, $lifetime, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
	
}

function cs_cookies_null(){
	global $cs_main;
	$lifetime = time()-3600;
	setcookie('cs_userid', "", $lifetime, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
	setcookie('cs_cookietime', "", $lifetime, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
	setcookie('cs_cookiehash', "", $lifetime, $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
}