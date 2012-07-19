<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');
require_once('mods/messages/functions.php');

$page = empty($_REQUEST['page']) ? 0 : $_REQUEST['page'];
$start = empty($_REQUEST['start']) ? 0 : (int) $_REQUEST['start'];

$cs_sort[1] = 'messages_time DESC';
$cs_sort[2] = 'messages_time ASC';
$cs_sort[3] = 'messages_subject DESC';
$cs_sort[4] = 'messages_subject ASC';
$cs_sort[5] = 'messages_view DESC';
$cs_sort[6] = 'messages_view ASC';
$cs_sort[7] = 'users_nick DESC';
$cs_sort[8] = 'users_nick ASC';

$sort = empty($_REQUEST['sort']) ? 1 : (int) $_REQUEST['sort'];
$order = $cs_sort[$sort];

$option = cs_sql_option(__FILE__,'messages');
$users_id = $account['users_id'];

$data = array();
$data['count']['inbox'] = cs_sql_count(__FILE__, 'messages', 'messages_show_receiver = 1 AND users_id_to = ' . $account['users_id']);
$data['count']['outbox'] = cs_sql_count(__FILE__, 'messages', 'messages_show_sender = 1 AND users_id = ' . $account['users_id'] );
$archivcond1 = '(messages_archiv_sender = 1 AND users_id = ' . $account['users_id'] . ') OR ';
$data['count']['archivbox'] = cs_sql_count(__FILE__, 'messages', $archivcond1 . '(messages_archiv_receiver = 1 AND users_id_to = ' . $account['users_id'] . ')');
$data['var']['pages'] = cs_pages('messages','inbox',$data['count']['inbox'],$start,$users_id,$sort);
$data['var']['new_msgs'] = cs_sql_count(__FILE__,'messages','users_id_to = '.$users_id.' AND messages_show_receiver = 1 AND messages_view = 0');

$data['sort']['view']    = cs_sort('messages','inbox',$start,'',5,$sort);
$data['sort']['subject'] = cs_sort('messages','inbox',$start,'',3,$sort);
$data['sort']['sender']  = cs_sort('messages','inbox',$start,'',7,$sort);
$data['sort']['date']    = cs_sort('messages','inbox',$start,'',1,$sort);

$where = "msg.users_id_to = '" . $users_id . "' AND msg.messages_show_receiver ='1'";
if ($page === 'new') $where .= ' AND msg.messages_view = "0"';
if (!empty($_POST['messages_filter'])) {
  $messages_data = cs_time_array();
  $id = (int) $_POST['messages_filter'] - 1;
  $time = $messages_data[$id]['messages_time'];
  $where .= " AND messages_time >= '" . $time . "'";
}

$from = 'messages msg INNER JOIN {pre}_users usr ON msg.users_id = usr.users_id';
$select = 'msg.messages_id AS messages_id, msg.messages_subject AS messages_subject, msg.messages_time AS messages_time, ';
$select .= 'msg.messages_view AS messages_view, msg.users_id_to AS users_id_to, msg.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, ';
$select .= 'msg.messages_show_sender AS messages_show_sender,msg.messages_show_receiver AS messages_show_receviver, usr.users_delete AS users_delete';
$data['msgs'] = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$data['msgs'] = fetch_pm_period($data['msgs'], 'messages_time');
$count = fetch_pm_period_count($data['msgs']);
$messages_loop = count($data['msgs']);
$period = 0;

for ($i = 0; $i < $messages_loop; $i++) {
  
  $data['msgs'][$i]['icon'] = empty($data['msgs'][$i]['messages_view']) ? cs_icon('email',16,$cs_lang['new']) : cs_icon('mail_generic',16,$cs_lang['read']);
  if ($data['msgs'][$i]['messages_view'] == 2) $data['msgs'][$i]['icon'] = cs_icon('mail_replay',16,$cs_lang['answered']);
  $data['msgs'][$i]['messages_time'] = cs_date('unix', $data['msgs'][$i]['messages_time'],1);
  $data['msgs'][$i]['user_from'] = cs_user($data['msgs'][$i]['users_id'],$data['msgs'][$i]['users_nick'],$data['msgs'][$i]['users_active'],$data['msgs'][$i]['users_delete']);
  $data['msgs'][$i]['messages_subject'] = cs_secure($data['msgs'][$i]['messages_subject']);
  if ($data['msgs'][$i]['period'] === $period) {
    $data['msgs'][$i]['if']['new_period'] = false;
  } else {
    $data['msgs'][$i]['if']['new_period'] = true;
    $data['msgs'][$i]['period_name'] = $cs_lang[$data['msgs'][$i]['period']];
    $data['msgs'][$i]['period_count'] = $count[$data['msgs'][$i]['period']];
    $period = $data['msgs'][$i]['period'];
  }
}

echo cs_subtemplate(__FILE__, $data, 'messages', 'inbox');
