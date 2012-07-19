<?php
// ClanSphere 2010 - www.clansphere.net 
// $Id$

$data = array();
$cs_lang = cs_translate('maps');

$data['count']['all'] = cs_sql_count(__FILE__,'maps');
$data['lang']['curr_maps'] = sprintf($cs_lang['curr_maps'],$data['count']['all']);

$cs_sort    = array();
$cs_sort[1] = 'mp.maps_name ASC';
$cs_sort[2] = 'mp.maps_name DESC';
$cs_sort[3] = 'gm.games_name ASC';
$cs_sort[4] = 'gm.games_name DESC';

$sort  = empty($_GET['sort'])  ? 1 : (int) $_GET['sort'];
$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];

$order = $cs_sort[$sort];

$data['pages']['list'] = cs_pages('maps','list',$data['count']['all'],$start,0,$sort);
$data['sort']['maps_name'] = cs_sort('maps','list',$start,0,1,$sort);
$data['sort']['games_name'] = cs_sort('maps','list',$start,0,3,$sort);

$tables = 'maps mp INNER JOIN {pre}_games gm ON mp.games_id = gm.games_id';
$cells = 'mp.maps_id AS maps_id, mp.maps_name AS maps_name, mp.games_id AS games_id, gm.games_name AS games_name';
$data['maps'] = cs_sql_select(__FILE__,$tables,$cells,0,$order,$start,$account['users_limit']);
$count_maps = count($data['maps']);

for ($run = 0; $run < $count_maps; $run++) {
  $data['maps'][$run]['maps_name'] = cs_secure($data['maps'][$run]['maps_name']);
}

echo cs_subtemplate(__FILE__,$data,'maps','list');