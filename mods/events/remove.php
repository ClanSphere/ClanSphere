<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$events_form = 1;
$events_id = $_REQUEST['id'];
settype($events_id,'integer');

if(isset($_GET['agree'])) {
  $events_form = 0;
  cs_sql_delete(__FILE__, 'events', $events_id);
  cs_sql_delete(__FILE__, 'eventguests', $events_id, 'events_id');

 cs_redirect($cs_lang['del_true'], 'events');
}

if(isset($_GET['cancel'])) 
    cs_redirect($cs_lang['del_false'], 'events');

if(!empty($events_form)) {
  $data['lang']['remove'] = $cs_lang['head_remove']; 
  $data['lang']['body'] = sprintf($cs_lang['del_rly'],$events_id);
  
  $data['lang']['content'] = cs_link($cs_lang['confirm'],'events','remove','id=' . $events_id . '&amp;agree');
  $data['lang']['content'] .= ' - ';
  $data['lang']['content'] .= cs_link($cs_lang['cancel'],'events','remove','id=' . $events_id . '&amp;cancel');
  
  echo cs_subtemplate(__FILE__,$data,'events','remove');
}