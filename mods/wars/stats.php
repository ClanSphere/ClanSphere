<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');

$data = array();

$data['wars']['all'] = cs_sql_count(__FILE__,'wars');
$data['wars']['played'] = cs_sql_count(__FILE__,'wars','wars_status = \'played\'');
$data['wars']['won_count'] = cs_sql_count(__FILE__,'wars','wars_score1 > wars_score2 AND wars_status = \'played\'');
$data['wars']['won_percent'] = empty($data['wars']['won_count']) ? 0 : round($data['wars']['won_count'] / $data['wars']['played'] * 100);
$data['wars']['lost_count'] = cs_sql_count(__FILE__,'wars','wars_score1 < wars_score2 AND wars_status = \'played\'');
$data['wars']['lost_percent'] = empty($data['wars']['lost_count']) ? 0 : round($data['wars']['lost_count'] / $data['wars']['played'] * 100);
$data['wars']['draw_count'] = cs_sql_count(__FILE__,'wars','wars_score1 = wars_score2 AND wars_status = \'played\'');
$data['wars']['draw_percent'] = empty($data['wars']['draw_count']) ? 0 : round($data['wars']['draw_count'] / $data['wars']['played'] * 100);

$data['rounds']['count'] = cs_sql_count(__FILE__,'rounds');

$data['wars']['players_count'] = cs_sql_count(__FILE__,'players');

$tables = 'users usr INNER JOIN {pre}_players ply ON ply.users_id = usr.users_id GROUP BY usr.users_id, usr.users_nick';
$cells  = 'usr.users_id AS users_id, usr.users_nick AS users_nick, COUNT(ply.players_id) AS wars';
$data['players'] = cs_sql_select(__FILE__,$tables,$cells,0,'wars DESC',0,5);
$count_players = count($data['players']);

for ($run = 0; $run < $count_players; $run++) {
  $data['players'][$run]['url'] = cs_url('users','view','id='.$data['players'][$run]['users_id']);
  $data['players'][$run]['users_nick'] = cs_secure($data['players'][$run]['users_nick']);
}

$tables = 'categories cat INNER JOIN {pre}_wars wr ON wr.categories_id = cat.categories_id GROUP BY cat.categories_id, cat.categories_name';
$cells  = 'cat.categories_id AS categories_id, cat.categories_name AS categories_name, COUNT(wr.wars_id) AS wars';
$data['categories'] = cs_sql_select(__FILE__,$tables,$cells,0,'wars DESC',0,5);
$count_categories = count($data['categories']);

for ($run = 0; $run < $count_categories; $run++) {
  $data['categories'][$run]['url'] = cs_url('categories','view','id='.$data['categories'][$run]['categories_id']);
  $data['categories'][$run]['categories_name'] = cs_secure($data['categories'][$run]['categories_name']);
}

$tables = 'maps mp INNER JOIN {pre}_rounds rnd ON rnd.maps_id = mp.maps_id GROUP BY mp.maps_id, mp.maps_name';
$cells = 'mp.maps_id AS maps_id, mp.maps_name AS maps_name, COUNT(rnd.rounds_id) AS rounds';
$data['maps'] = cs_sql_select(__FILE__,$tables,$cells,0,'rounds DESC',0,5);
$count_maps = count($data['maps']);

for ($run = 0; $run < $count_maps; $run++) {
  $data['maps'][$run]['maps_name'] = cs_secure($data['maps'][$run]['maps_name']);
}

echo cs_subtemplate(__FILE__,$data,'wars','stats');

?>