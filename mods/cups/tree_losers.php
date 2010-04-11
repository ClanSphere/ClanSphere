<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => true, 'init_tpl' => false, 'init_mod' => true);

chdir('../../');

require_once 'system/core/functions.php';

cs_init($cs_main);
@error_reporting(E_ALL);

chdir('mods/cups/');

$cups_id = (int) $_GET['id'];

$cup = cs_sql_select(__FILE__, 'cups', 'cups_teams, cups_name, cups_system', 'cups_id = ' . $cups_id);


// Style-Defs
$height = 400;
$width = 600;

$img = imagecreatetruecolor($width, $height) or die('Cannot Initialize new GD image stream');

$col_bg = imagecolorallocate($img, 255, 255, 255);
$col_csp_red = imagecolorallocate ($img, 186, 22, 22);
$col_csp_grey = imagecolorallocate ($img, 137, 137, 137);
$col_cup_headline = imagecolorallocate ($img, 0, 0, 0);
$col_team_bg = imagecolorallocate ($img, 200, 200, 200);
$col_team_font = imagecolorallocate ($img, 0, 0, 0);

$font_csp = 3;
$font_csp_width = imagefontwidth($font_csp);
$font_cup_headline = 2;
$font_match = 3;
$font_match_height = imagefontheight($font_match);

// Set background
imagefilledrectangle($img, 0,0, $width, $height, $col_bg);

// Headline
imagestring($img, $font_csp, 15, 15, 'CLAN', $col_csp_red);
imagestring($img, $font_csp, $font_csp_width * 4 + 15, 15, 'SPHERE', $col_csp_grey);
imagestring($img, $font_cup_headline, $font_csp_width * 10 + 15, 15, ' - Turnier: ' . $cup['cups_name'], $col_cup_headline);

$yspace_enemies = 4;
$yspace_normal = 8;
$xspace = 15;
$space_top = $currheight = 45;
$space_bottom = 5;
$space_left = $currwidth = 15;
$space_right = 10;

// Calc-Defs
$losers = cs_sql_count(__FILE__,'cupsquads','cups_id = '.$cups_id) - $cup['cups_teams'] / 2;
$rounds = strlen(decbin($losers));
$halfteams = $losers / 2;

$entityheight = round(($height - $space_top - $space_bottom - $halfteams * $yspace_enemies - $halfteams * $yspace_normal) / $cup['cups_teams']) ;
$entitywidth = round(($width - $space_left - $space_right - ($rounds) * $xspace) / ($rounds));
$entity_font_height = round($entityheight / 2 - $font_match_height / 2);
$entityheight_2 = round($entityheight / 2);
$yspace_normal_2 = round($yspace_normal / 2);

// "Cached" variables
$nexthalf = $halfteams;
$max = $nexthalf;
$round = 0;
$run = 0;

if($losers > 1) { // > 1
  // calc number of matches
  $n=2;
  while ( $losers >= $n ) $n *= 2;
  $count_matches = $n / 2;
  
  // select all losermatches and store in $cupmatches[rounds]
  $cupmatches = array();
  $rounds_loop = $rounds-1;
  $tables = 'cupmatches cm INNER JOIN ';
  $tables .= $cup['cups_system'] == 'users' ? '{pre}_users u1 ON u1.users_id = cm.squad1_id LEFT JOIN {pre}_users u2 ON u2.users_id = cm.squad2_id' :
    '{pre}_squads sq1 ON sq1.squads_id = cm.squad1_id LEFT JOIN {pre}_squads sq2 ON sq2.squads_id = cm.squad2_id LEFT JOIN {pre}_cupsquads cs1 ON cm.squad1_id = cs1.squads_id LEFT JOIN {pre}_cupsquads cs2 ON cm.squad2_id = cs2.squads_id';
  $cells = $cup['cups_system'] == 'users' ? 'u1.users_nick AS team1_name, u1.users_id AS team1_id, u2.users_nick AS team2_name, u2.users_id AS team2_id' :
    'sq1.squads_name AS team1_name, cm.squad1_id AS team1_id, sq2.squads_name AS team2_name, cm.squad2_id AS team2_id, cs1.squads_name AS squad1_name_c, cs2.squads_name AS squad2_name_c';
  $cells .= ', cm.cupmatches_winner AS cupmatches_winner, cm.cupmatches_accepted1 AS cupmatches_accepted1';
  $cells .= ', cm.cupmatches_accepted2 AS cupmatches_accepted2';
  while ($rounds_loop > 1) {
    $where = 'cm.cups_id = ' . $cups_id . ' AND cm.cupmatches_round = '. $rounds_loop . ' AND cupmatches_loserbracket = 1';
    $cupmatches[$rounds_loop] = cs_sql_select(__FILE__, $tables, $cells, $where, 'cm.cupmatches_id',0,0);
    $rounds_loop--;
  }
  
  // create image
  $rounds_loop = $rounds-1;
  for ($i = 0; $i < $count_matches; $i++) {
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
      $string = $cupmatches[$rounds_loop][$i]['team1_name'] = empty($cupmatches[$rounds_loop][$i]['team1_name']) ? $cupmatches[$rounds_loop][$i]['squad1_name_c'] : $cupmatches[$rounds_loop][$i]['team1_name'];
    elseif (!empty($cupmatches[$rounds_loop+1][$run]['cupmatches_winner'])) {
      $cond = $cupmatches[$rounds_loop+1][$run]['cupmatches_winner'] == $cupmatches[$rounds_loop+1][$run]['team1_id'];
      $string = $cond ? $cupmatches[$rounds_loop+1][$run]['team1_name'] : $cupmatches[$rounds_loop+1][$run]['team2_name'];
      if (empty($cupmatches[$rounds_loop+1][$run]['cupmatches_accepted1']) || empty($cupmatches[$rounds_loop+1][$run]['cupmatches_accepted2'])) $string = '(' . $string . ')';
      $string = empty($string) ? '-' : $string;
    }
    $string = mb_convert_encoding($string, "ISO-8859-1", $cs_main['charset']);
    if (!empty($string)) imagestring($img, $font_match, $currwidth + 10, $currheight + $entity_font_height, $string, $col_team_font);

    $run++;
    if ($i2 == $count_matches) break;
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
      $string = $cupmatches[$rounds_loop][$i]['team2_name'] = empty($cupmatches[$rounds_loop][$i]['team2_name']) ? $cupmatches[$rounds_loop][$i]['squad2_name_c'] : $cupmatches[$rounds_loop][$i]['team2_name'];
    elseif (!empty($cupmatches[$rounds_loop+1][$run]['cupmatches_winner'])) {
      $cond = $cupmatches[$rounds_loop+1][$run]['cupmatches_winner'] == $cupmatches[$rounds_loop+1][$run]['team1_id'];
      $string = $cond ? $cupmatches[$rounds_loop+1][$run]['team1_name'] : $cupmatches[$rounds_loop+1][$run]['team2_name'];
      if (empty($cupmatches[$rounds_loop+1][$run]['cupmatches_accepted1']) || empty($cupmatches[$rounds_loop+1][$run]['cupmatches_accepted2'])) $string = '(' . $string . ')';
      $string = empty($string) ? '-' : $string;
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
      $rounds_loop--;
    }
  }
}

header ('Content-type: image/png');
imagepng($img);
imagedestroy($img);