<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');

$article = empty($_POST['lanshop_articles_id']) ? 0 : $_POST['lanshop_articles_id'];
$value = empty($_POST['lanshop_orders_value']) ? 0 : $_POST['lanshop_orders_value'];

settype($article,'integer');
settype($value,'integer');

if(!empty($article) AND !empty($value)) {

	$order_cells = array('users_id', 'lanshop_articles_id', 'lanshop_orders_since', 'lanshop_orders_value', 'lanshop_orders_status');
  $order_save = array($account['users_id'], $article, cs_time(), $value, 1);
  cs_sql_insert(__FILE__,'lanshop_orders',$order_cells,$order_save);

	$get_art = "lanshop_articles_id = '" . $article . "'";
	$fetch = cs_sql_select(__FILE__,'lanshop_articles','categories_id',$get_art);
	$categories_id = $fetch['categories_id'];
	$msg = 1;
}
else {
	$categories_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
	settype($categories_id,'integer');
	$msg = 0;
}
$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$where = empty($categories_id) ? 0 : "categories_id = '" . $categories_id . "'";
$cs_sort[1] = 'lanshop_articles_name DESC';
$cs_sort[2] = 'lanshop_articles_name ASC';
$cs_sort[3] = 'lanshop_articles_price DESC';
$cs_sort[4] = 'lanshop_articles_price ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$lanshop_count = cs_sql_count(__FILE__,'lanshop_articles',$where);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_center'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo sprintf($cs_lang['items_found'],$lanshop_count);
echo cs_html_roco(2,'rightb');
echo cs_pages('lanshop','center',$lanshop_count,$start,$categories_id,$sort);
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['category'];
echo cs_html_form(1,'lanshop_center','lanshop','center');
$lanshopmod = "categories_mod='lanshop'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$lanshopmod,'categories_name',0,0);
echo cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');
echo cs_html_vote('submit',$cs_lang['show'],'submit');
echo cs_html_form(0);
echo cs_html_roco(2,'rightb');
echo cs_link($cs_lang['orders'],'lanshop','orders');
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!empty($msg)) {
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'centerc');
	echo $cs_lang['order_done'];
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_br(1);
}

$select = 'lanshop_articles_name, lanshop_articles_price, lanshop_articles_id';
$cs_lanshop = cs_sql_select(__FILE__,'lanshop_articles',$select,$where,$order,$start,$account['users_limit']);
$lanshop_loop = count($cs_lanshop);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo cs_sort('lanshop','center',$start,$categories_id,1,$sort);
echo $cs_lang['name'];
echo cs_html_roco(2,'headb');
echo cs_sort('lanshop','center',$start,$categories_id,3,$sort);
echo $cs_lang['price'];
echo cs_html_roco(3,'headb');
echo $cs_lang['basket'];
echo cs_html_roco(0);

for($run=0; $run<$lanshop_loop; $run++) {

	echo cs_html_roco(1,'leftc');
	$article = $cs_lanshop[$run]['lanshop_articles_id'];
	$lanshop_view = cs_secure($cs_lanshop[$run]['lanshop_articles_name']);
  echo cs_link($lanshop_view,'lanshop','view','id=' . $article);
	echo cs_html_roco(2,'leftc');
	echo $cs_lanshop[$run]['lanshop_articles_price'] / 100 . ' ' . $cs_lang['cost'];
	echo cs_html_roco(3,'leftc');
	echo cs_html_form(1,'lanshop_center' . $article,'lanshop','center');
	echo cs_html_input('lanshop_orders_value',1,'text',4,4);
	echo cs_html_vote('lanshop_articles_id',$article,'hidden');
	echo cs_html_vote('submit',$cs_lang['order'],'submit');
	echo cs_html_form(0);
	echo cs_html_roco(0);
}

echo cs_html_table(0);

?>
