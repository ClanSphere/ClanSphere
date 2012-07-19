<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');
require_once('mods/messages/functions.php');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'messages_time DESC';
$cs_sort[2] = 'messages_time ASC';
$cs_sort[3] = 'messages_subject DESC';
$cs_sort[4] = 'messages_subject ASC';
$cs_sort[5] = 'messages_view DESC';
$cs_sort[6] = 'messages_view ASC';
$cs_sort[7] = 'users_nick DESC';
$cs_sort[8] = 'users_nick ASC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$receiver_count = 0;
$sender_count = 0;
$cs_messages_option = cs_sql_option(__FILE__,'messages');
$max_space = $cs_messages_option['max_space'];
$time = cs_time();
$users_id = $account['users_id'];

$data = array();
$data['count']['inbox'] = cs_sql_count(__FILE__, 'messages', 'messages_show_receiver = 1 AND users_id_to = ' . $account['users_id'] );
$data['count']['outbox'] = cs_sql_count(__FILE__, 'messages', 'messages_show_sender = 1 AND users_id = ' . $account['users_id'] );
$archivcond1 = '(messages_archiv_sender = 1 AND users_id = ' . $account['users_id'] . ') OR ';
$data['count']['archivbox'] = cs_sql_count(__FILE__, 'messages', $archivcond1 . '(messages_archiv_receiver = 1 AND users_id_to = ' . $account['users_id'] . ')');
$data['var']['pages'] = cs_pages('messages','inbox',$data['count']['inbox'],$start,$users_id,$sort);
$data['var']['new_msgs'] = cs_sql_count(__FILE__,'messages','users_id_to = '.$users_id.' AND messages_show_receiver = 1 AND messages_view = 0');

$data['sort']['view']    = cs_sort('messages','archivbox',$start,'',5,$sort);
$data['sort']['subject'] = cs_sort('messages','archivbox',$start,'',3,$sort);
$data['sort']['sender']  = cs_sort('messages','archivbox',$start,'',7,$sort);
$data['sort']['date']    = cs_sort('messages','archivbox',$start,'',1,$sort);

$where = 'msg.users_id_to = ' . $users_id . ' AND msg.messages_archiv_receiver = 1';
if (!empty($_POST['messages_filter'])) {
  $messages_data = cs_time_array();
  $id = (int) $_POST['messages_filter'] - 1;
  $time = $messages_data[$id]['messages_time'];
  $where .= " AND messages_time >= '" . $time . "'";
}

$from = 'messages msg INNER JOIN {pre}_users usr ON msg.users_id = usr.users_id';
$select = 'msg.messages_id AS messages_id, msg.messages_subject AS messages_subject, msg.messages_time AS messages_time, ';
$select .= 'msg.messages_view AS messages_view, msg.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, ';
$select .= 'msg.messages_show_sender AS messages_show_sender,msg.messages_show_receiver AS messages_show_receviver, usr.users_delete AS users_delete';
$data['msgs_in'] = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$data['msgs_in'] = fetch_pm_period($data['msgs_in'], 'messages_time');
$count = fetch_pm_period_count($data['msgs_in']);
$messages_loop = count($data['msgs_in']);
$period = 0;

for ($i = 0; $i < $messages_loop; $i++) {
  
  $data['msgs_in'][$i]['icon'] = empty($data['msgs_in'][$i]['messages_view']) ? cs_icon('email',16,$cs_lang['new']) : cs_icon('mail_generic',16,$cs_lang['read']);
  if ($data['msgs_in'][$i]['messages_view'] == 2) $data['msgs_in'][$i]['icon'] = cs_icon('mail_replay',16,$cs_lang['answered']);
  $data['msgs_in'][$i]['messages_time'] = cs_date('unix', $data['msgs_in'][$i]['messages_time'],1);
  $data['msgs_in'][$i]['user_from'] = cs_user($data['msgs_in'][$i]['users_id'],$data['msgs_in'][$i]['users_nick'],$data['msgs_in'][$i]['users_active'],$data['msgs_in'][$i]['users_delete']);
  $data['msgs_in'][$i]['messages_subject'] = cs_secure($data['msgs_in'][$i]['messages_subject']);
  if ($data['msgs_in'][$i]['period'] === $period) {
    $data['msgs_in'][$i]['if']['new_period'] = false;
  } else {
    $data['msgs_in'][$i]['if']['new_period'] = true;
    $data['msgs_in'][$i]['period_name'] = $cs_lang[$data['msgs_in'][$i]['period']];
    $data['msgs_in'][$i]['period_count'] = $count[$data['msgs_in'][$i]['period']];
    $period = $data['msgs_in'][$i]['period'];
  }
}


$where = 'msg.users_id = ' . $users_id . ' AND msg.messages_archiv_sender = 1';
if (!empty($_POST['messages_filter'])) {
  $messages_data = cs_time_array();
  $id = (int) $_POST['messages_filter'] - 1;
  $time = $messages_data[$id]['messages_time'];
  $where .= " AND messages_time >= '" . $time . "'";
}

$from = 'messages msg INNER JOIN {pre}_users usr ON msg.users_id_to = usr.users_id';
$select = 'msg.messages_id AS messages_id, msg.messages_subject AS messages_subject, msg.messages_time AS messages_time, ';
$select .= 'msg.messages_view AS messages_view, msg.users_id_to AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, ';
$select .= 'msg.messages_show_sender AS messages_show_sender,msg.messages_show_receiver AS messages_show_receviver, usr.users_delete AS users_delete';
$data['msgs_out'] = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$data['msgs_out'] = fetch_pm_period($data['msgs_out'], 'messages_time');
$count = fetch_pm_period_count($data['msgs_out']);
$messages_loop = count($data['msgs_out']);
$period = 0;

for ($i = 0; $i < $messages_loop; $i++) {
  
  $data['msgs_out'][$i]['icon'] = empty($data['msgs_out'][$i]['messages_view']) ? cs_icon('email',16,$cs_lang['new']) : cs_icon('mail_generic',16,$cs_lang['read']);
  if ($data['msgs_out'][$i]['messages_view'] == 2) $data['msgs_out'][$i]['icon'] = cs_icon('mail_replay',16,$cs_lang['answered']);
  $data['msgs_out'][$i]['messages_time'] = cs_date('unix', $data['msgs_out'][$i]['messages_time'],1);
  $data['msgs_out'][$i]['user_to'] = cs_user($data['msgs_out'][$i]['users_id'],$data['msgs_out'][$i]['users_nick'],$data['msgs_out'][$i]['users_active'],$data['msgs_out'][$i]['users_delete']);
  $data['msgs_out'][$i]['messages_subject'] = cs_secure($data['msgs_out'][$i]['messages_subject']);
  if ($data['msgs_out'][$i]['period'] === $period) {
    $data['msgs_out'][$i]['if']['new_period'] = false;
  } else {
    $data['msgs_out'][$i]['if']['new_period'] = true;
    $data['msgs_out'][$i]['period_name'] = $cs_lang[$data['msgs_out'][$i]['period']];
    $data['msgs_out'][$i]['period_count'] = $count[$data['msgs_out'][$i]['period']];
    $period = $data['msgs_out'][$i]['period'];
  }
}

echo cs_subtemplate(__FILE__, $data, 'messages', 'archivbox');
