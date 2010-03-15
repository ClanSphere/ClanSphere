<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');
$data = array();

$games_id = !empty($_GET['id']) ? (int) $_GET['id'] : 0;
$games_id = !empty($_POST['games_id']) ? (int) $_POST['games_id'] : $games_id;

$data_games = cs_sql_select(__FILE__,'games','games_name, games_id',0,'games_name',0,0);
$data['games'] = cs_dropdownsel($data_games,$games_id,'games_id');

$cells  = 'cp.cups_id AS cups_id, cp.cups_name AS cups_name, ';
$cells .= 'cp.cups_start AS cups_start, cp.games_id AS games_id, ';
$cells .= 'cp.cups_teams AS cups_teams, COUNT(cs.cupsquads_id) AS cups_joined';
$tables = 'cups cp LEFT JOIN {pre}_cupsquads cs ON cs.cups_id = cp.cups_id';

if (empty($games_id)) {
  $where = 0;
  $tables .= ' GROUP BY cp.cups_id';
} else {
  $where  = 'cp.games_id = \''.$games_id.'\'';
  $where .= ' GROUP BY cp.cups_id';
}

$data['cups'] = cs_sql_select(__FILE__,$tables,$cells,$where,'cp.cups_start DESC',0,$account['users_limit']);
$data['count']['all'] = cs_sql_count(__FILE__,'cups');
$count_cups = count($data['cups']);

for ($run = 0; $run < $count_cups; $run++) {
  $data['cups'][$run]['games_img'] = cs_html_img('uploads/games/' . $data['cups'][$run]['games_id'] . '.gif');
  $data['cups'][$run]['start'] = cs_date('unix',$data['cups'][$run]['cups_start'],1);
  
}

echo cs_subtemplate(__FILE__,$data,'cups','list');