<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

require_once('mods/categories/functions.php');

$wars_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $wars_id = $cs_post['id'];


if (isset($_POST['submit'])) {

  $cs_wars['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : cs_categories_create('wars', $_POST['categories_name']);
  $cs_wars['games_id'] = (int)$_POST['games_id'];
  $cs_wars['clans_id'] = (int)$_POST['clans_id'];
  $cs_wars['squads_id'] = (int)$_POST['squads_id'];
  $cs_wars['wars_status'] = $_POST['wars_status'];
  $cs_wars['wars_score1'] = $_POST['wars_score1'] == '' ? 0 : (int)$_POST['wars_score1'];
  $cs_wars['wars_score2'] = $_POST['wars_score2'] == '' ? 0 : (int)$_POST['wars_score2'];
  $cs_wars['wars_players1'] = $_POST['wars_players1'] == '' ? 0 : $_POST['wars_players1'];
  $cs_wars['wars_players2'] = $_POST['wars_players2'] == '' ? 0 : $_POST['wars_players2'];
  $cs_wars['wars_opponents'] = $_POST['wars_opponents'];
  $cs_wars['wars_url'] = strpos($_POST['wars_url'], 'http://') === false ? $_POST['wars_url'] : substr($_POST['wars_url'], 7);
  $cs_wars['wars_report'] = $_POST['wars_report'];
  $cs_wars['wars_report2'] = $_POST['wars_report2'];
  $cs_wars['wars_date'] = cs_datepost('date', 'unix');
  $cs_wars['wars_close'] = isset($_POST['wars_close']) ? $_POST['wars_close'] : 0;
  $cs_wars['wars_topmatch'] = empty($_POST['wars_topmatch']) ? 0 : 1;  
  
  $old_cells = 'users_id, players_status, players_played, players_time';
  $old_players = cs_sql_select(__FILE__, 'players', $old_cells, 'wars_id = ' . $wars_id, 0, 0, 0);
  $old_players = empty($old_players) ? array() : $old_players;
  cs_sql_delete(__FILE__, 'players', $wars_id, 'wars_id');
  
  $players = empty($_POST['players']) ? 1 : (int)$_POST['players'];
  $pcells = array('users_id', 'wars_id', 'players_status', 'players_played', 'players_time');
  
  function multiarray_search_2($array, $innerkey, $value)
  {
    foreach ($array as $outerkey => $innerarray) {
      if ($innerarray[$innerkey] == $value)
        return $outerkey;
    }
    return false;
  }
  
  for ($run = 0; $run < $players; $run++) {
    if (empty($_POST['playerid' . $run]) && !empty($_POST['player' . $run])) {
      $nick = strtolower(cs_sql_escape($_POST['player' . $run]));
      $sel = cs_sql_select(__FILE__, 'users', 'users_id', 'users_nick  = \'' . $nick . '\'');
      $users_id = !empty($sel) ? $sel['users_id'] : 0;
    } elseif (!empty($_POST['playerid' . $run])) {
      $users_id = (int)$_POST['playerid' . $run];
    } else {
      $users_id = 0;
    }
    if (!empty($users_id)) {
      $key = multiarray_search_2($old_players, 'users_id', $users_id);
      if ($key !== false) {
        $status = $old_players[$key]['players_status'];
        $played = $cs_wars['wars_status'] == 'played' ? '1' : $old_players[$key]['players_played'];
        $time = $old_players[$key]['players_time'];
      } else {
        $status = 'admin';
        $played = '1';
        $time = cs_time();
      }
      cs_sql_insert(__FILE__, 'players', $pcells, array($users_id, $wars_id, $status, $played, $time));
    }
  }
  
  $error = '';
  
  if (empty($cs_wars['games_id']))
    $error .= $cs_lang['no_game'] . cs_html_br(1);
  if (empty($cs_wars['categories_id']))
    $error .= $cs_lang['no_cat'] . cs_html_br(1);
  if (empty($cs_wars['clans_id']))
    $error .= $cs_lang['no_enemy'] . cs_html_br(1);
  if (empty($cs_wars['squads_id']))
    $error .= $cs_lang['no_squad'] . cs_html_br(1);
  if (empty($cs_wars['wars_date']))
    $error .= $cs_lang['no_date'] . cs_html_br(1);
  if (empty($cs_wars['wars_status']))
    $error .= $cs_lang['no_status'] . cs_html_br(1);

} else {
  $cells = 'games_id, clans_id, squads_id, wars_date, wars_status, wars_url, wars_report, wars_report2, ';
  $cells .= 'wars_score1, wars_score2, wars_players1, wars_players2, wars_opponents, wars_close, wars_topmatch';
  $cs_wars = cs_sql_select(__FILE__, 'wars', 'categories_id, ' . $cells, "wars_id = '" . $wars_id . "'");
}
if (!isset($_POST['submit']))
   $data['head']['body'] = $cs_lang['errors_here'];
elseif (!empty($error))
   $data['head']['body'] = $error;

if (!empty($error) or !isset($_POST['submit'])) {
  $tables = 'members mrs INNER JOIN {pre}_users usr ON mrs.users_id = usr.users_id ';
  $tables .= 'INNER JOIN {pre}_squads sq ON mrs.squads_id = sq.squads_id';
  $cells = 'DISTINCT usr.users_nick AS users_nick, usr.users_id AS users_id';
  $where = 'sq.squads_own = \'1\'';
  $cs_members = cs_sql_select(__FILE__, $tables, $cells, $where, 'usr.users_nick', 0, 0);
  
  $tables = 'players ply LEFT JOIN {pre}_users usr ON ply.users_id = usr.users_id';
  $cells = 'usr.users_nick AS users_nick';
  $psel = cs_sql_select(__FILE__, $tables, $cells, 'ply.wars_id = \'' . $wars_id . '\'', 'ply.players_status DESC', 0, 0);
  
  $players = empty($_POST['players']) ? count($psel) : (int)$_POST['players'];
  
  if (empty($players)) {
    $players = 1;
  }
  
  if (!empty($_POST['playeradd'])) {
    $players++;
  }
  
  for ($x = 0; $x < $players; $x++) {
    if (!empty($_POST['playerid' . $x])) {
      $sel = cs_sql_select(__FILE__, 'users', 'users_nick', 'users_id = \'' . (int)$_POST['playerid' . $x] . '\'');
      $cs_players[$x] = $sel['users_nick'];
    } elseif (!empty($_POST['player' . $x])) {
      $cs_players[$x] = !empty($_POST['player' . $x]) ? $_POST['player' . $x] : '';
    } elseif (!empty($psel[$x]['users_nick'])) {
      $cs_players[$x] = $psel[$x]['users_nick'];
    } else {
      $cs_players[$x] = '';
    }
  }
  
    $data['wars'] = $cs_wars;

  $cs_games = cs_sql_select(__FILE__, 'games', 'games_name,games_id', 0, 'games_name', 0, 0);
  $games_count = count($cs_games);
  for ($run = 0; $run < $games_count; $run++) {
    $sel = $cs_games[$run]['games_id'] == $cs_wars['games_id'] ? 1 : 0;
    $data['games'][$run]['choose'] = cs_html_option($cs_games[$run]['games_name'], $cs_games[$run]['games_id'], $sel);
  }
  $url = 'uploads/games/' . $cs_wars['games_id'] . '.gif';
  $data['wars']['game_img'] = cs_html_img($url, 0, 0, 'id="game_1"');
  
  $data['wars']['category_sel'] = cs_categories_dropdown('wars', $cs_wars['categories_id']);
  
  $cid = "clans_id != '1'";
  $clans_data = cs_sql_select(__FILE__, 'clans', 'clans_name,clans_id', $cid, 'clans_name', 0, 0);
  $data['wars']['enemy_sel'] = cs_dropdown('clans_id', 'clans_name', $clans_data, $cs_wars['clans_id']);
  
  $where = "squads_own = '1' AND (squads_fightus = '0' OR squads_id = " . $cs_wars['squads_id'] . ")";
  $squads_data = cs_sql_select(__FILE__, 'squads', 'squads_name,squads_id', $where, 'squads_name', 0, 0);
  $data['wars']['squad_sel'] = cs_dropdown('squads_id', 'squads_name', $squads_data, $cs_wars['squads_id']);

  
  for ($x = 0; $x < $players; $x++) {
    $data['player'][$x]['x'] = $x;
    $data['player'][$x]['x2'] = $x+1;
    $data['player'][$x]['player_name'] = $cs_players[$x];
    $data['player'][$x]['user_sel'] = cs_dropdown('playerid' . $x, 'users_nick', $cs_members, 0, 'users_id');
  }
  
  $data['wars']['date_sel'] = cs_dateselect('date', 'unix', $cs_wars['wars_date'], 1995);
  
  $status = array();
  $status[0]['wars_status'] = 'upcoming';
  $status[0]['name'] = $cs_lang['upcoming'];
  $status[1]['wars_status'] = 'running';
  $status[1]['name'] = $cs_lang['running'];
  $status[2]['wars_status'] = 'canceled';
  $status[2]['name'] = $cs_lang['canceled'];
  $status[3]['wars_status'] = 'played';
  $status[3]['name'] = $cs_lang['played'];
  $data['wars']['status_dropdown'] = cs_dropdown('wars_status', 'name', $status, $cs_wars['wars_status']);

  $data['abcode']['smileys'] = cs_abcode_smileys('wars_report');
  $data['abcode']['features'] = cs_abcode_features('wars_report');
  $data['abcode']['smileys2'] = cs_abcode_smileys('wars_report2');
  $data['abcode']['features2'] = cs_abcode_features('wars_report2');
  
  $data['wars']['check_player'] = !empty($players) ? $players : 1;

  $data['wars']['close_check'] = empty($cs_wars['wars_close']) ? '' : 'checked="checked"';

  $data['value']['wars_topmatch_check'] = empty($cs_wars['wars_topmatch']) ? '' : 'checked="checked"';   
  
  $data['wars']['id'] = $wars_id;

  echo cs_subtemplate(__FILE__,$data,'wars','edit');
}
else {
  settype($cs_wars['wars_score1'], 'integer');
  settype($cs_wars['wars_score2'], 'integer');
  
  $wars_cells = array_keys($cs_wars);
  $wars_save = array_values($cs_wars);
  cs_sql_update(__FILE__, 'wars', $wars_cells, $wars_save, $wars_id);
  
  cs_redirect($cs_lang['changes_done'], 'wars');
}