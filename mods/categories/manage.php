<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('categories');
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 2 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

include_once('mods/categories/functions.php');
$op_cat = cs_sql_option(__FILE__,'categories');

$cs_sort[1] = 'categories_name DESC';
$cs_sort[2] = 'categories_name ASC';
$cs_sort[3] = 'categories_url DESC';
$cs_sort[4] = 'categories_url ASC';
$order = 'categories_subid, ' . $cs_sort[$sort];

$where = empty($_REQUEST['where']) ? $op_cat['def_mod'] : $_REQUEST['where'];
$mdp = "categories_mod = '" . cs_sql_escape($where) . "'";
$categories_count = cs_sql_count(__FILE__,'categories',$mdp);


$data['where']['mod'] = $where;
$data['head']['count'] = $categories_count;
$data['head']['pages'] = cs_pages('categories','manage',$categories_count,$start,$where,$sort);

$run = 0;
$modules = cs_checkdirs('mods');
foreach($modules as $mods) {
$check_axx = empty($account['access_' . $mods['dir'] . '']) ? 0 : $account['access_' . $mods['dir'] . ''];
  if(!empty($mods['categories']) AND $check_axx > 2) {
    $mods['dir'] == $where ? $sel = 1 : $sel = 0;
    $data['mod'][$run]['sel'] = cs_html_option($mods['name'],$mods['dir'],$sel);
    $run++;
  }
}

$data['head']['getmsg'] = cs_getmsg();

$data['sort']['name'] = cs_sort('categories','manage',$start,$where,1,$sort);
$data['sort']['url'] = cs_sort('categories','manage',$start,$where,3,$sort);

$select = 'categories_id, categories_name, categories_url, categories_subid';
$data['cat'] = cs_sql_select(__FILE__,'categories',$select,$mdp,$order,$start,$account['users_limit']);
$data['cat'] = cs_catsort($data['cat']);
$categories_loop = !empty($data['cat']) ? count($data['cat']) : '';


for($run=0; $run<$categories_loop; $run++) {
  
  $blank = '';
  if (!empty($data['cat'][$run]['layer'])) {
    for ($i = 0; $i < $data['cat'][$run]['layer']; $i++)
      $blank .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
      $blank .= cs_icon('add_sub_task');
  }
  $data['cat'][$run]['subcat_layer'] = $blank;
  $cs_cat_name = cs_secure($data['cat'][$run]['categories_name']);
  $data['cat'][$run]['category'] = cs_link($cs_cat_name,'categories','view','id=' . $data['cat'][$run]['categories_id']);

  $data['cat'][$run]['url'] = '';
  if(!empty($data['cat'][$run]['categories_url'])) {
    $cs_cat_url = cs_secure($data['cat'][$run]['categories_url']);
    $data['cat'][$run]['url'] = cs_html_link('http://' . $cs_cat_url,$cs_cat_url);
  }
  $data['cat'][$run]['id'] = $data['cat'][$run]['categories_id'];
}
echo cs_subtemplate(__FILE__,$data,'categories','manage');
