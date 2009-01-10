<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['create_dir'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');

if(empty($_POST['submit'])) {
	echo $cs_lang['folder_create'];
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_br(1);

	$dir = (empty($_GET['dir']) or $_GET['dir'] == '.') ? '' : $_GET['dir'];
	
	echo cs_html_form(1,'explorer_create_dir','explorer','create_dir');
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('folder_yellow') . $cs_lang['directory'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('data_folder',$dir,'text',60,40);
	echo cs_html_roco(0);
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('kate') . $cs_lang['dir_name'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('folder_name','','text',50,30);
	echo cs_html_roco(0);
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard') . $cs_lang['options'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('submit',$cs_lang['create'],'submit');
	echo cs_html_input('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	
	echo cs_html_table(0);
	echo cs_html_form(0);
} else {
	
	$dir = $_POST['data_folder'];
	
	if (substr($dir,-1,1) != '/') {
		$dir .= '/';
	}
  $dir = $dir == '/' ? '' : $dir;
	
	$dir_created = $dir . $_POST['folder_name'];
	
	if(@mkdir($dir_created, 0755)) {
		cs_redirect($cs_lang['success'],'explorer','roots','dir='.$dir);
	} else {
		cs_redirect($cs_lang['error'],'explorer','roots','dir='.$dir);
	}
	
	echo cs_html_roco(0);
	echo cs_html_table(0);
}

?>	