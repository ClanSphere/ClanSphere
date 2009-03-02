<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

$cups_id = !empty($_POST['where']) ? (int) $_POST['where'] : (int) $_GET['where'];

$maxteams = cs_sql_select(__FILE__,'cups','cups_teams','cups_id = \''.$cups_id.'\'');
$cupteams = strlen(decbin($maxteams['cups_teams']));

$round = !empty($_POST['round']) ? (int) $_POST['round'] : $cupteams - 1;
$round = !empty($_GET['round']) ? (int) $_GET['round'] : $round;
$round2 = $cupteams - $round;
$round2 = !empty($_GET['round']) ? (int) $_GET['round'] : $round;

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];

$system = cs_sql_select(__FILE__,'cups','cups_system, cups_brackets','cups_id = \''.$cups_id.'\'');

if ($system['cups_system'] == 'teams') {
  $cs_sort[1] = 'sq1.squads_name ASC';
  $cs_sort[2] = 'sq1.squads_name DESC';
  $cs_sort[3] = 'sq2.squads_name ASC';
  $cs_sort[4] = 'sq2.squads_name DESC';
} else {
  $cs_sort[1] = 'usr1.users_nick ASC';
  $cs_sort[2] = 'usr1.users_nick DESC';
  $cs_sort[3] = 'usr2.users_nick ASC';
  $cs_sort[4] = 'usr2.users_nick DESC';
}
$cs_sort[5] = 'cm.cupmatches_loserbracket ASC';
$cs_sort[6] = 'cm.cupmatches_loserbracket DESC';

$sort = empty($_GET['sort']) ? 3 : $_GET['sort'];
$order = $cs_sort[$sort];

$tables  = 'cupmatches cm ';
if ($system['cups_system'] == 'teams') {
  $tables .= 'INNER JOIN {pre}_squads sq1 ON cm.squad1_id = sq1.squads_id ';
  $tables .= 'LEFT JOIN {pre}_squads sq2 ON cm.squad2_id = sq2.squads_id';
} else {
  $tables .= 'INNER JOIN {pre}_users usr1 ON cm.squad1_id = usr1.users_id ';
  $tables .= 'LEFT JOIN {pre}_users usr2 ON cm.squad2_id = usr2.users_id';
}

$cells  = 'cm.cupmatches_id AS cupmatches_id, cm.cupmatches_score1 AS cupmatches_score1, ';
$cells .= 'cm.cupmatches_score2 AS cupmatches_score2, cm.cupmatches_accepted1 AS cupmatches_accepted1, ';
$cells .= 'cm.cupmatches_accepted2 AS cupmatches_accepted2, ';

if (!empty($system['cups_brackets']))
  $cells .= 'cm.cupmatches_loserbracket AS cupmatches_loserbracket, ';
if ($system['cups_system'] == 'teams') {
  $cells .= 'sq1.squads_id AS squad1_id, sq1.squads_name AS squad1_name, ';
  $cells .= 'sq2.squads_id AS squad2_id, sq2.squads_name AS squad2_name';
} else {
  $cells .= 'usr1.users_id AS user1_id, usr1.users_nick AS user1_nick, ';
  $cells .= 'usr2.users_id AS user2_id, usr2.users_nick AS user2_nick';
}

$cond = 'cm.cupmatches_round = \''.$round2.'\' and cm.cupmatches_id > \''.$start.'\' and cm.cups_id = \''.$cups_id.'\'';

$data = array();

$data['matches'] = cs_sql_select(__FILE__,$tables,$cells,$cond,$order,0,$account['users_limit']);
$data['cups']['id'] = $cups_id;

$data['rounds'] = array();
$max = $cupteams - 1;

for ($i = 0; $i < $max; $i++) {
  $j = $i+1;
  $data['rounds'][$i]['value'] = $cupteams - $j;
  $data['rounds'][$i]['if']['notselected'] = $data['rounds'][$i]['value'] == $round ? false : true;
  $data['rounds'][$i]['name'] = $j; 
}


$data['vars']['matchcount'] = count($data['matches']);
$data['vars']['cups_id'] = $cups_id;
$data['pages']['list'] = cs_pages('cups','matchlist', $data['vars']['matchcount'], $start, $cups_id, $sort);
$data['if']['brackets'] = empty($system['cups_brackets']) ? false : true;
$data['sort']['team1'] = cs_sort('cups','matchlist', $start, $cups_id . '&amp;round=' . $round, 1, $sort);
$data['sort']['team2'] = cs_sort('cups','matchlist', $start, $cups_id . '&amp;round=' . $round, 3, $sort);
$data['sort']['bracket'] = cs_sort('cups','matchlist', $start, $cups_id . '&amp;round=' . $round, 5, $sort);
if ($system['cups_system'] != 'teams') $data['lang']['team'] = $cs_lang['player'];

for ($i = 0; $i < $data['vars']['matchcount']; $i++) {
  
	if (!empty($system['cups_brackets']))
    $data['matches'][$i]['bracket'] = empty($data['matches'][$i]['cupmatches_loserbracket']) ? $cs_lang['winners'] : $cs_lang['losers'];
  
  $data['matches'][$i]['status'] = empty($data['matches'][$i]['cupmatches_accepted1']) || empty($data['matches'][$i]['cupmatches_accepted2']) ?
    $cs_lang['open'] : $cs_lang['closed'];
  
	if ($system['cups_system'] == 'teams') {
    $data['matches'][$i]['team1'] = cs_link($data['matches'][$i]['squad1_name'],'squads','view','id='.$data['matches'][$i]['squad1_id']);
    $data['matches'][$i]['team2'] = cs_link($data['matches'][$i]['squad2_name'],'squads','view','id='.$data['matches'][$i]['squad2_id']);
	} else {
		$users_data = cs_sql_select(__FILE__,'users','users_active, users_delete',"users_id = '" . $data['matches'][$i]['user1_id'] . "'");
		$data['matches'][$i]['team1'] = cs_user($data['matches'][$i]['user1_id'],$data['matches'][$i]['user1_nick'], $users_data['users_active'], $users_data['users_delete']);
		$users_data = cs_sql_select(__FILE__,'users','users_active, users_delete',"users_id = '" . $data['matches'][$i]['user2_id'] . "'");
    $data['matches'][$i]['team2'] = cs_user($data['matches'][$i]['user2_id'],$data['matches'][$i]['user2_nick'], $users_data['users_active'], $users_data['users_delete']);
	}
	if (empty($data['matches'][$i]['team2']) && $data['matches'][$i]['cupmatches_score1'] == 1 && $data['matches'][$i]['cupmatches_score2'] == 0) $data['matches'][$i]['team2'] = $cs_lang['bye'];
}

echo cs_subtemplate(__FILE__, $data, 'cups', 'matchlist');

?>