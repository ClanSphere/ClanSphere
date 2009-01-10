<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

if(!empty($_GET['cat_id'])) {
  $where = "categories_id = '" . $_GET['cat_id'] . "'";
}
else {
  $where = 0;
}

$cs_banners = cs_sql_select(__FILE__,'banners','*',$where,'banners_order ASC',0,0);
$banners_loop = count($cs_banners);

if(empty($cs_banners)) {
  $data['banners']['image'] = '----';
  echo cs_subtemplate(__FILE__,$data,'banners','navright');
}
else {
  $data = array();
  for($run=0; $run<$banners_loop; $run++) {
    $go = cs_secure($cs_banners[$run]['banners_picture']);
  	$picture = cs_html_img($go,0,0,0,cs_secure($cs_banners[$run]['banners_alt']));
	$cs_banners[$run]['image'] = cs_html_link('http://' . cs_secure($cs_banners[$run]['banners_url']),$picture) . ' ';
  }
  $data['banners'] = $cs_banners;
  
  echo cs_subtemplate(__FILE__,$data,'banners','navright');
}
?>