<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

require_once('mods/categories/functions.php');
$events_id = $_REQUEST['id'];
settype($events_id,'integer');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_edit'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');

if(isset($_POST['submit'])) {

  $cs_events['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
	cs_categories_create('events',$_POST['categories_name']);

  $cs_events['events_name'] = $_POST['events_name'];
  $cs_events['events_url'] = $_POST['events_url'];
  $cs_events['events_more'] = $_POST['events_more'];
  $cs_events['events_time'] = cs_datepost('time','unix');
  
  if(!empty($cs_main['fckeditor'])) {
    $cs_events['events_more'] = '[html]' . $_POST['events_more'] . '[/html]';
  }

  $error = 0;
  $errormsg = '';

  if(empty($cs_events['events_name'])) {
    $error++;
    $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
  }
  if(empty($cs_events['categories_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_cat'] . cs_html_br(1);
  }
  if(empty($cs_events['events_time'])) {
    $error++;
    $errormsg .= $cs_lang['no_date'] . cs_html_br(1);
  }
}
else {

  $cells = 'events_name, categories_id, events_time, events_url, events_more';
  $cs_events = cs_sql_select(__FILE__,'events',$cells,"events_id = '" . $events_id . "'");
}
if(!isset($_POST['submit'])) {
  echo $cs_lang['body_edit'];
}
elseif(!empty($error)) {
  echo $errormsg;
}
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!empty($error) OR !isset($_POST['submit'])) {

  echo cs_html_form (1,'events_edit','events','edit');
  echo cs_html_table(1,'forum',1);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('cal') . $cs_lang['name'] . ' *';
  echo cs_html_roco(2,'leftb');
	echo cs_html_input('events_name',$cs_events['events_name'],'text',40,40);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
	echo cs_icon('folder_yellow') . $cs_lang['category'] . ' *';
	echo cs_html_roco(2,'leftb');
	echo cs_categories_dropdown('events',$cs_events['categories_id']);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('1day') . $cs_lang['date'] . ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_dateselect('time','unix',$cs_events['events_time'],1995);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('gohome') . $cs_lang['url'];
  echo cs_html_roco(2,'leftb',0,2);
  echo 'http://' . cs_html_input('events_url',$cs_events['events_url'],'text',80,50);
  echo cs_html_roco(0);

  if(empty($cs_main['fckeditor'])) {
    echo cs_html_roco(1,'leftc');
	echo cs_icon('kate') . $cs_lang['more'];
    echo cs_html_br(2);
    echo cs_abcode_smileys('events_more');
	echo cs_html_roco(2,'leftb');
    echo cs_abcode_features('events_more');
	echo cs_html_textarea('events_more',$cs_events['events_more'],'50','8');
	echo cs_html_roco(0);
  } else {
    echo cs_html_roco(1,'leftc',0,2);
	echo cs_icon('kate') . $cs_lang['more'];
	echo cs_html_roco(0);
	echo cs_html_roco(1,'leftc" style="padding: 0px',0,2);
	echo cs_fckeditor('events_more',$cs_events['events_more']);
	echo cs_html_roco(0);
  }
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
	echo cs_html_vote('id',$events_id,'hidden');
  echo cs_html_vote('submit',$cs_lang['edit'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form(0);
}
else {

  $events_cells = array_keys($cs_events);
  $events_save = array_values($cs_events);
  cs_sql_update(__FILE__,'events',$events_cells,$events_save,$events_id);
  
    cs_redirect($cs_lang['changes_done'], 'events') ;
} 
  
?>
