<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$op_events = cs_sql_option(__FILE__,'events');

$unix = empty($_GET['unix']) ? cs_datereal('U') : $_GET['unix'];
settype($unix,'integer');
if(!empty($_POST['date_year']) AND !empty($_POST['date_month']) AND !empty($_POST['date_day'])) {
	$unix = mktime(0, 0, 0, $_POST['date_month'], $_POST['date_day'], $_POST['date_year']);
}
$unix = cs_datereal('U',$unix);
$max = $unix + 86399;

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_timer'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['date'];
echo cs_html_form(1,'events_timer','events','timer');
echo cs_dateselect('date','date',cs_datereal('Y-m-d',$unix),2000);
echo cs_html_vote('submit',$cs_lang['show'],'submit');
echo cs_html_form(0);
echo cs_html_roco(2,'rightb');
echo cs_link($cs_lang['calendar'],'events','calendar');
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

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

if(!empty($events_loop)) {
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'headb',0,0,'70%');
	echo $cs_lang['name'];
	echo cs_html_roco(2,'headb',0,0,'30%');
	echo $cs_lang['time'];
	echo cs_html_roco(0);

	for($run=0; $run<$events_loop; $run++) {

		echo cs_html_roco(1,'leftc');
		$sec_head = cs_secure($cs_events[$run]['events_name']);
    if (!empty($cs_events[$run]['events_id']))
		  echo cs_link($sec_head,'events','view','id=' . $cs_events[$run]['events_id']);
    elseif (!empty($cs_events[$run]['wars_id']))
      echo cs_link($sec_head,'wars','view','id=' . $cs_events[$run]['wars_id']);
		echo cs_html_roco(2,'leftc');
		echo cs_date('unix',$cs_events[$run]['events_time'],1);
		echo cs_html_roco(0);
	}
	echo cs_html_table(0);
	echo cs_html_br(1);
}

$month = cs_datereal('m',$unix);
$day = cs_datereal('d',$unix);

$select = 'users_nick, users_age, users_place, users_id, users_active';
$like = "users_age LIKE '%-" . $month . '-' . $day . "' AND users_active = '1'";
$birthdays = cs_sql_select(__FILE__,'users',$select,$like,'users_nick ASC',0,0);
$bday_loop = count($birthdays);

if(!empty($bday_loop)) {
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'headb',0,0,'40%');
	echo $cs_lang['user'];
	echo cs_html_roco(2,'headb',0,0,'20%');
	echo $cs_lang['new_age'];
	echo cs_html_roco(3,'headb',0,0,'40%');
	echo $cs_lang['place'];
	echo cs_html_roco(0);

	for($run=0; $run<$bday_loop; $run++) {

		echo cs_html_roco(1,'leftc');
		$sec_user = cs_secure($birthdays[$run]['users_nick']);
		echo cs_user($birthdays[$run]['users_id'],$birthdays[$run]['users_nick'], $birthdays[$run]['users_active']);
		echo cs_html_roco(2,'leftc');
		$birth = explode ('-', $birthdays[$run]['users_age']);
		$age = cs_datereal('Y',$unix) - $birth[0];
		if(cs_datereal('m',$unix) < $birth[1] OR cs_datereal('d',$unix) < $birth[2] AND cs_datereal('m',$unix) == $birth[1]) {
			$age--;
		}
		echo $age;
		echo cs_html_roco(2,'leftc');
		echo cs_secure($birthdays[$run]['users_place']);
		echo cs_html_roco(0);
	}
	echo cs_html_table(0);
}

?>