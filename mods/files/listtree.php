<?php
$cs_lang = cs_translate('files');
$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 2 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

include_once('mods/categories/functions.php');


$select = 'categories_id, categories_name, categories_url, categories_subid';
$where = "categories_mod = 'files'";
$order = 'categories_name ASC';
$data['cat'] = cs_sql_select(__FILE__,'categories',$select,$where,$order,0,$account['users_limit']);
$data['cat'] = cs_catsort($data['cat']);
echo '<pre>';
print_R($data);