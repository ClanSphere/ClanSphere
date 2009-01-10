<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');
require_once('mods/messages/functions.php');

empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start'];
$cs_sort[1] = 'messages_time DESC';
$cs_sort[2] = 'messages_time ASC';
$cs_sort[3] = 'messages_subject DESC';
$cs_sort[4] = 'messages_subject ASC';
$cs_sort[5] = 'messages_view DESC';
$cs_sort[6] = 'messages_view ASC';
$cs_sort[7] = 'users_nick DESC';
$cs_sort[8] = 'users_nick ASC';
empty($_REQUEST['sort']) ? $sort = 1 : $sort = $_REQUEST['sort'];
$order = $cs_sort[$sort];

$receiver_count = 0;
$sender_count = 0;
$cs_messages_option = cs_sql_option(__FILE__,'messages');
$max_space = $cs_messages_option['max_space'];
$time = cs_time();
$users_id = $account['users_id'];
empty($_POST['messages_id']) ? $messages_id = 0 : $messages_id = $_POST['messages_id'];
echo cs_box_head('archivbox',$messages_id,$start,$sort);
$messages_data = cs_time_array();
if(!empty($_POST['messages_id']))
{
	$messages_id = $_POST['messages_id'];
	$run = cs_sql_escape($messages_id) - 1;
	$messages_time = $messages_data[$run]['messages_time'];
	$where = "msg.users_id_to = '" . $users_id . "' AND msg.messages_archiv_receiver ='1' AND messages_time >= '" . $messages_time . "' OR ";
	$where .= "msg.users_id = '" . $users_id . "' AND msg.messages_archiv_sender ='1' AND messages_time >= '" . $messages_time . "'";
}
else
{
	$messages_time = '';
	$messages_id = '';
	$where = "msg.users_id_to = '" . $users_id . "' AND msg.messages_archiv_receiver ='1' OR msg.users_id = '" . $users_id . "' AND msg.messages_archiv_sender ='1'";
}
echo cs_html_br(1);

$from = 'messages msg INNER JOIN {pre}_users usr ON msg.users_id = usr.users_id';
$select = 'msg.messages_id AS messages_id, msg.messages_subject AS messages_subject, msg.messages_time AS messages_time, ';
$select .= 'msg.messages_view AS messages_view, msg.users_id_to AS users_id_to, msg.users_id AS users_id, usr.users_nick AS users_nick, ';
$select .= 'msg.messages_show_sender AS messages_show_sender, msg.messages_show_receiver AS messages_show_receviver, ';
$select .= 'msg.messages_archiv_sender AS messages_archiv_sender, msg.messages_archiv_receiver AS messages_archiv_receiver, usr.users_active AS users_active';
$cs_messages_inbox = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$messages_inbox_loop = count($cs_messages_inbox);

$from = 'messages msg INNER JOIN {pre}_users usr ON msg.users_id_to = usr.users_id';
$cs_messages_outbox = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$messages_outbox_loop = count($cs_messages_outbox);

for($run=0; $run<$messages_inbox_loop; $run++)
{
	$messages_archiv = $cs_messages_inbox[$run]['messages_archiv_receiver'];
	if($messages_archiv == '1')
	{
		$receiver_count++;
	}
}
if($receiver_count > 0)
{
	echo cs_archivbox_head($start,$sort);
}

for($run=0; $run<$messages_inbox_loop; $run++)
{
	$messages_archiv = $cs_messages_inbox[$run]['messages_archiv_receiver'];
	if($messages_archiv == '1')
	{
		echo cs_box($cs_messages_inbox,$run,1);
	}
}
if($receiver_count > 0)
{
	echo cs_html_table(0);
	echo cs_html_br(1);
}
for($run=0; $run<$messages_outbox_loop; $run++)
{
	$messages_archiv = $cs_messages_outbox[$run]['messages_archiv_sender'];
	if($messages_archiv == '1')
	{
		$sender_count++;
	}
}
if($sender_count > 0)
{
	echo cs_outbox_head($start,$sort);
}
for($run=0; $run<$messages_outbox_loop; $run++)
{
	$messages_archiv = $cs_messages_outbox[$run]['messages_archiv_sender'];
	if($messages_archiv == '1')
	{
		echo cs_box($cs_messages_outbox,$run,1);
	}
}

if($sender_count > 0)
{
	echo cs_html_table(0);
}
?>