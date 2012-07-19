<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('fightus');
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 3 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$cs_sort[1] = 'fightus_clan DESC';
$cs_sort[2] = 'fightus_clan ASC';
$cs_sort[3] = 'fightus_date ASC';
$cs_sort[4] = 'fightus_date DESC';
$order = $cs_sort[$sort];
$fightus_count = cs_sql_count(__FILE__,'fightus');


$data['head']['count'] = $fightus_count;
$data['head']['pages'] = cs_pages('fightus','manage',$fightus_count,$start,0,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['clan'] = cs_sort('fightus','manage',$start,0,1,$sort);
$data['sort']['date'] = cs_sort('fightus','manage',$start,0,3,$sort);

$select = 'games_id, fightus_clan, fightus_date, fightus_id';
$data['fightus'] = cs_sql_select(__FILE__,'fightus',$select,0,$order,$start,$account['users_limit']);
$fightus_loop = count($data['fightus']);


for($run=0; $run<$fightus_loop; $run++) {

  $id = $data['fightus'][$run]['fightus_id'];

  $data['fightus'][$run]['game'] = '-';
  if(!empty($data['fightus'][$run]['games_id'])) {
    $data['fightus'][$run]['game'] = cs_html_img('uploads/games/' . $data['fightus'][$run]['games_id'] . '.gif');
  }
  $data['fightus'][$run]['clan'] = cs_secure($data['fightus'][$run]['fightus_clan']);
  $data['fightus'][$run]['url_view'] = cs_url('fightus','view','id=' . $id);
  $data['fightus'][$run]['date'] = cs_date('unix',$data['fightus'][$run]['fightus_date'],1);
  
  $data['fightus'][$run]['url_convert_clan'] = cs_url('clans','create','fightus=' . $id);
  $data['fightus'][$run]['url_convert_war'] = cs_url('wars','create','fightus=' . $id);
   $data['fightus'][$run]['url_remove'] = cs_url('fightus','remove','id=' . $id);
  
}

echo cs_subtemplate(__FILE__,$data,'fightus','manage');