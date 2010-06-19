<?php
// ClanSphere 2010 - www.clansphere.net
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
$data['count']['all'] = cs_sql_count(__FILE__,'cupsquads','cups_id = ' . $cups_id);
$data['pages']['list'] = cs_pages('cups','teams',$data['count']['all'],$start,$cups_id,$sort);
$data['sort']['name'] = cs_sort('cups', 'teams', $start, $cups_id, 1, $sort);
$data['sort']['join'] = cs_sort('cups','teams',$start,$cups_id,3,$sort);
$data['var']['message'] = cs_getmsg();

$cups_system = cs_sql_select(__FILE__,'cups','cups_system','cups_id = ' . $cups_id);
$cups_system = $cups_system['cups_system'];


if ($cups_system == 'users') {
  // user
  $tables  = 'cupsquads cs INNER JOIN {pre}_';
  $tables .= 'users usr ON cs.squads_id = usr.users_id';
  $cells   = 'cs.cupsquads_id AS cupsquads_id, cs.cupsquads_time AS cupsquads_time, cs.squads_id AS squads_id, ';
  $cells  .= 'usr.users_nick AS squads_name, usr.users_active AS users_active, usr.users_delete AS users_delete';
  $mod     = 'users';
  $data['teams'] = cs_sql_select(__FILE__,$tables,$cells,'cups_id = ' . $cups_id,$order,$start,$account['users_limit']);
} else {
  // squad
  $squads_ids = cs_sql_select(__FILE__,'cupsquads cup LEFT JOIN {pre}_squads team ON cup.squads_id = team.squads_id','cup.squads_id, cup.cupsquads_id, cup.cupsquads_time, team.squads_name','cup.cups_id = ' . $cups_id,$order,$start,$account['users_limit']);
  $run=0;
  if(!empty($squads_ids)) {
    foreach($squads_ids as $squads_run) {
      if(empty($squads_run['squads_name'])) {
        // squad wurde bereits gelöscht
        $data['teams'][$run]['squads_name'] = '? ID: ' . $squads_run['squads_id'];
        $data['teams'][$run]['squads_id'] = 0;
      }
      else {
        $data['teams'][$run]['squads_id'] = $squads_run['squads_id'];
        $data['teams'][$run]['squads_name'] = $squads_run['squads_name'];
      }
      $data['teams'][$run]['cupsquads_time'] = $squads_run['cupsquads_time'];
      $data['teams'][$run]['cupsquads_id'] = $squads_run['cupsquads_id'];
      $run++;
    }
  }
  $mod     = 'squads';
}

$count_teams = empty($data['teams']) ? 0 : count($data['teams']);
$data['if']['teams_loop'] = empty($count_teams) ? FALSE : TRUE;
for ($i = 0; $i < $count_teams; $i++) {
  $data['teams'][$i]['join'] = cs_date('unix', $data['teams'][$i]['cupsquads_time'],1);
  if ($cups_system == 'teams') {
    $data['teams'][$i]['team'] = empty($data['teams'][$i]['squads_id']) ? cs_secure($data['teams'][$i]['squads_name']) : cs_link(cs_secure($data['teams'][$i]['squads_name']),'squads','view','id=' . $data['teams'][$i]['squads_id']);
  } else {
    $data['teams'][$i]['team'] = cs_user($data['teams'][$i]['squads_id'],$data['teams'][$i]['squads_name'], $data['teams'][$i]['users_active'], $data['teams'][$i]['users_delete']);
  }
}

echo cs_subtemplate(__FILE__, $data, 'cups', 'teams');