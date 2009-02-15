<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

require_once('mods/categories/functions.php');

if(isset($_POST['submit'])) {

  $cs_events['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
	cs_categories_create('events',$_POST['categories_name']);

  $cs_events['events_name'] = $_POST['events_name'];
  $cs_events['events_url'] = $_POST['events_url'];
  $cs_events['events_more'] = $_POST['events_more'];
  $cs_events['events_time'] = cs_datepost('time','unix');
  $cs_events['events_close'] = isset($_POST['events_close']) ? $_POST['events_close'] : 0;
  
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
  $cs_events['events_name'] = '';
  $cs_events['categories_id'] = 0;
  $cs_events['events_time'] = cs_time();
  $cs_events['events_url'] = '';
  $cs_events['events_more'] = '';
  $cs_events['events_close'] = 0;
  $_POST['events_multix'] = '';
  $_POST['events_multi'] = '';
}

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_create'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
if(!isset($_POST['submit'])) {
  echo $cs_lang['body_create'];
}
elseif(!empty($error)) {
  echo $errormsg;
}
else {
  echo $cs_lang['create_done'];
}
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

if(!empty($error) OR !isset($_POST['submit'])) {

  echo cs_html_form (1,'events_create','events','create');
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
  echo cs_icon('5days') . $cs_lang['multi'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_select(1,'events_multi');
  echo cs_html_option($cs_lang['no'], 'no', $select = $_POST['events_multi'] == 'no' ? 1 : 0 );
  echo cs_html_option($cs_lang['yes'], 'yes', $select = $_POST['events_multi'] == 'yes' ? 1 : 0);
  echo cs_html_select(0);
  echo $cs_lang['multi_info'];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('7days') . $cs_lang['multix']  . ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('events_multix',$_POST['events_multix'],'text','2','3');
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('configure') . $cs_lang['more'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('events_close', 1, 'checkbox', $cs_events['events_close']) . ' ' . $cs_lang['close'];
  echo cs_html_roco(0);
	
  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('submit',$cs_lang['create'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form(0);
}
else {
  $events_cells = array_keys($cs_events);
  $events_save = array_values($cs_events);
  cs_sql_insert(__FILE__,'events',$events_cells,$events_save);
  
  if($_POST['events_multi']=='yes') {
    for($run=0; $run<$_POST['events_multix']; $run++) {
	  $cs_events['events_time'] = strtotime("+1 week",$cs_events['events_time']);
	  $events_cells = array_keys($cs_events);
      $events_save = array_values($cs_events);
      cs_sql_insert(__FILE__,'events',$events_cells,$events_save);
	}
  }
  cs_redirect($cs_lang['create_done'],'events');
}

?>