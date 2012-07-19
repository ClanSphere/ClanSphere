<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('links');
$cs_post = cs_post('where,start,sort');
$cs_get = cs_get('where,start,sort');
$data = array();

include 'mods/categories/functions.php';

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

$cells = 'categories_id, categories_name';
$categories_data = cs_sql_select(__FILE__,'categories',$cells,"categories_mod = 'links'",'categories_name',0,0);

$data['head']['count'] = $links_count;
$data['head']['pages'] = cs_pages('links','manage',$links_count,$start,$categories_id,$sort);
$data['head']['cat_dropdown'] = cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');
$data['head']['getmsg'] = cs_getmsg();

$data['sort']['name'] = cs_sort('links','manage',$start,$categories_id,1,$sort);

$tables = 'links ln INNER JOIN {pre}_categories cat ON ln.categories_id = cat.categories_id';
$cells  = 'ln.links_name AS links_name, ln.links_url AS links_url, ln.links_stats AS links_stats, ';
$cells .= 'ln.links_id AS links_id, ln.categories_id AS categories_id, ';
$cells .= 'cat.categories_name AS categories_name';
$where = empty($categories_id) ? 0 : "ln.categories_id = '" . $categories_id . "'";
$data['links'] = cs_sql_select(__FILE__,$tables,$cells,$where,$order,$start,$account['users_limit']);
$links_loop = count($data['links']);


for($run=0; $run<$links_loop; $run++) {

  $data['links'][$run]['name'] = cs_secure($data['links'][$run]['links_name']);
  $data['links'][$run]['cat'] = cs_secure($data['links'][$run]['categories_name']);
  $data['links'][$run]['url'] = $data['links'][$run]['links_url'];
  $data['links'][$run]['url_short'] = cs_substr($data['links'][$run]['links_url'],0,20);

  if($data['links'][$run]['links_stats'] == 'on') {
    $data['links'][$run]['color'] = 'lime';
    $data['links'][$run]['on_off'] = $cs_lang['online'];
  }else{
    $data['links'][$run]['color'] = 'red';
    $data['links'][$run]['on_off'] = $cs_lang['offline'];
  }
  $data['links'][$run]['id'] = $data['links'][$run]['links_id'];
}

echo cs_subtemplate(__FILE__,$data,'links','manage');
