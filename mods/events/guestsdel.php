<?php
// ClanSphere 2009 - www.clansphere.net
// $Id: guestsdel.php 1775 2009-02-17 20:59:11Z duRiel $

$cs_lang = cs_translate('events');

$events_form = 1;
$eventguests_id = $_REQUEST['id'];
settype($eventguests_id, 'integer');

$cs_events = cs_sql_select(__FILE__, 'eventguests', 'events_id', "eventguests_id = '" . $eventguests_id . "'");

$events_id = empty($cs_events['events_id']) ? 0 : $cs_events['events_id'];

if(isset($_GET['agree'])) {

  $events_form = 0;

  cs_sql_delete(__FILE__, 'eventguests', $eventguests_id);
  
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

?>