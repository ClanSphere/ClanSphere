<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('replays');

$data = array();

$categories_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
if(!empty($_POST['categories_id']))
  $categories_id = $_POST['categories_id'];
settype($categories_id,'integer');
$where = empty($categories_id) ? 0 : "categories_id = '" . cs_sql_escape($categories_id) . "'";

$cs_sort[1] = 'replays_date DESC';
$cs_sort[2] = 'replays_date ASC';
$cs_sort[3] = 'replays_team1 DESC';
$cs_sort[4] = 'replays_team1 ASC';
$cs_sort[5] = 'replays_team2 DESC';
$cs_sort[6] = 'replays_team2 ASC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$replays_count = cs_sql_count(__FILE__,'replays',$where);

$data['head']['replays_count'] = $replays_count;
$data['head']['pages'] = cs_pages('replays','manage',$replays_count,$start,$categories_id,$sort);
$catmod = "categories_mod = 'replays'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$catmod,'categories_name',0,0);
$data['head']['dropdown'] = cs_dropdown('categories_id','categories_name',$categories_data,$categories_id);
  
$cat_where = empty($categories_id) ? '' : "categories_id = '" . cs_sql_escape($categories_id) . "'";
$select = 'games_id, replays_date, replays_team1, replays_team2, replays_id';
$data['replays'] = cs_sql_select(__FILE__,'replays',$select,$cat_where,$order,$start,$account['users_limit']);
$replays_loop = count($data['replays']);

$data['sort']['date'] = cs_sort('replays','manage',$start,$categories_id,1,$sort);
$data['sort']['team1'] = cs_sort('replays','manage',$start,$categories_id,3,$sort);
$data['sort']['team2'] = cs_sort('replays','manage',$start,$categories_id,5,$sort);

for($run=0; $run<$replays_loop; $run++) {

  $data['replays'][$run]['game_icon'] = cs_html_img('uploads/games/' . $data['replays'][$run]['games_id'] . '.gif');
  $data['replays'][$run]['date'] = cs_date('date',$data['replays'][$run]['replays_date']);
  $data['replays'][$run]['date_url'] = cs_url('replays','view','id=' . $data['replays'][$run]['replays_id']);
  $data['replays'][$run]['team1'] = cs_secure($data['replays'][$run]['replays_team1']);
  $data['replays'][$run]['team2'] = cs_secure($data['replays'][$run]['replays_team2']);
}

echo cs_subtemplate(__FILE__,$data,'replays','list');