<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$events_options = cs_sql_option(__FILE__, 'events');

$data = array();
$data['head']['info'] = $cs_lang['new_guest_info'];

$eventguests_id = empty($_REQUEST['id']) ? 0 : $_REQUEST['id'];
settype($eventguests_id,'integer');
$data['eventguests'] = cs_sql_select(__FILE__, 'eventguests', '*', 'eventguests_id = ' . $eventguests_id);
$cs_user = cs_sql_select(__FILE__, 'users', 'users_nick', 'users_id = ' . $data['eventguests']['users_id']);
$users_nick = empty($cs_user['users_nick']) ? '' : $cs_user['users_nick'];

if(empty($data['eventguests']['eventguests_age']))
  $data['eventguests']['eventguests_age'] = '';

$columns = 'events_time, events_name, events_needage, events_guestsmax, events_id';
$where = "events_id = '" . $data['eventguests']['events_id'] . "'";
$data['events'] = cs_sql_select(__FILE__, 'events', $columns, $where);

if(isset($_POST['submit'])) {

  $users_nick = empty($_REQUEST['users_nick']) ? '' : $_REQUEST['users_nick'];

  $data['eventguests']['users_id'] = 0;
  $data['eventguests']['eventguests_name'] = empty($_POST['eventguests_name']) ? '' : $_POST['eventguests_name'];
  $data['eventguests']['eventguests_surname'] = empty($_POST['eventguests_surname']) ? '' : $_POST['eventguests_surname'];
  $data['eventguests']['eventguests_phone'] = empty($_POST['eventguests_phone']) ? '' : $_POST['eventguests_phone'];
  $data['eventguests']['eventguests_mobile'] = empty($_POST['eventguests_mobile']) ? '' : $_POST['eventguests_mobile'];
  $data['eventguests']['eventguests_residence'] = empty($_POST['eventguests_residence']) ? '' : $_POST['eventguests_residence'];
  $data['eventguests']['eventguests_notice'] = empty($_POST['eventguests_notice']) ? '' : $_POST['eventguests_notice'];
  $data['eventguests']['eventguests_age'] = empty($_POST['eventguests_age']) ? '' : $_POST['eventguests_age'];
  $data['eventguests']['eventguests_status'] = empty($_POST['eventguests_status']) ? 0 : $_POST['eventguests_status'];

  $errormsg = '';

  $count_where = "events_id = '" . $data['eventguests']['events_id'] . "' AND eventguests_status > 3 AND eventguests_id != " . (int) $eventguests_id;
  $count = cs_sql_count(__FILE__, 'eventguests', $count_where);
  if($count >= $data['events']['events_guestsmax'] AND $data['eventguests']['eventguests_status'] > 3)
    $errormsg .= $cs_lang['event_full'] . cs_html_br(1);

  if(empty($data['eventguests']['events_id']))
    $errormsg .= $cs_lang['no_event'] . cs_html_br(1);
  elseif(!empty($users_nick)) {
    $where = "users_nick = '" . cs_sql_escape($users_nick) . "'";
    $users_data = cs_sql_select(__FILE__, 'users', 'users_id', $where);
    if(empty($users_data['users_id']))
      $errormsg .= $cs_lang['no_user'] . cs_html_br(1);
    else
      $data['eventguests']['users_id'] = $users_data['users_id'];

    $where = "events_id = '" . $data['eventguests']['events_id'] . "' AND users_id = '";
    $where .= $data['eventguests']['users_id'] . "' AND eventguests_id != " . $eventguests_id;
    $search_collision = cs_sql_count(__FILE__,'eventguests',$where);
    
    if(!empty($search_collision))
      $errormsg .= $cs_lang['user_event_exists'] . cs_html_br(1);
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
  else
    $errormsg = $cs_lang['new_guest_info'];
}

if(!empty($errormsg))
  $data['head']['info'] = $errormsg;

if(!empty($errormsg) OR !isset($_POST['submit'])) {
  $data['url']['form'] = cs_url('events','guestsadm');

  $data['events']['time'] = cs_date('unix',$data['events']['events_time'],1);

  $data['users']['nick'] = cs_secure($users_nick);

  if(empty($data['eventguests']['eventguests_phone'])) $data['eventguests']['eventguests_phone'] = '';
  if(empty($data['eventguests']['eventguests_mobile'])) $data['eventguests']['eventguests_mobile'] = '';

  $data['select'] = array(0 => '', 3 => '', 4 => '', 5 => '');
  $select = $data['eventguests']['eventguests_status'];
  $data['select'][$select] = ' selected ="selected"';

  echo cs_subtemplate(__FILE__,$data,'events','guestsadm');
}
else {
  settype($data['eventguests']['eventguests_age'], 'integer');
  $eventguests_cells = array_keys($data['eventguests']);
  $eventguests_save = array_values($data['eventguests']);
  cs_sql_update(__FILE__,'eventguests',$eventguests_cells,$eventguests_save, $eventguests_id);
  
  cs_redirect($cs_lang['create_done'],'events','guests','id=' . $data['eventguests']['events_id']);
}