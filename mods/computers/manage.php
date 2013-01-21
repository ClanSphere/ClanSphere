<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('computers');
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 2 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$cs_sort[1] = 'computers_name ASC';
$cs_sort[2] = 'computers_name DESC';
$cs_sort[3] = 'users_id ASC';
$cs_sort[4] = 'users_id DESC';
$cs_sort[5] = 'computers_since ASC';
$cs_sort[6] = 'computers_since DESC';
$order = $cs_sort[$sort];
$computers_count = cs_sql_count(__FILE__,'computers');

$data['head']['count'] = $computers_count;
$data['head']['pages'] = cs_pages('computers','manage',$computers_count,$start,0,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['name'] = cs_sort('computers','manage',$start,0,1,$sort);
$data['sort']['user'] = cs_sort('computers','manage',$start,0,3,$sort);
$data['sort']['since'] = cs_sort('computers','manage',$start,0,5,$sort);

$select = 'com.computers_name AS computers_name, com.computers_since AS computers_since , com.computers_id AS computers_id, com.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete';
$from = 'computers com LEFT JOIN {pre}_users usr ON com.users_id = usr.users_id';
$data['com'] = cs_sql_select(__FILE__,$from,$select,0,$order,$start,$account['users_limit']);
$computers_loop = count($data['com']);

for($run=0; $run<$computers_loop; $run++) {

  $id = $data['com'][$run]['computers_id'];
  $data['com'][$run]['name'] = cs_secure($data['com'][$run]['computers_name']);
  $data['com'][$run]['url_view'] = cs_url('computers','view','id=' . $id);
  $data['com'][$run]['user'] = cs_user($data['com'][$run]['users_id'],$data['com'][$run]['users_nick'], $data['com'][$run]['users_active'], $data['com'][$run]['users_delete']);
   $data['com'][$run]['since'] = cs_date('unix',$data['com'][$run]['computers_since'],1);

  $data['com'][$run]['url_picture'] = cs_url('computers','picture','id=' . $id);
  $data['com'][$run]['url_edit'] = cs_url('computers','edit','id=' . $id);
  $data['com'][$run]['url_remove'] = cs_url('computers','remove','id=' . $id);

}

echo cs_subtemplate(__FILE__,$data,'computers','manage');