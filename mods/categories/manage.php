<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('categories');

include_once('mods/categories/functions.php');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$where = empty($_REQUEST['where']) ? 'news' : $_REQUEST['where'];
$cs_sort[1] = 'categories_name DESC';
$cs_sort[2] = 'categories_name ASC';
$cs_sort[3] = 'categories_url DESC';
$cs_sort[4] = 'categories_url ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = 'categories_subid, ' . $cs_sort[$sort];

$mdp = "categories_mod = '" . cs_sql_escape($where) . "'";
$categories_count = cs_sql_count(__FILE__,'categories',$mdp);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['manage'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_icon('editpaste') . cs_link($cs_lang['new_category'],'categories','create','where=' . $where);
echo cs_html_roco(2,'leftb');
echo cs_icon('contents') . $cs_lang['total'] . ': ' . $categories_count;
echo cs_html_roco(2,'rightb');
echo cs_pages('categories','manage',$categories_count,$start,$where,$sort);
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb',0,3);
echo $cs_lang['modul'];
echo cs_html_form(1,'categories_manage','categories','manage');
echo cs_html_select(1,'where');
$modules = cs_checkdirs('mods');
foreach($modules as $mods) {
  $check_axx = empty($account['access_' . $mods['dir'] . '']) ? 0 : $account['access_' . $mods['dir'] . ''];
  if(!empty($mods['categories']) AND $check_axx > 2) {
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

echo cs_getmsg();

$select = 'categories_id, categories_name, categories_url, categories_subid';
$cs_categories = cs_sql_select(__FILE__,'categories',$select,$mdp,$order,$start,$account['users_limit']);
$cs_categories = cs_catsort($cs_categories);
$categories_loop = !empty($cs_categories) ? count($cs_categories) : '';

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo cs_sort('categories','manage',$start,$where,1,$sort);
echo $cs_lang['name'];
echo cs_html_roco(2,'headb');
echo cs_sort('categories','manage',$start,$where,3,$sort);
echo $cs_lang['url'];
echo cs_html_roco(4,'headb',0,2);
echo $cs_lang['options'];
echo cs_html_roco(0);

for($run=0; $run<$categories_loop; $run++) {
  
  $blank = '';
  if (!empty($cs_categories[$run]['layer'])) {
    for ($i = 0; $i < $cs_categories[$run]['layer']; $i++)
      $blank .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    $blank .= cs_icon('add_sub_task');
  }
	echo cs_html_roco(1,'leftc');
	echo $blank;
  $cs_cat_name = cs_secure($cs_categories[$run]['categories_name']);
  echo cs_link($cs_cat_name,'categories','view','id=' . $cs_categories[$run]['categories_id']);

	echo cs_html_roco(2,'leftc');
	$cs_cat_url = cs_secure($cs_categories[$run]['categories_url']);
	echo cs_html_link('http://' . $cs_cat_url,$cs_cat_url);
	echo cs_html_roco(3,'leftc');
  $img_edit = cs_icon('edit',16,$cs_lang['edit']);
	echo cs_link($img_edit,'categories','edit','id=' . $cs_categories[$run]['categories_id'],0,$cs_lang['edit']);
  echo cs_html_roco(4,'leftc');
	$img_del = cs_icon('editdelete',16,$cs_lang['remove']);
  echo cs_link($img_del,'categories','remove','id=' . $cs_categories[$run]['categories_id'],0,$cs_lang['remove']);
	echo cs_html_roco(0);
}
echo cs_html_table(0);

?>
