<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');
$data = array();
$messages_id = (int) $_GET['id'];

$cells = 'users_id, users_id_to, messages_subject, messages_time, messages_view, messages_text';
$where = 'messages_id = "' . $messages_id . '" AND (users_id = "' . $account['users_id'] . '" OR users_id_to = "' . $account['users_id'] . '")';
$data['msg'] = cs_sql_select(__FILE__, 'messages', $cells, $where);

$sender = $data['msg']['users_id_to'] != $account['users_id'] ? 1 : 0;

if (empty($sender)) {
	if (empty($data['msg']['messages_view']))
	  cs_sql_update(__FILE__, 'messages', array('messages_view'), array('1'), $messages_id);
	$user_data = cs_sql_select(__FILE__, 'users', 'users_nick, users_active, users_delete', 'users_id = "' . $data['msg']['users_id'] . '"');
	$data['msg']['from'] = cs_user($data['msg']['users_id'], $user_data['users_nick'], $user_data['users_active'], $user_data['users_delete']);
} else {
	$user_data = cs_sql_select(__FILE__, 'users', 'users_nick, users_active, users_delete', 'users_id = "' . $data['msg']['users_id_to'] . '"');
  $data['msg']['from'] = cs_user($data['msg']['users_id_to'], $user_data['users_nick'], $user_data['users_active'], $user_data['users_delete']);
}
$data['msg']['messages_time'] = cs_date('unix', $data['msg']['messages_time'],1);
$data['msg']['messages_id'] = $messages_id;
$data['msg']['messages_subject'] = cs_secure($data['msg']['messages_subject']);
$data['msg']['messages_text'] = cs_secure($data['msg']['messages_text'],1,1);

echo cs_subtemplate(__FILE__, $data, 'messages', 'view');

?>