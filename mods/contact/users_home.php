<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('contact');

$data = array();
$max = 3;
$mail_select = 'mail_name, mail_subject, mail_time, mail_id';
$where = "mail_answered = 0";
$cs_mail = cs_sql_select(__FILE__,'mail',$mail_select,$where,'mail_time DESC',0,$max);

if(!empty($cs_mail)) {

  for($run=0; $run<count($cs_mail); $run++) {
    $data['mail'][$run]['name'] = cs_secure($cs_mail[$run]['mail_name']);
    $data['mail'][$run]['subject'] = cs_secure($cs_mail[$run]['mail_subject']);
    $data['mail'][$run]['id'] = $cs_mail[$run]['mail_id'];
    $data['mail'][$run]['date'] = cs_date('unix',$cs_mail[$run]['mail_time'],1);
  }

  echo cs_subtemplate(__FILE__,$data,'contact','users_home');
}
