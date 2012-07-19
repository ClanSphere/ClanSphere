<?php
$cs_lang = cs_translate('wars');
$users_id = $_REQUEST['id'];

$where = empty($_REQUEST['where']) ? $_GET['id'] : $_REQUEST['where'];
$data = array();
$data['wars']['see_page'] = cs_addons('users','view',$where,'wars');


$tables = "users usr INNER JOIN {pre}_players ply ON ply.users_id = '" . $users_id . "'";
$cells  = 'usr.users_id AS users_id, usr.users_nick AS users_nick, ply.wars_id AS wars_id';
$where =  "ply.players_played = '1' AND usr.users_id = '" . $users_id . "'";
$player_wars = cs_sql_select(__FILE__,$tables,$cells,$where,0,0,0);
$player_wars_count = count($player_wars);


$data['wars']['played'] = $player_wars_count;

$data['wars']['win'] = 0;
$data['wars']['draw'] = 0;
$data['wars']['lost'] = 0;
for($run=0; $run<$player_wars_count; $run++) {
  $select2 = 'wars_id, wars_score1, wars_score2, wars_status';
  $win = "wars_id = '" . $player_wars[$run]['wars_id'] . "' AND wars_score1 > wars_score2 AND wars_status = 'played'";
  $wars_win = cs_sql_select(__FILE__,'wars',$select2,$win,0,0,0);
  $data['wars']['win'] = $data['wars']['win'] + count($wars_win);
  
  $draw = "wars_id = '" . $player_wars[$run]['wars_id'] . "' AND wars_score1 = wars_score2 AND wars_status = 'played'";
  $wars_draw = cs_sql_select(__FILE__,'wars',$select2,$draw,0,0,0);
  $data['wars']['draw'] = $data['wars']['draw'] + count($wars_draw);
  
  $lost = "wars_id = '" . $player_wars[$run]['wars_id'] . "' AND wars_score1 < wars_score2 AND wars_status = 'played'";
  $wars_lost = cs_sql_select(__FILE__,'wars',$select2,$lost,0,0,0);
  $data['wars']['lost'] = $data['wars']['lost'] + count($wars_lost);
}
$data['wars']['win_percent'] = empty($data['wars']['win']) ? 0 : round($data['wars']['win'] / $data['wars']['played'] * 100);
$data['wars']['draw_percent'] = empty($data['wars']['draw']) ? 0 : round($data['wars']['draw'] / $data['wars']['played'] * 100);
$data['wars']['lost_percent'] = empty($data['wars']['lost']) ? 0 : round($data['wars']['lost'] / $data['wars']['played'] * 100);

echo cs_subtemplate(__FILE__,$data,'wars','users');
