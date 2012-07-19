<?php
$op_partner = cs_sql_option(__FILE__,'partner');

$cells = 'partner_id, partner_rimg, partner_alt, partner_url';
$where = "partner_rimg != '' ";

if ($op_partner['method'] == 'random') {
  
  $banner = cs_sql_select(__FILE__,'partner',$cells,$where,'{random}');

} elseif ($op_partner['method'] == 'rotation') {
  
  $id = $op_partner['last_id'];
  $check = cs_sql_select(__FILE__,'partner','partner_id',$where,'partner_id DESC');
  
  if($id == $check['partner_id']) {
    $id = 0;
  }
  
  $where2 = 'partner_rimg != \'\' AND partner_id > \''.$id.'\'';
  $banner = cs_sql_select(__FILE__,'partner',$cells,$where2,'partner_id ASC');
  
}
$place = 'uploads/partner/';
$banner_img = cs_html_img($place.$banner['partner_rimg'],0,0,0,$banner['partner_alt']);  

echo cs_html_link('http://'.$banner['partner_url'], $banner_img);

$cells = array('options_value');
$values = array($banner['partner_id']);
$where_op = 'options_mod = \'partner\' AND options_name = \'last_id\'';

cs_sql_update(__FILE__,'options',$cells,$values,0,$where_op);