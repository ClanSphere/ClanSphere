<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$select = 'events_id, events_name, events_time';
$upcome = "events_time > '" . cs_time() . "'";
$cs_events = cs_sql_select(__FILE__,'events',$select,$upcome,'events_time',0,4);
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