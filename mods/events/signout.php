<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$eventguests_id = $_REQUEST['id'];
settype($eventguests_id,'integer');

$error = 0;
$errormsg = '';

$where = "eventguests_id = '" . $eventguests_id . "'";
$eventguests = cs_sql_select(__FILE__,'eventguests','*',$where);
$where2 = "events_id = '" . $eventguests['events_id'] . "'";
$events = cs_sql_select(__FILE__,'events','events_time, events_name, events_id',$where2);

if($eventguests['users_id'] != $account['users_id']) {
  $error++;
  $errormsg .= $cs_lang['userid_diff'] . cs_html_br(1);
}

if($events['events_time'] < cs_time()) {
  $error++;
  $errormsg .= $cs_lang['event_done'] . cs_html_br(1);
}

if($eventguests['eventguests_status'] > 3) {
  $error++;
  $errormsg .= $cs_lang['event_paid'] . cs_html_br(1);
}

if(isset($_GET['agree']) AND empty($error)) {
  cs_sql_delete(__FILE__,'eventguests',$eventguests_id);

  # email notification for eventguest interactions
  if(!empty($account['users_id'])) {
    $subject  = $cs_lang['evg_mail_subject'] . ': ' . $events['events_name'];
    $message  = $cs_lang['evg_mail_reasons'] . $cs_lang['evg_mail_deletes'] . "\n\n";
    $message .= $cs_lang['event'] . ': ' . $events['events_name'] . "\n";
    $message .= $cs_lang['date'] . ': ' . cs_date('unix',$events['events_time'],1) . "\n";
    $message .= $cs_lang['status'] . ': ' . $cs_lang['status_' . $eventguests['eventguests_status']] . "\n\n";
    $message .= $cs_lang['evg_mail_weblink'] . "\n";
    $message .= $cs_main['php_self']['website'] . cs_url('events', 'view', 'id=' . $events['events_id']);
    cs_mail($account['users_email'], $subject, $message);
  }

  cs_redirect($cs_lang['signout_true'],'events','center');
}
elseif(isset($_GET['cancel']) OR !empty($error)) {
  cs_redirect(empty($error) ? $cs_lang['signout_false'] : $errormsg,'events','center');
}
else {
  $data['lang']['remove'] = $cs_lang['head_signout'];

  $data['lang']['body'] = $cs_lang['signout_confirm'];

  $data['lang']['content'] = cs_link($cs_lang['confirm'],'events','signout','id=' . $eventguests_id . '&amp;agree');
  $data['lang']['content'] .= ' - ';
  $data['lang']['content'] .= cs_link($cs_lang['cancel'],'events','signout','id=' . $eventguests_id . '&amp;cancel');

  echo cs_subtemplate(__FILE__,$data,'events','remove');
}