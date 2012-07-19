<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');

$wars['if']['squadmember'] = FALSE;

$wars_id = empty($_REQUEST['where']) ? (int) $_GET['id'] : (int) $_REQUEST['where'];
$cells  = 'games_id, categories_id, clans_id, wars_opponents, squads_id, wars_status, wars_players1, wars_players2, ';
$cells .= 'wars_score1, wars_score2, wars_url, wars_pictures, wars_report, wars_report2, wars_date, wars_status, wars_close';
$cs_wars = cs_sql_select(__FILE__,'wars',$cells,"wars_id = '" . $wars_id . "'");

$wars['head']['topline'] = $cs_lang['body_view'];

$wars['lang']['getmsg'] = cs_getmsg();

$gameicon = 'uploads/games/'.$cs_wars['games_id'].'.gif';
$where = "games_id = '" . $cs_wars['games_id'] . "'";
$cs_game = cs_sql_select(__FILE__,'games','games_name, games_id',$where);

$wars['game']['icon'] = file_exists($gameicon) ? cs_html_img($gameicon) : '';
$wars['game']['link'] = cs_link($cs_game['games_name'],'games','view','id=' . $cs_game['games_id']);

$where = "categories_id = '" . $cs_wars['categories_id'] . "'";
$cs_cat = cs_sql_select(__FILE__,'categories','categories_name, categories_id',$where);
$wars['lang']['category'] = $cs_lang['category'];
$wars['category']['link'] = cs_link($cs_cat['categories_name'],'categories','view','id=' . $cs_cat['categories_id']);

$where = "clans_id = '" . $cs_wars['clans_id'] . "'";
$cs_clan = cs_sql_select(__FILE__,'clans','clans_name, clans_picture, clans_country, clans_id',$where);
$wars['enemy']['link'] = cs_link(cs_secure($cs_clan['clans_name']),'clans','view','id=' . $cs_clan['clans_id']);
$wars['enemy']['logo'] = ! empty($cs_clan['clans_picture']) ? cs_html_img('uploads/clans/' . $cs_clan['clans_picture']) : $cs_lang['no_logo'];   
if(!empty($cs_wars['wars_opponents'])) {
$wars['wars']['opponents'] = cs_secure($cs_wars['wars_opponents'],0,0,0);
} else {
$wars['wars']['opponents'] = '-';
}
if(!empty($cs_clan['clans_country'])) {
$wars['enemy']['country'] = cs_html_img('symbols/countries/' . $cs_clan['clans_country'] . '.png',11,16);
} else {
$wars['enemy']['country'] = '-';
}


$select = 'sqd.squads_name AS squads_name, sqd.squads_id AS squads_id, sqd.squads_picture AS squads_picture, owncln.clans_picture AS squad_picture, cln.clans_country AS clans_country';
$from = 'squads sqd INNER JOIN {pre}_clans cln ON sqd.clans_id = cln.clans_id INNER JOIN {pre}_clans owncln ON owncln.clans_id = sqd.clans_id';
$where = "squads_id = '" . $cs_wars['squads_id'] . "'";
$cs_squad = cs_sql_select(__FILE__,$from,$select,$where);
$wars['squad']['link'] = cs_link(cs_secure($cs_squad['squads_name']),'squads','view','id=' . $cs_squad['squads_id']);
$wars['squad']['logo'] = ! empty($cs_squad['squad_picture']) ? cs_html_img('uploads/clans/' . $cs_squad['squad_picture']) : $cs_lang['no_logo'];   
if(!empty($cs_squad['clans_country'])) {
$wars['squad']['country'] = cs_html_img('symbols/countries/' . $cs_squad['clans_country'] . '.png',11,16);
} else {
$wars['squad']['country'] = '-';
}


$cells = 'pl.users_id AS users_id, usr.users_nick AS users_nick';
$tables = 'players pl INNER JOIN {pre}_users usr ON pl.users_id = usr.users_id';
$cond = 'pl.wars_id = \''.$wars_id.'\' AND pl.players_played = \'1\'';
$players = cs_sql_select(__FILE__,$tables,$cells,$cond,'usr.users_nick',0,0);

if(!empty($players)) {
  $first = 0;
  $wars['wars']['players'] = '';
  foreach($players AS $player) {
    $wars['wars']['players'] .= empty($first) ? '' : ' - ';
    $first++;
    $wars['wars']['players'] .= cs_link(cs_secure($player['users_nick']), 'users', 'view', 'id=' . $player['users_id']);
  }
}
else
  $wars['wars']['players'] = '-';

if (empty($cs_wars['wars_players1']) && empty($cs_wars['wars_players2'])) {
  $wars['lang']['on'] = '';
  $wars['wars']['players1'] = '-';
  $wars['wars']['players2'] = '';
} else {
  $wars['wars']['players1'] = $cs_wars['wars_players1'];
  $wars['wars']['players2'] = $cs_wars['wars_players2'];
}

$wars['date']['show'] = cs_date('unix',$cs_wars['wars_date'],1);

$wars_status = empty($cs_wars['wars_status']) ? 'upcoming' : $cs_wars['wars_status'];
$wars['war']['status'] = $cs_lang[$wars_status];

$wars['war']['score1'] = $cs_wars['wars_score1'];
$wars['war']['score2'] = $cs_wars['wars_score2'];
$result = $cs_wars['wars_score1'] - $cs_wars['wars_score2'];
$icon = $result >= 1 ? 'green' : 'red';
$icon = empty($result) ? 'grey' : $icon;
$icon3 = $result >= 1 ? '#74B200' : '#DE0002';
$icon3 = empty($result) ? '#c0c0c0' : $icon3;
$icon4 = $result <= 1 ? '#74B200' : '#DE0002';
$icon4 = empty($result) ? '#c0c0c0' : $icon4;
$wars['result']['color1'] = $icon3;
$wars['result']['color2'] = $icon4;

$wars['result']['img'] = cs_html_img('symbols/clansphere/' . $icon . '.gif');

$wars_url = cs_secure($cs_wars['wars_url']);
$wars['war']['link'] = empty($wars_url) ? '-' : cs_html_link('http://' . $wars_url,$wars_url);

$wars['pictures']['show'] = '';

if(empty($cs_wars['wars_pictures'])) {
    $wars['pictures']['show'] = '-';
  } else {
    $wars_pics = explode("\n",$cs_wars['wars_pictures']);
    foreach($wars_pics AS $pic) {
      $link = cs_html_img('uploads/wars/thumb-' . $pic);
      $path = $cs_main['php_self']['dirname'];
      $wars['pictures']['show'] .=  cs_html_link($path . 'uploads/wars/picture-' . $pic,$link) . ' ';
    }
}

$wars['war']['report'] = empty($cs_wars['wars_report']) ? '-' : cs_secure($cs_wars['wars_report'],1,1);
$wars['war']['report2'] = empty($cs_wars['wars_report2']) ? '-' : cs_secure($cs_wars['wars_report2'],1,1);

$tables2 = 'rounds rnd INNER JOIN {pre}_maps mps ON rnd.maps_id = mps.maps_id';
$cells2 = 'rnd.rounds_score1 AS rounds_score1, rnd.rounds_score2 AS rounds_score2, '
    . 'rnd.rounds_description AS rounds_description, mps.maps_name AS maps_name, '
    . 'rnd.maps_id AS maps_id';

$wars['rounds'] = cs_sql_select(__FILE__,$tables2,$cells2,'rnd.wars_id = \''.$wars_id.'\'','rnd.rounds_order ASC',0,0);

if(!empty($wars['rounds'])) {
  
  $count_rounds = count($wars['rounds']);
  
  for ($run = 0; $run < $count_rounds; $run++) {
    
    $wars['rounds'][$run]['mapurl'] = cs_url('maps','view','id='.$wars['rounds'][$run]['maps_id']);
    $wars['rounds'][$run]['maps_name'] = cs_secure($wars['rounds'][$run]['maps_name']);
    $result2 = $wars['rounds'][$run]['rounds_score1'] - $wars['rounds'][$run]['rounds_score2'];
    $icon2 = $result2 >= 1 ? 'green' : 'red';
    $icon2 = !empty($result2) ? $icon2 : 'grey';
    $wars['rounds'][$run]['resulticon'] = cs_html_img('symbols/clansphere/' . $icon2 . '.gif');
    $wars['rounds'][$run]['rounds_description'] = cs_secure($wars['rounds'][$run]['rounds_description'],1,1);
  }
} else {
  $wars['rounds'] = array();
}


if ($wars_status == 'upcoming') {
  
  $condition = 'users_id = \''.$account['users_id'].'\' AND squads_id = \''.$cs_squad['squads_id'].'\'';
  $squadmember = cs_sql_count(__FILE__,'members',$condition);
  
  $wars_access = empty($account['access_wars']) ? 0 : $account['access_wars'];
  
  if (!empty($squadmember) OR $wars_access >= 3) {
  
    $wars['if']['squadmember'] = TRUE;
    $wars['if']['no_players'] = FALSE;
    $wars['if']['status'] = FALSE;
    
    $tables = 'players ply INNER JOIN {pre}_users usr ON ply.users_id = usr.users_id';
    $cells = 'ply.users_id AS users_id, ply.players_status AS players_status, '
        .'ply.players_time AS players_time, usr.users_nick AS users_nick, usr.users_active AS users_active';
    
    $nplayers = cs_sql_select(__FILE__,$tables,$cells,'ply.wars_id = \''.$wars_id.'\'','ply.players_status DESC',0,0);
    
    if (empty($nplayers)) {
      $wars['if']['no_players'] = TRUE;
      $wars['nplayers'] = array();
    } else {
      $in_list = 0;
      $pl = 0;
      foreach ($nplayers AS $player) {
      
        $wars['nplayers'][$pl]['user'] = cs_user($player['users_id'],$player['users_nick'],$player['users_active']);
        $wars['nplayers'][$pl]['status'] = $cs_lang[$player['players_status']];
        $wars['nplayers'][$pl]['date'] = cs_date('unix',$player['players_time'],1);
        
        if ($player['users_id'] == $account['users_id']) {
          $in_list = 1;
        }
        $pl++;
      }
    }
  
    if (!empty($squadmember)) {
    
      $wars['if']['status'] = TRUE;

      if(!isset($_POST['status'])) {
        $condition = 'users_id = \''.$account['users_id'].'\' AND wars_id = \''.$wars_id.'\'';
        $select = cs_sql_select(__FILE__,'players','players_id, players_status',$condition);
  
        $wars['status']['yes'] = '';
        $wars['status']['maybe'] = '';
        $wars['status']['no'] = '';
        $sel = 'selected="selected"';
  
        if($select['players_status'] == 'yes')
          $wars['status']['yes'] = $sel;
        if($select['players_status'] == 'maybe')
          $wars['status']['maybe'] = $sel;
        if($select['players_status'] == 'no')
          $wars['status']['no'] = $sel;    

        $wars['status']['players_id'] = $select['players_id'];
        $wars['status']['wars_id'] = $wars_id;
        $wars['lang']['submit'] = empty($in_list) ? $cs_lang['confirm'] : $cs_lang['edit'];
      } 
      else {
        $players_id = (int) $_POST['players_id'];
        $wars_id = (int) $_POST['wars_id'];
        $status = $_POST['players_status'];
        $time = cs_time();
        
        if(empty($in_list)) {
          $cells = array('wars_id','users_id','players_status','players_time');
          $values = array($wars_id,$account['users_id'],$status,$time);
          cs_sql_insert(__FILE__,'players',$cells,$values);
        } else {
          $cells = array('players_status','players_time');
          $values = array($status,$time);
          cs_sql_update(__FILE__,'players',$cells,$values,$players_id);
        }
        cs_redirect($cs_lang['success'],'wars','view','id='.$wars_id);
      }
    }
  }
}

echo cs_subtemplate(__FILE__,$wars,'wars','view');

$where_com = "comments_mod = 'wars' AND comments_fid = '" . $wars_id . "'";
$count_com = cs_sql_count(__FILE__,'comments',$where_com);
include_once('mods/comments/functions.php');

if(!empty($count_com)) {
  echo cs_html_br(1);
  echo cs_comments_view($wars_id,'wars','view',$count_com);
}

echo cs_comments_add($wars_id,'wars',$cs_wars['wars_close']);