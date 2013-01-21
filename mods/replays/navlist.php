<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('replays');
$cs_get = cs_get('catid');
$cs_option = cs_sql_option(__FILE__,'replays');
$data = array();

$tables = 'replays re INNER JOIN {pre}_categories cat ON re.categories_id = cat.categories_id';
$select = 're.replays_id AS replays_id, re.games_id AS games_id, re.replays_date AS replays_date, re.replays_team1 AS replays_team1, re.replays_team2 AS replays_team2';
$check = 'cat.categories_access <= \'' . $account['access_replays'] . '\'';
if(!empty($cs_get['catid'])) {
  $check .= ' AND cat.categories_id = ' . $cs_get['catid'];
}
$order = 're.replays_date DESC';
$cs_replays = cs_sql_select(__FILE__,$tables,$select,$check,$order,0,$cs_option['max_navlist']);

if(empty($cs_replays)) {
  echo $cs_lang['no_data'];
}
else {
  $run = 0;
  foreach ($cs_replays AS $replays) {
    $data['replays'][$run]['game_icon'] = cs_html_img('uploads/games/' . $replays['games_id'] . '.gif');
    $data['replays'][$run]['date'] = cs_date('date',$replays['replays_date']);
    $data['replays'][$run]['view_url'] = cs_url('replays','view','id=' . $replays['replays_id']);
    $short_team1 = strlen($replays['replays_team1']) <= $cs_option['max_headline_team1'] ? $replays['replays_team1'] : cs_substr($replays['replays_team1'],0,$cs_option['max_headline_team1']) . '...';
    $short_team2 = strlen($replays['replays_team2']) <= $cs_option['max_headline_team2'] ? $replays['replays_team2'] : cs_substr($replays['replays_team2'],0,$cs_option['max_headline_team2']) . '...';
    $data['replays'][$run]['team1_short'] = cs_secure($short_team1);
    $data['replays'][$run]['team2_short'] = cs_secure($short_team2);
    $data['replays'][$run]['team1'] = cs_secure($replays['replays_team1']);
    $data['replays'][$run]['team2'] = cs_secure($replays['replays_team2']);
    $run++;
  }
  echo cs_subtemplate(__FILE__,$data,'replays','navlist');
}