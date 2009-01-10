<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');

if(!empty($_GET['remove_id'])) {

	$remove_id = $_GET['remove_id'];
	settype($remove_id,'integer');
	$self = "lanshop_orders_id = '" . $remove_id . "'";
	$target = cs_sql_select(__FILE__,'lanshop_orders','users_id, lanshop_orders_status',$self);
  if($target['users_id'] == $account['users_id'] AND $target['lanshop_orders_status'] == 1) {
		cs_sql_delete(__FILE__,'lanshop_orders',$remove_id);
  }
}

$categories_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
settype($categories_id,'integer');
$where = "users_id = '" . $account['users_id'] . "'";
$where .= empty($categories_id) ? '' : " AND las.categories_id = '" . $categories_id . "'";

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'lanshop_articles_name DESC';
$cs_sort[2] = 'lanshop_articles_name ASC';
$cs_sort[3] = 'lanshop_articles_price DESC';
$cs_sort[4] = 'lanshop_articles_price ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$from = 'lanshop_orders lso INNER JOIN {pre}_lanshop_articles las ON lso.lanshop_articles_id = las.lanshop_articles_id';
$ls_count = cs_sql_select(__FILE__,$from,'COUNT(lanshop_orders_id)',$where);
$ls_values = array_values($ls_count);
$lanshop_count = $ls_values[0];
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_orders'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo sprintf($cs_lang['ordered_items'],$lanshop_count);
echo cs_html_roco(2,'rightb');
echo cs_pages('lanshop','orders',$lanshop_count,$start,$categories_id,$sort);
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['category'];
echo cs_html_form(1,'lanshop_orders','lanshop','orders');
$lanshopmod = "categories_mod='lanshop'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$lanshopmod,'categories_name',0,0);
echo cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');
echo cs_html_vote('submit',$cs_lang['show'],'submit');
echo cs_html_form(0);
echo cs_html_roco(2,'rightb');
echo cs_link($cs_lang['center'],'lanshop','center');
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$select = 'lso.lanshop_orders_id AS lanshop_orders_id, lso.lanshop_orders_status AS lanshop_orders_status, lso.lanshop_orders_value AS lanshop_orders_value, las.lanshop_articles_id AS lanshop_articles_id, las.lanshop_articles_name AS lanshop_articles_name, las.lanshop_articles_price AS lanshop_articles_price';
$cs_lanshop = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$lanshop_loop = count($cs_lanshop);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo cs_sort('lanshop','orders',$start,$categories_id,1,$sort);
echo $cs_lang['name'];
echo cs_html_roco(2,'headb');
echo $cs_lang['status'];
echo cs_html_roco(3,'headb',0,2);
echo $cs_lang['basket'];
echo cs_html_roco(4,'headb');
echo cs_sort('lanshop','orders',$start,$categories_id,3,$sort);
echo $cs_lang['money'];
echo cs_html_roco(0);

$money = 0;

for($run=0; $run<$lanshop_loop; $run++) {

	echo cs_html_roco(1,'leftc');
	$lanshop_view = cs_secure($cs_lanshop[$run]['lanshop_articles_name']);
  echo cs_link($lanshop_view,'lanshop','view','id=' . $cs_lanshop[$run]['lanshop_articles_id']);
	echo cs_html_roco(2,'leftc');
	$status = $cs_lanshop[$run]['lanshop_orders_status'];
	echo $cs_lang['status_' . $status];
	echo cs_html_roco(3,'leftc');
	echo $cs_lanshop[$run]['lanshop_orders_value'];
	echo cs_html_roco(4,'leftc');
	$img_del = cs_icon('editdelete',16,$cs_lang['remove']);
  echo cs_link($img_del,'lanshop','orders','remove_id=' . $cs_lanshop[$run]['lanshop_orders_id'],0,$cs_lang['remove']);
	echo cs_html_roco(5,'leftc');
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
