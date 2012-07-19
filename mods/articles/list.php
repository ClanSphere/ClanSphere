<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('articles');
require_once 'mods/categories/functions.php';

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];
$cs_sort[1] = 'categories_name DESC';
$cs_sort[2] = 'categories_name ASC';
$sort = empty($_GET['sort']) ? 1 : (int) $_GET['sort'];
$order = 'categories_subid, ' . $cs_sort[$sort];

$cat_where = "categories_mod = 'articles' AND categories_access <= '" . $account['access_categories'] . "'";
$cells = 'categories_name, categories_id, categories_text, categories_picture, categories_subid';
$data['categories'] = cs_sql_select(__FILE__,'categories',$cells,$cat_where,$order,$start,0);
$data['categories'] = cs_catsort($data['categories']);
$categories_loop = is_array($data['categories']) ? count($data['categories']) : 0;

$data['sort']['category'] = cs_sort('articles','list',$start,'',1,$sort);
if(!empty($categories_loop)) {
  for($run=0; $run<$categories_loop; $run++) {
    $data['categories'][$run]['space'] = cs_catspaces($data['categories'][$run]['layer']);
    $data['categories'][$run]['categories_name'] = cs_link(cs_secure($data['categories'][$run]['categories_name']),'articles','listcat','id=' . $data['categories'][$run]['categories_id']);
    $data['categories'][$run]['articles_count'] = cs_sql_count(__FILE__,'articles','categories_id = ' .$data['categories'][$run]['categories_id']);
    $data['categories'][$run]['categories_text'] = cs_secure($data['categories'][$run]['categories_text'],1);
    $data['if']['catimg'] = empty($data['categories'][$run]['categories_picture']) ? false : true;
    $data['categories'][$run]['url_catimg'] = '';
    //categorie_image
    //$data['categories'][$run]['url_catimg'] = empty($data['if']['catimg']) ? '' : 'uploads/categories/'.$data['categories'][$run]['categories_picture'];
  }
}
echo cs_subtemplate(__FILE__,$data,'articles','list');