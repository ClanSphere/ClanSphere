<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

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
$cs_sort[3] = 'usr.users_surname DESC, egt.eventguests_surname DESC';
$cs_sort[4] = 'usr.users_surname ASC, egt.eventguests_surname ASC';
$cs_sort[5] = 'egt.eventguests_since DESC';
$cs_sort[6] = 'egt.eventguests_since ASC';
$cs_sort[7] = 'egt.eventguests_status DESC, egt.eventguests_since ASC';
$cs_sort[8] = 'egt.eventguests_status ASC, egt.eventguests_since DESC';
$sort = empty($_REQUEST['sort']) ? 7 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$data['if']['admin'] = $account['access_events'] >= 5 ? 1 : 0;

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

$data['head']['pages'] = cs_pages('events','guests',$data['head']['count'],$start,$events_id,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['user'] = cs_sort('events','guests',$start,$events_id,1,$sort);
$data['sort']['name'] = cs_sort('events','guests',$start,$events_id,3,$sort);
$data['sort']['time'] = cs_sort('events','guests',$start,$events_id,5,$sort);
$data['sort']['status'] = cs_sort('events','guests',$start,$events_id,7,$sort);

$from = 'eventguests egt LEFT JOIN {pre}_users usr ON egt.users_id = usr.users_id';
$select = 'egt.eventguests_name AS eventguests_name, egt.eventguests_surname AS eventguests_surname, '
        . 'egt.eventguests_since AS eventguests_since, egt.users_id AS users_id, usr.users_nick AS users_nick, '
        . 'usr.users_surname AS users_surname, usr.users_hidden AS users_hidden, usr.users_active AS users_active, '
        . 'usr.users_delete AS users_delete, usr.users_name AS users_name, usr.users_phone AS users_phone, '
        . 'usr.users_mobile AS users_mobile, egt.eventguests_id AS eventguests_id, egt.eventguests_notice AS eventguests_notice, '
        . 'egt.eventguests_phone AS eventguests_phone, egt.eventguests_mobile AS eventguests_mobile, '
        . 'egt.eventguests_status AS eventguests_status';
$cs_eventguests = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
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
  if(!empty($surname) AND !empty($name))
    $data['eventguests'][$run]['name'] = $surname . ', ' . $name;
  elseif(!empty($surname) OR !empty($name))
    $data['eventguests'][$run]['name'] = $surname . $name;
  else
    $data['eventguests'][$run]['name'] = '';

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

  $data['eventguests'][$run]['user'] = empty($cs_eventguests[$run]['users_id']) ? '-' : cs_user($cs_eventguests[$run]['users_id'],$cs_eventguests[$run]['users_nick'], $cs_eventguests[$run]['users_active'], $cs_eventguests[$run]['users_delete']);
  $data['eventguests'][$run]['since'] = cs_date('unix',$cs_eventguests[$run]['eventguests_since']);
  $data['eventguests'][$run]['phone'] = empty($cs_eventguests[$run]['eventguests_phone']) ? '&nbsp;' : cs_html_img('symbols/' . $cs_main['img_path'] . '/16/linphone.' . $cs_main['img_ext'],16,16,'title="'. $cs_eventguests[$run]['eventguests_phone'] .'"');
  $data['eventguests'][$run]['mobile'] = empty($cs_eventguests[$run]['eventguests_mobile']) ? '&nbsp;' : cs_html_img('symbols/' . $cs_main['img_path'] . '/16/sms_protocol.' . $cs_main['img_ext'],16,16,'title="'. $cs_eventguests[$run]['eventguests_mobile'] .'"');
  $data['eventguests'][$run]['status'] = $cs_lang['status_' . $cs_eventguests[$run]['eventguests_status']];
  $data['eventguests'][$run]['notice'] = empty($cs_eventguests[$run]['eventguests_notice']) ? '&nbsp;' : cs_icon('txt',16,$cs_lang['notice']);
  $data['eventguests'][$run]['edit'] = cs_link(cs_icon('edit',16,$cs_lang['edit']),'events','guestsadm','id=' . $cs_eventguests[$run]['eventguests_id'],0,$cs_lang['edit']);
  $data['eventguests'][$run]['remove'] = cs_link(cs_icon('editdelete',16,$cs_lang['remove']),'events','guestsdel','id=' . $cs_eventguests[$run]['eventguests_id'],0,$cs_lang['remove']);
}

echo cs_subtemplate(__FILE__,$data,'events','guests');