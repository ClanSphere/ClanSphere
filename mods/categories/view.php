<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('categories');

$cs_categories_id = $_GET['id'];
settype($cs_categories_id,'integer');
$cs_categories = cs_sql_select(__FILE__,'categories','*',"categories_id = '" . $cs_categories_id . "'");

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_view'];
echo cs_html_roco(0);

echo cs_html_roco(1,'leftb');
echo $cs_lang['body_view'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'leftc');
echo cs_icon('folder_yellow') . $cs_lang['name'];
echo cs_html_roco(2,'leftb');
echo cs_secure($cs_categories['categories_name']);
echo cs_html_roco(0);
  
echo cs_html_roco(1,'leftc');
echo cs_icon('kcmdf') . $cs_lang['modul'];
echo cs_html_roco(2,'leftb');
$cat_mod = empty($_POST['cat_mod']) ? $cs_categories['categories_mod'] : $_POST['cat_mod'];
$modules = cs_checkdirs('mods');
foreach($modules as $mods) {
	if($mods['dir'] == $cat_mod) {
 		echo $mods['name'];
	}
}
echo cs_html_vote('cat_mod',$cat_mod,'hidden');
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('gohome') . $cs_lang['url'];
echo cs_html_roco(2,'leftb',0,2);
$cs_cat_url = cs_secure($cs_categories['categories_url']);
echo cs_html_link('http://' . $cs_cat_url,$cs_cat_url);
echo cs_html_roco(0);
	
echo cs_html_roco(1,'leftc');
echo cs_icon('kate') . $cs_lang['text'];
echo cs_html_roco(2,'leftb');
echo cs_secure($cs_categories['categories_text'],1,1);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('images') . $cs_lang['picture'];
echo cs_html_roco(2,'leftb');
if(empty($cs_categories['categories_picture'])) {
  echo $cs_lang['nopic'];
}
else {
	$place = 'uploads/categories/' . $cs_categories['categories_picture'];
  $size = getimagesize($cs_main['def_path'] . '/' . $place);
  echo cs_html_img($place,$size[1],$size[0]);
}
echo cs_html_roco(0);
echo cs_html_table(0);

?>
