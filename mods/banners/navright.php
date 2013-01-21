<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('banners');
$cs_get = cs_get('catid');
$cs_option = cs_sql_option(__FILE__,'banners');
$data = array();

$where = empty($cs_get['catid']) ? 0 : 'categories_id = ' . $cs_get['catid'];
$data['banners'] = cs_sql_select(__FILE__,'banners','banners_picture, banners_alt, banners_url',$where,'banners_order ASC',0,$cs_option['max_navright']);

if(empty($data['banners'])) {
  echo $cs_lang['no_banners'];
}
else {
  for($run=0; $run<count($data['banners']); $run++) {
    $go = cs_secure($data['banners'][$run]['banners_picture']);
    $picture = cs_html_img($go,0,0,0,cs_secure($data['banners'][$run]['banners_alt']));
  $data['banners'][$run]['image'] = cs_html_link('http://' . cs_secure($data['banners'][$run]['banners_url']),$picture) . ' ';
  }
  echo cs_subtemplate(__FILE__,$data,'banners','navright');
}