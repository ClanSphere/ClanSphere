<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('computers');
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 1 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$cs_sort[1] = 'computers_name DESC';
$cs_sort[2] = 'computers_name ASC';
$cs_sort[3] = 'computers_since ASC';
$cs_sort[4] = 'computers_since DESC';
$order = $cs_sort[$sort];
$computers_count = cs_sql_count(__FILE__,'computers');

$data['head']['count'] = $computers_count;
$data['head']['pages'] = cs_pages('computers','list',$computers_count,$start,0,$sort);

$data['sort']['name'] = cs_sort('computers','list',$start,0,1,$sort);
$data['sort']['since'] = cs_sort('computers','list',$start,0,3,$sort);

$select = 'computers_name, computers_since, computers_id';
$cs_computers = cs_sql_select(__FILE__,'computers',$select,0,$order,$start,$account['users_limit']);
$computers_loop = count($cs_computers);

for($run=0; $run<$computers_loop; $run++) {

  $data['com'][$run]['name'] = cs_secure($cs_computers[$run]['computers_name']);
  $data['com'][$run]['url_view'] = cs_url('computers','view','id=' . $cs_computers[$run]['computers_id']);
  $data['com'][$run]['since'] = cs_date('unix',$cs_computers[$run]['computers_since'],1);
  
}

echo cs_subtemplate(__FILE__,$data,'computers','list');
