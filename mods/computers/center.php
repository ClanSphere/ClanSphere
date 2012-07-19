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

$cid = "users_id = '" . $account['users_id'] . "'";

$cs_sort[1] = 'computers_name DESC';
$cs_sort[2] = 'computers_name ASC';
$cs_sort[3] = 'computers_since ASC';
$cs_sort[4] = 'computers_since DESC';
$order = $cs_sort[$sort];
$computers_count = cs_sql_count(__FILE__,'computers',$cid);

$data['head']['count'] = $computers_count;
$data['head']['pages'] = cs_pages('computers','center',$computers_count,$start,0,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['name'] = cs_sort('computers','center',$start,0,1,$sort);
$data['sort']['since'] = cs_sort('computers','center',$start,0,3,$sort);

$select = 'computers_name, computers_since, computers_id';
$data['com'] = cs_sql_select(__FILE__,'computers',$select,$cid,$order,$start,$account['users_limit']);
$computers_loop = count($data['com']);

for($run=0; $run<$computers_loop; $run++) {

  $id = $data['com'][$run]['computers_id'];
  $data['com'][$run]['name'] = cs_secure($data['com'][$run]['computers_name']);
  $data['com'][$run]['since'] = cs_date('unix',$data['com'][$run]['computers_since'],1);

  $data['com'][$run]['id'] = $id;

}

echo cs_subtemplate(__FILE__,$data,'computers','center');
