<?php
// ClanSphere 2010 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('shoutbox');
$data = array();

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];

$cs_sort[1] = 'shoutbox_name DESC';
$cs_sort[2] = 'shoutbox_name ASC';
$cs_sort[3] = 'shoutbox_date DESC';
$cs_sort[4] = 'shoutbox_date ASC';

$sort = empty($_GET['sort']) ? 3 : (int) $_GET['sort'];
$order = $cs_sort[$sort];

$data['count']['all'] = cs_sql_count(__FILE__,'shoutbox');
$data['page']['list'] = cs_pages('shoutbox','manage',$data['count']['all'],$start,0,$sort);
$data['sort']['nick'] = cs_sort('shoutbox','manage',$start,0,1,$sort);
$data['sort']['date'] = cs_sort('shoutbox','manage',$start,0,3,$sort);

$data['head']['message'] = cs_getmsg();

$data['shoutbox'] = array();

$cells = 'shoutbox_id, shoutbox_name, shoutbox_date';
$data['shoutbox'] = cs_sql_select(__FILE__,'shoutbox',$cells,0,$order,$start,$account['users_limit']);
$count_shoutbox = count($data['shoutbox']);

if(empty($count_shoutbox)) {
  $data['shoutbox'] = '';
}

for($run = 0; $run < $count_shoutbox; $run++) {
  $data['shoutbox'][$run]['shoutbox_name'] = cs_secure($data['shoutbox'][$run]['shoutbox_name']);
  $data['shoutbox'][$run]['time'] = cs_date('unix',$data['shoutbox'][$run]['shoutbox_date'],1);
  $data['shoutbox'][$run]['url_edit'] = cs_url('shoutbox','edit','id='.$data['shoutbox'][$run]['shoutbox_id']);
  $data['shoutbox'][$run]['url_remove'] = cs_url('shoutbox','remove','id='.$data['shoutbox'][$run]['shoutbox_id']);
  $data['shoutbox'][$run]['url_ip'] = cs_url('shoutbox','ip','id='.$data['shoutbox'][$run]['shoutbox_id']);
}

echo cs_subtemplate(__FILE__,$data,'shoutbox','manage');