<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');

$cs_messages = cs_sql_option(__FILE__,'messages');
$messages_form = 1;
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['options'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_opt'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);
echo cs_getmsg();
if(isset($_POST['submit'])) 
{	
	$messages_form = 0;
	$opt_where = 'options_mod=\'messages\' AND options_name=';
	$def_cell = array('options_value');
	$def_cont = array($_POST['del_time']);
	cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'del_time\'');
	$def_cont = array($_POST['max_space']);
	cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'max_space\'');

	cs_redirect($cs_lang['changes_done'],'messages','options');
}

if(!empty($messages_form)) 
{	
	echo cs_html_form(1,'messages_edit','messages','options');
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('insert_table_row');
	echo $cs_lang['del_time'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('del_time',$cs_messages['del_time'],'text',3,4);
	echo cs_html_roco(0);
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('insert_table_row');
	echo $cs_lang['max_space'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('max_space',$cs_messages['max_space'],'text',4,4);
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