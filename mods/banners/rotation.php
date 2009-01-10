<?php
$op_banners = cs_sql_option(__FILE__,'banners');

if(!empty($_GET['cat_id'])) {
  $where = "categories_id = '" . $_GET['cat_id'] . "' AND banners_id != '" . $op_banners['last_id'] . "'";
}
else {
  $where = "banners_id != '" . $op_banners['last_id'] . "'";
}

$cs_banners = cs_sql_select(__FILE__,'banners','banners_id, banners_picture, banners_alt, banners_url, categories_id',$where,'rand()',0,1);

if(empty($cs_banners)) {
  echo '----';
}
else {
  $go = cs_secure($cs_banners['banners_picture']);
  $picture = cs_html_img($go,0,0," style=\"margin-bottom:4px\"",cs_secure($cs_banners['banners_alt']));
  echo cs_html_link('http://' . cs_secure($cs_banners['banners_url']),$picture) . cs_html_br(1);
  $cells = array('options_value');
  $values = array($cs_banners['banners_id']);
  $where_op = 'options_mod = \'banners\' AND options_name = \'last_id\'';
  cs_sql_update(__FILE__,'options',$cells,$values,0,$where_op);	  
}
?>