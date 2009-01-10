<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');

$lanshop_id = $_REQUEST['id'];
settype($lanshop_id,'integer');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_view'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_view'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$cs_lanshop = cs_sql_select(__FILE__,'lanshop_articles','*','lanshop_articles_id = ' . $lanshop_id);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'leftc',0,0,'140px');
echo cs_icon('folder_yellow') . $cs_lang['category'];
echo cs_html_roco(2,'leftb');
$where = "categories_id='" . $cs_lanshop['categories_id'] . "'";
$cs_cat = cs_sql_select(__FILE__,'categories','categories_name, categories_id',$where);
echo cs_link($cs_cat['categories_name'],'categories','view','id=' . $cs_cat['categories_id']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('warehause') . $cs_lang['name'];
echo cs_html_roco(2,'leftb');
echo cs_secure($cs_lanshop['lanshop_articles_name']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('money') . $cs_lang['price'];
echo cs_html_roco(2,'leftb');
$price = $cs_lanshop['lanshop_articles_price'] / 100;
echo $price . ' ' . $cs_lang['cost'];
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('documentinfo') . $cs_lang['info'];
echo cs_html_roco(2,'leftb');
echo cs_secure($cs_lanshop['lanshop_articles_info']);
echo cs_html_roco(0);
echo cs_html_table(0);

?>
