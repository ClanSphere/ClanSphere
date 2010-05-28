<?php
// ClanSphere 2009 - www.clansphere.net
// $Id: signin.php 1430 2008-12-10 13:08:44Z Fr33z3m4n $

$cs_lang = cs_translate('events');

$events_id = empty($_REQUEST['id']) ? 0 : $_REQUEST['id'];
settype($events_id,'integer');

$error = '';

$where = "events_id = '" . $events_id . "' AND users_id ='" . $account['users_id'] . "'";
$eventguests = cs_sql_count(__FILE__,'eventguests',$where);
$where2 = "events_id = '" . $events_id . "'";
$events = cs_sql_select(__FILE__,'events','events_time, events_cancel, events_needage, events_guestsmax',$where2);

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
  $array_keys = array('events_id','users_id','eventguests_since');
  $array_values = array($events_id,$account['users_id'],cs_time());
  cs_sql_insert(__FILE__,'eventguests',$array_keys,$array_values);

  $msg = $cs_lang['body_signin'];
}
else {
  $msg = $error;
}

cs_redirect($msg,'events','view','id=' . $events_id);