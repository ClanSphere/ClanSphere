<?php
// ClanSphere 2009 - www.clansphere.net
// $Id: create.php 1775 2009-02-17 20:59:11Z duRiel $

$cs_lang = cs_translate('events');

$cs_eventguests['eventguests_since'] = cs_time();

$cs_eventguests['events_id'] = empty($_REQUEST['events_id']) ? 0 : $_REQUEST['events_id'];
$cs_eventguests['users_id'] = empty($_REQUEST['users_id']) ? 0 : $_REQUEST['users_id'];

settype($cs_eventguests['events_id'],'integer');
settype($cs_eventguests['users_id'],'integer');

if(isset($_POST['submit'])) {

  $error = 0;
  $errormsg = '';

  if(empty($cs_eventguests['users_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_user'] . cs_html_br(1);
  }
  
  if(empty($cs_eventguests['events_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_event'] . cs_html_br(1);
  }
  else {
    $where = "events_id = '" . $cs_eventguests['events_id'] . "' AND users_id = '";
    $where .= $cs_eventguests['users_id'] . "'";
    $search_collision = cs_sql_count(__FILE__,'eventguests',$where);
    
  if(!empty($search_collision)) {
      $error++;
      $errormsg .= $cs_lang['user_event_exists'] . cs_html_br(1);
    }
  }
}

if(!isset($_POST['submit'])) {
  $data['lang']['body'] = $cs_lang['body_create'];
}

if(!empty($error))
  $data['lang']['body'] = $errormsg;

if(!empty($error) OR !isset($_POST['submit'])) {
  $data['url']['form'] = cs_url('events','guestsnew');

  $where = "events_id = '" . $cs_eventguests['events_id'] . "'";
  $events_data = cs_sql_select(__FILE__, 'events', 'events_time, events_name, events_id', $where);

  $data['events']['id'] = $events_data['events_id'];
  $data['events']['name'] = $events_data['events_name'];
  $data['events']['time'] = cs_date('unix',$events_data['events_time'],1);

  $users_data = cs_sql_select(__FILE__,'users','users_nick, users_id','users_active = "1" AND users_delete = "0"','users_nick',0,0);
  $users_data_loop = count($users_data);

  if(empty($users_data_loop)) {
    $data['user'] = '';
  }

  for($run=0; $run<$users_data_loop; $run++) {
    $data['user'][$run]['id'] = $users_data[$run]['users_id'];
    $data['user'][$run]['name'] = $users_data[$run]['users_nick'];
  }

  echo cs_subtemplate(__FILE__,$data,'events','guestsnew');
}
else {

  $eventguests_cells = array_keys($cs_eventguests);
  $eventguests_save = array_values($cs_eventguests);
  cs_sql_insert(__FILE__,'eventguests',$eventguests_cells,$eventguests_save);
  
  cs_redirect($cs_lang['create_done'],'events','guests','id=' . $cs_eventguests['events_id']);
}