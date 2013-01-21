<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$events_id = empty($_REQUEST['id']) ? 0 : $_REQUEST['id'];
settype($events_id,'integer');

$error = '';

$where = "events_id = '" . $events_id . "' AND users_id ='" . $account['users_id'] . "'";
$eventguests = cs_sql_count(__FILE__,'eventguests',$where);
$where2 = "events_id = '" . $events_id . "'";
$events = cs_sql_select(__FILE__,'events','events_time, events_name, events_cancel, events_needage, events_guestsmax, events_id',$where2);

if(empty($events_id) OR empty($events) OR empty($events['events_guestsmax']))
  $error .= $cs_lang['no_event'] . cs_html_br(1);
elseif(($events['events_time'] < cs_time()) OR !empty($events['events_cancel']))
  $error .= $cs_lang['err_time'] . cs_html_br(1);
elseif(!empty($eventguests))
  $error .= $cs_lang['user_found'] . cs_html_br(1);
else {
  $fields = 'users_age, users_name, users_surname, users_phone, users_mobile, users_adress, users_postalcode, users_place, users_country';
  $where3 = "users_id = '" . $account['users_id'] . "'";
  $cs_user = cs_sql_select(__FILE__,'users',$fields,$where3);  

  $age = 0;
  if(!empty($cs_user['users_age'])) {
    $birth = explode ('-', $cs_user['users_age']);
    $age = cs_datereal('Y') - $birth[0];
    if(cs_datereal('m')<=$birth[1]) { $age--; }
    if(cs_datereal('d')>=$birth[2] AND cs_datereal('m')==$birth[1]) { $age++; }
  }
  if($events['events_needage'] > $age)
    $error .= $cs_lang['err_age'] . cs_html_br(1);

  $options = cs_sql_option(__FILE__,'events');

  if(!empty($options['req_fullname']) AND (empty($cs_user['users_name']) OR empty($cs_user['users_surname'])))
    $error .= $cs_lang['err_name'] . cs_html_br(1);
  if(!empty($options['req_fulladress']) AND (empty($cs_user['users_adress']) OR empty($cs_user['users_postalcode']) OR empty($cs_user['users_place']) OR empty($cs_user['users_country'])))
    $error .= $cs_lang['err_adress'] . cs_html_br(1);
  if(!empty($options['req_phone']) AND (strlen(trim($cs_user['users_phone'])) < 5))
    $error .= $cs_lang['err_phone'] . cs_html_br(1);
  if(!empty($options['req_mobile']) AND (strlen(trim($cs_user['users_mobile'])) < 8))
    $error .= $cs_lang['err_mobile'] . cs_html_br(1);
}
  
if(empty($error)) {

  $count_where = "events_id = '" . $events_id . "' AND eventguests_status > 3";
  $count = cs_sql_count(__FILE__, 'eventguests', $count_where);
  $status = $events['events_guestsmax'] > $count ? 0 : 3;

  $array_keys = array('events_id','users_id','eventguests_since','eventguests_status');
  $array_values = array($events_id,$account['users_id'],cs_time(),$status);
  cs_sql_insert(__FILE__,'eventguests',$array_keys,$array_values);

  $msg = $cs_lang['body_signin'];

  # email notification for eventguest interactions
  if(!empty($account['users_id'])) {
    $subject  = $cs_lang['evg_mail_subject'] . ': ' . $events['events_name'];
    $message  = $cs_lang['evg_mail_reasons'] . $cs_lang['evg_mail_signups'] . "\n\n";
    $message .= $cs_lang['event'] . ': ' . $events['events_name'] . "\n";
    $message .= $cs_lang['date'] . ': ' . cs_date('unix',$events['events_time'],1) . "\n";
    $message .= $cs_lang['status'] . ': ' . $cs_lang['status_' . $status] . "\n\n";
    $message .= $cs_lang['evg_mail_weblink'] . "\n";
    $message .= $cs_main['php_self']['website'] . cs_url('events', 'view', 'id=' . $events['events_id']);
    cs_mail($account['users_email'], $subject, $message);
  }
}
else
  $msg = $error;

cs_redirect($msg,'events','view','id=' . $events_id);