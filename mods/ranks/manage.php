<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('ranks');
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 2 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$cs_sort[1] = 'ranks_name DESC';
$cs_sort[2] = 'ranks_name ASC';
$order = $cs_sort[$sort];
$ranks_count = cs_sql_count(__FILE__,'ranks');


$data['head']['count'] = $ranks_count;
$data['head']['pages'] = cs_pages('ranks','manage',$ranks_count,$start,0,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['name'] = cs_sort('ranks','manage',$start,0,1,$sort);

$select = 'ranks_id, ranks_name';
$data['ranks'] = cs_sql_select(__FILE__,'ranks',$select,0,$order,$start,$account['users_limit']);
$ranks_loop = count($data['ranks']);


for($run=0; $run<$ranks_loop; $run++) {

   $data['ranks'][$run]['name'] = cs_secure($data['ranks'][$run]['ranks_name']);
  $data['ranks'][$run]['id'] = $data['ranks'][$run]['ranks_id'];
  
}
echo cs_subtemplate(__FILE__,$data,'ranks','manage');
