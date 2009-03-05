<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');
$cs_get = cs_get('id');
$data = array();

$lanshop_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$select = 'categories_id, lanshop_articles_name, lanshop_articles_price, lanshop_articles_info';
$cs_lanshop = cs_sql_select(__FILE__,'lanshop_articles',$select,'lanshop_articles_id = ' . $lanshop_id);


$where = "categories_id='" . $cs_lanshop['categories_id'] . "'";
$cs_cat = cs_sql_select(__FILE__,'categories','categories_name, categories_id',$where);
$data['ls']['category'] = cs_link($cs_cat['categories_name'],'categories','view','id=' . $cs_cat['categories_id']);

$data['ls']['name'] = cs_secure($cs_lanshop['lanshop_articles_name']);

$price = $cs_lanshop['lanshop_articles_price'] / 100;
$data['ls']['price'] = $price . ' ' . $cs_lang['cost'];

$data['ls']['info'] = cs_secure($cs_lanshop['lanshop_articles_info'],1,1);


echo cs_subtemplate(__FILE__,$data,'lanshop','view');

?>
