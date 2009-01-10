<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('replays');

$cs_replays = cs_sql_option(__FILE__,'replays');
$replays_form = 1;
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_options'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_options'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);
echo cs_getmsg();
if(isset($_POST['submit'])) 
{	
	$replays_form = 0;
  $filesize = (int) $_POST['file_size'] * 1024;
	$opt_where = 'options_mod=\'replays\' AND options_name=';
	$def_cell = array('options_value');  
	$def_cont = array($filesize);
	cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'file_size\'');
	$def_cont = array($_POST['file_type']);
	cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'file_type\'');
	
	cs_redirect($cs_lang['changes_done'],'replays','options');
}

if(!empty($replays_form)) 
{	
	echo cs_html_form (1,'replays_edit','replays','options');
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('fileshare');
	echo $cs_lang['max_size'];
	echo cs_html_roco(2,'leftb'); 
	$size = round($cs_replays['file_size'] / 1024);
	echo cs_html_input('file_size',$size,'text',20,6);
	echo $cs_lang['kbyte'];
	echo cs_html_roco(0);
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('fileshare');
	echo $cs_lang['filetypes'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('file_type',$cs_replays['file_type'],'text',80,50);
	echo cs_html_roco(0);
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard');
	echo $cs_lang['options'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('id',1,'hidden');
	echo cs_html_vote('submit',$cs_lang['edit'],'submit');
	echo cs_html_vote('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_form (0);
}

?>