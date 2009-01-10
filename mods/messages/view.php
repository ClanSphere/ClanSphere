<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');

$message_id = empty($_REQUEST['where']) ? $_GET['id'] : $_REQUEST['where'];
settype($message_id,'integer');
$message_view = '1';
$users_id = $account['users_id'];

$from = 'messages msg INNER JOIN {pre}_users usr ON msg.users_id = usr.users_id ';
$from .= 'INNER JOIN {pre}_users usr2 ON msg.users_id_to = usr2.users_id';
$select = 'msg.messages_id AS messages_id, msg.messages_subject AS messages_subject, ';
$select .= 'msg.messages_time AS messages_time, msg.messages_view AS messages_view, ';
$select .= 'msg.messages_text AS messages_text, msg.users_id_to AS users_id_to, ';
$select .= 'msg.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr2.users_nick AS users_nick2';
$where = "msg.messages_id = '" . $message_id . "' AND (msg.users_id_to = '" . $users_id . "' OR msg.users_id = '" . $users_id . "')";
$cs_messages = cs_sql_select(__FILE__,$from,$select,$where);
$messages_loop = count($cs_messages);

if(!empty($cs_messages))
{
	$users_id_2 = $cs_messages['users_id_to'];
	if($users_id_2 == $users_id)
	{
		$messages_cells = array('messages_view');
		$messages_content = array($message_view);
		cs_sql_update(__FILE__,'messages',$messages_cells,$messages_content,$message_id);
	}

	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'headb',0,2);
	echo cs_link($cs_lang['mod'],'messages','center') . ' - ' . $cs_lang['text'];
	echo cs_html_roco(0);

/*	echo cs_html_roco(1,'leftb');
	echo $cs_lang['subject'];
	echo cs_html_roco(2,'leftb');
	echo cs_secure($cs_messages['messages_subject']);
	echo cs_html_roco(0);
*/
	echo cs_html_roco(1,'leftb');
	echo $cs_lang['from'];
	echo cs_html_roco(2,'leftb');
	$cs_messages_user = cs_secure($cs_messages['users_nick']);
	echo cs_user($cs_messages['users_id'],$cs_messages['users_nick'], $cs_messages['users_active']);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'leftb');
	echo $cs_lang['date'];
	echo cs_html_roco(2,'leftb');
	echo cs_date('unix',$cs_messages['messages_time'],1);
	echo cs_html_roco(0);

/*	echo cs_html_roco(1,'leftb');
	echo $cs_lang['to'];
	echo cs_html_roco(2,'leftb');
	$cs_messages_user2 = cs_secure($cs_messages['users_nick2']);
	echo cs_link($cs_messages_user2,'users','view','id=' . $cs_messages['users_id_to']);
	echo cs_html_roco(0);
*/
	echo cs_html_roco(1,'leftb');
	echo $cs_lang['options'];
	echo cs_html_roco(2,'leftb');
	$img_back = cs_icon('back',16,$cs_lang['back']);
	echo cs_html_link('javascript:history.back()',$img_back,0);
	if($users_id == $cs_messages['users_id_to'])
	{
		$img_rep = cs_icon('mail_replay',16,$cs_lang['replay']);
		echo cs_link($img_rep,'messages','create_rep','id=' . $message_id);
	}
	$img_del = cs_icon('mail_delete',16,$cs_lang['remove']);
	echo cs_link($img_del,'messages','remove','id=' . $message_id,0,$cs_lang['remove']);
	$img_archiv = cs_icon('ark',16,$cs_lang['archiv']);
	echo cs_link($img_archiv,'messages','archiv','id=' . $message_id);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'headb',0,2);
	echo cs_secure($cs_messages['messages_subject']);
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftb',0,2);
	echo cs_secure($cs_messages['messages_text'],1,1);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}
else
{
	echo cs_html_table(1,'forum',1);
	echo cs_html_roco(1,'headb',0,3);
	echo $cs_lang['mod'];
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftc');
	echo cs_icon('important',16,$cs_lang['remove']);
	echo $cs_lang['error'];
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftb');
	echo $cs_lang['error_empty'];
	echo cs_html_roco(0);
	echo cs_html_roco(1,'centerc');
	echo cs_link($cs_lang['back'],'messages','center');
	echo cs_html_roco(0);
	echo cs_html_table(0);
}
?>