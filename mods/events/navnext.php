<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$from = 'events evs INNER JOIN {pre}_categories cat ON evs.categories_id = cat.categories_id';
$select = 'evs.events_id AS events_id, evs.events_name AS events_name, evs.events_time AS events_time';
$upcome = "evs.events_time > '" . cs_time() . "' AND cat.categories_access <= " . $account['access_events'];
$cs_events = cs_sql_select(__FILE__,$from,$select,$upcome,'evs.events_time',0,4);
$events_loop = count($cs_events);

$data = array();

if(empty($cs_events)) {
  echo $cs_lang['no_events'];
}
else {
  for($run=0; $run<$events_loop; $run++) {
    $data['events'][$run]['date'] = cs_date('unix',$cs_events[$run]['events_time'],1);
    $data['events'][$run]['name'] = cs_secure($cs_events[$run]['events_name']);
    $data['events'][$run]['link'] = cs_url('events','view','id=' . $cs_events[$run]['events_id']);
  }
  echo cs_subtemplate(__FILE__,$data,'events','navnext');
}
?>