<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('games');

$cs_games_id = $_GET['id'];
settype($cs_games_id,'integer');
$cs_games = cs_sql_select(__FILE__,'games','*',"games_id = '" . $cs_games_id . "'");
$games_genre = cs_sql_select(__FILE__,'categories','*',"categories_id = '" . $cs_games['categories_id'] . "'");

empty($cs_games['games_released']) ? $since2 = '-' : $since2 = cs_date('date',$cs_games['games_released']);
$data['games']['release'] = $since2;
$data['games']['name'] = cs_secure($cs_games['games_name']);
$data['games']['version'] = cs_secure($cs_games['games_version']);
$data['games']['genre'] = cs_secure($games_genre['categories_name']);

if(!empty($cs_games['games_usk'])) {
  $data['games']['usk'] = cs_html_img('symbols/games/' . $cs_games['games_usk'] . '.gif');
}
else {
  $data['games']['usk'] = cs_html_img('symbols/games/00.gif');
}

if(file_exists('uploads/games/' . $cs_games['games_id'] . '.gif')) {
  $data['games']['icon'] = cs_html_img('uploads/games/' . $cs_games['games_id'] . '.gif');
}
else {
  $data['games']['icon'] = '-';
}

if(!empty($cs_games['games_creator'])) {
  $data['games']['creator'] = cs_secure($cs_games['games_creator']);
}
else {
  $data['games']['creator'] = '-';
}

if(!empty($cs_games['games_url'])) {
  $data['games']['homepage'] = cs_html_link('http://' . $cs_games['games_url'],$cs_games['games_url']);
}
else {
  $data['games']['homepage'] = '-';
}

echo cs_subtemplate(__FILE__,$data,'games','view');
