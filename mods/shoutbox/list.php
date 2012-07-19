<?php
// ClanSphere 2010 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('shoutbox');

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];

$cs_sort[1] = 'shoutbox_name ASC';
$cs_sort[2] = 'shoutbox_name DESC';
$cs_sort[3] = 'shoutbox_date ASC';
$cs_sort[4] = 'shoutbox_date DESC';
$cs_sort[5] = 'shoutbox_text ASC';
$cs_sort[6] = 'shoutbox_text DESC';

$sort = empty($_GET['sort']) ? 4 : $_GET['sort'];
$order = $cs_sort[$sort];

$data = array();
$data['count']['all'] = cs_sql_count(__FILE__,'shoutbox');
$data['pages']['list'] = cs_pages('shoutbox','list',$data['count']['all'],$start,0,$sort);
$data['sort']['nick'] = cs_sort('shoutbox','list',$start,0,1,$sort);
$data['sort']['msg'] = cs_sort('shoutbox','list',$start,0,5,$sort);
$data['sort']['date'] = cs_sort('shoutbox','list',$start,0,3,$sort);

$cells = 'shoutbox_name, shoutbox_text, shoutbox_date';
$data['shoutbox'] = cs_sql_select(__FILE__,'shoutbox',$cells,0,$order,$start,$account['users_limit']);
$count_shoutbox = count($data['shoutbox']);

if(empty($count_shoutbox)) {
$data['shoutbox'] = '';
}

for($run = 0; $run < $count_shoutbox; $run++) {
  $data['shoutbox'][$run]['date'] = cs_date('unix',$data['shoutbox'][$run]['shoutbox_date']);
  $data['shoutbox'][$run]['shoutbox_name'] = cs_secure($data['shoutbox'][$run]['shoutbox_name'],0,0,0);
  $data['shoutbox'][$run]['shoutbox_text'] = cs_secure($data['shoutbox'][$run]['shoutbox_text'],0,1,0);
}

echo cs_subtemplate(__FILE__,$data,'shoutbox','list');