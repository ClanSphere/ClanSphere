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

if(isset($_POST['submit']) OR isset($_POST['preview']))
{
	$update = $_POST['update'];
	$cs_messages['autoresponder_text'] = $_POST['autoresponder_text'];
	$cs_messages['autoresponder_id'] = $_POST['autoresponder_id'];
	$cs_messages['autoresponder_subject'] = $_POST['autoresponder_subject'];
	$cs_messages['autoresponder_close'] = isset($_POST['autoresponder_close']) ? $_POST['autoresponder_close'] : 0;
	$cs_messages['users_id'] = $users_id;
	$cs_messages['autoresponder_time'] = $time;

  settype($cs_messages['autoresponder_id'], 'integer');
  settype($cs_messages['autoresponder_close'], 'integer');  
}
else 
{
  $cells = 'autoresponder_id,autoresponder_text,autoresponder_subject,autoresponder_close';
  $cs_messages = cs_sql_select(__FILE__,'autoresponder',$cells,"users_id = '" . $users_id . "'");
  $update = count($cs_messages);
}
if(!isset($_POST['submit']) AND !isset($_POST['preview'])) 
{
  echo $cs_lang['body_edit'];
}
elseif(isset($_POST['preview'])) 
{
  echo $cs_lang['preview'];
}
else 
{
  echo $cs_lang['changes_done'];
}

echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(isset($_POST['preview'])) 
{
		echo cs_html_table(1,'forum',1);
		echo cs_html_roco(1,'headb',0,3);
		echo $cs_lang['mod'] . ' - ' . cs_secure($cs_messages['autoresponder_subject']);
		echo cs_html_roco(0);
		echo cs_html_roco(1,'leftb');
		echo $cs_lang['subject'];
		echo cs_html_roco(2,'leftb');
		$autoresponder = $cs_lang['autoresponder'];
		echo cs_secure($autoresponder,1);
		echo cs_secure($cs_messages['autoresponder_subject']);
		echo cs_html_roco(0);
		
		echo cs_html_roco(1,'leftb');
		echo $cs_lang['date'];
		echo cs_html_roco(2,'leftb');
		echo cs_date('unix',$cs_messages['autoresponder_time'],1);
		echo cs_html_roco(0);
		
		echo cs_html_roco(1,'leftb');
		echo $cs_lang['to'];
		echo cs_html_roco(2,'leftb');
		echo cs_html_roco(0);
		
		echo cs_html_roco(1,'leftb');
		echo $cs_lang['options'];
		echo cs_html_roco(2,'leftb');
		
		echo cs_icon('back',16,$cs_lang['back']);
		echo cs_icon('mail_replay',16,$cs_lang['replay']);
		echo cs_icon('mail_delete',16,$cs_lang['remove']);
		echo cs_html_roco(0);
		echo cs_html_table(0);
		
		echo cs_html_table(1,'forum',1);
		echo cs_html_roco(1,'headb',0,3);
		echo $cs_lang['mod'] . ' - ' . $cs_lang['text'];
		echo cs_html_roco(0);
		echo cs_html_roco(1,'leftb');
		echo cs_secure($cs_messages['autoresponder_text'],1,1);
		echo cs_html_roco(0);
		echo cs_html_table(0);
		echo cs_html_br(1);
}

if(isset($_POST['preview']) OR !isset($_POST['submit'])) 
{
	echo cs_html_form (1,'messages_edit','messages','autoresponder');
	echo cs_html_table(1,'forum',1);
	
	echo cs_html_roco(1,'leftc');
	echo cs_icon('kedit') . $cs_lang['subject'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_html_input('autoresponder_subject',$cs_messages['autoresponder_subject'],'text',200,50);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('kate') . $cs_lang['text'];
	echo cs_html_br(2);
	echo cs_abcode_smileys('autoresponder_text');
	echo cs_html_roco(2,'leftb');
	echo cs_abcode_features('autoresponder_text');
	echo cs_html_textarea('autoresponder_text',$cs_messages['autoresponder_text'],'50','20');
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftc');
	echo cs_icon('configure') . $cs_lang['more'];
	echo cs_html_roco(2,'leftb');
	echo cs_html_vote('autoresponder_close','1','checkbox',$cs_messages['autoresponder_close']);
	echo $cs_lang['messages_autoresponder'];

	echo cs_html_roco(1,'leftc');
	echo cs_icon('ksysguard') . $cs_lang['options'];
	echo cs_html_roco(2,'leftb');	
	echo cs_html_vote('autoresponder_id',$cs_messages['autoresponder_id'],'hidden');
	echo cs_html_vote('update',$update,'hidden');
	echo cs_html_vote('submit',$cs_lang['edit'],'submit');
	echo cs_html_vote('preview',$cs_lang['preview'],'submit');
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