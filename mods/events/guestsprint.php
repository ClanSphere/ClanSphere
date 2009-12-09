<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$data = array();

$events_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
$events_id = empty($_REQUEST['id']) ? $events_id : $_REQUEST['id'];
settype($events_id,'integer');
$where = empty($events_id) ? 0 : "events_id = '" . $events_id . "'";
$where2 = empty($events_id) ? 0 : 'evs.' . $where;

$data['head']['count'] = cs_sql_count(__FILE__, 'eventguests', "events_id = '" . $events_id . "'");

$columns = 'events_id, events_name, events_time, events_needage, events_guestsmax, events_guestsmin';
$data['events'] = cs_sql_select(__FILE__,'events',$columns,$where,0,0,1);
$data['events']['time'] = cs_date('unix',$data['events']['events_time'],1);

$from = 'eventguests egt LEFT JOIN {pre}_users usr ON egt.users_id = usr.users_id';
$select = 'egt.eventguests_name AS eventguests_name, egt.eventguests_surname AS eventguests_surname, '
        . 'egt.eventguests_since AS eventguests_since, egt.users_id AS users_id, usr.users_nick AS users_nick, '
        . 'usr.users_surname AS users_surname, usr.users_hidden AS users_hidden, usr.users_active AS users_active, '
        . 'usr.users_delete AS users_delete, usr.users_name AS users_name, egt.eventguests_id AS eventguests_id, '
        . 'egt.eventguests_phone AS eventguests_phone, egt.eventguests_mobile AS eventguests_mobile';
$cs_eventguests = cs_sql_select(__FILE__,$from,$select,$where,'egt.eventguests_since',0,0);
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

  $data['eventguests'][$run]['surname'] = $surname;
  $data['eventguests'][$run]['name'] = $name;

  $data['eventguests'][$run]['user'] = empty($cs_eventguests[$run]['users_id']) ? '-' : cs_user($cs_eventguests[$run]['users_id'],$cs_eventguests[$run]['users_nick'], $cs_eventguests[$run]['users_active'], $cs_eventguests[$run]['users_delete']);
  $data['eventguests'][$run]['since'] = cs_date('unix',$cs_eventguests[$run]['eventguests_since'],1);
  $data['eventguests'][$run]['phone'] = empty($cs_eventguests[$run]['eventguests_phone']) ? '&nbsp;' : cs_icon('linphone') . $cs_eventguests[$run]['eventguests_phone'];
  $data['eventguests'][$run]['mobile'] = empty($cs_eventguests[$run]['eventguests_mobile']) ? '&nbsp;' : cs_icon('sms_protocol') . $cs_eventguests[$run]['eventguests_mobile'];
  $data['eventguests'][$run]['edit'] = cs_link(cs_icon('edit',16,$cs_lang['edit']),'events','guestsadm','id=' . $cs_eventguests[$run]['eventguests_id'],0,$cs_lang['edit']);
  $data['eventguests'][$run]['remove'] = cs_link(cs_icon('editdelete',16,$cs_lang['remove']),'events','guestsdel','id=' . $cs_eventguests[$run]['eventguests_id'],0,$cs_lang['remove']);
}

echo cs_subtemplate(__FILE__,$data,'events','guestsprint');