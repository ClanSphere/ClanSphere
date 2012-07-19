<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('count');

$data = array('count' => array());

$geton = cs_time() - 300;
$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];

$where = "count_time > '" . $geton . "'";
$counte_online = cs_sql_count(__FILE__,'count',$where);

$data['online']['online'] = $counte_online;
$data['head']['pages'] = cs_pages('count','online',$counte_online,$start);

$cs_counter = cs_sql_select(__FILE__,'count','count_time, count_location',"count_time >= '" . $geton . "'",'count_id DESC',$start,$account['users_limit']);
$counte_loop = count($cs_counter);

for($run=0; $run<$counte_loop; $run++) {

  $data['count'][$run]['count_time'] = cs_date('unix',$cs_counter[$run]['count_time'],1);
  $data['count'][$run]['count_location'] = cs_secure($cs_counter[$run]['count_location']);
}

echo cs_subtemplate(__FILE__,$data,'count','online');