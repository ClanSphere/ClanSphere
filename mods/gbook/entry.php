<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gbook');

$cs_post = cs_post('id,from');
$cs_get = cs_get('id,from');
$data = array();

$from = 'list';
$id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $id = $cs_post['id'];
if(!empty($_POST['from'])) $from = $_POST['from'];
elseif(!empty($_GET['from'])) $from = $_GET['from'];
$from = cs_secure($from, 0, 0, 0, 0, 0); 

$cs_options = cs_sql_option(__FILE__,'gbook');
$users_id = $account['users_id'];
$error = '';

$ip = cs_getip();

//check if user exists
if($id != 0) {
  $users_check = cs_sql_count(__FILE__,'users',"users_id = '" . (int) $id . "'");
  if(empty($users_check)) {
    cs_redirect($cs_lang['user_not_exist'],'gbook','list');
  }
  if($users_id == 0) {
    $error .= $cs_lang['error_login'] . cs_html_br(1);
  }
}

//check last own
if(empty($account['users_id'])) {
    $last_entry = cs_sql_select(__FILE__,'gbook','gbook_ip, users_id',"gbook_users_id = '" . (int) $id . "'",'gbook_id DESC');
    if ($last_entry['gbook_ip'] == $ip && empty($last_entry['users_id'])) {
      $error .= $cs_lang['last_own'] . cs_html_br(1);
    }
} 
else {
    $last_entry = cs_sql_select(__FILE__,'gbook','users_id',"gbook_users_id = '" . (int) $id . "'",'gbook_id DESC');
    if ($last_entry['users_id'] == $account['users_id']) {
      $error .= $cs_lang['last_own'] . cs_html_br(1);
    }
}

//check flood
$flood = cs_sql_select(__FILE__,'gbook','gbook_time',"users_id = '" . (int) $users_id . "'",'gbook_time DESC');
$maxtime = $flood['gbook_time'] + $cs_main['def_flood'];
if ($maxtime > cs_time()) {
  $diff = $maxtime - cs_time();
  $error .= sprintf($cs_lang['flood_on'], $diff) . cs_html_br(1);
}

//if error -> redirect
if (!empty($error)) {
  if(empty($id)) {
    cs_redirect($error,'gbook','list');
  } else {
    cs_redirect($error,'gbook','users','id=' . $id);
  }
}

$data['tpl']['preview'] = '';
$data['tpl']['extension'] = '';
$data['tpl']['captcha'] = '';

if(empty($users_id))
  $data['if']['guest'] = TRUE;

if(empty($users_id) OR !empty($cs_options['captcha_users'])) {
  $captcha = extension_loaded('gd') ? 1 : 0;
  $data['if']['captcha'] = TRUE;
}

$cs_gbook['gbook_nick'] = '';
$cs_gbook['gbook_email'] = '';
$cs_gbook['gbook_icq'] = '';
$cs_gbook['gbook_jabber'] = '';
$cs_gbook['gbook_skype'] = '';
$cs_gbook['gbook_url'] = '';
$cs_gbook['gbook_town'] = '';
$cs_gbook['gbook_text'] = '';

if(isset($_POST['submit']) OR isset($_POST['preview'])) {

  $g_error = '';

  //if guest
  if(empty($users_id)) {
    $cs_gbook['gbook_nick'] = $_POST['gbook_nick'];
    $cs_gbook['gbook_email'] = $_POST['gbook_email'];
    $cs_gbook['gbook_jabber'] = $_POST['gbook_jabber'];
    $cs_gbook['gbook_icq'] = $_POST['gbook_icq'];
    $cs_gbook['gbook_skype'] = $_POST['gbook_skype'];
    $cs_gbook['gbook_town'] = $_POST['gbook_town'];
    $cs_gbook['gbook_url'] = $_POST['gbook_url'];
    
    //check nick if exists or empty
    if (!empty($cs_gbook['gbook_nick'])) {
      $exists_user = cs_sql_select(__FILE__,'users','users_nick',"users_nick = '" . cs_sql_escape($cs_gbook['gbook_nick']) . "'");
      
      if(!empty($exists_user)) {
        $g_error .= $cs_lang['error_exist_nick'] . cs_html_br(1);
      }
    } else {
      $g_error .= $cs_lang['error_nick'] . cs_html_br(1);
    }
    
    //check email if exists, chars or empty
    if (!empty($cs_gbook['gbook_email'])) {
      $exists_user = cs_sql_select(__FILE__,'users','users_email',"users_email = '" . cs_sql_escape($_POST['gbook_email']) . "'");
    
      if(!empty($exists_user)) {
        $g_error .= $cs_lang['error_exist_email'] . cs_html_br(1);
      }
      $pattern = "/^[0-9a-zA-Z._\\-]+@[0-9a-zA-Z._\\-]{2,}\\.[a-zA-Z]{2,4}\$/";
      if(!preg_match($pattern,$cs_gbook['gbook_email'])) {
        $g_error .= $cs_lang['error_email'] . cs_html_br(1);
      }
    } else {
      $g_error .= $cs_lang['error_email'] . cs_html_br(1);
    }
    
    //check jabber
    if (!empty($cs_gbook['gbook_jabber'])) {
      $pattern = "/^[0-9a-zA-Z._\\-]+@[0-9a-zA-Z._\\-]{2,}\\.[a-zA-Z]{2,4}\$/";
      if(!preg_match($pattern,$cs_gbook['gbook_jabber'])) {
        $g_error .= $cs_lang['error_jabber'] . cs_html_br(1);
      }
    }
    
    //check icq
    if (!empty($cs_gbook['gbook_icq'])) {
      $pattern = '#^[\d-]*$#';
      if (!preg_match($pattern,$cs_gbook['gbook_icq'])) {
        $g_error .= $cs_lang['error_icq'] . cs_html_br(1);
      }
    }

    //check url
    if (!empty($cs_gbook['gbook_url'])) {
      $pattern = "=.[a-z0-9].[a-z0-9]=si";
      if(!preg_match($pattern,$cs_gbook['gbook_url'])) {
        $g_error .= $cs_lang['error_url'] . cs_html_br(1);
      }
    }
  }
  else {
    //if user
    $select = 'users_nick, users_email, users_icq, users_jabber, users_skype, users_place, users_url';
    $cs_user = cs_sql_select(__FILE__,'users',$select,"users_id = '" . (int) $users_id . "'");

    $cs_gbook['gbook_nick'] = $cs_user['users_nick'];
    $cs_gbook['gbook_email'] = $cs_user['users_email'];
    $cs_gbook['gbook_icq'] = $cs_user['users_icq'];
    $cs_gbook['gbook_jabber'] = $cs_user['users_jabber'];
    $cs_gbook['gbook_skype'] = $cs_user['users_skype'];
    $cs_gbook['gbook_url'] = $cs_user['users_url'];
    $cs_gbook['gbook_town'] = $cs_user['users_place'];
  }
  
    //captcha
	if(empty($users_id) OR !empty($cs_options['captcha_users'])) {
	
		if (!cs_captchacheck($_POST['captcha'])) {
		  $g_error .= $cs_lang['captcha_false'] . cs_html_br(1);
		}
	}

  $cs_gbook['gbook_time'] = cs_time();
  $cs_gbook['gbook_ip'] = $ip;
  $cs_gbook['gbook_text'] = $_POST['gbook_text'];

  //check text (min figures and resize img)
  if (!empty($cs_gbook['gbook_text'])) {
    if(strlen($cs_gbook['gbook_text']) < 30) {
      $g_error .= $cs_lang['error_to_short'] . cs_html_br(1);
    }
      $cs_gbook['gbook_text'] = preg_replace_callback("=\[img\](.*?)\[/img\]=si","cs_abcode_resize",$cs_gbook['gbook_text']);
      $cs_gbook['gbook_text'] = preg_replace_callback("=\[img width\=(.*?) height\=(.*?)\](.*?)\[/img\]=si","cs_abcode_resize",$cs_gbook['gbook_text']);
  } else {
    $g_error .= $cs_lang['no_text'] . cs_html_br(1);
  }
}

$data['head']['body'] = $cs_lang['preview'];
if(!isset($_POST['submit']) && !isset($_POST['preview']))
  $data['head']['body'] = $cs_lang['body_create'];
elseif(!empty($g_error))
  $data['head']['body'] = $g_error;

//preview
if (isset($_POST['preview']) AND empty($g_error)) {
  
  $where_user = !empty($id) ? "gbook_users_id = '" . (int) $id . "'" : 0;
  $count_entry = cs_sql_count(__FILE__,'gbook',$where_user);

  $data['gbook']['entry_count'] = $count_entry + 1;
  $data['gbook']['users_nick'] = $cs_gbook['gbook_nick'];
  $data['gbook']['icon_town'] = empty($cs_gbook['gbook_town']) ? '' : cs_icon('gohome');
  $data['gbook']['town'] = empty($cs_gbook['gbook_town']) ? '' : cs_secure($cs_gbook['gbook_town']);
  $data['gbook']['icon_mail'] = cs_html_link('mailto:' . $cs_gbook['gbook_email'],cs_icon('mail_generic'));
   $icq = cs_html_link('http://www.icq.com/people/' . $cs_gbook['gbook_icq'],cs_icon('licq'));
  $data['gbook']['icon_icq'] = empty($cs_gbook['gbook_icq']) ? '' : $icq;
   $jabber = cs_html_jabbermail($cs_gbook['gbook_jabber'],cs_icon('jabber_protocol'));
  $data['gbook']['icon_jabber'] = empty($cs_gbook['gbook_jabber']) ? '' : $jabber;
   $url = 'http://mystatus.skype.com/smallicon/' . $cs_gbook['gbook_skype'];
   $skype = cs_html_link('skype:' . $cs_gbook['gbook_skype'] . '?userinfo',cs_html_img($url,'16','16','0','Skype'),'0');
  $data['gbook']['icon_skype'] = empty($cs_gbook['gbook_skype']) ? '' : $skype;
   $url = cs_html_link('http://' . $cs_gbook['gbook_url'],cs_icon('gohome'));
  $data['gbook']['icon_url'] = empty($cs_gbook['gbook_url']) ? '' : $url;
  $data['gbook']['text'] = cs_secure($cs_gbook['gbook_text'],1,1);
  $data['gbook']['time'] = cs_date('unix',$cs_gbook['gbook_time'],1);
  
  $data['tpl']['preview'] = cs_subtemplate(__FILE__,$data,'gbook','preview');
}

if(!empty($g_error) OR !isset($_POST['submit']) OR isset($_POST['preview'])) {

  foreach($cs_gbook AS $key => $value)
    $data['gbook'][$key] = cs_secure($value);

  if(empty($users_id))
    $data['tpl']['extension'] = cs_subtemplate(__FILE__,$data,'gbook','extension');

  if(empty($users_id) OR !empty($cs_options['captcha_users'])) {
    
    if(!empty($captcha)) {
      $data['captcha']['img'] = cs_html_img('mods/captcha/generate.php?time=' . cs_time());
      $data['tpl']['captcha'] = cs_subtemplate(__FILE__,$data,'gbook','captcha');
    }
  }

  $data['abcode']['smileys'] = cs_abcode_smileys('gbook_text');
  $data['abcode']['features'] = cs_abcode_features('gbook_text');

  $data['gbook']['id'] = $id;
  $data['gbook']['from'] = $from;
  
 echo cs_subtemplate(__FILE__,$data,'gbook','entry');
} 
else {

  $cs_gbook['users_id'] = $account['users_id'];
  $cs_gbook['gbook_users_id'] = $id;
  $cs_gbook['gbook_lock'] = empty($cs_options['lock']) ? 1 : 0;
  
  if(!empty($account['users_id'])) {
    unset($cs_gbook['gbook_ip']);
  }

  $cells = array_keys($cs_gbook);
  $save = array_values($cs_gbook);
  cs_sql_insert(__FILE__,'gbook',$cells,$save);
  require_once('mods/notifymods/functions.php');
  notifymods_mail('gbook', $account['users_id']);
  
  $msg = empty($cs_options['lock']) ? $cs_lang['create_done'] : $cs_lang['create_done_lock'];
  if(empty($id)) {
    cs_redirect($msg,'gbook',$from);
  } else {
    cs_redirect($msg,'gbook','users','id=' . $id);
  }
}