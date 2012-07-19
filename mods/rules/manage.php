<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('rules');
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 2 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$cs_sort[1] = 'rules_order DESC';
$cs_sort[2] = 'rules_order ASC';
$cs_sort[3] = 'rules_title DESC';
$cs_sort[4] = 'rules_title ASC';
$cs_sort[5] = 'cat.categories_id DESC';
$cs_sort[6] = 'cat.categories_id ASC';
$order = $cs_sort[$sort];
$rules_count = cs_sql_count(__FILE__,'rules');

$data['count']['rules'] = $rules_count;
$data['head']['message'] = cs_getmsg();
$data['head']['pages']   = cs_pages('rules','manage',$rules_count,$start,$sort);

$data['sort']['order'] = cs_sort('rules','manage',$start,0,1,$sort);
$data['sort']['title'] = cs_sort('rules','manage',$start,0,3,$sort);
$data['sort']['cat']   = cs_sort('rules','manage',$start,0,5,$sort);

$from = 'rules ru INNER JOIN {pre}_categories cat ON ru.categories_id = cat.categories_id';
$select = 'ru.rules_id AS rules_id, ru.rules_order AS rules_order, ru.rules_title AS rules_title, cat.categories_name AS categories_name';
$data['rules'] = cs_sql_select(__FILE__,$from,$select,0,$order,$start,$account['users_limit']);
$rules_loop = count($data['rules']);

for($run=0; $run<$rules_loop; $run++) {

  $data['rules'][$run]['order'] = cs_secure($data['rules'][$run]['rules_order']);
  $data['rules'][$run]['title'] = cs_secure($data['rules'][$run]['rules_title']);
  $data['rules'][$run]['cat'] = cs_secure($data['rules'][$run]['categories_name']);
  $data['rules'][$run]['url_edit']   = cs_url('rules','edit','id='.$data['rules'][$run]['rules_id']);
  $data['rules'][$run]['url_remove'] = cs_url('rules','remove','id='.$data['rules'][$run]['rules_id']);
}

echo cs_subtemplate(__FILE__,$data,'rules','manage');
