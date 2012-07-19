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

$data['head']['body'] = sprintf($cs_lang['all'],$ranks_count);
$data['head']['pages'] = cs_pages('ranks','list',$ranks_count,$start,0,$sort);

$data['sort']['name'] = cs_sort('ranks','list',$start,0,1,$sort);

$select = 'ranks_id, ranks_name, ranks_url, ranks_img, ranks_code';
$data['ranks'] = cs_sql_select(__FILE__,'ranks',$select,0,$order,$start,$account['users_limit']);
$ranks_loop = count($data['ranks']);


for($run=0; $run<$ranks_loop; $run++) {

  $data['ranks'][$run]['name'] = cs_secure($data['ranks'][$run]['ranks_name']);

  $data['ranks'][$run]['picture'] = '';
  if(!empty($data['ranks'][$run]['ranks_url'])) {
    $picture = cs_html_img($data['ranks'][$run]['ranks_img']);
    $data['ranks'][$run]['picture'] = cs_html_link($data['ranks'][$run]['ranks_url'],$picture);
  } else {
    $data['ranks'][$run]['picture'] = $data['ranks'][$run]['ranks_code'];
  }
}

echo cs_subtemplate(__FILE__,$data,'ranks','list');
