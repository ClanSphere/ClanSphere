<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$data = array();

$categories_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
settype($categories_id,'integer');
$where = empty($categories_id) ? 0 : "categories_id = '" . $categories_id . "'";
$where2 = empty($categories_id) ? 0 : 'evs.' . $where;

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'events_name DESC';
$cs_sort[2] = 'events_name ASC';
$cs_sort[3] = 'events_time DESC';
$cs_sort[4] = 'events_time ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$data['count']['all'] = cs_sql_count(__FILE__,'events',$where);
$data['pages']['list'] = cs_pages('events','manage',$data['count']['all'],$start,$categories_id,$sort);

$data['head']['message'] = cs_getmsg();

$eventsmod = "categories_mod = 'events'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$eventsmod,'categories_name',0,0);
$data['head']['categories'] = cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');

$data['sort']['name'] = cs_sort('events','manage',$start,$categories_id,1,$sort);
$data['sort']['date'] = cs_sort('events','manage',$start,$categories_id,3,$sort);

$select = 'events_time, events_id, events_name, events_cancel, events_guestsmax';

$data['events'] = cs_sql_select(__FILE__,'events',$select,$where2,$order,$start,$account['users_limit']);
$count_events = count($data['events']);

for ($run = 0; $run < $count_events; $run++) {
  $data['events'][$run]['time'] = cs_date('unix',$data['events'][$run]['events_time'],1);
  $data['events'][$run]['guests'] = cs_sql_count(__FILE__, 'eventguests', "events_id = '" . $data['events'][$run]['events_id'] . "'");
  $data['events'][$run]['canceled'] = empty($data['events'][$run]['events_cancel']) ? '' : ' - ' . $cs_lang['canceled'];
}

echo cs_subtemplate(__FILE__,$data,'events','manage');

?>