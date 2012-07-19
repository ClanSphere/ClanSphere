<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('links');
$cs_post = cs_post('where,start,sort');
$cs_get = cs_get('where,start,sort');
$data = array();

$categories_id = empty($cs_get['where']) ? 0 : $cs_get['where'];
if (!empty($cs_post['where']))  $categories_id = $cs_post['where'];
$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 1 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$cs_sort[1] = 'links_name DESC';
$cs_sort[2] = 'links_name ASC';
$order = $cs_sort[$sort];
$where = !empty($categories_id) ? "categories_id = '" . $categories_id . "'" : 0;
$links_count = cs_sql_count(__FILE__,'links',$where);

if (empty($categories_id)){
  $data['categories']['name'] = $cs_lang['head_list'];
  $data['categories']['text'] = '';
} else {
  $select = 'categories_name, categories_text';
  $categories_data = cs_sql_select(__FILE__,'categories',$select,$where,'categories_name',0);
  $data['categories']['name'] = cs_secure($categories_data['categories_name']);
  $data['categories']['text'] = cs_secure ($categories_data['categories_text']);
}
$data['head']['pages'] = cs_pages('links','listcat',$links_count,$start,$categories_id,$sort);

$data['sort']['name'] = cs_sort('links','listcat',$start,$categories_id,1,$sort);

$select = 'links_id, links_name, links_url, links_stats';
$data['links'] = cs_sql_select(__FILE__,'links',$select,$where,$order,$start,$account['users_limit']);
$links_loop = count($data['links']);


for($run=0; $run<$links_loop; $run++) {

  $data['links'][$run]['name'] = cs_secure($data['links'][$run]['links_name']);
  $data['links'][$run]['url'] = $data['links'][$run]['links_url'];
  $data['links'][$run]['url_short'] = cs_substr($data['links'][$run]['links_url'],0,30);

  if($data['links'][$run]['links_stats'] == 'on') {
    $data['links'][$run]['color'] = 'lime';
    $data['links'][$run]['on_off'] = $cs_lang['online'];
  }else{
    $data['links'][$run]['color'] = 'red';
    $data['links'][$run]['on_off'] = $cs_lang['offline'];
  }
  $data['links'][$run]['id'] = $data['links'][$run]['links_id'];
}

echo cs_subtemplate(__FILE__,$data,'links','listcat');