<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('replays');

$cs_replays_id = empty($_REQUEST['where']) ? $_GET['id'] : $_REQUEST['where'];
settype($cs_replays_id,'integer');

$select = 'users_id, replays_since, categories_id, games_id, replays_version, replays_team1, ';
$select .= 'replays_team2, replays_date, replays_map, replays_mirror_urls, replays_info, replays_id, replays_close, replays_mirror_names';
$cs_replays = cs_sql_select(__FILE__,'replays',$select,"replays_id = '" . $cs_replays_id . "'");


$who = "users_id = '" . $cs_replays['users_id'] . "'";
$cs_users = cs_sql_select(__FILE__,'users','users_nick, users_active, users_delete',$who);
$cs_users_nick = cs_secure($cs_users['users_nick']);
$data['replays']['user'] = cs_user($cs_replays['users_id'],$cs_users['users_nick'], $cs_users['users_active'], $cs_users['users_delete']);

$data['replays']['since'] = cs_date('unix',$cs_replays['replays_since'],1);

$where = "categories_id = '" . $cs_replays['categories_id'] . "'";
$cs_cat = cs_sql_select(__FILE__,'categories','categories_name, categories_id',$where);
$data['replays']['category'] = cs_link($cs_cat['categories_name'],'categories','view','id=' . $cs_cat['categories_id']);

if(!empty($cs_replays['games_id'])) {
  $img = cs_html_img('uploads/games/' . $cs_replays['games_id'] . '.gif') . ' ';
  $where = "games_id = '" . $cs_replays['games_id'] . "'";
  $cs_game = cs_sql_select(__FILE__,'games','games_name, games_id',$where);
  $data['replays']['game_img'] = $img . cs_link($cs_game['games_name'],'games','view','id=' . $cs_game['games_id']);
}
else {
  $data['replays']['game_img'] = ' - ';
}

$data['replays']['version'] = cs_secure($cs_replays['replays_version']);
$data['replays']['team1'] = cs_secure($cs_replays['replays_team1']);
$data['replays']['team2'] = cs_secure($cs_replays['replays_team2']);
$data['replays']['date'] = cs_date('date',$cs_replays['replays_date']);
$data['replays']['map'] = cs_secure($cs_replays['replays_map']);

$data['replays']['mirrors'] = ' - ';
if(!empty($cs_replays['replays_mirror_urls'])) {
  $data['replays']['mirrors'] = '';
  $mirror_names = explode("\n", $cs_replays['replays_mirror_names']);
  $mirror_urls = explode("\n", $cs_replays['replays_mirror_urls']);
  $mirror_count = count($mirror_urls);

  for($run=0; $run < $mirror_count; $run++) {

    if(empty($mirror_names[$run]))
      $mirror_names[$run] = $mirror_urls[$run];
    if(substr($mirror_urls[$run],0,15) == 'uploads/replays')
      $mirror_urls[$run] = $cs_main['php_self']['dirname'] . $mirror_urls[$run];

    $data['replays']['mirrors'] .= cs_html_link($mirror_urls[$run],$mirror_names[$run]) . cs_html_br(1);
  }
}

$data['replays']['info'] = cs_secure($cs_replays['replays_info'],1,1);

echo cs_subtemplate(__FILE__,$data,'replays','view');

$where_com = "comments_mod = 'replays' AND comments_fid = '" . $cs_replays['replays_id'] . "'";
$count_com = cs_sql_count(__FILE__,'comments',$where_com);
include_once('mods/comments/functions.php');

if(!empty($count_com)) {
  echo cs_html_br(1);
  echo cs_comments_view($cs_replays_id,'replays','view',$count_com);
}

echo cs_comments_add($cs_replays_id,'replays',$cs_replays['replays_close']);