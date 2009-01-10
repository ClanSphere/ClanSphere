<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('categories');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$where = empty($_REQUEST['where']) ? 'news' : $_REQUEST['where'];
$cs_sort[1] = 'categories_name DESC';
$cs_sort[2] = 'categories_name ASC';
$cs_sort[3] = 'categories_url DESC';
$cs_sort[4] = 'categories_url ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$mdp = "categories_mod = '" . cs_sql_escape($where) . "'";
$categories_count = cs_sql_count(__FILE__,'categories',$mdp);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_list'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo sprintf($cs_lang['count'], $categories_count);
echo cs_html_roco(2,'rightb');
echo cs_pages('categories','manage',$categories_count,$start,$where,$sort);
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb',0,2);
echo $cs_lang['modul'];
echo cs_html_form(1,'categories_list','categories','list');
echo cs_html_select(1,'where');
$modules = cs_checkdirs('mods');
foreach($modules as $mods) {
	if(!empty($mods['categories'])) {
  	$mods['dir'] == $where ? $sel = 1 : $sel = 0;
  	echo cs_html_option($mods['name'],$mods['dir'],$sel);
	}
}
echo cs_html_select(0);
echo cs_html_vote('submit',$cs_lang['show'],'submit');
echo cs_html_form(0);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$select = 'categories_id, categories_name, categories_url';
$cs_categories = cs_sql_select(__FILE__,'categories',$select,$mdp,$order,$start,$account['users_limit']);
$categories_loop = count($cs_categories);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo cs_sort('categories','list',$start,$where,1,$sort);
echo $cs_lang['name'];
echo cs_html_roco(2,'headb');
echo cs_sort('categories','list',$start,$where,3,$sort);
echo $cs_lang['url'];
echo cs_html_roco(0);

for($run=0; $run<$categories_loop; $run++) {

	echo cs_html_roco(1,'leftc');
  $cs_cat_name = cs_secure($cs_categories[$run]['categories_name']);
  echo cs_link($cs_cat_name,'categories','view','id=' . $cs_categories[$run]['categories_id']);

	echo cs_html_roco(2,'leftc');
	$cs_cat_url = cs_secure($cs_categories[$run]['categories_url']);
	echo cs_html_link('http://' . $cs_cat_url,$cs_cat_url);
	echo cs_html_roco(0);
}
echo cs_html_table(0);

?>
