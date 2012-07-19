<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('count');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'count_time DESC';
$cs_sort[2] = 'count_time ASC';
$cs_sort[3] = 'count_id DESC';
$cs_sort[4] = 'count_id ASC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$counter_count = cs_sql_count(__FILE__,'count');

$data = array();
$data['head']['counter_count'] = $counter_count;
$data['head']['counter_pages'] = cs_pages('count','manage',$counter_count,$start);

$data['head']['message'] = cs_getmsg();

$data['sort']['count_time'] = cs_sort('count','manage',$start,0,1,$sort);
$data['sort']['count_id'] = cs_sort('count','manage',$start,0,3,$sort);

$cs_counter = cs_sql_select(__FILE__,'count','*',0,$order,$start,$account['users_limit']);
$count_loop = count($cs_counter);

$data['count'] = array();
for($run=0; $run<$count_loop; $run++) {
        
  $data['count'][$run]['count_id']      = $cs_counter[$run]['count_id'];
  $data['count'][$run]['count_ip']      = $cs_counter[$run]['count_ip'];
  $data['count'][$run]['count_locate']  = $cs_counter[$run]['count_location'];
  $data['count'][$run]['count_time']    = cs_date('unix',$cs_counter[$run]['count_time'],1);
}

echo cs_subtemplate(__FILE__,$data,'count','manage');