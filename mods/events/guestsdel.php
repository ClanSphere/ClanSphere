<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$events_form = 1;
$eventguests_id = $_REQUEST['id'];
settype($eventguests_id, 'integer');

$cols = 'events_id, users_id, eventguests_status';
$cs_events = cs_sql_select(__FILE__, 'eventguests', $cols, "eventguests_id = '" . $eventguests_id . "'");

$events_id = empty($cs_events['events_id']) ? 0 : $cs_events['events_id'];
$users_id = empty($cs_events['users_id']) ? 0 : $cs_events['users_id'];

if(isset($_GET['agree'])) {

  $events_form = 0;

  cs_sql_delete(__FILE__, 'eventguests', $eventguests_id);

  # email notification for eventguest interactions
  if(!empty($users_id)) {
    $columns = 'events_time, events_name, events_id';
    $where = "events_id = '" . $events_id . "'";
    $event = cs_sql_select(__FILE__, 'events', $columns, $where);
    $user  = cs_sql_select(__FILE__, 'users', 'users_id, users_email', "users_id = '" . $users_id . "'");

    $subject  = $cs_lang['evg_mail_subject'] . ': ' . $event['events_name'];
    $message  = $cs_lang['evg_mail_reasons'] . $cs_lang['evg_mail_deletes'] . "\n\n";
    $message .= $cs_lang['event'] . ': ' . $event['events_name'] . "\n";
    $message .= $cs_lang['date'] . ': ' . cs_date('unix',$event['events_time'],1) . "\n";
    $message .= $cs_lang['status'] . ': ' . $cs_lang['status_' . $cs_events['eventguests_status']] . "\n\n";
    $message .= $cs_lang['evg_mail_weblink'] . "\n";
    $message .= $cs_main['php_self']['website'] . cs_url('events', 'view', 'id=' . $event['events_id']);
    cs_mail($user['users_email'], $subject, $message);
  }
  
  cs_redirect($cs_lang['del_true'], 'events', 'guests', 'id=' . $events_id);
}

if(isset($_GET['cancel']))
  cs_redirect($cs_lang['del_false'], 'events', 'guests', 'id=' . $events_id);

if(!empty($events_form)) {
  $data['lang']['body'] = sprintf($cs_lang['del_rly'],$eventguests_id);
  
  $data['lang']['content'] = cs_link($cs_lang['confirm'],'events','guestsdel','id=' . $eventguests_id . '&amp;agree');
  $data['lang']['content'] .= ' - ';
  $data['lang']['content'] .= cs_link($cs_lang['cancel'],'events','guestsdel','id=' . $eventguests_id . '&amp;cancel');
  
  echo cs_subtemplate(__FILE__,$data,'events','remove');
}