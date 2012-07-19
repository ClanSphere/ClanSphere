<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');
$data = array();
$cs_squads = array();

$squads_id = empty($_GET['id']) ? 0 : (int) $_GET['id'];
if (!empty($_POST['squads_id'])) $squads_id = (int) $_POST['squads_id'];

$cs_squads = cs_sql_select(__FILE__,'squads','squads_name, squads_id','squads_fightus = "0"','squads_name',0,0);
$data['head']['dropdown'] = cs_dropdown('squads_id','squads_name',$cs_squads,$squads_id,'squads_id');

$squad = empty($squads_id) ? '' : "squads_id = '" . $squads_id . "'";
$squad_and = empty($squads_id) ? '' : " AND squads_id = '" . $squads_id . "'";
$squad_andwr = empty($squads_id) ? '' : "AND (wr.squads_id = '" . $squads_id . "')";
$squad_players = empty($squads_id) ? '' : "INNER JOIN {pre}_wars wr ON (wr.wars_id = ply.wars_id) WHERE (wr.squads_id = '" . $squads_id . "')";
$squad_maps = empty($squads_id) ? '' : "INNER JOIN {pre}_wars wr ON (wr.wars_id = rnd.wars_id) WHERE (wr.squads_id = '" . $squads_id . "')";

$data['wars']['all'] = cs_sql_count(__FILE__,'wars', $squad);
$data['wars']['played'] = cs_sql_count(__FILE__,'wars','wars_status = \'played\'' . $squad_and);
$data['wars']['upcoming'] = cs_sql_count(__FILE__,'wars','wars_status = \'upcoming\'' . $squad_and);
$data['wars']['canceled'] = cs_sql_count(__FILE__,'wars','wars_status = \'canceled\'' . $squad_and);
$data['wars']['running'] = cs_sql_count(__FILE__,'wars','wars_status = \'running\'' . $squad_and);
$data['wars']['won_count'] = cs_sql_count(__FILE__,'wars','wars_score1 > wars_score2 AND wars_status = \'played\'' . $squad_and);
$data['wars']['won_percent'] = empty($data['wars']['won_count']) ? 0 : round($data['wars']['won_count'] / $data['wars']['played'] * 100);
$data['wars']['lost_count'] = cs_sql_count(__FILE__,'wars','wars_score1 < wars_score2 AND wars_status = \'played\'' . $squad_and);
$data['wars']['lost_percent'] = empty($data['wars']['lost_count']) ? 0 : round($data['wars']['lost_count'] / $data['wars']['played'] * 100);
$data['wars']['draw_count'] = cs_sql_count(__FILE__,'wars','wars_score1 = wars_score2 AND wars_status = \'played\'' . $squad_and);
$data['wars']['draw_percent'] = empty($data['wars']['draw_count']) ? 0 : round($data['wars']['draw_count'] / $data['wars']['played'] * 100);

$tables = 'users usr INNER JOIN {pre}_players ply ON (ply.users_id = usr.users_id) ' . $squad_players . ' GROUP BY usr.users_id, usr.users_nick, usr.users_active, usr.users_delete';
$cells  = 'usr.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete, COUNT(ply.players_id) AS wars';
$data['players'] = cs_sql_select(__FILE__,$tables,$cells,0,'wars DESC',0,0);

$data['wars']['players_count'] = count($data['players']);
$data['wars']['missions'] = 0;

for ($run = 0; $run < $data['wars']['players_count']; $run++) {
  $data['players'][$run]['user'] = cs_user($data['players'][$run]['users_id'],$data['players'][$run]['users_nick'], $data['players'][$run]['users_active'], $data['players'][$run]['users_delete']);
  $data['wars']['missions'] += $data['players'][$run]['wars'];
}

$tables = 'categories cat INNER JOIN {pre}_wars wr ON (wr.categories_id = cat.categories_id) ' . $squad_andwr . ' GROUP BY cat.categories_id, cat.categories_name';
$cells = 'cat.categories_id AS categories_id, cat.categories_name AS categories_name, COUNT(wr.wars_id) AS wars';
$data['categories'] = cs_sql_select(__FILE__,$tables,$cells,0,'wars DESC',0,0);
$data['wars']['cats_count'] = count($data['categories']);

$tables = 'maps mp INNER JOIN {pre}_rounds rnd ON rnd.maps_id = mp.maps_id ' . $squad_maps . ' GROUP BY mp.maps_id, mp.maps_name';
$cells = 'mp.maps_id AS maps_id, mp.maps_name AS maps_name, COUNT(rnd.rounds_id) AS rounds';
$data['maps'] = cs_sql_select(__FILE__,$tables,$cells,0,'rounds DESC',0,0);

$data['rounds']['count'] = count($data['maps']);
$data['rounds']['missions'] = 0;

for ($run = 0; $run < $data['rounds']['count']; $run++) {
  $data['rounds']['missions'] += $data['maps'][$run]['rounds'];
}

echo cs_subtemplate(__FILE__,$data,'wars','stats');