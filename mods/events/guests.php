<?php
// ClanSphere 2008 - www.clansphere.net
// $Id: manage.php 1775 2009-02-17 20:59:11Z duRiel $

$cs_lang = cs_translate('events');

$data = array();

$events_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
$events_id = empty($_REQUEST['id']) ? $events_id : $_REQUEST['id'];
settype($events_id,'integer');
$where = empty($events_id) ? 0 : "events_id = '" . $events_id . "'";
$where2 = empty($events_id) ? 0 : 'evs.' . $where;

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'usr.users_nick DESC';
$cs_sort[2] = 'usr.users_nick ASC';
$cs_sort[3] = 'usr.users_surname DESC';
$cs_sort[4] = 'usr.users_surname ASC';
$cs_sort[5] = 'evs.events_time DESC';
$cs_sort[6] = 'evs.events_time ASC';
$sort = empty($_REQUEST['sort']) ? 4 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$data['head']['count'] = cs_sql_count(__FILE__, 'eventguests', "events_id = '" . $events_id . "'");

$data['events'] = cs_sql_select(__FILE__,'events','events_id, events_name, events_time',$where,0,0,1);
$data['events']['time'] = cs_date('unix',$data['events']['events_time'],1);

$data['head']['pages'] = cs_pages('squads','manage',$data['head']['count'],$start,$events_id,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['user'] = cs_sort('events','guests',$start,$events_id,1,$sort);
$data['sort']['name'] = cs_sort('events','guests',$start,$events_id,3,$sort);
$data['sort']['time'] = cs_sort('events','guests',$start,$events_id,5,$sort);

$from = 'eventguests egt LEFT JOIN {pre}_users usr ON egt.users_id = usr.users_id';
$select = 'egt.eventguests_since AS eventguests_since, egt.users_id AS users_id, usr.users_nick AS users_nick, usr.users_surname AS users_surname, usr.users_active AS users_active, usr.users_delete AS users_delete, usr.users_name AS users_name, egt.eventguests_id AS eventguests_id';
$cs_eventguests = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$eventguests_loop = count($cs_eventguests);

if(empty($eventguests_loop))
  $data['eventguests'] = '';

for($run=0; $run<$eventguests_loop; $run++) {
  $data['eventguests'][$run]['user'] = cs_user($cs_eventguests[$run]['users_id'],$cs_eventguests[$run]['users_nick'], $cs_eventguests[$run]['users_active'], $cs_eventguests[$run]['users_delete']);
  $data['eventguests'][$run]['since'] = cs_date('unix',$cs_eventguests[$run]['eventguests_since'],1);
  $data['eventguests'][$run]['name'] = empty($cs_eventguests[$run]['users_surname']) ? $cs_eventguests[$run]['users_name'] : $cs_eventguests[$run]['users_surname'] . ', ' . $cs_eventguests[$run]['users_name'];
  $data['eventguests'][$run]['remove'] = cs_link(cs_icon('editdelete',16,$cs_lang['remove']),'events','guestsdel','id=' . $cs_eventguests[$run]['eventguests_id'],0,$cs_lang['remove']);
}

echo cs_subtemplate(__FILE__,$data,'events','guests');

?>