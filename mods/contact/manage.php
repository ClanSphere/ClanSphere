<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('contact');

$filename = 'uploads/imprint/imprint.txt';
$content = '';

empty($_GET['start']) ? $start = 0 : $start = $_GET['start'];
$cs_sort[1] = 'mail_name DESC';
$cs_sort[2] = 'mail_name ASC';
$cs_sort[3] = 'mail_subject DESC';
$cs_sort[4] = 'mail_subject ASC';
$cs_sort[5] = 'mail_time DESC';
$cs_sort[6] = 'mail_time ASC';
empty($_GET['sort']) ? $sort = 5 : $sort = $_GET['sort'];
$order = $cs_sort[$sort];

$select = 'mail_id, mail_name, categories_id, mail_subject, mail_time';
$where = "mail_answered = 0";
$cs_mail = cs_sql_select(__FILE__,'mail',$select,$where,$order,$start,$account['users_limit']);
$mail_loop = count($cs_mail);
$data = array();

$data['head']['pages']  = cs_pages('contact','manage',$mail_loop,$start,0,$sort);
$data['head']['sort_name'] = cs_sort('contact','manage',$start,0,1,$sort);
$data['head']['sort_subject'] = cs_sort('contact','manage',$start,0,3,$sort);
$data['head']['sort_date'] = cs_sort('contact','manage',$start,0,5,$sort);
$data['url']['imp_edit'] = cs_url('contact','imp_edit');

$data['head']['message'] = cs_getmsg();

$data['mail'] = array();
for($run=0; $run<$mail_loop; $run++) {
  $data['mail'][$run]['mail_id'] = $cs_mail[$run]['mail_id'];
  $data['mail'][$run]['mail_name'] = cs_secure($cs_mail[$run]['mail_name']);
  $categories_data = cs_sql_select(__FILE__,'categories','*',"categories_id = '" . $cs_mail[$run]['categories_id'] . "'");
  $data['mail'][$run]['categories_name'] = $categories_data['categories_name'];
  $data['mail'][$run]['mail_subject'] = cs_secure($cs_mail[$run]['mail_subject']);
  $data['mail'][$run]['mail_date'] = cs_date('unix',$cs_mail[$run]['mail_time'],1);
}

if (file_exists($filename)) {
  $fp = fopen ($filename, "r");
  $content = fread ($fp, filesize($filename));
  $imprint = explode("{laststandbreak}", $content);
  $date = cs_date('unix',$imprint[0],1);
  fclose ($fp);
} else {
  $date = '-'; 
}

$data['body']['date'] = cs_secure($date);

echo cs_subtemplate(__FILE__,$data,'contact','manage');
