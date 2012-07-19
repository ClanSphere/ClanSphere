<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');
$cs_post = cs_post('where,start,sort');
$cs_get = cs_get('where,start,sort');
$data = array();

$categories_id = empty($cs_get['where']) ? 0 : $cs_get['where'];
if (!empty($cs_post['where']))  $categories_id = $cs_post['where'];
$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 3 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$where = empty($categories_id) ? 0 : "categories_id = '" . $categories_id . "'";

$cs_sort[1] = 'events_name DESC';
$cs_sort[2] = 'events_name ASC';
$cs_sort[3] = 'events_time DESC';
$cs_sort[4] = 'events_time ASC';
$order = $cs_sort[$sort];

$data['count']['all'] = cs_sql_count(__FILE__,'events',$where);
$data['pages']['list'] = cs_pages('events','manage',$data['count']['all'],$start,$categories_id,$sort);

$data['head']['message'] = cs_getmsg();

$eventsmod = "categories_mod = 'events'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$eventsmod,'categories_name',0,0);
$data['head']['categories'] = cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');

$data['sort']['name'] = cs_sort('events','manage',$start,$categories_id,1,$sort);
$data['sort']['date'] = cs_sort('events','manage',$start,$categories_id,3,$sort);

$select = 'events_time, events_id, events_name, events_cancel, events_guestsmax, events_guestsmin';
$data['events'] = cs_sql_select(__FILE__,'events',$select,$where,$order,$start,$account['users_limit']);
$count_events = count($data['events']);

for ($run = 0; $run < $count_events; $run++) {
  $data['events'][$run]['time'] = cs_date('unix',$data['events'][$run]['events_time'],1);
  $data['events'][$run]['events_name'] = cs_secure($data['events'][$run]['events_name']);
  $data['events'][$run]['signed'] = cs_sql_count(__FILE__, 'eventguests', "events_id = '" . $data['events'][$run]['events_id'] . "' AND eventguests_status < 4");
  $data['events'][$run]['guests'] = cs_sql_count(__FILE__, 'eventguests', "events_id = '" . $data['events'][$run]['events_id'] . "' AND eventguests_status > 3");
  $data['events'][$run]['canceled'] = empty($data['events'][$run]['events_cancel']) ? '' : ' - ' . $cs_lang['canceled'];
  $data['events'][$run]['class'] = $data['events'][$run]['events_time'] > cs_time() ? 'b' : 'c';

  if(empty($data['events'][$run]['events_guestsmax']) OR $data['events'][$run]['events_time'] < cs_time())
    $data['events'][$run]['indicator'] = cs_html_img('symbols/clansphere/grey.gif');
  elseif($data['events'][$run]['guests'] >= $data['events'][$run]['events_guestsmax'])
    $data['events'][$run]['indicator'] = cs_html_img('symbols/clansphere/red.gif');
  else
    $data['events'][$run]['indicator'] = cs_html_img('symbols/clansphere/green.gif');
}

echo cs_subtemplate(__FILE__,$data,'events','manage');