<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

if (!empty($cs_main)) {
	
  $data = array();
  $data['cups']['id'] = (int) $_GET['id'];
  $cup = cs_sql_select(__FILE__, 'cups', 'cups_teams', 'cups_id = ' . $data['cups']['id']);
  $cond_1 = (bool) cs_sql_count(__FILE__, 'cups', 'cups_id = ' . $data['cups']['id'] . ' AND cups_brackets = 1');
  $cond_2 = cs_sql_count(__FILE__,'cupsquads','cups_id = ' . $data['cups']['id']) - $cup['cups_teams'] / 2;
  if ($cond_1 AND $cond_2 > 1)
    $data['if']['brackets'] = TRUE;
  else
    $data['if']['brackets'] = FALSE;
  
  echo cs_subtemplate(__FILE__, $data, 'cups', 'tree');

}
else {
	

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => true, 'init_tpl' => false, 'init_mod' => true);

chdir('../../');

require_once 'system/core/functions.php';

cs_init($cs_main);
@error_reporting(E_ALL);

chdir('mods/cups/');

$cups_id = (int) $_GET['id'];

$cup = cs_sql_select(__FILE__, 'cups', 'cups_teams, cups_name, cups_system', 'cups_id = ' . $cups_id);
$rounds = strlen(decbin($cup['cups_teams']));
$rounds_1 = $rounds - 1;


$tables = 'cupmatches cm LEFT JOIN ';
$tables .= $cup['cups_system'] == 'users' ? '{pre}_users u1 ON u1.users_id = cm.squad1_id LEFT JOIN {pre}_users u2 ON u2.users_id = cm.squad2_id' :
	'{pre}_squads sq1 ON sq1.squads_id = cm.squad1_id LEFT JOIN {pre}_squads sq2 ON sq2.squads_id = cm.squad2_id LEFT JOIN {pre}_cupsquads cs1 ON cm.squad1_id = cs1.squads_id LEFT JOIN {pre}_cupsquads cs2 ON cm.squad2_id = cs2.squads_id';
$cells = $cup['cups_system'] == 'users'
  ? 'u1.users_nick AS team1_name, u1.users_id AS team1_id, u2.users_nick AS team2_name, u2.users_id AS team2_id'
  : 'sq1.squads_name AS team1_name, cm.squad1_id AS team1_id, sq2.squads_name AS team2_name, cm.squad2_id AS team2_id, '
    . 'cs1.squads_name AS squad1_name_c, cs2.squads_name AS squad2_name_c';
$cells .= ', cm.cupmatches_winner AS cupmatches_winner, cm.cupmatches_accepted1 AS cupmatches_accepted1';
$cells .= ', cm.cupmatches_accepted2 AS cupmatches_accepted2, cm.cupmatches_tree_order AS cupmatches_tree_order';
$where = 'cm.cups_id = ' . $cups_id . ' AND cm.cupmatches_round = ';

$cupmatches = array();
for ($i=0; $i < $rounds_1; $i++) {
  $temp = cs_sql_select(__FILE__, $tables, $cells, $where . ($rounds_1 - $i), 'cm.cupmatches_tree_order',0,0);
  // $cupmatches[$i] = array();
  foreach ($temp as $match)
    $cupmatches[$i][ $match['cupmatches_tree_order'] ] = $match;
}
// var_dump($cupmatches);
// Calc-Defs
$count_matches = $cup['cups_teams'];
include 'tree_inc.php';


$count_cupmatches = 0;
$result = $cup['cups_teams'];
while ($result > 2) { $result /= 2; $count_cupmatches += $result; }
$count_cupmatches += 2;
$round = 0;
$run = 0;

for ($i = 0; $i < $count_cupmatches; $i++) {
	$i2 = $i + 1;
	$round_2 = floor($round / 2);
	if (!empty($round)) {
		$currheight += (pow(2, $round - 1) - 0.5) * $entityheight;
		$currheight += (pow(2, $round - 2))       * $yspace_enemies;
		$currheight += (pow(2, $round - 2) - 0.5) * $yspace_normal;
	}
	
	imagefilledrectangle ($img, $currwidth, $currheight, $currwidth + $entitywidth, $currheight + $entityheight, $col_team_bg);
	
	$string = '';
	
	if (empty($round))
		$string = $cupmatches[0][$i]['team1_name'] = empty($cupmatches[0][$i]['team1_name']) ? $cupmatches[0][$i]['squad1_name_c'] : $cupmatches[0][$i]['team1_name'];
	elseif (!empty($cupmatches[$round-1][$run]['cupmatches_winner'])) {
		$cond = $cupmatches[$round-1][$run]['cupmatches_winner'] == $cupmatches[$round-1][$run]['team1_id'];
		$string = $cond ? $cupmatches[$round-1][$run]['team1_name'] : $cupmatches[$round-1][$run]['team2_name'];
		if (empty($cupmatches[$round-1][$run]['cupmatches_accepted1']) || empty($cupmatches[$round-1][$run]['cupmatches_accepted2'])) $string = '(' . $string . ')';
  }
  $string = mb_convert_encoding($string, "ISO-8859-1", $cs_main['charset']);
	if (!empty($string)) imagestring($img, $font_match, $currwidth + 10, $currheight + $entity_font_height, $string, $col_team_font);
	
	$run++;
	if ($i2 == $count_cupmatches) break;
	if (empty($round))
	    $currheight += empty($round) ? $entityheight + $yspace_enemies : ($round + 1) * $entityheight + $yspace_enemies * $round + $round * $entityheight_2;
	else {
	    $currheight += pow(2, $round)     * $entityheight;
	    $currheight += pow(2, $round - 1) * $yspace_enemies;
	    $currheight += pow(2, $round - 1) * $yspace_normal;
	}
	imagefilledrectangle ($img, $currwidth, $currheight, $currwidth + $entitywidth, $currheight + $entityheight, $col_team_bg);
	
	$string = '';
	if (empty($round))
		$string = $cupmatches[0][$i]['team2_name'] = empty($cupmatches[0][$i]['team2_name']) ? $cupmatches[0][$i]['squad2_name_c'] : $cupmatches[0][$i]['team2_name'];
	elseif (!empty($cupmatches[$round-1][$run]['cupmatches_winner'])) {
		$cond = $cupmatches[$round-1][$run]['cupmatches_winner'] == $cupmatches[$round-1][$run]['team1_id'];
		$string = $cond ? $cupmatches[$round-1][$run]['team1_name'] : $cupmatches[$round-1][$run]['team2_name'];
		if (empty($cupmatches[$round-1][$run]['cupmatches_accepted1']) || empty($cupmatches[$round-1][$run]['cupmatches_accepted2'])) $string = '(' . $string . ')';
  }
  $string = mb_convert_encoding($string, "ISO-8859-1", $cs_main['charset']);
	if (!empty($string)) imagestring($img, $font_match, $currwidth + 10, $currheight + $entity_font_height, $string, $col_team_font);
	
	if (empty($round))
	    $currheight += $entityheight + $yspace_normal;
	else {
		$currheight += (pow(2, $round - 1) + 0.5) * $entityheight;
		$currheight +=  pow(2, $round - 2)        * $yspace_enemies;
		$currheight += (pow(2, $round - 2) + 0.5) * $yspace_normal;
		
	}
	$run++;
	if ($i2 >= $max) {
		$currheight = $space_top;
		$currwidth += $entitywidth + $xspace;
		$nexthalf /= 2;
		$max += $nexthalf;
		$round++;
		$run = 0;
		// $rounds_1--;
		// $cupmatches[$round] = cs_sql_select(__FILE__, $tables, $cells, $where . $rounds_1 . ' AND cm.cupmatches_loserbracket = 0', 'cm.cupmatches_tree_order',0,0);
	}
	
}

header ('Content-type: image/png');
imagepng($img);
imagedestroy($img);
	
	
}