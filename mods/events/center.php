<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'events_name DESC';
$cs_sort[2] = 'events_name ASC';
$cs_sort[3] = 'events_time DESC';
$cs_sort[4] = 'events_time ASC';
$sort = empty($_REQUEST['sort']) ? 4 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$data['lang']['getmsg'] = cs_getmsg();
$data['lang']['agenda'] = cs_link($cs_lang['agenda'],'events','agenda');

$select = 'evs.events_name AS events_name, evs.events_id AS events_id, evs.events_time AS events_time, '
        . 'evs.events_cancel AS events_cancel, evs.events_guestsmax AS events_guestsmax, '
        . 'egt.eventguests_id AS eventguests_id, egt.eventguests_status AS eventguests_status';
$from = 'eventguests egt INNER JOIN {pre}_events evs ON egt.events_id = evs.events_id';
$where = 'events_time > ' . cs_time() . ' AND users_id = ' . $account['users_id'];

$cs_events = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$events_loop = count($cs_events);

$data['sort']['name'] = cs_sort('events','center',$start,0,1,$sort);
$data['sort']['time'] = cs_sort('events','center',$start,0,3,$sort);

if(empty($events_loop)) {
  $data['events'] = '';
}

for($run=0; $run<$events_loop; $run++) {
  $data['events'][$run]['name'] = cs_link(cs_secure($cs_events[$run]['events_name']),'events','view','id=' . $cs_events[$run]['events_id']);
  $data['events'][$run]['time'] = cs_date('unix',$cs_events[$run]['events_time'],1);
  $data['events'][$run]['guests'] = cs_sql_count(__FILE__, 'eventguests', "events_id = '" . $cs_events[$run]['events_id'] . "'");
  $data['events'][$run]['guestsmax'] = $cs_events[$run]['events_guestsmax'];
  $data['events'][$run]['canceled'] = empty($cs_events[$run]['events_cancel']) ? '' : ' - ' . $cs_lang['canceled'];
  $data['events'][$run]['status'] = $cs_lang['status_' . $cs_events[$run]['eventguests_status']];
  $data['events'][$run]['remove'] = cs_link(cs_icon('cancel',16,$cs_lang['signout']),'events','signout','id=' . $cs_events[$run]['eventguests_id'],0,$cs_lang['remove']);
}

echo cs_subtemplate(__FILE__,$data,'events','center');