<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');
$data = array();

$data['option'] = cs_sql_option(__FILE__,'messages');

$time = cs_time();
$del_time_new = 60 * 60 * 24 * $data['option']['del_time'];
$del_time_new = $time - $del_time_new;

$query = "DELETE FROM {pre}_messages WHERE messages_time <= '$del_time_new' AND (messages_archiv_sender = '0' AND messages_archiv_receiver = '0')";
cs_sql_query(__FILE__,$query);

$users_id = $account['users_id'];

$from = 'messages';
$select = 'users_id, users_id_to, messages_show_sender, messages_show_receiver, messages_view, messages_archiv_sender, messages_archiv_receiver';
$where = "users_id = '" . $users_id . "' OR users_id_to = '" . $users_id . "'";
$cs_messages = cs_sql_select(__FILE__, 'messages', $select, $where, 0, 0, 0);
$messages_loop = count($cs_messages);

$data['count']['inbox'] = 0;
$data['count']['outbox'] = 0;
$data['count']['archivbox'] = 0;
$data['count']['new_messages'] = 0;

for ($run = 0; $run < $messages_loop; $run++) {

  if(!empty($cs_messages[$run]['messages_show_receiver']) AND $cs_messages[$run]['users_id_to'] == $users_id)
    $data['count']['inbox']++;
  if(!empty($cs_messages[$run]['messages_show_sender']) AND $cs_messages[$run]['users_id'] == $users_id)
    $data['count']['outbox']++;
  if(empty($cs_messages[$run]['messages_view']) AND $cs_messages[$run]['users_id_to'] == $users_id AND !empty($cs_messages[$run]['messages_show_receiver']))
    $data['count']['new_messages']++;
  if(!empty($cs_messages[$run]['messages_archiv_sender']) AND $cs_messages[$run]['users_id'] == $users_id
    OR !empty($cs_messages[$run]['messages_archiv_receiver']) AND $cs_messages[$run]['users_id_to'] == $users_id)
    $data['count']['archivbox']++;

}

$data['head']['message'] = cs_getmsg();

if ($data['count']['new_messages'] == 1) $data['lang']['new_messages'] = $cs_lang['new_message'];

$cs_messages_options = cs_sql_select(__FILE__,'autoresponder','autoresponder_close,autoresponder_mail','users_id = "' . $users_id . '"');

$data['var']['autoresponder'] = empty($cs_messages_options['autoresponder_close']) ? $cs_lang['autore_false'] : $cs_lang['autore_true'];
$data['var']['mailmessage'] = empty($cs_messages_options['autoresponder_mail']) ? $cs_lang['autore_false'] : $cs_lang['autore_true'];

$data['if']['buddies'] = empty($account['access_buddys']) ? 0 : 1;
if(!empty($account['access_buddys']))
  $data['count']['buddys'] = cs_sql_count(__FILE__,'buddys','users_id = "' . $users_id . '"');

$data['var']['space_used'] = !empty($data['count']['archivbox']) ? round($data['count']['archivbox'] / $data['option']['max_space'] * 100) : 0;

$data['var']['color'] = '';
if ($data['var']['space_used'] >= 50) $data['var']['color'] = '_orange';
if ($data['var']['space_used'] >= 90) $data['var']['color'] = '_red';

echo cs_subtemplate(__FILE__, $data, 'messages', 'center');