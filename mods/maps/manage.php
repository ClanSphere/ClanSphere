<?php
// ClanSphere 2010 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('maps');
$cs_post = cs_post('where,start,sort');
$cs_get = cs_get('where,start,sort');
$data = array();

$games_id = empty($cs_get['where']) ? 0 : $cs_get['where'];
if (!empty($cs_post['where']))  $games_id = $cs_post['where'];
$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 1 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$where = !empty($games_id) ? 'games_id = "' . $games_id . '"' : 0;

$cs_sort[1] = 'maps_name ASC';
$cs_sort[2] = 'maps_name DESC';
$order = $cs_sort[$sort];
$maps_count = cs_sql_count(__FILE__,'maps',$where);


$data['head']['count_maps'] = $maps_count;
$data['head']['pages'] = cs_pages('maps','manage',$maps_count,$start,$games_id,$sort);

$cs_games = cs_sql_select(__FILE__,'games','games_id, games_name',0,'games_name',0,0);
$data['head']['dropdown'] = cs_dropdown('where','games_name',$cs_games,$games_id,'games_id');
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['name'] = cs_sort('maps','manage',$start,$games_id,1,$sort);

$cells = 'maps_id, maps_name';
$data['maps'] = cs_sql_select(__FILE__,'maps',$cells,$where,$order,$start,$account['users_limit']);
$loop_maps = count($data['maps']);


for($run=0; $run<$loop_maps; $run++){

  $data['maps'][$run]['id'] = $data['maps'][$run]['maps_id'];
  $data['maps'][$run]['name'] = $data['maps'][$run]['maps_name']; 

}

echo cs_subtemplate(__FILE__,$data,'maps','manage');