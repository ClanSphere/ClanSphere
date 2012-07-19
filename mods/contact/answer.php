<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('contact');

$data = array();
$error = 0;
$message = '';

$id = isset($_POST['id']) ? $_POST['id'] : $_GET['id'];
settype($id,'integer');

$cs_answer_user = cs_sql_select(__FILE__,'users','users_email, users_name, users_surname',"users_id = '" . $account['users_id'] . "'");
$cs_answer_mail = cs_sql_select(__FILE__,'mail','mail_name, mail_email, mail_time, mail_message',"mail_id = '" . $id . "'");

$cs_contact = cs_sql_option(__FILE__, 'contact');
if(empty($cs_answer_user['users_email'])){
  $from = $cs_contact['def_mail'];
} else {
  $from = $cs_answer_user['users_email'];
}

if(isset($_POST['submit'])) {

  $mail['subject']  = $_POST['subject'];
  $mail['message']  = $_POST['message'];
  
  if(empty($mail['subject'])) {
    $error++;
    $message .= $cs_lang['error_subject'] . cs_html_br(1);
  }
  if(empty($mail['message'])) {
    $error++;
    $message .= $cs_lang['error_message'] . cs_html_br(1);
  }
}
else {
  $mail['subject']  = '';
  $mail['message']  = '';
}

if(!isset($_POST['submit'])) {
  $data['lang']['head'] = $cs_lang['head_answer'];
}
elseif(!empty($error)) {
  $data['lang']['head'] = cs_icon('important') . cs_html_br(1);
  $data['lang']['head'] .= $message;
}
else {
  $data['lang']['head'] = $cs_lang['success'];
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['if']['form'] = TRUE;
  $data['if']['done'] = FALSE;
  
  $data['mail']['users_name']     = $cs_answer_user['users_name'];
  $data['mail']['users_surname']  = $cs_answer_user['users_surname'];
  $data['mail']['users_email']    = $from;
  $data['mail']['mail_name']      = $cs_answer_mail['mail_name'];
  $data['mail']['mail_email']     = $cs_answer_mail['mail_email'];
  $data['mail']['subject']        = $mail['subject'];
  $data['mail']['message']        = $mail['message'];
  $data['mail']['id']             = $id;
}
else {
  
  $data['if']['form'] = FALSE;
  $data['if']['done'] = TRUE;
  
  $message = $mail['message'];
  $message .= "\n\n\n\n". sprintf($cs_lang['in_response'],cs_date('unix',$cs_answer_mail['mail_time'])) . "\n";
  $message .= cs_secure($cs_answer_mail['mail_message']);
  cs_mail($cs_answer_mail['mail_email'],$mail['subject'],$message,$from);
  
  $cells = array('mail_answered', 'mail_answertime', 'mail_answer', 'mail_answeruser');
  $save = array(1, cs_time(), $mail['message'], $account['users_id']);
  cs_sql_update(__FILE__,'mail',$cells,$save,$id);
  cs_cache_delete('count_mail_unread');
}

$data['mail']['mail_name'] = cs_secure($cs_answer_mail['mail_name']);
$data['mail']['users_name'] = cs_secure($cs_answer_user['users_name']);
$data['mail']['users_surname'] = cs_secure($cs_answer_user['users_surname']);

echo cs_subtemplate(__FILE__,$data,'contact','answer');