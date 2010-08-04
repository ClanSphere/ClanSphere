<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$events_options = cs_sql_option(__FILE__, 'events');

$users_nick = empty($_REQUEST['users_nick']) ? '' : $_REQUEST['users_nick'];

$data = array();
$data['head']['info'] = $cs_lang['new_guest_info'];

$select = 'events_id, events_name, events_time, events_needage, events_guestsmax';
$where = 'events_cancel = 0 AND events_guestsmax > 0 AND events_time > ' . (int) cs_time();
$data['events'] = cs_sql_select(__FILE__, 'events', $select, $where, 'events_time ASC', 0, 50);
$count_events = count($data['events']);

$checked = empty($_POST['events_checked']) ? array() : $_POST['events_checked'];
$checked = empty($_GET['events_id']) ? $checked : array((int) $_GET['events_id'] => 1);
$status = empty($_POST['events_status']) ? array() : $_POST['events_status'];
$status_empty = array('events_status_0' => '', 'events_status_3' => '', 'events_status_4' => '', 'events_status_5' => '');

for ($run = 0; $run < $count_events; $run++) {

  $data['events'][$run]['time'] = cs_date('unix',$data['events'][$run]['events_time'],1);
  $data['events'][$run]['events_name'] = cs_secure($data['events'][$run]['events_name']);
  $data['events'][$run]['events_checked'] = empty($checked[$data['events'][$run]['events_id']]) ? '' : ' checked = "checked"';
  $data['events'][$run] = array_merge($data['events'][$run], $status_empty);
  $data['events'][$run]['events_status'] = isset($status[$data['events'][$run]['events_id']]) ? $status[$data['events'][$run]['events_id']] : 4;
  $data['events'][$run]['events_status_' . $data['events'][$run]['events_status']] = ' selected = "selected"';
}

$data['eventguests']['users_id'] = 0;
$data['eventguests']['eventguests_since'] = cs_time();
$data['eventguests']['eventguests_name'] = empty($_POST['eventguests_name']) ? '' : $_POST['eventguests_name'];
$data['eventguests']['eventguests_surname'] = empty($_POST['eventguests_surname']) ? '' : $_POST['eventguests_surname'];
$data['eventguests']['eventguests_phone'] = empty($_POST['eventguests_phone']) ? '' : $_POST['eventguests_phone'];
$data['eventguests']['eventguests_mobile'] = empty($_POST['eventguests_mobile']) ? '' : $_POST['eventguests_mobile'];
$data['eventguests']['eventguests_residence'] = empty($_POST['eventguests_residence']) ? '' : $_POST['eventguests_residence'];
$data['eventguests']['eventguests_notice'] = empty($_POST['eventguests_notice']) ? '' : $_POST['eventguests_notice'];
$data['eventguests']['eventguests_age'] = empty($_POST['eventguests_age']) ? '' : $_POST['eventguests_age'];

if(isset($_POST['submit'])) {

  $errormsg = '';

  if(empty($_REQUEST['events_checked']))
    $errormsg .= $cs_lang['no_event'] . cs_html_br(1);
  elseif(!empty($users_nick)) {
    $where = "users_nick = '" . cs_sql_escape($users_nick) . "'";
    $users_data = cs_sql_select(__FILE__, 'users', 'users_id, users_email', $where);
    if(empty($users_data['users_id']))
      $errormsg .= $cs_lang['no_user'] . cs_html_br(1);
    else
      $data['eventguests']['users_id'] = $users_data['users_id'];
  }
  elseif(!empty($data['eventguests']['eventguests_name']) OR !empty($data['eventguests']['eventguests_surname'])) {
    if(!empty($events_options['req_fullname']) AND (empty($data['eventguests']['eventguests_name']) OR empty($data['eventguests']['eventguests_surname'])))
      $errormsg .= $cs_lang['err_name'] . cs_html_br(1);
    if(!empty($events_options['req_fulladress']) AND empty($data['eventguests']['eventguests_residence']))
      $errormsg .= $cs_lang['err_adress'] . cs_html_br(1);
    if(!empty($events_options['req_phone']) AND (strlen(trim($data['eventguests']['eventguests_phone'])) < 5))
      $errormsg .= $cs_lang['err_phone'] . cs_html_br(1);
    if(!empty($events_options['req_mobile']) AND (strlen(trim($data['eventguests']['eventguests_mobile'])) < 8))
      $errormsg .= $cs_lang['err_mobile'] . cs_html_br(1);
  }

  for ($run = 0; $run < $count_events; $run++) {
    if(!empty($data['events'][$run]['events_checked'])) {

      $err_event = ' -> ' . $cs_lang['event'] . ': ' . $data['events'][$run]['events_name'];

      if(!empty($data['eventguests']['users_id'])) {
        $where = "events_id = '" . $data['events'][$run]['events_id'] . "' AND users_id = '";
        $where .= $data['eventguests']['users_id'] . "'";
        $search_collision = cs_sql_count(__FILE__,'eventguests',$where);

        if(!empty($search_collision))
          $errormsg .= $cs_lang['user_event_exists'] . $err_event . cs_html_br(1);
      }
      else {
        $where = "events_id = '" . $data['events'][$run]['events_id'] . "' AND eventguests_name = '"
               . cs_sql_escape($data['eventguests']['eventguests_name']) . "' AND eventguests_surname = '"
               . cs_sql_escape($data['eventguests']['eventguests_surname']) . "'";
        $search_collision = cs_sql_count(__FILE__,'eventguests',$where);

        if(!empty($search_collision))
          $errormsg .= $cs_lang['name_event_exists'] . $err_event . cs_html_br(1);
      }

      $count_where = "events_id = '" . $data['events'][$run]['events_id'] . "' AND eventguests_status > 3";
      $count = cs_sql_count(__FILE__, 'eventguests', $count_where);
      if($count >= $data['events'][$run]['events_guestsmax'] AND $data['events'][$run]['events_status'] > 3)
        $errormsg .= $cs_lang['event_full'] . $err_event . cs_html_br(1);
    }
  }
}

$data['head']['info'] = empty($errormsg) ? $cs_lang['new_guest_info'] : $errormsg;

if(!empty($errormsg) OR !isset($_POST['submit'])) {
  $data['url']['form'] = cs_url('events','guestsmulti');

  $data['users']['nick'] = cs_secure($users_nick);

  echo cs_subtemplate(__FILE__,$data,'events','guestsmulti');
}
else {
  settype($data['eventguests']['eventguests_age'], 'integer');

  for ($run = 0; $run < $count_events; $run++) {
    if(!empty($data['events'][$run]['events_checked'])) {

      $data['eventguests']['events_id'] = $data['events'][$run]['events_id'];
      $data['eventguests']['eventguests_status'] = $data['events'][$run]['events_status'];
      $eventguests_cells = array_keys($data['eventguests']);
      $eventguests_save = array_values($data['eventguests']);
      cs_sql_insert(__FILE__,'eventguests',$eventguests_cells,$eventguests_save);

      # email notification for eventguest interactions
      if(!empty($data['eventguests']['users_id'])) {
        $subject  = $cs_lang['evg_mail_subject'] . ': ' . $data['events'][$run]['events_name'];
        $message  = $cs_lang['evg_mail_reasons'] . $cs_lang['evg_mail_updates'] . "\n\n";
        $message .= $cs_lang['event'] . ': ' . $data['events'][$run]['events_name'] . "\n";
        $message .= $cs_lang['date'] . ': ' . cs_date('unix',$data['events'][$run]['events_time'],1) . "\n";
        $message .= $cs_lang['status'] . ': ' . $cs_lang['status_' . $data['eventguests']['eventguests_status']] . "\n\n";
        $message .= $cs_lang['evg_mail_weblink'] . "\n";
        $message .= $cs_main['php_self']['website'] . cs_url('events', 'view', 'id=' . $data['events'][$run]['events_id']);
        cs_mail($users_data['users_email'], $subject, $message);
      }
    }
  }

  cs_redirect($cs_lang['create_done'],'events','manage');
}