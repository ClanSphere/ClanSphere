<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');

$categories_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
settype($categories_id,'integer');
$where = empty($categories_id) ? 0 : "categories_id = '" . $categories_id . "'";

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'lanshop_articles_name DESC';
$cs_sort[2] = 'lanshop_articles_name ASC';
$cs_sort[3] = 'lanshop_articles_price DESC';
$cs_sort[4] = 'lanshop_articles_price ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$lanshop_count = cs_sql_count(__FILE__,'lanshop_articles',$where);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_manage'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_icon('editpaste') . cs_link($cs_lang['new_article'],'lanshop','create');
echo cs_html_roco(2,'leftb');
echo cs_icon('contents') . $cs_lang['all'] . $lanshop_count;
echo cs_html_roco(2,'rightb');
echo cs_pages('lanshop','manage',$lanshop_count,$start,$categories_id,$sort);
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb',0,2);
echo $cs_lang['category'];
echo cs_html_form(1,'lanshop_manage','lanshop','manage');
$lanshopmod = "categories_mod='lanshop'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$lanshopmod,'categories_name',0,0);
echo cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');
echo cs_html_vote('submit',$cs_lang['show'],'submit');
echo cs_html_form(0);
echo cs_html_roco(2,'rightb');
echo cs_link($cs_lang['cashdesk'],'lanshop','cashdesk');
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_getmsg();

$select = 'lanshop_articles_name, lanshop_articles_price, lanshop_articles_id';

$cs_lanshop = cs_sql_select(__FILE__,'lanshop_articles',$select,$where,$order,$start,$account['users_limit']);
$lanshop_loop = count($cs_lanshop);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo cs_sort('lanshop','manage',$start,$categories_id,1,$sort);
echo $cs_lang['name'];
echo cs_html_roco(2,'headb');
echo cs_sort('lanshop','manage',$start,$categories_id,3,$sort);
echo $cs_lang['price'];
echo cs_html_roco(3,'headb',0,2);
echo $cs_lang['options'];
echo cs_html_roco(0);

for($run=0; $run<$lanshop_loop; $run++) {

  echo cs_html_roco(1,'leftc');
  $lanshop_view = cs_secure($cs_lanshop[$run]['lanshop_articles_name']);
  echo cs_link($lanshop_view,'lanshop','view','id=' . $cs_lanshop[$run]['lanshop_articles_id']);
  echo cs_html_roco(2,'leftc');
  echo $cs_lanshop[$run]['lanshop_articles_price'] / 100 . ' ' . $cs_lang['cost'];
  echo cs_html_roco(3,'leftc');
  $img_edit = cs_icon('edit',16,$cs_lang['edit']);
  echo cs_link($img_edit,'lanshop','edit','id=' . $cs_lanshop[$run]['lanshop_articles_id'],0,$cs_lang['edit']);
  echo cs_html_roco(4,'leftc');
  $img_del = cs_icon('editdelete',16,$cs_lang['remove']);
  echo cs_link($img_del,'lanshop','remove','id=' . $cs_lanshop[$run]['lanshop_articles_id'],0,$cs_lang['remove']);
  echo cs_html_roco(0);
}

echo cs_html_table(0);

?>
