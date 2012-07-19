<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');

$squads_id = empty($_REQUEST['where']) ? 0 : (int) $_REQUEST['where'];
$where_count = empty($squads_id) ? 0 : "squads_id = '" . $squads_id . "'";
$where = empty($squads_id) ? 0 : "war.squads_id = '" . $squads_id . "'";

$start = empty($_REQUEST['start']) ? 0 : (int) $_REQUEST['start'];
$cs_sort[1] = 'war.wars_date DESC';
$cs_sort[2] = 'war.wars_date ASC';
$cs_sort[3] = 'cln.clans_name DESC';
$cs_sort[4] = 'cln.clans_name ASC';
$cs_sort[5] = 'cat.categories_name DESC';
$cs_sort[6] = 'cat.categories_name ASC';
$sort = empty($_REQUEST['sort']) ? 1 : (int) $_REQUEST['sort'];
$order = $cs_sort[$sort];
$wars_count = cs_sql_count(__FILE__,'wars',$where_count);

$data = array();
$data['info']['warcount'] = sprintf($cs_lang['count'], $wars_count);
$data['pages']['choice'] = cs_pages('wars','list',$wars_count,$start,$squads_id,$sort);
$data['url']['form'] = cs_url('wars','list');
$cid = "squads_fightus = '0'";
$data['squads'] = cs_sql_select(__FILE__,'squads','squads_name, squads_id',$cid,'squads_name',0,0);
$count_squads = count($data['squads']);

for ($run = 0; $run < $count_squads; $run++) {
  $data['squads'][$run]['name'] = cs_secure($data['squads'][$run]['squads_name']);
}

$data['sort']['date'] = cs_sort('wars','list',$start,$squads_id,1,$sort);
$data['sort']['enemy'] = cs_sort('wars','list',$start,$squads_id,3,$sort);
$data['sort']['category'] = cs_sort('wars','list',$start,$squads_id,5,$sort);

$select = 'war.games_id AS games_id, war.wars_date AS wars_date, war.wars_status AS status, war.clans_id AS clans_id, cln.clans_short AS clans_short, cat.categories_name AS categories_name, war.categories_id AS categories_id, war.wars_score1 AS wars_score1, war.wars_score2 AS wars_score2, war.wars_id AS wars_id';
$from = 'wars war INNER JOIN {pre}_categories cat ON war.categories_id = cat.categories_id ';
$from .= 'INNER JOIN {pre}_clans cln ON war.clans_id = cln.clans_id ';
$cs_wars = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);

$data['wars'] = '';
$count_wars = count($cs_wars);

for ($run = 0; $run < $count_wars; $run++) {
  $data['wars'][$run]['gameicon'] = cs_html_img('uploads/games/' . $cs_wars[$run]['games_id'] . '.gif');
  $data['wars'][$run]['date'] = cs_date('unix',$cs_wars[$run]['wars_date']);
  $data['wars'][$run]['enemyurl'] = cs_url('clans','view','id=' . $cs_wars[$run]['clans_id']);
  $data['wars'][$run]['enemy'] = cs_secure($cs_wars[$run]['clans_short']);
  $data['wars'][$run]['caturl'] = cs_url('categories','view','id=' . $cs_wars[$run]['categories_id']);
  $data['wars'][$run]['category'] = cs_secure($cs_wars[$run]['categories_name']);
  $data['wars'][$run]['url'] = cs_url('wars','view','id=' . $cs_wars[$run]['wars_id']);
  $data['wars'][$run]['result'] = $cs_wars[$run]['wars_score1'] . ' : ' . $cs_wars[$run]['wars_score2'];
  $data['wars'][$run]['if']['upcoming'] = ($cs_wars[$run]['status'] == 'upcoming') ? true : false;
  $data['wars'][$run]['if']['played'] = ($cs_wars[$run]['status'] == 'played') ? true : false;
  $data['wars'][$run]['if']['running'] = ($cs_wars[$run]['status'] == 'running') ? true : false;
  $data['wars'][$run]['if']['canceled'] = ($cs_wars[$run]['status'] == 'canceled') ? true : false;  
  $result = $cs_wars[$run]['wars_score1'] - $cs_wars[$run]['wars_score2'];
  $icon = $result >= 1 ? 'green' : 'red';
  $icon = !empty($result) ? $icon : 'grey';
  $data['wars'][$run]['resulticon'] = cs_html_img('symbols/clansphere/' . $icon . '.gif');
}

echo cs_subtemplate(__FILE__,$data,'wars','list');