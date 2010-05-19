<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$halfteams = $count_matches / 2;

// Style-Defs
$yspace_enemies = 4;
$yspace_normal = 8;
$xspace = 15;
$space_top = $currheight = 45;
$space_bottom = 5;
$space_left = $currwidth = 15;
$space_right = 10;
$entityheight = 25;

$height = $count_matches * ($entityheight + $yspace_normal/2 + $yspace_enemies/2) + $space_top + $space_bottom;
$width = empty($_GET['width']) ? 600 : $_GET['width'];

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

// $entityheight = round(($height - $space_top - $space_bottom - $halfteams * $yspace_enemies - $halfteams * $yspace_normal) / $cup['cups_teams']) ;
$entitywidth = round(($width - $space_left - $space_right - ($rounds) * $xspace) / ($rounds));
$entity_font_height = round($entityheight / 2 - $font_match_height / 2);
$entityheight_2 = round($entityheight / 2);
$yspace_normal_2 = round($yspace_normal / 2);

// "Cached" variables
$nexthalf = $halfteams;
$max = $nexthalf;
