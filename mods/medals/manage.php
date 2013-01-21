<?php
// ClanSphere 2010 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('medals');
$data = array();

$start = empty($_GET['start']) ? 0 : $_GET['start'];
$cs_sort[1] = 'medals_name DESC';
$cs_sort[2] = 'medals_name ASC';
$sort = empty($_GET['sort']) ? 1 : $_GET['sort'];
$order = $cs_sort[$sort];
$medals_count = cs_sql_count(__FILE__,'medals');

$data['medals'] = cs_sql_select(__FILE__,'medals','medals_name, medals_id',0,$order,$start,$account['users_limit']);
$data['count']['medals'] = count($data['medals']);
$data['sort']['name'] = cs_sort('medals','manage',$start,0,1,$sort);
$data['pages']['list'] = cs_pages('medals','manage',$medals_count,$start,0,$sort);

for ($i = 0; $i < $data['count']['medals']; $i++) {
  $data['medals'][$i]['medals_user'] = cs_sql_count(__FILE__,'medalsuser','medals_id='.$data['medals'][$i]['medals_id']);
  $data['medals'][$i]['view_user'] = cs_url('medals','user','where=' . $data['medals'][$i]['medals_id']);
  $data['medals'][$i]['count_user'] = $data['medals'][$i]['medals_user'];
  $data['medals'][$i]['edit_url'] = cs_url('medals','edit','id=' . $data['medals'][$i]['medals_id']);
  $data['medals'][$i]['remove_url'] = cs_url('medals','remove','id=' . $data['medals'][$i]['medals_id']);
}

$data['message']['medals'] = cs_getmsg();

echo cs_subtemplate(__FILE__,$data,'medals','manage');