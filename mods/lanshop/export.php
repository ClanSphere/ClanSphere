<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');

$categories_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
settype($categories_id,'integer');
$where = "lso.lanshop_orders_status = '2' AND las.categories_id = '" . $categories_id . "'";

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_export'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_link($cs_lang['manage'],'lanshop','manage');
echo cs_html_roco(2,'centerb');
echo cs_link($cs_lang['delivery'],'lanshop','delivery');
echo cs_html_roco(3,'rightb');
echo cs_link($cs_lang['cashdesk'],'lanshop','cashdesk');
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc',0,3);
echo $cs_lang['category'];
echo cs_html_form(1,'lanshop_export','lanshop','export');
$lanshopmod = "categories_mod='lanshop'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$lanshopmod,'categories_name',0,0);
echo cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');
echo cs_html_vote('submit',$cs_lang['show'],'submit');
echo cs_html_form(0);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$select = 'usr.users_id AS users_id, usr.users_nick AS users_nick, lso.lanshop_orders_value AS lanshop_orders_value, las.lanshop_articles_name AS lanshop_articles_name, las.lanshop_articles_price AS lanshop_articles_price';
$from = 'lanshop_orders lso INNER JOIN {pre}_lanshop_articles las ON lso.lanshop_articles_id = las.lanshop_articles_id INNER JOIN {pre}_users usr ON lso.users_id = usr.users_id';
$order = 'lso.users_id ASC, las.lanshop_articles_name ASC, lso.lanshop_orders_value DESC';
$cs_lanshop = cs_sql_select(__FILE__,$from,$select,$where,$order,0,0);
$lanshop_loop = count($cs_lanshop);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['user'];
echo cs_html_roco(2,'headb');
echo $cs_lang['product'];
echo cs_html_roco(3,'headb');
echo $cs_lang['value'];
echo cs_html_roco(0);

$lanshop_price = 0;
$lanshop_value = 0;
$users_id = 0;

for($run=0; $run<$lanshop_loop; $run++) {

  if($users_id != $cs_lanshop[$run]['users_id']) {
    $users_id = $cs_lanshop[$run]['users_id'];
    echo cs_html_roco(1,'centerb',0,3);
    echo cs_secure($cs_lanshop[$run]['users_nick']);
    echo cs_html_roco(0);
  }
  echo cs_html_roco(1,'leftc');
  echo $cs_lanshop[$run]['users_id'];
  echo cs_html_roco(2,'leftc');
  echo cs_secure($cs_lanshop[$run]['lanshop_articles_name']);
  echo cs_html_roco(3,'leftc');
  echo $cs_lanshop[$run]['lanshop_orders_value'];
  echo cs_html_roco(0);
  $pay = $cs_lanshop[$run]['lanshop_articles_price'] * $cs_lanshop[$run]['lanshop_orders_value'];
  $lanshop_price = $lanshop_price + $pay;
  $lanshop_value = $lanshop_value + $cs_lanshop[$run]['lanshop_orders_value'];
}

echo cs_html_table(0);
echo cs_html_br(1);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'leftc');
echo $cs_lang['orders_price'];
echo cs_html_roco(2,'leftb');
echo $lanshop_price / 100 . ' ' . $cs_lang['cost'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
echo $cs_lang['orders_value'];
echo cs_html_roco(2,'leftb');
echo $lanshop_value;
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
echo $cs_lang['orders_time'];
echo cs_html_roco(2,'leftb');
echo cs_date('unix',cs_time(),1);
echo cs_html_roco(0);
echo cs_html_table(0);

?>
