<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');
$cs_get = cs_get('id,agree,cancel');

if(isset($cs_get['agree'])) {
  cs_sql_delete(__FILE__, 'events', $cs_get['id']);
  cs_sql_delete(__FILE__, 'eventguests', $cs_get['id'], 'events_id');
  cs_redirect($cs_lang['del_true'], 'events');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'events');
}


$event = cs_sql_select(__FILE__,'events','events_name','events_id = ' . $cs_get['id'],0,0,1);
if(!empty($event)) {
  $data = array();
  $data['lang']['remove'] = $cs_lang['head_remove'];
  $data['lang']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['event'],$event['events_name']);
  $data['lang']['content'] = cs_link($cs_lang['confirm'],'events','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['lang']['content'] .= ' - ';
  $data['lang']['content'] .= cs_link($cs_lang['cancel'],'events','remove','id=' . $cs_get['id'] . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'events','remove');
}
else {
  cs_redirect('','events');
}
