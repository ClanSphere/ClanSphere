<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('joinus');
$cs_get = cs_get('start,sort');
$cs_post = cs_post('start,sort');
$data = array();

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 5 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$cs_sort[1] = 'joinus_nick DESC';
$cs_sort[2] = 'joinus_nick ASC';
$cs_sort[3] = 'joinus_age ASC';
$cs_sort[4] = 'joinus_age DESC';
$cs_sort[5] = 'joinus_since ASC';
$cs_sort[6] = 'joinus_since DESC';
$order = $cs_sort[$sort];
$joinus_count = cs_sql_count(__FILE__,'joinus');

$data['head']['count'] = $joinus_count;
$data['head']['pages'] = cs_pages('joinus','manage',$joinus_count,$start,0,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['nick'] = cs_sort('joinus','manage',$start,0,1,$sort);
$data['sort']['age'] = cs_sort('joinus','manage',$start,0,3,$sort);
$data['sort']['since'] = cs_sort('joinus','manage',$start,0,5,$sort);

$select = 'games_id, joinus_nick, joinus_age, joinus_since, joinus_id';
$data['join'] = cs_sql_select(__FILE__,'joinus',$select,0,$order,$start,$account['users_limit']);
$joinus_loop = count($data['join']);


for($run=0; $run<$joinus_loop; $run++) {

  $id = $data['join'][$run]['joinus_id'];

  if(!empty($data['join'][$run]['games_id'])) {
    $data['join'][$run]['game'] = cs_html_img('uploads/games/' . $data['join'][$run]['games_id'] . '.gif');
  } else { $data['join'][$run]['game'] = '-'; }

  $nick = cs_secure($data['join'][$run]['joinus_nick']);
  $data['join'][$run]['nick'] = cs_link($nick,'joinus','view','id=' . $id);

  $birth = explode ('-', $data['join'][$run]['joinus_age']);
  $age = cs_datereal('Y') - $birth[0];
  if(cs_datereal('m')<=$birth[1]) { $age--; }
  if(cs_datereal('d')>=$birth[2] AND cs_datereal('m')==$birth[1]) { $age++; }
  $data['join'][$run]['age'] = $age;
  
  $data['join'][$run]['since'] = cs_date('unix',$data['join'][$run]['joinus_since'],1);

  $data['join'][$run]['url_convert'] = cs_url('joinus','convert','id=' . $id);
   $data['join'][$run]['url_remove'] = cs_url('joinus','remove','id=' . $id);

}

echo cs_subtemplate(__FILE__,$data,'joinus','manage');
