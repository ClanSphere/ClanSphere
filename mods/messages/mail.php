<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');

$users_id = $account['users_id'];
$time = cs_time();

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['edit'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');

if(isset($_POST['submit']))
{
	$update = $_POST['update'];
	$cs_messages['autoresponder_id'] = $_POST['autoresponder_id'];
	$cs_messages['autoresponder_mail'] = isset($_POST['autoresponder_mail']) ? $_POST['autoresponder_mail'] : 0;
	$cs_messages['users_id'] = $users_id;
}
else 
{
  $cells = 'autoresponder_id,autoresponder_mail';
  $cs_messages = cs_sql_select(__FILE__,'autoresponder',$cells,"users_id = '" . $users_id . "'");
  $update = count($cs_messages);
}
if(!isset($_POST['submit'])) 
{
  echo $cs_lang['body_edit_email'];
}
else 
{
  echo $cs_lang['changes_done'];
}

echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!isset($_POST['submit'])) 
{
	echo cs_html_form (1,'messages_edit','messages','mail');
	echo cs_html_table(1,'forum',1);
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('configure') . $cs_lang['more'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('autoresponder_mail','1','checkbox',$cs_messages['autoresponder_mail']);
	echo $cs_lang['autoresponder_mail'];

	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard') . $cs_lang['options'];
	echo cs_html_roco(2,'leftb');	
	echo cs_html_vote('autoresponder_id',$cs_messages['autoresponder_id'],'hidden');
	echo cs_html_vote('update',$update,'hidden');
	echo cs_html_vote('submit',$cs_lang['edit'],'submit');
	echo cs_html_vote('reset',$cs_lang['reset'],'reset');
	echo cs_html_roco(0);
	echo cs_html_table(0);
	echo cs_html_form(0);
}
else 
{
	if(empty($update))
	{
		$messages_cells = array_keys($cs_messages);
		$messages_save = array_values($cs_messages);
		cs_sql_insert(__FILE__,'autoresponder',$messages_cells,$messages_save);

		cs_redirect('','messages','center');
	}
	else
	{
		$messages_cells = array_keys($cs_messages);
		$messages_save = array_values($cs_messages);
		cs_sql_update(__FILE__,'autoresponder',$messages_cells,$messages_save,$cs_messages['autoresponder_id']);

		cs_redirect('','messages','center');
	}
}
?>