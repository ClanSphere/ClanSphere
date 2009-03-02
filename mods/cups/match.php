<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

$match_id = (int) $_GET['id'];

$tables = 'cupmatches cm INNER JOIN {pre}_cups cp ON cm.cups_id = cp.cups_id';
$cells = 'cp.cups_system AS cups_system';
$system = cs_sql_select(__FILE__,$tables,$cells,'cm.cupmatches_id = \''.$match_id.'\'');

$tables  = 'cupmatches cm ';
$tables .= 'INNER JOIN {pre}_cups cp ON cm.cups_id = cp.cups_id ';
$tables .= 'INNER JOIN {pre}_games gms ON cp.games_id = gms.games_id ';

if ($system['cups_system'] == 'teams') {
  $tables .= 'INNER JOIN {pre}_squads sq1 ON cm.squad1_id = sq1.squads_id ';
  $tables .= 'INNER JOIN {pre}_squads sq2 ON cm.squad2_id = sq2.squads_id';
} else {
  $tables .= 'INNER JOIN {pre}_users usr1 ON cm.squad1_id = usr1.users_id ';
  $tables .= 'INNER JOIN {pre}_users usr2 ON cm.squad2_id = usr2.users_id';
}

$cells  = 'cm.cups_id AS cups_id, cp.cups_name AS cups_name, ';
$cells .= 'cp.games_id AS games_id, gms.games_name AS games_name, ';
$cells .= 'cm.cupmatches_score1 AS cupmatches_score1, ';
$cells .= 'cm.cupmatches_score2 AS cupmatches_score2, ';
$cells .= 'cm.cupmatches_accepted1 AS cupmatches_accepted1, ';
$cells .= 'cm.cupmatches_accepted2 AS cupmatches_accepted2, ';
$cells .= 'cm.cupmatches_winner AS cupmatches_winner, ';

if ($system['cups_system'] == 'teams') {
  $cells .= 'sq1.squads_name AS squad1_name, sq2.squads_name AS squad2_name, ';
  $cells .= 'cm.squad1_id AS squad1_id, cm.squad2_id AS squad2_id';
} else {
  $cells .= 'usr1.users_nick AS user1_nick, usr2.users_nick AS user2_nick, ';
  $cells .= 'cm.squad1_id AS user1_id, cm.squad2_id AS user2_id';
}

$data = array();

$data['get']['message'] = cs_getmsg();
$data['match'] = cs_sql_select(__FILE__,$tables,$cells,'cupmatches_id = \''.$match_id.'\'');

if ($system['cups_system'] == 'teams') {
  $data['match']['team1'] = cs_link($data['match']['squad1_name'],'squads','view','id=' . $data['match']['squad1_id']);
  $data['match']['team2'] = cs_link($data['match']['squad2_name'],'squads','view','id=' . $data['match']['squad2_id']);
} else {
  $data['lang']['team'] = $cs_lang['player'];
  
  $users_data = cs_sql_select(__FILE__,'users','users_active, users_delete',"users_id = '" . $data['match']['user1_id'] . "'");
  $data['match']['team1'] = cs_user($data['match']['user1_id'], $data['match']['user1_nick'], $users_data['users_active'], $users_data['users_delete']);
  $users_data = cs_sql_select(__FILE__,'users','users_active, users_delete',"users_id = '" . $data['match']['user2_id'] . "'");
  $data['match']['team2'] = cs_user($data['match']['user2_id'], $data['match']['user2_nick'], $users_data['users_active'], $users_data['users_delete']);
}

# das muss ueberarbeitet werden
$nothingyet = empty($data['match']['cupmatches_score1']) && empty($data['match']['cupmatches_score2']) ? true : false;
$nothingyet = !empty($nothingyet) && empty($data['match']['cupmatches_accepted1']) ? true : false;
$nothingyet = !empty($nothingyet) && empty($data['match']['cupmatches_accepted2']) && empty($data['match']['cupmatches_winner']) ? true : false;
$data['if']['showscore'] = empty($nothingyet) ? true : false;

$data['match']['status'] = empty($data['match']['cupmatches_accepted1']) || empty($data['match']['cupmatches_accepted2']) ? $cs_lang['open'] : $cs_lang['closed'];


if ($system['cups_system'] == 'teams') {
  $cond = 'users_id = "' . $account['users_id'] . '" AND squads_id = "' . $data['match']['squad1_id'] . '"';
  $squad1_member = cs_sql_count(__FILE__,'members',$cond);
  
  $cond = 'users_id = "' . $account['users_id'] . '" AND squads_id = "' . $data['match']['squad2_id'] . '"';
  $squad2_member = cs_sql_count(__FILE__,'members',$cond);
} else {
  $squad1_member = $data['match']['user1_id'] == $account['users_id'] ? 1 : 0;
  $squad2_member = $data['match']['user2_id'] == $account['users_id'] ? 1 : 0;
}

if (!empty($squad1_member) OR !empty($squad2_member) OR $account['access_cups'] >= 4) {
	$data['if']['participator'] = true;
	$data['match']['id'] = $match_id;
	
	if (!empty($data['match']['cupmatches_winner'])) {
		$squad1 = $system['cups_system'] == 'teams' ? $data['match']['squad1_id'] : $data['match']['user1_id'];
	  $winner = $data['match']['cupmatches_winner'] == $squad1 ? $data['match']['team1'] : $data['match']['team2'];
	  $data['match']['cupmatches_score2'] .= ' (' . $cs_lang['winner'] . ': ' . $winner . ')';
	}
	
	$data['if']['nothingyet'] = false;
	$data['if']['accept'] = false;
	$data['if']['confirmed'] = false;
	$data['if']['waiting'] = false;
	$data['if']['admin'] = $account['access_cups'] >= 4 ? true : false;
	
	$data['match']['teamnr'] = empty($squad2_member) ? 1 : 2;
	if ($data['match']['teamnr'] == 1 && empty($squad1_member)) $data['match']['teamnr'] = 0;
	
	if (!empty($data['match']['teamnr']) && !empty($nothingyet)) {
    $data['if']['nothingyet'] = true;
  } elseif ((!empty($squad1_member) && empty($data['match']['cupmatches_accepted1'])) || (!empty($squad2_member) && empty($data['match']['cupmatches_accepted2']))) {
  	$data['if']['accept'] = true;
  } elseif (!empty($data['match']['cupmatches_accepted1']) && !empty($data['match']['cupmatches_accepted2'])) {
	  $data['if']['confirmed'] = true;
  } elseif (!empty($data['match']['cupmatches_accepted1']) || !empty($data['match']['cupmatches_accepted2'])) {
  	$data['if']['waiting'] = true;
  	$other_team = empty($squad2_member) ? 2 : 1;
    if ($system['cups_system'] == 'teams') {
      $link = cs_link($data['match']['squad'.$other_team.'_name'],'squads','view','id='.$data['match']['squad'.$other_team.'_id']);
    } else {
      $users_data = cs_sql_select(__FILE__,'users','users_active',"users_id = '" . $data['match']['user'.$other_team.'_id'] . "'");
      $link =  cs_user($data['match']['user'.$other_team.'_id'],$data['match']['user'.$other_team.'_nick'], $users_data['users_active']);
    }
    $data['lang']['waiting'] = sprintf($cs_lang['waiting'],$link);  
  } else {
  	$data['if']['waiting'] = true;
  	$data['lang']['waiting'] = $cs_lang['waiting_both'];
  }
} else
  $data['if']['participator'] = false;

echo cs_subtemplate(__FILE__, $data, 'cups', 'match');

include_once 'mods/comments/functions.php';

$count = cs_sql_count(__FILE__,'comments','comments_fid = \''.$match_id.'\' AND comments_mod = \'cups\'');
if (!empty($count)) cs_comments_view($match_id,'cups','match',$count);
cs_comments_add($match_id,'cups');

?>