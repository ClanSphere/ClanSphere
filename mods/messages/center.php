<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');

$cs_messages_option = cs_sql_option(__FILE__,'messages');
$max_space = $cs_messages_option['max_space'];

$del_time = $cs_messages_option['del_time'];
$time = cs_time();
$del_time_new = 60 * 60 * 24 * $del_time;
$del_time_new = $time - $del_time_new;

$query = "DELETE FROM {pre}_messages WHERE messages_time <= '$del_time_new' AND (messages_archiv_sender = '0' AND messages_archiv_receiver = '0')";
cs_sql_query(__FILE__,$query);

$users_id = $account['users_id'];

$from = 'messages';
$select = 'users_id, users_id_to, messages_show_sender, messages_show_receiver, messages_view, messages_archiv_sender, messages_archiv_receiver';
$where = "users_id = '" . $users_id . "' OR users_id_to = '" . $users_id . "'";
$cs_messages = cs_sql_select(__FILE__,$from,$select,$where,'','0','0');
$messages_loop = count($cs_messages);
$inbox_count = 0;
$outbox_count = 0;
$archivbox_count = 0;
$new_mail = 0;
for ($run = 0; $run < $messages_loop; $run++)
{
	$show_sender = $cs_messages[$run]['messages_show_sender'];
	$show_receiver = $cs_messages[$run]['messages_show_receiver'];
	$archiv_sender = $cs_messages[$run]['messages_archiv_sender'];
	$archiv_receiver = $cs_messages[$run]['messages_archiv_receiver'];
	$messages_users_id = $cs_messages[$run]['users_id'];
	$messages_users_id_to = $cs_messages[$run]['users_id_to'];
	$messages_view = $cs_messages[$run]['messages_view'];

	if($show_receiver == '1' AND $messages_users_id_to == $users_id)
	{
		$inbox_count++;
	}
	if($show_sender == '1' AND $messages_users_id == $users_id)
	{
		$outbox_count++;
	}
	if($messages_view == '0' AND $messages_users_id_to == $users_id AND $show_receiver == '1')
	{
		$new_mail++;
	}
	if($archiv_sender == '1' AND $messages_users_id == $users_id OR $archiv_receiver == '1' AND $messages_users_id_to == $users_id)
	{
		$archivbox_count++;
	}

}
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,4);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_center'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
$new_message = cs_icon('mail_new') . $cs_lang['new_message'];
echo cs_link($new_message,'messages','create');
echo cs_html_roco(2,'leftb');
$inbox = cs_icon('inbox') . $cs_lang['inbox'] . $inbox_count;
echo cs_link($inbox,'messages','inbox');
echo cs_html_roco(3,'leftb');
$outbox = cs_icon('outbox') . $cs_lang['outbox'] . $outbox_count;
echo cs_link($outbox,'messages','outbox');
echo cs_html_roco(4,'leftb');
$img_archiv = cs_icon('queue') . $cs_lang['archivbox'] . $archivbox_count;
echo cs_link($img_archiv,'messages','archivbox');
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_getmsg();

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'leftc',0,2);
echo cs_icon('email');
if($new_mail == 1)
{
	$inbox = $new_mail . ' ' . $cs_lang['new_message'];
}
else
{
	$inbox = $new_mail . $cs_lang['new_messages'];
}
echo cs_link($inbox,'messages','inbox','page=new');

echo cs_html_roco(1,'leftc');
echo cs_icon('kedit');
$autoresponder = cs_secure($cs_lang['autoresponder'],1);
echo cs_link($autoresponder,'messages','autoresponder');
echo cs_html_roco(2,'rightb');
$where = "users_id = '" . $users_id . "'";
$cs_messages_options = cs_sql_select(__FILE__,'autoresponder','autoresponder_close,autoresponder_mail',$where);
$autoresponder_close = $cs_messages_options['autoresponder_close'];
$autoresponder_mail = $cs_messages_options['autoresponder_mail'];

if(empty($autoresponder_close))
{
	$autore_false = $cs_lang['autore_false'];
	echo cs_secure($autore_false,1);
}
else
{
	$autore_true = $cs_lang['autore_true'];
	echo cs_secure($autore_true,1);
}
echo cs_html_roco(0);

$buddys_count = cs_sql_count(__FILE__,'buddys',"users_id = '$users_id'");

echo cs_html_roco(1,'leftc');
echo cs_icon('mail_send');
$mail_message = $cs_lang['mail_message'];
echo cs_link($mail_message,'messages','mail');
echo cs_html_roco(2,'rightb');
if(empty($autoresponder_mail))
{
	$autore_false = $cs_lang['autore_false'];
	echo cs_secure($autore_false,1);
}
else
{
	$autore_true = $cs_lang['autore_true'];
	echo cs_secure($autore_true,1);
}
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('xchat');
$buddys = $cs_lang['buddys'];
echo cs_link($buddys,'buddys','center');
echo cs_html_roco(2,'rightb');
echo $buddys_count;
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('inbox');
echo $cs_lang['in_inbox'];
echo cs_html_roco(2,'rightb');
echo $inbox_count;
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('outbox');
echo $cs_lang['in_outbox'];
echo cs_html_roco(2,'rightb');
echo $outbox_count;
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('queue');
echo $cs_lang['in_archiv'];
echo cs_html_roco(2,'rightb');
echo $archivbox_count;
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('mail_delete');
echo $cs_lang['auto_del'];
echo cs_html_roco(2,'rightb');
echo $del_time . ' ';
echo $cs_lang['days'];
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('mail_generic');
echo $cs_lang['max_mails'];
echo cs_html_roco(2,'rightb');
echo $max_space;
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('nfs_unmount');
echo $cs_lang['space'];
echo cs_html_roco(2,'leftb');
$space = 0;
if(!empty($archivbox_count))
{
	$space = $archivbox_count / $max_space * 100;
	$space = round($space,1);
}
echo cs_html_div(1,'float:right;text-align:right;height:13px;width:35px;vertical-align:middle');
echo $space;
echo '%';
echo cs_html_div(0);
echo cs_html_div(1,'background-image:url(' . $cs_main['php_self']['dirname'] . 'symbols/messages/messages03.png); width:100px; height:13px;');
if($space <= 50)
{
	echo cs_html_div(1,'background-image:url(' . $cs_main['php_self']['dirname'] . 'symbols/messages/messages01.png); width:' . $space . 'px; text-align:right; padding-left:1px');
}
if($space > 50 AND $space < 95)
{
	echo cs_html_div(1,'background-image:url(' . $cs_main['php_self']['dirname'] . 'symbols/messages/messages01_orange.png); width:' . $space . 'px; text-align:right; padding-left:1px');
}
if($space >= 95)
{
	echo cs_html_div(1,'background-image:url(' . $cs_main['php_self']['dirname'] . 'symbols/messages/messages01_red.png); width:' . $space . 'px; text-align:right; padding-left:1px');
}
if(!empty($messages_loop))
{
	if($space <= 50)
	{
		echo cs_html_img('symbols/messages/messages02.png','13','2');
	}
	if($space > 50 AND $space < 95)
	{
		echo cs_html_img('symbols/messages/messages02_orange.png','13','2');
	}
	if($space >= 95)
	{
		echo cs_html_img('symbols/messages/messages02_red.png','13','2');
	}
}
echo cs_html_div(0);
echo cs_html_div(0);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);


?>
