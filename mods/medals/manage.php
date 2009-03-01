<?php

$cs_lang = cs_translate('medals');
$data = array();

$start = empty($_GET['start']) ? 0 : $_GET['start'];
$cs_sort[1] = 'md.medals_date DESC';
$cs_sort[2] = 'md.medals_date ASC';
$cs_sort[3] = 'md.medals_name DESC';
$cs_sort[4] = 'md.medals_name ASC';
$cs_sort[5] = 'usr.users_nick DESC';
$cs_sort[6] = 'usr.users_nick ASC';
$sort = empty($_GET['sort']) ? 1 : $_GET['sort'];
$order = $cs_sort[$sort];

$tables = 'medals md LEFT JOIN {pre}_users usr ON usr.users_id = md.users_id';
$cells  = 'md.medals_name AS medals_name, usr.users_nick AS users_nick, md.users_id AS users_id, ';
$cells .= 'md.medals_id AS medals_id, md.medals_date AS medals_date';

$data['medals'] = cs_sql_select(__FILE__,$tables,$cells,0,$order,$start,$account['users_limit']);
$data['count']['medals'] = count($data['medals']);

$data['sort']['date'] = cs_sort('medals','manage',$start,0,1,$sort);
$data['sort']['name'] = cs_sort('medals','manage',$start,0,3,$sort);
$data['sort']['users_nick'] = cs_sort('medals','manage',$start,0,5,$sort);

$data['pages']['list'] = cs_pages('medals','manage',$data['count']['medals'],$start,0,$sort);

for ($i = 0; $i < $data['count']['medals']; $i++) {
  $data['medals'][$i]['users_url'] = cs_url('users','view','id=' . $data['medals'][$i]['users_id']);
  $data['medals'][$i]['medals_url'] = cs_url('medals','users','id=' . $data['medals'][$i]['users_id'] . '#' . $data['medals'][$i]['medals_id']);
  $data['medals'][$i]['edit_url'] = cs_url('medals','edit','id=' . $data['medals'][$i]['medals_id']);
  $data['medals'][$i]['remove_url'] = cs_url('medals','remove','id=' . $data['medals'][$i]['medals_id']);
  $data['medals'][$i]['medals_date'] = cs_date('unix',$data['medals'][$i]['medals_date']);
}

$data['message']['medals'] = cs_getmsg();

echo cs_subtemplate(__FILE__,$data,'medals','manage');

?>