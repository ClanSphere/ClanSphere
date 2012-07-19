<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('newsletter');
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 1 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$cs_sort[1] = 'newsletter_time DESC';
$cs_sort[2] = 'newsletter_time ASC'; 
$cs_sort[3] = 'users_nick DESC';
$cs_sort[4] = 'users_nick ASC';
$order = $cs_sort[$sort];
$newsletter_count = cs_sql_count(__FILE__,'newsletter');


$data['head']['count'] = $newsletter_count;
$data['head']['pages'] = cs_pages('newsletter','manage',$newsletter_count,$start,0,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['user'] = cs_sort('newsletter','manage',$start,0,3,$sort);
$data['sort']['date'] = cs_sort('newsletter','manage',$start,0,1,$sort);


$from = 'newsletter nwl INNER JOIN {pre}_users usr ON nwl.users_id = usr.users_id ';
$select = 'nwl.newsletter_id AS newsletter_id, nwl.newsletter_subject AS newsletter_subject, nwl.newsletter_time AS newsletter_time, nwl.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active';
$data['newsletter'] = cs_sql_select(__FILE__,$from,$select,0,$order,$start,$account['users_limit']);
$newsletter_loop = count($data['newsletter']);

for($run=0; $run<$newsletter_loop; $run++) {

  $data['newsletter'][$run]['user'] = cs_user($data['newsletter'][$run]['users_id'],$data['newsletter'][$run]['users_nick'],$data['newsletter'][$run]['users_active']);
  $data['newsletter'][$run]['subject'] = $data['newsletter'][$run]['newsletter_subject'];
  $data['newsletter'][$run]['date'] = cs_date('unix',$data['newsletter'][$run]['newsletter_time'],1);
  $data['newsletter'][$run]['id'] = $data['newsletter'][$run]['newsletter_id'];

}

echo cs_subtemplate(__FILE__,$data,'newsletter','manage');