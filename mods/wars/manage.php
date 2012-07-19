<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');
$data = array();

$wars_status = empty($_REQUEST['where']) ? '' : $_REQUEST['where'];
$where = empty($wars_status) ? 0 : "wars_status = '" . $wars_status . "'";

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'war.wars_date DESC';
$cs_sort[2] = 'war.wars_date ASC';
$cs_sort[3] = 'sqd.squads_name DESC';
$cs_sort[4] = 'sqd.squads_name ASC';
$cs_sort[5] = 'cln.clans_name DESC';
$cs_sort[6] = 'cln.clans_name ASC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$data['count']['all'] = cs_sql_count(__FILE__,'wars',$where);
$data['pages']['list'] = cs_pages('wars','manage',$data['count']['all'],$start,$wars_status,$sort);

$data['head']['message'] = cs_getmsg();

$data['selection']['upcoming'] = $wars_status != 'upcoming' ? '' : ' selected="selected"';
$data['selection']['running'] = $wars_status != 'running' ? '' : ' selected="selected"';
$data['selection']['canceled'] = $wars_status != 'canceled' ? '' : ' selected="selected"';
$data['selection']['played'] = $wars_status != 'played' ? '' : ' selected="selected"';

$data['sort']['date'] = cs_sort('wars','manage',$start,$wars_status,1,$sort);
$data['sort']['squad'] = cs_sort('wars','manage',$start,$wars_status,3,$sort);
$data['sort']['enemy'] = cs_sort('wars','manage',$start,$wars_status,5,$sort);

$select = 'war.wars_date AS wars_date, war.squads_id AS squads_id, war.clans_id AS ';
$select .= 'clans_id, sqd.squads_name AS squads_name, cln.clans_name AS clans_name, ';
$select .= 'war.wars_id AS wars_id';
$from = 'wars war LEFT JOIN {pre}_squads sqd ON war.squads_id = sqd.squads_id ';
$from .= 'LEFT JOIN {pre}_clans cln ON war.clans_id = cln.clans_id ';

$data['wars'] = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$count_wars = count($data['wars']);

for ($run = 0; $run < $count_wars; $run++) {
  $data['wars'][$run]['date'] = cs_date('unix',$data['wars'][$run]['wars_date']);
  $data['wars'][$run]['clans_name'] = cs_secure($data['wars'][$run]['clans_name']);
  $data['wars'][$run]['squads_name'] = cs_secure($data['wars'][$run]['squads_name']);
}

echo cs_subtemplate(__FILE__,$data,'wars','manage');