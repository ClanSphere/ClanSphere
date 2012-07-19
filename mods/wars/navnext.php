<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');
$cs_get = cs_get('catid');
$cs_option = cs_sql_option(__FILE__,'wars');
$data = array();

$select = 'war.games_id AS games_id, war.wars_date AS wars_date, sqd.squads_name AS squads_name, cln.clans_name AS clans_name, war.wars_id AS wars_id';
$from = 'wars war INNER JOIN {pre}_squads sqd ON war.squads_id = sqd.squads_id INNER JOIN {pre}_clans cln ON war.clans_id = cln.clans_id ';
$upcome = 'war.wars_date > ' . cs_time() . ' AND war.wars_status = \'upcoming\'';
if(!empty($cs_get['catid'])) {
  $upcome .= ' AND war.categories_id = ' . $cs_get['catid'];
}
$order = 'war.wars_date ASC';
$data['wars'] = cs_sql_select(__FILE__,$from,$select,$upcome,$order,0,$cs_option['max_navnext']);

if(empty($data['wars'])) {
  echo $cs_lang['no_data'];
} else {
  for ($run = 0; $run <count($data['wars']); $run++) {
    $data['wars'][$run]['date'] = cs_date('unix',$data['wars'][$run]['wars_date'],1);
    $data['wars'][$run]['url'] = cs_url('wars','view','id=' . $data['wars'][$run]['wars_id']);
    $data['wars'][$run]['squads_name'] = cs_secure($data['wars'][$run]['squads_name']);
    $data['wars'][$run]['clans_name'] = cs_secure($data['wars'][$run]['clans_name']);
    $data['wars'][$run]['games_img'] = cs_html_img('uploads/games/' . $data['wars'][$run]['games_id'] . '.gif');
  }
  echo cs_subtemplate(__FILE__,$data,'wars','navnext');
}