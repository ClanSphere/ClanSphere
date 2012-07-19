<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');
$data = array();

require_once('mods/categories/functions.php');

$cs_events['events_name'] = '';
$cs_events['categories_id'] = 0;
$cs_events['events_time'] = cs_time();
$cs_events['events_venue'] = '';
$cs_events['events_url'] = '';
$cs_events['events_more'] = '';
$cs_events['events_close'] = 0;
$cs_events['events_cancel'] = 0;
$cs_events['events_guestsmin'] = '';
$cs_events['events_guestsmax'] = '';
$cs_events['events_needage'] = '';
$_POST['events_multix'] = empty($_POST['events_multix']) ? '' : $_POST['events_multix'];
$_POST['events_multi']  = empty($_POST['events_multi'])  ? '' : $_POST['events_multi'];


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
  $data['head']['body'] = $cs_lang['body_create'];
elseif(!empty($error))
  $data['head']['body'] = $error;


if(!empty($error) OR !isset($_POST['submit'])) {

  $data['data'] = $cs_events;

  $data['categories']['dropdown'] = cs_categories_dropdown('events',$cs_events['categories_id']);
  $data['select']['time'] = cs_dateselect('time','unix',$cs_events['events_time'],1995);

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

  $selected = 'selected="selected"';
  $data['check']['multi_no'] = $_POST['events_multi'] == 'no' ? $selected : '';
  $data['check']['multi_yes'] = $_POST['events_multi'] == 'yes' ? $selected : '';
  $data['data']['events_multix'] = $_POST['events_multix'];

  $checked = 'checked="checked"';
  $data['check']['close'] = empty($cs_events['events_close']) ? '' : $checked;
  $data['check']['cancel'] = empty($cs_events['events_cancel']) ? '' : $checked;  


 echo cs_subtemplate(__FILE__,$data,'events','create');
}
else {

  settype($cs_events['events_guestsmin'],'integer');
  settype($cs_events['events_guestsmax'],'integer');
  settype($cs_events['events_needage'],'integer');

  $events_cells = array_keys($cs_events);
  $events_save = array_values($cs_events);
  cs_sql_insert(__FILE__,'events',$events_cells,$events_save);

  if($_POST['events_multi'] == 'yes') {

    $mode = date('I', $cs_events['events_time']);
    for($run=0; $run < $_POST['events_multix']; $run++) {

      $cs_events['events_time'] = strtotime("+1 week",$cs_events['events_time']);
      if(date('I', $cs_events['events_time']) > $mode) {
        $cs_events['events_time'] = $cs_events['events_time'] - 3600;
        $mode = 1;
      }
      elseif(date('I', $cs_events['events_time']) < $mode) {
        $cs_events['events_time'] = $cs_events['events_time'] + 3600;
        $mode = 0;
      }

      $events_cells = array_keys($cs_events);
      $events_save = array_values($cs_events);
      cs_sql_insert(__FILE__,'events',$events_cells,$events_save);
    }
  }

 cs_redirect($cs_lang['create_done'],'events');
}