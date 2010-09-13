<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$data = array();

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'egt.eventguests_since DESC';
$cs_sort[2] = 'egt.eventguests_since ASC';
$cs_sort[3] = 'usr.users_surname DESC, egt.eventguests_surname DESC';
$cs_sort[4] = 'usr.users_surname ASC, egt.eventguests_surname ASC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$data['head']['count'] = cs_sql_count(__FILE__, 'eventguests');

$data['head']['pages'] = cs_pages('events','guestslatest',$data['head']['count'],$start,0,$sort);

$data['sort']['time'] = cs_sort('events','guestslatest',$start,0,1,$sort);
$data['sort']['name'] = cs_sort('events','guestslatest',$start,0,3,$sort);

$from = 'eventguests egt INNER JOIN {pre}_events evt ON egt.events_id = evt.events_id LEFT JOIN {pre}_users usr ON egt.users_id = usr.users_id';
$select = 'egt.eventguests_name AS eventguests_name, egt.eventguests_surname AS eventguests_surname, '
        . 'egt.eventguests_since AS eventguests_since, egt.users_id AS users_id, usr.users_nick AS users_nick, '
        . 'usr.users_surname AS users_surname, usr.users_hidden AS users_hidden, usr.users_active AS users_active, '
        . 'usr.users_delete AS users_delete, usr.users_name AS users_name, evt.events_id AS events_id, evt.events_name AS events_name, '
        . 'evt.events_time AS events_time, egt.eventguests_id AS eventguests_id, egt.eventguests_notice AS eventguests_notice';
$cs_eventguests = cs_sql_select(__FILE__,$from,$select,0,$order,$start,$account['users_limit']);
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

  $data['eventguests'][$run]['events_id'] = $cs_eventguests[$run]['events_id'];
  $data['eventguests'][$run]['events_name'] = cs_secure($cs_eventguests[$run]['events_name']);
  $data['eventguests'][$run]['events_date'] = cs_date('unix',$cs_eventguests[$run]['events_time']);
  $data['eventguests'][$run]['user'] = empty($cs_eventguests[$run]['users_id']) ? '-' : cs_user($cs_eventguests[$run]['users_id'],$cs_eventguests[$run]['users_nick'], $cs_eventguests[$run]['users_active'], $cs_eventguests[$run]['users_delete']);
  $data['eventguests'][$run]['since'] = cs_date('unix',$cs_eventguests[$run]['eventguests_since'],1);
  $data['eventguests'][$run]['notice'] = empty($cs_eventguests[$run]['eventguests_notice']) ? '&nbsp;' : cs_icon('txt',16,$cs_lang['notice']);
  $data['eventguests'][$run]['edit'] = cs_link(cs_icon('edit',16,$cs_lang['edit']),'events','guestsadm','id=' . $cs_eventguests[$run]['eventguests_id'],0,$cs_lang['edit']);
  $data['eventguests'][$run]['remove'] = cs_link(cs_icon('editdelete',16,$cs_lang['remove']),'events','guestsdel','id=' . $cs_eventguests[$run]['eventguests_id'],0,$cs_lang['remove']);
}

echo cs_subtemplate(__FILE__,$data,'events','guestslatest');