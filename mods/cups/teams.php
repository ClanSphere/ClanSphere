<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

$cups_id = (int) $_GET['where'];
$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];

$cs_sort[1] = 'squads_name ASC';
$cs_sort[2] = 'squads_name DESC';
$cs_sort[3] = 'cupsquads_time ASC';
$cs_sort[4] = 'cupsquads_time DESC';

$sort = empty($_GET['sort']) ? 3 : (int) $_GET['sort'];
$order = $cs_sort[$sort];

$data = array();
$data['count']['all'] = cs_sql_count(__FILE__,'cupsquads','cups_id = \''.$cups_id.'\'');
$data['pages']['list'] = cs_pages('cups','teams',$data['count']['all'],$start,$cups_id,$sort);
$data['sort']['name'] = cs_sort('cups', 'teams', $start, $cups_id, 1, $sort);
$data['sort']['join'] = cs_sort('cups','teams',$start,$cups_id,3,$sort);
$data['var']['message'] = cs_getmsg();

$cups_system = cs_sql_select(__FILE__,'cups','cups_system','cups_id = "' . $cups_id . '"');
$cups_system = $cups_system['cups_system'];

$cells  = 'cs.cupsquads_id AS cupsquads_id, cs.cupsquads_time AS cupsquads_time, cs.squads_id AS squads_id, ';
$tables = 'cupsquads cs INNER JOIN {pre}_';

if ($cups_system == 'users') {
  $tables .= 'users usr ON cs.squads_id = usr.users_id';
  $cells  .= 'usr.users_nick AS squads_name, usr.users_active AS users_active, usr.users_delete AS users_delete';
  $mod     = 'users';
} else {
  $tables .= 'squads sq ON cs.squads_id = sq.squads_id';
  $cells  .= 'sq.squads_name AS squads_name';
  $mod     = 'squads';
}

$data['teams'] = cs_sql_select(__FILE__,$tables,$cells,'cups_id = "' . $cups_id . '"',$order,$start,$account['users_limit']);
$count_teams = count($data['teams']);

for ($i = 0; $i < $count_teams; $i++) {
	$data['teams'][$i]['join'] = cs_date('unix', $data['teams'][$i]['cupsquads_time'],1);
	if ($cups_system == 'teams') {
		$data['teams'][$i]['team'] = cs_link($data['teams'][$i]['squads_name'], 'squads', 'view', 'id=' . $data['teams'][$i]['squads_id']);
	} else {
		$data['teams'][$i]['team'] = cs_user($data['teams'][$i]['squads_id'],$data['teams'][$i]['squads_name'], $data['teams'][$i]['users_active'], $data['teams'][$i]['users_delete']);
	}
}

echo cs_subtemplate(__FILE__, $data, 'cups', 'teams');