<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('categories');
$cs_get = cs_get('id');

$categories_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
$cs_categories = cs_sql_select(__FILE__,'categories','*',"categories_id = '" . $categories_id . "'");

$data['cat']['name'] = cs_secure($cs_categories['categories_name']);

#$cat_mod = empty($_POST['cat_mod']) ? $cs_categories['categories_mod'] : $_POST['cat_mod'];
$cat_mod = $cs_categories['categories_mod'];
$modules = cs_checkdirs('mods');
foreach($modules as $mods) {
  if($mods['dir'] == $cat_mod) {
     $data['cat']['mod'] = $mods['name'];
  }
}

$data['cat']['url'] = '';
if(!empty($cs_categories['categories_url'])) {
  $cs_cat_url = cs_secure($cs_categories['categories_url']);
  $data['cat']['url'] = cs_html_link('http://' . $cs_cat_url,$cs_cat_url);
}


$data['cat']['text'] = cs_secure($cs_categories['categories_text'],1,1);

$data['cat']['pic'] = '';
if(!empty($cs_categories['categories_picture'])) {
  $place = 'uploads/categories/' . $cs_categories['categories_picture'];
  $size = getimagesize($cs_main['def_path'] . '/' . $place);
  $data['cat']['pic'] = cs_html_img($place,$size[1],$size[0]);
}

echo cs_subtemplate(__FILE__,$data,'categories','view');
