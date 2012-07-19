<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$op_events = cs_sql_option(__FILE__,'events');

$unix = empty($_GET['unix']) ? cs_datereal('U') : $_GET['unix'];
settype($unix,'integer');
if(!empty($_POST['date_year']) AND !empty($_POST['date_month']) AND !empty($_POST['date_day'])) {
  $unix = mktime(0, 0, 0, $_POST['date_month'], $_POST['date_day'], $_POST['date_year']);
}
$unix = cs_datereal('U',$unix, 1);
$max = $unix + 86399;

$data = array();

$data['head']['dropdown'] = cs_dateselect('date','date',cs_datereal('Y-m-d',$unix),2000);

$select = 'events_name, events_time, events_id';
$where = "events_time >= '" . $unix . "' AND events_time <= '" . $max . "'";
$cs_events = cs_sql_select(__FILE__,'events',$select,$where,'events_time ASC',0,0);

if (!empty($op_events['show_wars'])) {
  $select = 'war.wars_date AS events_time, war.wars_id AS wars_id, cl.clans_name AS clans_name';
  $tables = 'wars war INNER JOIN {pre}_clans cl ON war.clans_id = cl.clans_id';
  $where = 'war.wars_date >= \'' . $unix . '\' AND war.wars_date <= \'' . $max . '\'';
  $cs_events2 = cs_sql_select(__FILE__,$tables,$select,$where,'wars_date ASC',0,0);
  $count_events2 = count($cs_events2);

  for ($run = 0; $run < $count_events2; $run++) {
    $cs_events2[$run]['events_name'] = $cs_lang['war_against'] . $cs_events2[$run]['clans_name'];
  }
  
  $cs_events = !is_array($cs_events) ? array() : $cs_events;
  $cs_events2 = !is_array($cs_events2) ? array() : $cs_events2;
  $cs_events = array_merge($cs_events, $cs_events2);
}

$events_loop = count($cs_events);

$data['if']['av_events'] = empty($events_loop) ? 0 : 1;

if(!empty($events_loop)) {

  for($run=0; $run < $events_loop; $run++) {

    $link = '';
    $sec_head = cs_secure($cs_events[$run]['events_name']);
    if (!empty($cs_events[$run]['events_id']))
      $link = cs_link($sec_head,'events','view','id=' . $cs_events[$run]['events_id']);
    elseif (!empty($cs_events[$run]['wars_id']))
      $link = cs_link($sec_head,'wars','view','id=' . $cs_events[$run]['wars_id']);

      $data['events'][$run]['link'] = $link;
      $data['events'][$run]['time'] = cs_date('unix',$cs_events[$run]['events_time'],1);
  }
}

// user part
$month = cs_datereal('m',$unix);
$day = cs_datereal('d',$unix);

$select = 'users_nick, users_age, users_place, users_id, users_active';
$like = "users_age LIKE '%-" . $month . '-' . $day . "' AND users_hidden NOT LIKE '%users_age%'";
$birthdays = cs_sql_select(__FILE__,'users',$select,$like,'users_nick ASC',0,0);
$bday_loop = count($birthdays);

$data['if']['av_users'] = empty($bday_loop) ? 0 : 1;

if(!empty($bday_loop)) {

  for($run=0; $run < $bday_loop; $run++) {

    $sec_user = cs_secure($birthdays[$run]['users_nick']);
    $sec_user = cs_user($birthdays[$run]['users_id'],$birthdays[$run]['users_nick'], $birthdays[$run]['users_active']);
    $birth = explode ('-', $birthdays[$run]['users_age']);
    $age = cs_datereal('Y',$unix) - $birth[0];
    if(cs_datereal('m',$unix) < $birth[1] OR cs_datereal('d',$unix) < $birth[2] AND cs_datereal('m',$unix) == $birth[1]) {
      $age--;
    }

    $data['users'][$run]['link'] = $sec_user;
    $data['users'][$run]['new_age'] = $age;
    $data['users'][$run]['place'] = cs_secure($birthdays[$run]['users_place']);
  }
}

echo cs_subtemplate(__FILE__, $data, 'events', 'timer');