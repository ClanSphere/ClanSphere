<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');

$data = array();

$messages_id = (int) $_GET['id'];

$cells = 'users_id, users_id_to, messages_subject, messages_time, messages_view, messages_text, messages_archiv_receiver, messages_archiv_sender';
$where = 'messages_id = "' . $messages_id . '" AND (users_id = "' . $account['users_id'] . '" OR users_id_to = "' . $account['users_id'] . '")';
$data['msg'] = cs_sql_select(__FILE__, 'messages', $cells, $where);

$sender = $data['msg']['users_id_to'] != $account['users_id'] ? 1 : 0;

if (empty($sender)) {
    if (empty($data['msg']['messages_view']))
        cs_sql_update(__FILE__, 'messages', array('messages_view'), array('1'), $messages_id);
    $user_data = cs_sql_select(__FILE__, 'users', 'users_nick, users_active, users_delete', 'users_id = "' . $data['msg']['users_id'] . '"');
    $data['msg']['from'] = cs_user($data['msg']['users_id'], $user_data['users_nick'], $user_data['users_active'], $user_data['users_delete']);
    $data['if']['reply'] = true;
    $data['if']['forward'] = true;
    $data['if']['archiv'] = empty($data['msg']['messages_archiv_receiver']) ? 1 : 0;
}
else {
    $user_data = cs_sql_select(__FILE__, 'users', 'users_nick, users_active, users_delete', 'users_id = "' . $data['msg']['users_id_to'] . '"');
    $data['msg']['from'] = cs_user($data['msg']['users_id_to'], $user_data['users_nick'], $user_data['users_active'], $user_data['users_delete']);
    $data['lang']['from'] = $cs_lang['to'];
    $data['if']['reply'] = false;
    $data['if']['forward'] = false;
    $data['if']['archiv'] = empty($data['msg']['messages_archiv_sender']) ? 1 : 0; 
}

if(isset($data['msg']['messages_time'])) {
  $data['msg']['messages_time'] = cs_date('unix', $data['msg']['messages_time'],1);
  $data['msg']['messages_id'] = $messages_id;
  $data['msg']['messages_subject'] = cs_secure($data['msg']['messages_subject']);
  $data['msg']['messages_text'] = cs_secure($data['msg']['messages_text'],1,1);

  echo cs_subtemplate(__FILE__, $data, 'messages', 'view');
}