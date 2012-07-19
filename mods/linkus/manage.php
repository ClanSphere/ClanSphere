<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('linkus');
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 2 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$cs_sort[1] = 'linkus_name DESC';
$cs_sort[2] = 'linkus_name ASC';  
$cs_sort[3] = 'linkus_banner DESC';
$cs_sort[4] = 'linkus_banner ASC';
$order = $cs_sort[$sort];
$linkus_count = cs_sql_count(__FILE__,'linkus');


$data['head']['count'] = $linkus_count;
$data['head']['pages'] = cs_pages('linkus','manage',$linkus_count,$start,0,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['name'] = cs_sort('linkus','manage',$start,0,1,$sort);
$data['sort']['banner'] = cs_sort('linkus','manage',$start,0,3,$sort);

$select = 'linkus_id, linkus_name, linkus_banner';
$data['linkus'] = cs_sql_select(__FILE__,'linkus',$select,0,$order,$start,$account['users_limit']);
$linkus_loop = count($data['linkus']);


for($run=0; $run<$linkus_loop; $run++) {

  $data['linkus'][$run]['name'] = cs_secure($data['linkus'][$run]['linkus_name']);
  $data['linkus'][$run]['banner'] = cs_secure($data['linkus'][$run]['linkus_banner']);
  
  $place = 'uploads/linkus/' .$data['linkus'][$run]['linkus_banner'];
  $mass = getimagesize($place);
  $data['linkus'][$run]['mass'] = cs_secure($mass[0] .' x '. $mass[1]);
  $data['linkus'][$run]['id'] = $data['linkus'][$run]['linkus_id'];

}

echo cs_subtemplate(__FILE__,$data,'linkus','manage');
