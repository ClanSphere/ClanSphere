<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');
$cs_post = cs_post('where,start,sort');
$cs_get = cs_get('where,start,sort');
$data = array();

$categories_id = empty($cs_get['where']) ? 0 : $cs_get['where'];
if (!empty($cs_post['where']))  $categories_id = $cs_post['where'];
$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 3 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

if(!empty($_GET['remove_id'])) {

  $remove_id = $_GET['remove_id'];
  settype($remove_id,'integer');
  $self = "lanshop_orders_id = '" . $remove_id . "'";
  $target = cs_sql_select(__FILE__,'lanshop_orders','users_id, lanshop_orders_status',$self);
  if($target['users_id'] == $account['users_id'] AND $target['lanshop_orders_status'] == 1) {
    cs_sql_delete(__FILE__,'lanshop_orders',$remove_id);
  }
}

$where = "users_id = '" . $account['users_id'] . "'";
$where .= empty($categories_id) ? '' : " AND las.categories_id = '" . $categories_id . "'";

$cs_sort[1] = 'lanshop_articles_name DESC';
$cs_sort[2] = 'lanshop_articles_name ASC';
$cs_sort[3] = 'lanshop_articles_price DESC';
$cs_sort[4] = 'lanshop_articles_price ASC';
$order = $cs_sort[$sort];
$from = 'lanshop_orders lso INNER JOIN {pre}_lanshop_articles las ON lso.lanshop_articles_id = las.lanshop_articles_id';
$ls_count = cs_sql_select(__FILE__,$from,'COUNT(lanshop_orders_id)',$where);
$ls_values = array_values($ls_count);
$lanshop_count = $ls_values[0];


$data['head']['body'] = sprintf($cs_lang['ordered_items'],$lanshop_count);
$data['head']['pages'] = cs_pages('lanshop','orders',$lanshop_count,$start,$categories_id,$sort);

$lanshopmod = "categories_mod='lanshop'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$lanshopmod,'categories_name',0,0);
$data['head']['cat_dropdown'] = cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');

$data['sort']['name'] = cs_sort('lanshop','orders',$start,$categories_id,1,$sort);
$data['sort']['price'] = cs_sort('lanshop','orders',$start,$categories_id,3,$sort);

$select = 'lso.lanshop_orders_id AS lanshop_orders_id, lso.lanshop_orders_status AS lanshop_orders_status, lso.lanshop_orders_value AS lanshop_orders_value, las.lanshop_articles_id AS lanshop_articles_id, las.lanshop_articles_name AS lanshop_articles_name, las.lanshop_articles_price AS lanshop_articles_price';
$cs_lanshop = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$lanshop_loop = count($cs_lanshop);

$money = 0;

for($run=0; $run<$lanshop_loop; $run++) {

	$data['orders'][$run]['id'] = $cs_lanshop[$run]['lanshop_orders_id'];
	$data['orders'][$run]['articles_id'] = $cs_lanshop[$run]['lanshop_articles_id'];
	$data['orders'][$run]['articles_name'] = cs_secure($cs_lanshop[$run]['lanshop_articles_name']);
	$status = $cs_lanshop[$run]['lanshop_orders_status'];
	$data['orders'][$run]['status'] = $cs_lang['status_' . $status];
	$data['orders'][$run]['value'] = $cs_lanshop[$run]['lanshop_orders_value'];
  $cost = $cs_lanshop[$run]['lanshop_articles_price'] * $cs_lanshop[$run]['lanshop_orders_value'];
  $data['orders'][$run]['cost'] = $cost / 100 . ' ' . $cs_lang['cost'];
  
  if($status == 1) {
    $money = $money + $cost;
  }
}

$data['bottom']['body'] = sprintf($cs_lang['money_all'],$money / 100);

echo cs_subtemplate(__FILE__,$data,'lanshop','orders');

?>
