<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('contact');

$captcha = extension_loaded('gd') ? 1 : 0;
$data = array();
$error = 0;
$errormsg = '';

$id = isset($_POST['id']) ? $_POST['id'] : $_GET['id'];
settype($id,'integer');

$captcha = 0;
if(empty($account['users_id']) AND extension_loaded('gd')) {
  $captcha = 1;
}

$data['if']['captcha'] = 0;

$cs_answer_user = cs_sql_select(__FILE__,'users','users_name, users_surname',"users_id = '" . $account['users_id'] . "'");
$cs_answer_mail = cs_sql_select(__FILE__,'mail','mail_name, mail_email, mail_time',"mail_id = '" . $id . "'");

$cs_contact = cs_sql_option(__FILE__, 'contact');
if(empty($cs_answer_user['users_email'])){
  $from = $cs_contact['def_mail'];
} else {
  $from = $cs_answer_user['users_email'];
}

$mail['name']          = empty($_POST['name']) ? '' : $_POST['name'];
$mail['email']         = empty($_POST['email']) ? '' : $_POST['email'];
$mail['why']           = empty($_POST['why']) ? '' : $_POST['why'];
$mail['text']          = empty($_POST['text']) ? '' : $_POST['text'];
$mail['jabber']           = empty($_POST['jabber']) ? '' : $_POST['jabber'];
$mail['icq']           = empty($_POST['icq']) ? '' : str_replace('-','',$_POST['icq']);
$mail['firm']          = empty($_POST['firm']) ? '' : $_POST['firm'];
$mail['categories_id'] = empty($_POST['categories_id']) ? '' : $_POST['categories_id'];

if(isset($_POST['submit'])) {
  
  if(empty($account['users_id'])) {
    if (!cs_captchacheck($_POST['captcha'])) {
      $error++;
      $errormsg .= $cs_lang['captcha_false'] . cs_html_br(1);
    }
  }

  $ip = cs_getip();
  $time15 = cs_time()-900;
  $checklock = cs_sql_select(__FILE__,'mail','*',"mail_time > '" . $time15 . "' AND mail_ip = '" . cs_sql_escape($ip) . "' AND mail_answered = 0");
  if(!empty($checklock)){ 
    $error++; 
    $errormsg .= $cs_lang['15min'] . cs_html_br(1); 
  }
  if(empty($mail['name'])) { 
    $error++; 
    $errormsg .= $cs_lang['error_name'].' '. cs_html_br(1); 
  }
  if(empty($mail['why'])) { 
    $error++; 
    $errormsg .= $cs_lang['error_subject'].' '. cs_html_br(1); 
  }
  if(empty($mail['text'])) { 
    $error++; 
    $errormsg .= $cs_lang['error_message'].' '. cs_html_br(1); 
  }
  if(!preg_match("/^[0-9a-zA-Z._\\-]+@[0-9a-zA-Z._\\-]{2,}\\.[a-zA-Z]{2,4}\$/",$mail['email'])) {
    $error++; 
    $errormsg .= $cs_lang['error_email'] . cs_html_br(1); 
  }
  include_once 'mods/contact/trashmail.php';
  if(cs_trashmail($mail['email'])) {
    $error++;
    $errormsg .= $cs_lang['error_email'] . cs_html_br(1);
  }
  if(!empty($mail['icq']) AND !preg_match('#^[\d-]*$#', $mail['icq'])){ 
    $error++; 
    $errormsg .= $cs_lang['error_icq'] . cs_html_br(1); 
  }
  if(empty($mail['categories_id'])){ 
    $error++; 
    $errormsg .= $cs_lang['error_category'] . cs_html_br(1); 
  }
}

if(!isset($_POST['submit'])) {
  $data['lang']['head'] = $cs_lang['body_mail'];
}
elseif(!empty($error)) {
  $data['lang']['head'] = cs_icon('important') . cs_html_br(1);
  $data['lang']['head'] .= $errormsg;
}
else {
  $data['lang']['head'] = $cs_lang['success'];
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['if']['form'] = TRUE;
  $data['if']['done'] = FALSE;

  $categories_data = cs_sql_select(__FILE__,'categories','*',"categories_mod = 'contact'",'categories_order ASC, categories_name',0,0);

  foreach($mail AS $key => $value)
    $data['mail'][$key] = cs_secure($value);

  $data['mail']['categories_id']  = cs_dropdown('categories_id','categories_name',$categories_data,$mail['categories_id']);

  if(!empty($captcha)) {
    $data['if']['captcha'] = 1;
  }
}
else {
  $data['if']['form'] = FALSE;
  $data['if']['done'] = TRUE;

  $categories_data = cs_sql_select(__FILE__,'categories','categories_name',"categories_id = '" . $mail['categories_id'] . "'");

  $message = sprintf($cs_lang['mailtxt'],date('d.m.Y'),date('H:i'),$ip,$mail['name'],$mail['firm'],$mail['icq'],$mail['email'],$categories_data['categories_name'],$mail['why'],$mail['text']);

  settype($mail['icq'], 'integer');

  $mail_cells = array('mail_name','mail_time','mail_ip','mail_email','mail_icq','mail_jabber','mail_firm','categories_id','mail_subject','mail_message');
  $mail_save = array($mail['name'],cs_time(),$ip,$mail['email'],$mail['icq'],$mail['jabber'],$mail['firm'],$mail['categories_id'],$mail['why'],$mail['text']);
  cs_sql_insert(__FILE__,'mail',$mail_cells,$mail_save);

  cs_cache_delete('count_mail_unread');

  cs_mail($cs_contact['def_mail'],$mail['why'],$message,$mail['email']);
}

$data['captcha']['img'] = cs_html_img('mods/captcha/generate.php?time=' . cs_time());

echo cs_subtemplate(__FILE__,$data,'contact','mail');