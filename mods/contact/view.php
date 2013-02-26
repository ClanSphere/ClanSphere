<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('contact');

$mail_id = $_GET['id'];
settype($mail_id,'integer');

$select = 'mail_name, categories_id, mail_subject, mail_icq, mail_jabber, mail_firm, mail_ip, mail_time, mail_message, ';
$select .= 'mail_email, mail_answertime, mail_answer, mail_answered, mail_answeruser, mail_id';
$cs_mail = cs_sql_select(__FILE__,'mail',$select,"mail_id = '" . $mail_id . "'");

$data['mail'] = $cs_mail;

$categories_data = cs_sql_select(__FILE__,'categories','categories_name',"categories_id = '" . $cs_mail['categories_id'] . "'");
$data['mail']['categories_name'] = $categories_data['categories_name'];
$data['mail']['mail_date'] = cs_date('unix',$cs_mail['mail_time'],1);
$users_data = cs_sql_select(__FILE__,'users','users_nick, users_id, users_active',"users_id = '" . $cs_mail['mail_answeruser'] . "'");
$data['mail']['user'] = cs_user($users_data['users_id'],$users_data['users_nick'], $users_data['users_active']);
$data['mail']['mail_answertime'] = cs_date('unix',$cs_mail['mail_time'],1);
$data['mail']['mail_answer'] = cs_secure($cs_mail['mail_answer'],1,1,1);
$data['mail']['mail_message'] = cs_secure($cs_mail['mail_message'],1,1,1);

$data['mail']['mail_subject'] = cs_secure($cs_mail['mail_subject']);
$data['mail']['mail_icq'] = empty($cs_mail['mail_icq']) ? '' : $cs_mail['mail_icq'];
$data['mail']['mail_jabber'] = cs_secure($cs_mail['mail_jabber']);
$data['mail']['mail_firm'] = cs_secure($cs_mail['mail_firm']);
$data['mail']['mail_name'] = cs_secure($cs_mail['mail_name']);

$data['if']['answer'] = !empty($cs_mail['mail_answered']) ? TRUE : FALSE;
$data['if']['noanswer'] = empty($cs_mail['mail_answered']) ? TRUE : FALSE;
  
echo cs_subtemplate(__FILE__,$data,'contact','view');