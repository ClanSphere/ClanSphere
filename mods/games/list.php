<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('games');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'games_name DESC';
$cs_sort[2] = 'games_name ASC';
$cs_sort[3] = 'games_usk DESC';
$cs_sort[4] = 'games_usk ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$games_count = cs_sql_count(__FILE__,'games');


$data['lang']['body'] = sprintf($cs_lang['all'], $games_count);
$data['pages']['list'] = cs_pages('games','list',$games_count,$start,0,$sort);

$cs_games = cs_sql_select(__FILE__,'games','*',0,$order,$start,$account['users_limit']);
$games_loop = count($cs_games);

$data['sort']['name'] = cs_sort('games','list',$start,0,1,$sort);
$data['sort']['usk'] = cs_sort('games','list',$start,0,3,$sort);

if(empty($games_loop)) {
  $data['games'] = '';
}

for($run=0; $run<$games_loop; $run++) {
  $data['games'][$run]['name'] = cs_link($cs_games[$run]['games_name'],'games','view','id=' . $cs_games[$run]['games_id']);
  $games_genre = cs_sql_select(__FILE__,'categories','*',"categories_id = '" . $cs_games[$run]['categories_id'] . "'");
  $data['games'][$run]['genre'] = cs_secure($games_genre['categories_name']);
  $data['games'][$run]['usk'] = cs_secure($cs_games[$run]['games_usk']);    
  $data['games'][$run]['release'] = empty($cs_games[$run]['games_released']) ? $since2 = '-' : $since2 = cs_date('date',$cs_games[$run]['games_released']);       
}

echo cs_subtemplate(__FILE__,$data,'games','list');
