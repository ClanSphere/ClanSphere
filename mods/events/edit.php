<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');
$cs_post = cs_post('id');
$cs_get = cs_get('id');

$events_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $events_id = $cs_post['id'];

require_once('mods/categories/functions.php');

$select = 'categories_id, events_name, events_time, events_venue, events_guestsmin, events_guestsmax, ';
$select .= 'events_needage, events_url, events_more, events_close, events_cancel';
$cs_events = cs_sql_select(__FILE__,'events',$select,"events_id = '" . $events_id . "'");


if(isset($_POST['submit'])) {

  $cs_events['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
  cs_categories_create('events',$_POST['categories_name']);

  $cs_events['events_name'] = $_POST['events_name'];
  $cs_events['events_venue'] = $_POST['events_venue'];
  $cs_events['events_url'] = $_POST['events_url'];
  $cs_events['events_more'] = empty($cs_main['rte_html']) ? $_POST['events_more'] : cs_abcode_inhtml($_POST['events_more'], 'add');
  $cs_events['events_time'] = cs_datepost('time','unix');
  $cs_events['events_close'] = isset($_POST['events_close']) ? $_POST['events_close'] : 0;
  $cs_events['events_cancel'] = isset($_POST['events_cancel']) ? $_POST['events_cancel'] : 0;
  $cs_events['events_guestsmin'] = !empty($_POST['events_guestsmin']) ? $_POST['events_guestsmin'] : '';
  $cs_events['events_guestsmax'] = !empty($_POST['events_guestsmax']) ? $_POST['events_guestsmax'] : '';
  $cs_events['events_needage'] = !empty($_POST['events_needage']) ? $_POST['events_needage'] : '';

  $error = '';

  if(empty($cs_events['events_name']))
    $error .= $cs_lang['no_name'] . cs_html_br(1);
  if(empty($cs_events['categories_id']))
    $error .= $cs_lang['no_cat'] . cs_html_br(1);
  if(empty($cs_events['events_time']))
    $error .= $cs_lang['no_date'] . cs_html_br(1);
  if($cs_events['events_guestsmax'] < $cs_events['events_guestsmin'])
    $error .= $cs_lang['min_greater_max'] . cs_html_br(1);

}

if(!isset($_POST['submit']))
  $data['head']['body'] = $cs_lang['body_edit'];
elseif(!empty($error))
  $data['head']['body'] = $error;


if(!empty($error) OR !isset($_POST['submit'])) {

  $data['data'] = $cs_events;

  $data['categories']['dropdown'] = cs_categories_dropdown('events',$cs_events['categories_id']);
  $data['select']['time'] = cs_dateselect('time','unix',$cs_events['events_time'],1995);
  
  $data['data']['events_guestsmin'] = !empty($cs_events['events_guestsmin']) ? $cs_events['events_guestsmin'] : '';
  $data['data']['events_guestsmax'] = !empty($cs_events['events_guestsmax']) ? $cs_events['events_guestsmax'] : '';
  $data['data']['events_needage'] = !empty($cs_events['events_needage']) ? $cs_events['events_needage'] : '';

  if(empty($cs_main['rte_html'])) {
    $data['if']['abcode'] = TRUE;
    $data['if']['rte_html'] = FALSE;
    $data['abcode']['smileys'] = cs_abcode_smileys('events_more', 1);
    $data['abcode']['features'] = cs_abcode_features('events_more', 1, 1);
  } else {
    $data['if']['abcode'] = FALSE;
    $data['if']['rte_html'] = TRUE;
    $data['rte']['html'] = cs_rte_html('events_more',$cs_events['events_more']);
  }

  $checked = 'checked="checked"';
  $data['check']['close'] = empty($cs_events['events_close']) ? '' : $checked;
  $data['check']['cancel'] = empty($cs_events['events_cancel']) ? '' : $checked;  

  $data['events']['id'] = $events_id;

 echo cs_subtemplate(__FILE__,$data,'events','edit');
}
else {

  settype($cs_events['events_guestsmin'],'integer');
  settype($cs_events['events_guestsmax'],'integer');
  settype($cs_events['events_needage'],'integer');

  $events_cells = array_keys($cs_events);
  $events_save = array_values($cs_events);
 cs_sql_update(__FILE__,'events',$events_cells,$events_save,$events_id);
  
 cs_redirect($cs_lang['changes_done'], 'events') ;
} 
  