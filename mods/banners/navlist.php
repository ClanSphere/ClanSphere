<?php

$cs_lang = cs_translate('banners');

if(!empty($_GET['cat_id'])) $where = "categories_id = '" . $_GET['cat_id'] . "'"; else $where = 0;

$data = array();

$data['banners'] = cs_sql_select(__FILE__,'banners','banners_picture, banners_alt, banners_url',$where,'banners_order ASC',0,0);
$banners_loop = count($data['banners']);

if(empty($data['banners'])) {
  echo $cs_lang['no_banners'];
}
else {
  for($run=0; $run<$banners_loop; $run++) {
    $go = cs_secure($data['banners'][$run]['banners_picture']);
    $picture = cs_html_img($go,0,0," style=\"margin-bottom:4px\"",cs_secure($data['banners'][$run]['banners_alt']));
  $data['banners'][$run]['image'] = cs_html_link('http://' . cs_secure($data['banners'][$run]['banners_url']),$picture) . ' ';
  }
  echo cs_subtemplate(__FILE__,$data,'banners','navlist');
}

/*
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cat_id = empty($_GET['cat_id']) ? 0 : (int) $_GET['cat_id'];

$where = empty($cat_id) ? 0 : "categories_id = '" . $cat_id . "'";

$cells = 'banners_picture, banners_alt, banners_url, categories_id';
$data['banners'] = cs_sql_select(__FILE__,'banners',$cells,$where,'banners_order ASC',0,0);

if(empty($data['banners'])) {
  echo '----';
}
else {
  foreach ($data['banners'] AS $banner) {
    $go = cs_secure($banner['banners_picture']);
    $picture = cs_html_img($go,0,0," style=\"margin-bottom:4px\"",cs_secure($banner['banners_alt']));
    echo cs_html_link('http://' . cs_secure($banner['banners_url']),$picture) . cs_html_br(1);
  }
}*/
?>