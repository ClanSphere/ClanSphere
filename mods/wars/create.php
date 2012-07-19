<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');

$data = array();

require_once('mods/categories/functions.php');

if(isset($_POST['submit'])) {

  $cs_wars['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] :
  cs_categories_create('wars',$_POST['categories_name']);

  $cs_wars['games_id'] = $_POST['games_id'];
  $cs_wars['clans_id'] = $_POST['clans_id'];
  $cs_wars['squads_id'] = $_POST['squads_id'];
  $cs_wars['wars_status'] = $_POST['wars_status'];
  $cs_wars['wars_score1'] = $_POST['wars_score1'] == '' ? 0 : $_POST['wars_score1'];
  $cs_wars['wars_score2'] = $_POST['wars_score2'] == '' ? 0 : $_POST['wars_score2'];
  $cs_wars['wars_players1'] = $_POST['wars_players1'] == '' ? 0 : $_POST['wars_players1'];
  $cs_wars['wars_players2'] = $_POST['wars_players2'] == '' ? 0 : $_POST['wars_players2'];
  $cs_wars['wars_opponents'] = $_POST['wars_opponents'];
  $cs_wars['wars_url'] = strpos($_POST['wars_url'],'http://') === false ? $_POST['wars_url'] : substr($_POST['wars_url'],7);
  $cs_wars['wars_report'] = $_POST['wars_report'];
  $cs_wars['wars_report2'] = $_POST['wars_report2'];
  $cs_wars['wars_date'] = cs_datepost('date','unix');
  $cs_wars['wars_close'] = isset($_POST['wars_close']) ? $_POST['wars_close'] : 0;
  $cs_wars['wars_topmatch'] = empty($_POST['wars_topmatch']) ? 0 : 1;

  $players = empty($_POST['players']) ? 1 : (int) $_POST['players'];
  $cs_players = array();

  for ($x = 1; $x <= $players; $x++) {

    $existing = array_values($cs_players);
    if(!empty($_POST['playerid'.$x])) {
      $sel = cs_sql_select(__FILE__,'users','users_nick','users_id = \''.(int) $_POST['playerid'.$x].'\'');
      $player = $sel['users_nick'];
    }
    elseif(!empty($_POST['player'.$x]))
      $player = $_POST['player'.$x];

    if(!empty($player) AND !in_array($player, $existing))
      $cs_players['player'.$x] = $player;
    else
      $players--;
  }

  if (!empty($_POST['new_enemy'])) {

    $cs_clans['clans_name'] = $_POST['new_enemy'];
    $cs_clans['clans_short'] = $_POST['new_enemy'];
    $cs_clans['clans_country'] = 'fam';
    $cs_clans['clans_since'] = 0;

    $clans_cells = array_keys($cs_clans);
    $clans_save = array_values($cs_clans);

    cs_sql_insert(__FILE__,'clans',$clans_cells,$clans_save);

    $cs_wars['clans_id'] = cs_sql_insertid(__FILE__);
  }

  $error = '';

  if(empty($cs_wars['games_id']))
    $error .= $cs_lang['no_game'] . cs_html_br(1);
  if(empty($cs_wars['categories_id']))
    $error .= $cs_lang['no_cat'] . cs_html_br(1);
  if(empty($cs_wars['clans_id']))
    $error .= $cs_lang['no_enemy'] . cs_html_br(1);
  if(empty($cs_wars['squads_id']))
    $error .= $cs_lang['no_squad'] . cs_html_br(1);
  if(empty($cs_wars['wars_date']))
    $error .= $cs_lang['no_date'] . cs_html_br(1);
  if(empty($cs_wars['wars_status']))
    $error .= $cs_lang['no_status'] . cs_html_br(1);

} else {
  $cs_wars['games_id'] = 0;
  $cs_wars['categories_id'] = 0;
  $cs_wars['clans_id'] = 0;
  $cs_wars['squads_id'] = 0;
  $cs_wars['wars_date'] = cs_time();
  $cs_wars['wars_status'] = '';
  $cs_wars['wars_score1'] = '';
  $cs_wars['wars_score2'] = '';
  $cs_wars['wars_players1'] = '';
  $cs_wars['wars_players2'] = '';
  $cs_wars['wars_opponents'] = '';
  $cs_wars['wars_url'] = '';
  $cs_wars['wars_report'] = '';
  $cs_wars['wars_report2'] = '';
  $cs_wars['wars_close'] = 0;
  $cs_wars['wars_topmatch'] = 0;

  if(!empty($_GET['fightus'])) {
    $fightus_where = "fightus_id = '" . cs_sql_escape($_GET['fightus']) . "'";
    $cs_fightus = cs_sql_select(__FILE__,'fightus','*',$fightus_where);
    if(!empty($cs_fightus)) {
      $cs_wars['games_id'] = $cs_fightus['games_id'];
      $cs_wars['squads_id'] = $cs_fightus['squads_id'];
      $cs_wars['wars_date'] = $cs_fightus['fightus_date'];
      $cs_wars['wars_status'] = 'upcoming';
      $cs_wars['wars_url'] = $cs_fightus['fightus_url'];
      $cs_wars['wars_report'] = $cs_fightus['fightus_more'];
      $cs_wars['wars_report2'] = $cs_fightus['fightus_more'];
    
      $where = "clans_name = '" . cs_sql_escape($cs_fightus['fightus_clan']) . "'";
      $cs_wars['clans_id'] = cs_sql_select(__FILE__,'clans','clans_id',$where);
    }
  }
}

if(!isset($_POST['submit'])) {
  $data['var']['message'] = $cs_lang['body_create'];
} elseif(!empty($error)) {
  $data['var']['message'] = $cs_lang['error_occured'] . cs_html_br(1) . $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $players = empty($_POST['players']) ? 1 : (int) $_POST['players'];

  if (!empty($_POST['playeradd'])) {
    $players++;

    $cs_wars['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] :
    cs_categories_create('wars',$_POST['categories_name']);

    $cs_wars['games_id'] = $_POST['games_id'];
    $cs_wars['clans_id'] = $_POST['clans_id'];
    $cs_wars['squads_id'] = $_POST['squads_id'];
    $cs_wars['wars_status'] = $_POST['wars_status'];
    $cs_wars['wars_score1'] = $_POST['wars_score1'] == '' ? 0 : $_POST['wars_score1'];
    $cs_wars['wars_score2'] = $_POST['wars_score2'] == '' ? 0 : $_POST['wars_score2'];
    $cs_wars['wars_players1'] = empty($_POST['wars_players1']) ? 0 : $_POST['wars_players1'];
    $cs_wars['wars_players2'] = empty($_POST['wars_players2']) ? 0 : $_POST['wars_players2'];
    $cs_wars['wars_opponents'] =  $_POST['wars_opponents'];
    $cs_wars['wars_url'] = $_POST['wars_url'];
    $cs_wars['wars_report'] = $_POST['wars_report'];
  $cs_wars['wars_report2'] = $_POST['wars_report2'];
    $cs_wars['wars_date'] = cs_datepost('date','unix');

    for ($x = 0; $x <= $players; $x++) {
      if (!empty($_POST['playerid'.$x])) {
        $sel = cs_sql_select(__FILE__,'users','users_nick','users_id = \''.(int) $_POST['playerid'.$x].'\'');
        $cs_players['player'.$x] = $sel['users_nick'];
      } else {
        $cs_players['player'.$x] = !empty($_POST['player'.$x]) ? $_POST['player'.$x] : '';
      }
    }

    if (!empty($_POST['new_enemy'])) {

      $cs_clans['clans_name'] = $_POST['new_enemy'];
      $cs_clans['clans_short'] = $_POST['new_enemy'];
      $cs_clans['clans_country'] = 'fam';
      $cs_clans['clans_since'] = 0;

      $clans_cells = array_keys($cs_clans);
      $clans_save = array_values($cs_clans);

      cs_sql_insert(__FILE__,'clans',$clans_cells,$clans_save);

      $cs_wars['clans_id'] = cs_sql_insertid(__FILE__);
    }
  }

  $tables = 'members mrs INNER JOIN {pre}_users usr ON mrs.users_id = usr.users_id ';
  $tables .= 'INNER JOIN {pre}_squads sq ON mrs.squads_id = sq.squads_id';
  $cells = 'DISTINCT usr.users_nick AS users_nick, usr.users_id AS users_id';
  $where = 'sq.squads_own = \'1\'';
  $cs_members = cs_sql_select(__FILE__,$tables,$cells,$where,'usr.users_nick',0,0);

  $data_games = cs_sql_select(__FILE__,'games','games_name, games_id',0,'games_name',0,0);
  $data_clans = cs_sql_select(__FILE__,'clans','clans_name, clans_id','clans_id != \'1\'','clans_name',0,0);
  $where = "squads_own = '1' AND squads_fightus = '0'";
  $data_squads = cs_sql_select(__FILE__,'squads','squads_name,squads_id',$where,'squads_name',0,0);
  $data_categories = cs_sql_select(__FILE__,'categories','categories_name, categories_id','categories_mod = \'wars\'','categories_name',0,0);

  $data['games'] = cs_dropdownsel($data_games,$cs_wars['games_id'],'games_id');
  $data['categories'] = cs_dropdownsel($data_categories,$cs_wars['categories_id'],'categories_id');

  $data['clans'] = cs_dropdownsel($data_clans,$cs_wars['clans_id'],'clans_id');
  $data_clans_count = count($data['clans']);
  for ($run = 0; $run < $data_clans_count; $run++)
    $data['clans'][$run]['clans_name'] = cs_secure($data['clans'][$run]['clans_name']);

  $data['squads'] = cs_dropdownsel($data_squads,$cs_wars['squads_id'],'squads_id');
  $data_squads_count = count($data['squads']);
  for ($run = 0; $run < $data_squads_count; $run++)
    $data['squads'][$run]['squads_name'] = cs_secure($data['squads'][$run]['squads_name']);

  $data['players'] = array();
  for($run = 1; $run <= $players; $run++) {
    $data['players'][$run-1]['run'] = $run;
    $data['players'][$run-1]['value'] = !empty($cs_players['player'.$run]) ? $cs_players['player'.$run] : '';
    $data['players'][$run-1]['dropdown'] = cs_dropdown('playerid'.$run,'users_nick',$cs_members,0,'users_id');
  }

  $data['dropdown']['date'] = cs_dateselect('date','unix',$cs_wars['wars_date'],1995);
  $data['abcode']['smileys'] = cs_abcode_smileys('wars_report');
  $data['abcode']['features'] = cs_abcode_features('wars_report');
  $data['abcode']['smileys2'] = cs_abcode_smileys('wars_report2');
  $data['abcode']['features2'] = cs_abcode_features('wars_report2');
  $data['form']['players'] = $players;

  $data['value']['opponents'] = $cs_wars['wars_opponents'];
  $data['value']['players1'] = $cs_wars['wars_players1'];
  $data['value']['players2'] = $cs_wars['wars_players2'];
  $data['value']['score1'] = $cs_wars['wars_score1'];
  $data['value']['score2'] = $cs_wars['wars_score2'];
  $data['value']['url'] = $cs_wars['wars_url'];
  $data['value']['report'] = cs_secure($cs_wars['wars_report']);
  $data['value']['report2'] = cs_secure($cs_wars['wars_report2']);
  
  $data['upcoming']['selection'] = $cs_wars['wars_status'] != 'upcoming' ? '' : ' selected="selected"';
  $data['running']['selection'] = $cs_wars['wars_status'] != 'running' ? '' : ' selected="selected"';
  $data['canceled']['selection'] = $cs_wars['wars_status'] != 'canceled' ? '' : ' selected="selected"';
  $data['played']['selection'] = $cs_wars['wars_status'] != 'played' ? '' : ' selected="selected"';

  $data['img']['game'] = cs_html_img('uploads/games/0.gif',0,0,'id="game_1"');
  
  $data['value']['wars_topmatch_check'] = empty($cs_wars['wars_topmatch']) ? '' : 'checked="checked"';
  $data['value']['close_check'] = empty($cs_wars['wars_close']) ? '' : 'checked="checked"';

  echo cs_subtemplate(__FILE__,$data,'wars','create_1');
}
else {

  settype($cs_wars['wars_score1'],'integer');
  settype($cs_wars['wars_score2'],'integer');

  $wars_cells = array_keys($cs_wars);
  $wars_save = array_values($cs_wars);
  cs_sql_insert(__FILE__,'wars',$wars_cells,$wars_save);

  $warid = cs_sql_insertid(__FILE__);

  $players = (int) $_POST['players'];

  for ($x = 1; $x <= $players; $x++) {

    if (!empty($cs_players['player'.$x])) {
      $get_user_id = cs_sql_select(__FILE__,'users','users_id','users_nick = \''.strtolower(cs_sql_escape($cs_players['player'.$x])).'\'');
      if (!empty($get_user_id)) {
        $pcells = array('users_id','wars_id','players_status','players_played','players_time');
        $pvalues = array($get_user_id['users_id'],$warid,'yes',1,cs_time());
        cs_sql_insert(__FILE__,'players',$pcells,$pvalues);
      }
    }
  }

  $data['url']['wars_pictures'] = cs_url('wars','picture','id='.$warid);
  $data['url']['wars_rounds'] = cs_url('wars','rounds','id='.$warid);

  $msg  = $cs_lang['create_done'] . "\r\n" . cs_html_br(2);
  $msg .= cs_link($cs_lang['add_pictures'], 'wars', 'picture', 'id=' . $warid) . "\r\n" . cs_html_br(1);
  $msg .= cs_link($cs_lang['add_rounds'], 'wars', 'rounds','id=' . $warid) . "\r\n" . cs_html_br(1);
  $msg .= cs_link($cs_lang['add_news'], 'news', 'create', 'warid=' . $warid);

  cs_redirect($msg,'wars');
}