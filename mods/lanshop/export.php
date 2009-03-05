<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');
$cs_post = cs_post('where');
$cs_get = cs_get('where');
$data = array();

$categories_id = empty($cs_get['where']) ? 0 : $cs_get['where'];
if (!empty($cs_post['where']))  $categories_id = $cs_post['where'];

$and_cat = !empty($categories_id) ? " AND las.categories_id = '" . $categories_id . "'" : '';
$where = "lso.lanshop_orders_status = '2'" . $and_cat ;

$lanshopmod = "categories_mod='lanshop'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$lanshopmod,'categories_name',0,0);
$data['head']['cat_dropdown'] = cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');

$select = 'usr.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete, lso.lanshop_orders_value AS lanshop_orders_value, las.lanshop_articles_name AS lanshop_articles_name, las.lanshop_articles_price AS lanshop_articles_price';
$from = 'lanshop_orders lso INNER JOIN {pre}_lanshop_articles las ON lso.lanshop_articles_id = las.lanshop_articles_id INNER JOIN {pre}_users usr ON lso.users_id = usr.users_id';
$order = 'lso.users_id ASC, las.lanshop_articles_name ASC, lso.lanshop_orders_value DESC';
$cs_lanshop = cs_sql_select(__FILE__,$from,$select,$where,$order,0,0);
$lanshop_loop = count($cs_lanshop);

$lanshop_price = 0;
$lanshop_value = 0;
$users_id = 0;


for($run = 0; $run < $lanshop_loop; $run++) {

	$data['orders'][$run]['if']['user'] = FALSE;
  if($users_id != $cs_lanshop[$run]['users_id']) {
  	$data['orders'][$run]['if']['user'] = TRUE;
    $users_id = $cs_lanshop[$run]['users_id'];
    $data['orders'][$run]['user'] = cs_user($users_id, $cs_lanshop[$run]['users_nick'], $cs_lanshop[$run]['users_active'], $cs_lanshop[$run]['users_delete']);
  }
  $data['orders'][$run]['users_id'] = $cs_lanshop[$run]['users_id'];
  $data['orders'][$run]['article'] = cs_secure($cs_lanshop[$run]['lanshop_articles_name']);
  $data['orders'][$run]['value'] = $cs_lanshop[$run]['lanshop_orders_value'];

  $pay = $cs_lanshop[$run]['lanshop_articles_price'] * $cs_lanshop[$run]['lanshop_orders_value'];
  $lanshop_price = $lanshop_price + $pay;
  $lanshop_value = $lanshop_value + $cs_lanshop[$run]['lanshop_orders_value'];
}

$data['stats']['price'] = $lanshop_price / 100 . ' ' . $cs_lang['cost'];
$data['stats']['value'] = $lanshop_value;
$data['stats']['time'] = cs_date('unix',cs_time(),1);

echo cs_subtemplate(__FILE__,$data,'lanshop','export');

?>
