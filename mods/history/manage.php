<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('history');

empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start']; 
$cs_sort[1] = 'history_time DESC';
$cs_sort[2] = 'history_time ASC';
$cs_sort[3] = 'history_text DESC';
$cs_sort[4] = 'history_text ASC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$history_count = cs_sql_count(__FILE__,'history');

$data = array();
$cells  = 'hs.history_time AS history_time, hs.history_text AS history_text, ';
$data['history'] = cs_sql_select(__FILE__,'history','*',0,$order,$start,$account['users_limit']);
$history_loop = count($data['history']);

$data['url']['create'] = cs_url('history','create');
$data['count']['history'] = $history_count;

$data['head']['message'] = cs_getmsg();
$data['head']['pages'] = cs_pages('history','manage',$history_count,$start,$sort);

$data['sort']['time'] = cs_sort('history','manage',$start,0,1,$sort);
$data['sort']['text'] = cs_sort('history','manage',$start,0,3,$sort);

for($run=0; $run<$history_loop; $run++) {

  $data['history'][$run]['text'] = cs_secure(cs_substr($data['history'][$run]['history_text'], 0, 17)) . '...';
  $data['history'][$run]['time'] = cs_date('unix',$data['history'][$run]['history_time'],1);

  $data['history'][$run]['url_edit'] = cs_url('history','edit','id='.$data['history'][$run]['history_id']);
  $data['history'][$run]['url_remove'] = cs_url('history','remove','id='.$data['history'][$run]['history_id']);
}

echo cs_subtemplate(__FILE__,$data,'history','manage');