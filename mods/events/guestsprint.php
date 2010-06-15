<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$data = array();
$data['time']['now'] = cs_date('unix',cs_time(),1);

$events_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
$events_id = empty($_REQUEST['id']) ? $events_id : $_REQUEST['id'];
settype($events_id,'integer');
$where = empty($events_id) ? 0 : "events_id = '" . $events_id . "'";
$where2 = empty($events_id) ? 0 : 'evs.' . $where;

$columns = 'events_id, events_name, events_time, events_needage, events_guestsmax, events_guestsmin';
$data['events'] = cs_sql_select(__FILE__,'events',$columns,$where,0,0,1);
$data['events']['time'] = cs_date('unix',$data['events']['events_time'],1);

$count_where = "events_id = '" . $events_id . "' AND eventguests_status = ";
$data['count']['status_0'] = cs_sql_count(__FILE__, 'eventguests', $count_where . '0');
$data['count']['status_3'] = cs_sql_count(__FILE__, 'eventguests', $count_where . '3');
$data['count']['status_4'] = cs_sql_count(__FILE__, 'eventguests', $count_where . '4');
$data['count']['status_5'] = cs_sql_count(__FILE__, 'eventguests', $count_where . '5');
$data['count']['status_booked'] = $data['count']['status_4'] + $data['count']['status_5'];
$data['count']['status_available'] = $data['events']['events_guestsmax'] - $data['count']['status_booked'];
$data['head']['count'] = $data['count']['status_0'] + $data['count']['status_3'] + $data['count']['status_booked'];

$order = 'egt.eventguests_status DESC, usr.users_surname ASC, egt.eventguests_surname ASC';
$from = 'eventguests egt LEFT JOIN {pre}_users usr ON egt.users_id = usr.users_id';
$select = 'egt.eventguests_name AS eventguests_name, egt.eventguests_surname AS eventguests_surname, '
        . 'egt.eventguests_since AS eventguests_since, egt.users_id AS users_id, usr.users_nick AS users_nick, '
        . 'usr.users_surname AS users_surname, usr.users_hidden AS users_hidden, usr.users_active AS users_active, '
        . 'usr.users_delete AS users_delete, usr.users_name AS users_name, usr.users_phone AS users_phone, '
        . 'usr.users_mobile AS users_mobile, usr.users_age AS users_age, egt.eventguests_notice AS eventguests_notice, '
        . 'egt.eventguests_phone AS eventguests_phone, egt.eventguests_mobile AS eventguests_mobile, '
        . 'egt.eventguests_age AS eventguests_age, egt.eventguests_status AS eventguests_status';
$cs_eventguests = cs_sql_select(__FILE__,$from,$select,$where,$order,0,0);
$eventguests_loop = count($cs_eventguests);

if(empty($eventguests_loop))
  $data['eventguests'] = '';
  
for($run=0; $run<$eventguests_loop; $run++) {

  $allow = 0;
  if($cs_eventguests[$run]['users_id'] == $account['users_id'] OR $account['access_users'] > 4)
    $allow = 1;

  $hidden = explode(',',$cs_eventguests[$run]['users_hidden']);
  $content = cs_secure($cs_eventguests[$run]['users_surname']);
  if(in_array('users_surname',$hidden)) {
    $content = empty($allow) ? '' : cs_html_italic(1) . $content . cs_html_italic(0);
  }
  $surname = empty($cs_eventguests[$run]['users_surname']) ? $cs_eventguests[$run]['eventguests_surname'] : $content;
  $content = cs_secure($cs_eventguests[$run]['users_name']);
  if(in_array('users_name',$hidden)) {
    $content = empty($allow) ? '' : cs_html_italic(1) . $content . cs_html_italic(0);
  }
  $name = empty($cs_eventguests[$run]['users_name']) ? $cs_eventguests[$run]['eventguests_name'] : $content;

  if(empty($cs_eventguests[$run]['eventguests_phone']))
    if(in_array('users_phone',$hidden))
      $cs_eventguests[$run]['eventguests_phone'] = empty($allow) ? '' : cs_html_italic(1) . $cs_eventguests[$run]['users_phone'] . cs_html_italic(0);
    elseif(!empty($allow))
      $cs_eventguests[$run]['eventguests_phone'] = $cs_eventguests[$run]['users_phone'];
  if(empty($cs_eventguests[$run]['eventguests_mobile']))
    if(in_array('users_mobile',$hidden))
      $cs_eventguests[$run]['eventguests_mobile'] = empty($allow) ? '' : cs_html_italic(1) . $cs_eventguests[$run]['users_mobile'] . cs_html_italic(0);
    elseif(!empty($allow))
      $cs_eventguests[$run]['eventguests_mobile'] = $cs_eventguests[$run]['users_mobile'];

  $age = $cs_eventguests[$run]['eventguests_age'];
  if(!empty($cs_eventguests[$run]['users_age'])) {
    $birth = explode ('-', $cs_eventguests[$run]['users_age']);
    $age = cs_datereal('Y') - $birth[0];
    if(cs_datereal('m')<=$birth[1]) { $age--; }
    if(cs_datereal('d')>=$birth[2] AND cs_datereal('m')==$birth[1]) { $age++; }
    if(in_array('users_age',$hidden))
      $age = empty($allow) ? '' : cs_html_italic(1) . $age . cs_html_italic(0);
  }

  $data['eventguests'][$run]['number'] = $run + 1;
  $data['eventguests'][$run]['surname'] = $surname;
  $data['eventguests'][$run]['name'] = $name;
  $data['eventguests'][$run]['age'] = empty($age) ? '' : $age;
  $data['eventguests'][$run]['notice'] = cs_secure($cs_eventguests[$run]['eventguests_notice']);
  $data['eventguests'][$run]['user'] = empty($cs_eventguests[$run]['users_id']) ? '-' : cs_user($cs_eventguests[$run]['users_id'],$cs_eventguests[$run]['users_nick'], $cs_eventguests[$run]['users_active'], $cs_eventguests[$run]['users_delete']);
  $data['eventguests'][$run]['status'] = $cs_lang['status_' . $cs_eventguests[$run]['eventguests_status']];
  $data['eventguests'][$run]['phone'] = empty($cs_eventguests[$run]['eventguests_phone']) ? '&nbsp;' : cs_icon('linphone') . $cs_eventguests[$run]['eventguests_phone'];
  $data['eventguests'][$run]['mobile'] = empty($cs_eventguests[$run]['eventguests_mobile']) ? '&nbsp;' : cs_icon('sms_protocol') . $cs_eventguests[$run]['eventguests_mobile'];
}

echo cs_subtemplate(__FILE__,$data,'events','guestsprint');