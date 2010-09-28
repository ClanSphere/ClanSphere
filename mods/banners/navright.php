<?php

$cs_lang = cs_translate('banners');

if(!empty($_GET['bc_id']))
  $where = "categories_id = '" . (int) $_GET['bc_id'] . "'";
else
  $where = 0;

$data = array();

$data['banners'] = cs_sql_select(__FILE__,'banners','banners_picture, banners_alt, banners_url',$where,'banners_order ASC',0,0);
$banners_loop = count($data['banners']);

if(empty($data['banners'])) {
  echo $cs_lang['no_banners'];
}
else {
  for($run=0; $run<$banners_loop; $run++) {
    $go = cs_secure($data['banners'][$run]['banners_picture']);
    $picture = cs_html_img($go,0,0,0,cs_secure($data['banners'][$run]['banners_alt']));
  $data['banners'][$run]['image'] = cs_html_link('http://' . cs_secure($data['banners'][$run]['banners_url']),$picture) . ' ';
  }
  echo cs_subtemplate(__FILE__,$data,'banners','navright');
}