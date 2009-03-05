<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');
$data = array();

if(!empty($_GET['remove_id']) AND $account['access_lanshop'] == 5) {
  $remove_id = $_GET['remove_id'];
  settype($remove_id,'integer');
 cs_sql_delete(__FILE__,'lanshop_orders',$remove_id);
}
elseif(!empty($_GET['pay_id']) AND $account['access_lanshop'] >= 4) {
  $pay_id = $_GET['pay_id'];
  settype($pay_id,'integer');
  $lanshop_cells = array('lanshop_orders_since','lanshop_orders_status');
  $lanshop_save = array(cs_time(),2);
 cs_sql_update(__FILE__,'lanshop_orders',$lanshop_cells,$lanshop_save,$pay_id);
}

$categories_id = empty($_REQUEST['categories_id']) ? 0 : $_REQUEST['categories_id'];
$users_id = empty($_REQUEST['users_id']) ? 0 : $_REQUEST['users_id'];
$orders_status = empty($_REQUEST['status']) ? 0 : $_REQUEST['status'];

settype($categories_id,'integer');
settype($users_id,'integer');
settype($orders_status,'integer');

$where = empty($users_id) ? '' : "lso.users_id = '" . $users_id . "' AND ";
$where .= empty($categories_id) ? '' : "las.categories_id = '" . $categories_id . "' AND ";
$where .= empty($orders_status) ? '' : "lso.lanshop_orders_status = '" . $orders_status . "' AND ";
$where = substr($where,0,-5);

$users_data = cs_sql_select(__FILE__,'users','users_nick, users_id',0,'users_nick ASC',0,0);
$data['head']['users_dropdown'] = cs_dropdown('users_id','users_nick',$users_data,$users_id);

$lanshopmod = "categories_mod='lanshop'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$lanshopmod,'categories_name',0,0);
$data['head']['cat_dropdown'] = cs_dropdown('categories_id','categories_name',$categories_data,$categories_id);

$status[0]['status'] = 1;
$status[0]['name'] = $cs_lang['status_1'];
$status[1]['status'] = 2;
$status[1]['name'] = $cs_lang['status_2'];
$status[2]['status'] = 3;
$status[2]['name'] = $cs_lang['status_3'];
$data['head']['status_dropdown'] = cs_dropdown('status','name',$status,$orders_status);


$from = 'lanshop_orders lso INNER JOIN {pre}_lanshop_articles las ON lso.lanshop_articles_id = las.lanshop_articles_id INNER JOIN {pre}_users usr ON lso.users_id = usr.users_id';
$select = 'lso.lanshop_orders_id AS lanshop_orders_id, lso.lanshop_orders_status AS lanshop_orders_status, lso.lanshop_orders_value AS lanshop_orders_value, las.lanshop_articles_id AS lanshop_articles_id, las.lanshop_articles_name AS lanshop_articles_name, las.lanshop_articles_price AS lanshop_articles_price, usr.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete';
$order = 'users_nick, lanshop_articles_name';
$data['orders'] = cs_sql_select(__FILE__,$from,$select,$where,$order,0,0);
$lanshop_loop = count($data['orders']);

$money = 0;

for($run = 0; $run < $lanshop_loop; $run++) {

  $get = 'users_id=' . $users_id . '&amp;categories_id=' . $categories_id . '&amp;status=' . $orders_status . '&amp;';
  $id = $data['orders'][$run]['lanshop_orders_id'];

  $users_view = cs_secure($data['orders'][$run]['users_nick']);
  $data['orders'][$run]['user'] = cs_user($data['orders'][$run]['users_id'],$data['orders'][$run]['users_nick'], $data['orders'][$run]['users_active'], $data['orders'][$run]['users_delete']);
  $lanshop_view = cs_secure($data['orders'][$run]['lanshop_articles_name']);
  $data['orders'][$run]['article'] = cs_link($lanshop_view,'lanshop','view','id=' . $data['orders'][$run]['lanshop_articles_id']);
  $status = $data['orders'][$run]['lanshop_orders_status'];
  $data['orders'][$run]['status'] = $cs_lang['status_' . $status];

  $img_pay = cs_icon('money',16);
  $data['orders'][$run]['pay_id'] = cs_link($img_pay,'lanshop','cashdesk',$get . 'pay_id=' . $id);
  $data['orders'][$run]['value'] = $data['orders'][$run]['lanshop_orders_value'];
  $img_del = cs_icon('editdelete',16);
  $data['orders'][$run]['remove_id'] = cs_link($img_del,'lanshop','cashdesk',$get . 'remove_id=' . $id,0,$cs_lang['remove']);
  $cost = $data['orders'][$run]['lanshop_articles_price'] * $data['orders'][$run]['lanshop_orders_value'];
  $data['orders'][$run]['cost'] = $cost / 100 . ' ' . $cs_lang['cost'];

  if($status == 1) {
    $money = $money + $cost;
  }
}

$data['bottom']['body'] = sprintf($cs_lang['money_all'],$money / 100);

echo cs_subtemplate(__FILE__,$data,'lanshop','cashdesk');

?>