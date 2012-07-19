<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');
$cs_post = cs_post('where,start,sort');
$cs_get = cs_get('where,start,sort');
$data = array();

$categories_id = empty($cs_get['where']) ? 0 : $cs_get['where'];
if (!empty($cs_post['where']))  $categories_id = $cs_post['where'];
$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 4 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$cs_sort[1] = 'cat.categories_name DESC';
$cs_sort[2] = 'cat.categories_name ASC';
$cs_sort[3] = 'brd.board_name DESC';
$cs_sort[4] = 'brd.board_name ASC';
$order = $cs_sort[$sort];
$where = empty($categories_id) ? 0 : "categories_id = '" . $categories_id . "'";
$board_count = cs_sql_count(__FILE__,'board',$where);

$data['head']['count_attachments'] = cs_sql_count(__FILE__,'boardfiles');
$data['head']['count_reports'] = cs_sql_count(__FILE__,'boardreport');

$data['head']['count'] = $board_count;
$data['head']['pages'] = cs_pages('board','manage',$board_count,$start,$categories_id,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['name'] = cs_sort('board','manage',$start,$categories_id,3,$sort);
$data['sort']['cat'] = cs_sort('board','manage',$start,$categories_id,1,$sort);

$from = 'board brd INNER JOIN {pre}_categories cat ON brd.categories_id = cat.categories_id';
$select = 'brd.board_name AS board_name, cat.categories_name AS categories_name, brd.board_id AS board_id';
$data['board'] = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$board_loop = count($data['board']);

for($run=0; $run<$board_loop; $run++) {
  
  $data['board'][$run]['name'] = cs_secure($data['board'][$run]['board_name']);
  $data['board'][$run]['cat'] = cs_secure($data['board'][$run]['categories_name']);
  $data['board'][$run]['id'] = $data['board'][$run]['board_id'];
}

echo cs_subtemplate(__FILE__,$data,'board','manage');