<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$cs_contact = cs_sql_option(__FILE__, 'contact');

$captcha = extension_loaded('gd') ? 1 : 0;

$checked = 0;
$success = 0;

$error = 0;
$errormsg= '';

if(isset($_POST['submit'])) {

  $sendpw['email'] = $_POST['email'];
  $sendpw['email_send'] = empty($_POST['email_send']) ? 0 : 1;
  
  if (empty($sendpw['email_send']) && !cs_captchacheck($_POST['captcha'])) {
    $error++;
    $errormsg .= $cs_lang['captcha_false'] . cs_html_br(1);
  }

  $search_email = cs_sql_count(__FILE__,'users',"users_email = '" . cs_sql_escape($sendpw['email']) . "'");
  if(empty($search_email)) {
    $error++;
    $errormsg .= $cs_lang['email_unknown'] . cs_html_br(1);
  }
  
  if(!empty($sendpw['email_send']) AND empty($error)) {
    $sendpw['key'] = $_POST['key'];
    $sendpw['new_pwd'] = $_POST['new_pwd'];
    $pwd2 = str_replace(' ','',$sendpw['new_pwd']);
    $pwdchars = strlen($pwd2);
    if($pwdchars<4) {
      $error++;
      $errormsg .= $cs_lang['short_pwd'] . cs_html_br(1);
    }
    $key2 = cs_sql_select(__FILE__,'users','users_pwd,users_id',"users_email = '" . cs_sql_escape($sendpw['email']) . "'");
    $key = substr($key2['users_pwd'],4,16);
    if($key != $sendpw['key']) {
      $error++;
      $errormsg .= $cs_lang['error_key'] . cs_html_br(1);
    }
    if(empty($error)) {
      
      global $cs_db;
      if($cs_db['hash'] == 'md5') { 
        $sec_pwd = md5($sendpw['new_pwd']);
      }
      elseif($cs_db['hash'] == 'sha1') { 
        $sec_pwd = sha1($sendpw['new_pwd']);
      }
      $cells = array('users_pwd');
      $content = array($sec_pwd);
      cs_sql_update(__FILE__,'users',$cells,$content,$key2['users_id']);
      $success = 1;
    }
    else {
      $checked = 1;
    }
  }
  elseif(empty($error)) {
    $checked = 1;
    $key2 = cs_sql_select(__FILE__,'users','users_pwd, users_nick',"users_email = '" . cs_sql_escape($sendpw['email']) . "'");
    $key = substr($key2['users_pwd'],4,16);

    $ip = cs_getip();
    $cs_contact = cs_sql_option(__FILE__, 'contact');
    $content = $cs_lang['mail_spw_start'] . $cs_contact['def_org'] . $cs_lang['mail_spw_start2'];
    $content .= $cs_lang['mail_spw_start3'];
    $content .= $cs_lang['mail_reg_nick'] . $key2['users_nick'];
    $content .= $cs_lang['mail_spw_key'] . $key;
    $content .= $cs_lang['mail_spw_ip'] . $ip;
    $content .= $cs_lang['mail_spw_ask'] . $cs_contact['def_mail'] . $cs_lang['mail_spw_end'];

    cs_mail($sendpw['email'],$cs_lang['mail_spw_head'],$content);
  }
}
else { 
  $sendpw['email'] = '';
}

$data['head']['mod'] = $cs_lang['mod_name'];
$data['head']['action'] = $cs_lang['sendpw'];

if(!isset($_POST['submit'])) {
  $data['head']['body_text'] = $cs_lang['sendpw_info'];
}
elseif(!empty($error)) {
  $data['head']['body_text'] = $errormsg;
}
elseif(!empty($checked)) {
  $data['head']['body_text'] = $cs_lang['email_found'];
}
else {
  $data['head']['body_text'] = $cs_lang['sendpw_done'];
}

echo cs_subtemplate(__FILE__,$data,'users','head');

if(empty($success)) {

  if(!empty($checked)) {

  $data['lang']['key'] = $cs_lang['key'];
  $data['lang']['new_pwd'] = $cs_lang['new_pwd'];
  $data['hidden']['email'] = $sendpw['email'];
  $data['lang']['options'] = $cs_lang['options'];
  $data['lang']['save'] = $cs_lang['save'];
  $data['lang']['reset'] = $cs_lang['reset'];
  echo cs_subtemplate(__FILE__,$data,'users','sendpw_2');
  }
  else {
    $data['lang']['email'] = $cs_lang['email'];
    $data['lang']['security_code'] = $cs_lang['security_code'];
    $data['lang']['options'] = $cs_lang['options'];
    $data['lang']['request'] = $cs_lang['request'];
    $data['lang']['reset'] = $cs_lang['reset'];

    $data['captcha']['img'] = cs_html_img('mods/captcha/generate.php?time=' . cs_time());

    echo cs_subtemplate(__FILE__,$data,'users','sendpw_1');
  }
}
else
  cs_redirect('','users','login');