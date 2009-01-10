<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');

if(!empty($_GET['remove_id'])) {

	$remove_id = $_GET['remove_id'];
	settype($remove_id,'integer');
  if($account['access_lanshop'] >= 5) {
		cs_sql_delete(__FILE__,'lanshop_orders',$remove_id);
  }
}
elseif(!empty($_GET['pay_id'])) {

	$pay_id = $_GET['pay_id'];
	settype($pay_id,'integer');
  if($account['access_lanshop'] >= 4) {
  	$lanshop_cells = array('lanshop_orders_since','lanshop_orders_status');
  	$lanshop_save = array(cs_time(),2);
  	cs_sql_update(__FILE__,'lanshop_orders',$lanshop_cells,$lanshop_save,$pay_id);
  }
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

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_cashdesk'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_link($cs_lang['manage'],'lanshop','manage');
echo cs_html_roco(2,'centerb');
echo cs_link($cs_lang['delivery'],'lanshop','delivery');
echo cs_html_roco(3,'rightb');
echo cs_link($cs_lang['export'],'lanshop','export');
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_html_form(1,'lanshop_cashdesk','lanshop','cashdesk');
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'leftc');
echo $cs_lang['user'];
echo cs_html_roco(2,'leftc');
echo $cs_lang['category'];
echo cs_html_roco(3,'leftc');
echo $cs_lang['status'];
echo cs_html_roco(4,'leftc');
echo $cs_lang['options'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
$users_data = cs_sql_select(__FILE__,'users','users_nick, users_id',0,'users_nick ASC',0,0);
echo cs_dropdown('users_id','users_nick',$users_data,$users_id);
echo cs_html_roco(2,'leftb');
$lanshopmod = "categories_mod='lanshop'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$lanshopmod,'categories_name',0,0);
echo cs_dropdown('categories_id','categories_name',$categories_data,$categories_id);
echo cs_html_roco(3,'leftb');
$status[0]['status'] = 1;
$status[0]['name'] = $cs_lang['status_1'];
$status[1]['status'] = 2;
$status[1]['name'] = $cs_lang['status_2'];
$status[2]['status'] = 3;
$status[2]['name'] = $cs_lang['status_3'];
echo cs_dropdown('status','name',$status,$orders_status);
echo cs_html_roco(4,'leftb');
echo cs_html_vote('submit',$cs_lang['show'],'submit');
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_form(0);
echo cs_html_br(1);

$from = 'lanshop_orders lso INNER JOIN {pre}_lanshop_articles las ON lso.lanshop_articles_id = las.lanshop_articles_id INNER JOIN {pre}_users usr ON lso.users_id = usr.users_id';
$select = 'lso.lanshop_orders_id AS lanshop_orders_id, lso.lanshop_orders_status AS lanshop_orders_status, lso.lanshop_orders_value AS lanshop_orders_value, las.lanshop_articles_id AS lanshop_articles_id, las.lanshop_articles_name AS lanshop_articles_name, las.lanshop_articles_price AS lanshop_articles_price, usr.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active';
$order = 'users_nick, lanshop_articles_name';
$cs_lanshop = cs_sql_select(__FILE__,$from,$select,$where,$order,0,0);
$lanshop_loop = count($cs_lanshop);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['user'];
echo cs_html_roco(2,'headb');
echo $cs_lang['name'];
echo cs_html_roco(3,'headb',0,2);
echo $cs_lang['status'];
echo cs_html_roco(4,'headb',0,2);
echo $cs_lang['basket'];
echo cs_html_roco(5,'headb');
echo $cs_lang['money'];
echo cs_html_roco(0);

$money = 0;

for($run=0; $run<$lanshop_loop; $run++) {

	$get = 'users_id=' . $users_id . '&amp;categories_id=' . $categories_id . '&amp;status=' . $orders_status . '&amp;';

	echo cs_html_roco(1,'leftc');
	$users_view = cs_secure($cs_lanshop[$run]['users_nick']);
  echo cs_user($cs_lanshop[$run]['users_id'],$cs_lanshop[$run]['users_nick'], $cs_lanshop[$run]['users_active']);
	echo cs_html_roco(2,'leftc');
	$lanshop_view = cs_secure($cs_lanshop[$run]['lanshop_articles_name']);
  echo cs_link($lanshop_view,'lanshop','view','id=' . $cs_lanshop[$run]['lanshop_articles_id']);
	echo cs_html_roco(3,'leftc');
	$status = $cs_lanshop[$run]['lanshop_orders_status'];
	echo $cs_lang['status_' . $status];
	echo cs_html_roco(4,'leftc');
	$img_pay = cs_icon('money',16,$cs_lang['pay']);
  echo cs_link($img_pay,'lanshop','cashdesk',$get . 'pay_id=' . $cs_lanshop[$run]['lanshop_orders_id']);
	echo cs_html_roco(5,'leftc');
	echo $cs_lanshop[$run]['lanshop_orders_value'];
	echo cs_html_roco(6,'leftc');
	$img_del = cs_icon('editdelete',16,$cs_lang['remove']);
  echo cs_link($img_del,'lanshop','cashdesk',$get . 'remove_id=' . $cs_lanshop[$run]['lanshop_orders_id'],0,$cs_lang['remove']);
	echo cs_html_roco(6,'leftc');
	$cost = $cs_lanshop[$run]['lanshop_articles_price'] * $cs_lanshop[$run]['lanshop_orders_value'];
	echo $cost / 100 . ' ' . $cs_lang['cost'];
	echo cs_html_roco(0);
	if($status == 1) {
		$money = $money + $cost;
	}
}

echo cs_html_table(0);
echo cs_html_br(1);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'centerb');
echo sprintf($cs_lang['money_all'],$money / 100);
echo cs_html_roco(0);
echo cs_html_table(0);

?>