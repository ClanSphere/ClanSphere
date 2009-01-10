<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('categories');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['options'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_options'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);
echo cs_getmsg();
$op_categories = cs_sql_option(__FILE__,'categories');

if(isset($_POST['submit'])) {
	require('mods/clansphere/func_options.php');
	$save = array();
	$save['max_width'] = (int) $_POST['max_width'];
	$save['max_height'] = (int) $_POST['max_height'];
	$save['max_size'] = (int) $_POST['max_size'];
	$save['def_mod'] = (int) $_POST['def_mod'];
	cs_optionsave('categories', $save);	
	cs_redirect($cs_lang['changes_done'],'categories','options');
}
else {
	echo cs_html_form (1,'categories_options','categories','options');
	echo cs_html_table(1,'forum',1);
  	echo cs_html_roco(1,'leftc');
  	echo cs_icon('resizecol') . $cs_lang['max_width'];
  	echo cs_html_roco(2,'leftb');
  	echo cs_html_input('max_width',$op_categories['max_width'],'text',4,4) . ' ' . $cs_lang['pixel'];
  	echo cs_html_roco(0);
	
  	echo cs_html_roco(1,'leftc');
  	echo cs_icon('resizerow') . $cs_lang['max_height'];
  	echo cs_html_roco(2,'leftb');
  	echo cs_html_input('max_height',$op_categories['max_height'],'text',4,4) . ' ' . $cs_lang['pixel'];
  	echo cs_html_roco(0);

  	echo cs_html_roco(1,'leftc');
  	echo cs_icon('fileshare') . $cs_lang['max_size'];
  	echo cs_html_roco(2,'leftb');
  	echo cs_html_input('max_size',$op_categories['max_size'],'text',20,8) . ' ' . $cs_lang['bytes'];
  	echo cs_html_roco(0);

  	echo cs_html_roco(1,'leftc');
  	echo cs_icon('kcmdf') . $cs_lang['def_mod'];
  	echo cs_html_roco(2,'leftb');
  	echo cs_html_select(1,'def_mod');
	$modules = cs_checkdirs('mods');
	foreach($modules as $mods) {
		if(!empty($mods['categories'])) {
  			$mods['dir'] == $op_categories['def_mod'] ? $sel = 1 : $sel = 0;
  			echo cs_html_option($mods['name'],$mods['dir'],$sel);
		}
	}
  	echo cs_html_select(0);
  	echo cs_html_roco(0);
	
  	echo cs_html_roco(1,'leftc');
  	echo cs_icon('ksysguard') . $cs_lang['options'];
  	echo cs_html_roco(2,'leftb');
  	echo cs_html_vote('submit',$cs_lang['edit'],'submit');
  	echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  	echo cs_html_roco(0);
  	echo cs_html_table(0);
  	echo cs_html_form (0);
}
?>