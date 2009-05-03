<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');

$max = 4;

$data = array();

$select = 'war.games_id AS games_id, cln.clans_short AS clans_short, war.wars_score1 AS wars_score1, war.wars_score2 AS wars_score2, war.wars_date AS wars_date, sqd.squads_name AS squads_name, war.wars_id AS wars_id';
$from = 'wars war INNER JOIN {pre}_categories cat ON war.categories_id = cat.categories_id INNER JOIN {pre}_clans cln ON war.clans_id = cln.clans_id INNER JOIN {pre}_squads sqd ON war.squads_id = sqd.squads_id';
$order = 'wars_date DESC';
$cs_wars = cs_sql_select(__FILE__,$from,$select,"war.wars_status = 'played'",$order,0,$max);

if (!empty($cs_wars)) {

  $all = count($cs_wars);
  for ($i = 0; $i < $all; $i++) {

    $cs_wars[$i]['game_icon'] = file_exists('uploads/games/' . $cs_wars[$i]['games_id'] . '.gif') ?
      cs_html_img('uploads/games/' . $cs_wars[$i]['games_id'] . '.gif') : '';
    $secure_short = cs_secure($cs_wars[$i]['squads_name'] . ' vs ' . cs_secure($cs_wars[$i]['clans_short']));
    $cs_wars[$i]['matchup'] = cs_link($secure_short,'wars','view','id=' . $cs_wars[$i]['wars_id']);

    $result = $cs_wars[$i]['wars_score1'] - $cs_wars[$i]['wars_score2'];
    $icon = $result > 0 ? 'green' : 'red';
    if(empty($result)) $icon = 'grey';
    $cs_wars[$i]['icon'] = cs_html_img('symbols/clansphere/' . $icon . '.gif');
    $cs_wars[$i]['date'] = cs_date('unix',$cs_wars[$i]['wars_date']);
  }
  
  $data['wars'] = $cs_wars;
  echo cs_subtemplate(__FILE__,$data,'wars','navlist2');
}
else {

  echo $cs_lang['no_data'];
}