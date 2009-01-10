<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');
$data = array();

$categories_id = empty($_REQUEST['where']) ? 0 : (int) $_REQUEST['where'];
$where = empty($categories_id) ? 0 : "categories_id = '" . $categories_id . "'";

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'events_time DESC';
$cs_sort[2] = 'events_time ASC';
$cs_sort[3] = 'events_name DESC';
$cs_sort[4] = 'events_name ASC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$count_all = cs_sql_count(__FILE__,'events',$where);

$data['head']['count_all'] = $count_all;
$data['head']['pages'] = cs_pages('events','list',$count_all,$start,$categories_id,$sort);

$cond = "categories_mod = 'events' AND categories_access <= '" . $account['access_events'] . "'";
$categories_data = cs_sql_select(__FILE__,'categories','categories_name, categories_id',$cond,'categories_name',0,0);
$data['head']['dropdown'] = cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');

$data['sort']['name'] = cs_sort('events','list',$start,$categories_id,3,$sort);
$data['sort']['date'] = cs_sort('events','list',$start,$categories_id,1,$sort);

$cells = 'events_name, events_time, events_id';
$data['events'] = cs_sql_select(__FILE__,'events',$cells,$where,$order,$start,$account['users_limit']);
$events_count = count($data['events']);

for ($i = 0; $i < $events_count; $i++) {
	$data['events'][$i]['time'] = cs_date('unix',$data['events'][$i]['events_time'],1);
}

echo cs_subtemplate(__FILE__, $data, 'events');

?>