<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

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
  $go = cs_secure($cs_banners['banners_picture']);
  $picture = cs_html_img($go,0,0," style=\"margin-bottom:4px\"",cs_secure($cs_banners['banners_alt']));
  
  echo cs_html_link('http://' . cs_secure($cs_banners['banners_url']),$picture) . cs_html_br(1);
  
  require_once 'mods/clansphere/func_options.php';
  
  $save = array('last_id' => $cs_banners['banners_id']);
  
  cs_optionsave('banners', $save);
}