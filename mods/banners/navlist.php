<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cat_id = empty($_GET['cat_id']) ? 0 : (int) $_GET['cat_id'];

$where = empty($cat_id) ? 0 : "categories_id = '" . $cat_id . "'";

$cells = 'banners_picture, banners_alt, banners_url, categories_id';
$cs_banners = cs_sql_select(__FILE__,'banners',$cells,$where,'banners_order ASC',0,0);

if(empty($cs_banners)) {
  echo '----';
}
else {
  foreach ($cs_banners AS $banner) {
    $go = cs_secure($banner['banners_picture']);
  	$picture = cs_html_img($go,0,0," style=\"margin-bottom:4px\"",cs_secure($banner['banners_alt']));
    echo cs_html_link('http://' . cs_secure($banner['banners_url']),$picture) . cs_html_br(1);
  }
}
?>