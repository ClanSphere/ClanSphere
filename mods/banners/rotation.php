<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$data = array();
$op_banners = cs_sql_option(__FILE__,'banners');

if(!empty($_GET['cat_id'])) {
  $cat_id = (int) $_GET['cat_id'];
  $where = "categories_id = '" . $cat_id . "' AND banners_id != '" . $op_banners['last_id'] . "'";
}
else {
  $where = "banners_id != '" . $op_banners['last_id'] . "'";
}

$cs_banners = cs_sql_select(__FILE__,'banners','banners_id, banners_picture, banners_alt, banners_url, categories_id',$where,'{random}',0,1);

if(empty($cs_banners)) {
  
  echo '----';
  
} else {

  $data['banner']['pic'] = cs_secure($cs_banners['banners_picture']);
  $data['banner']['alt'] = cs_secure($cs_banners['banners_alt']);
  $data['banner']['url'] = cs_secure($cs_banners['banners_url']);
  echo cs_subtemplate(__FILE__,$data,'banners','rotation');
  
  require_once 'mods/clansphere/func_options.php';
  $save = array('last_id' => $cs_banners['banners_id']);
  cs_optionsave('banners', $save);
}