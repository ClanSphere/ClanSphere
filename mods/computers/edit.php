<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('computers');
$cs_post = cs_post('id');
$cs_get = cs_get('id');

$computers_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $computers_id = $cs_post['id'];

if(isset($_POST['submit'])) {

  #$cs_computers['users_id'] = $account['users_id'];
  $cs_computers['computers_name'] = $_POST['computers_name'];
  $cs_computers['computers_software'] = $_POST['computers_software'];
  $cs_computers['computers_mainboard'] = $_POST['computers_mainboard'];
  $cs_computers['computers_memory'] = $_POST['computers_memory'];
  $cs_computers['computers_processors'] = $_POST['computers_processors'];
  $cs_computers['computers_graphics'] = $_POST['computers_graphics'];
  $cs_computers['computers_sounds'] = $_POST['computers_sounds'];
  $cs_computers['computers_harddisks'] = $_POST['computers_harddisks'];
  $cs_computers['computers_drives'] = $_POST['computers_drives'];
  $cs_computers['computers_screens'] = $_POST['computers_screens'];
  $cs_computers['computers_interfaces'] = $_POST['computers_interfaces'];
  $cs_computers['computers_networks'] = $_POST['computers_networks'];
  $cs_computers['computers_more'] = $_POST['computers_more'];

  $error = '';

  $search_user = cs_sql_select(__FILE__,'computers','users_id',"computers_id = '" . $computers_id . "'");
  if($search_user['users_id'] != $account['users_id'] AND $account['access_computers'] < 4) {
    $error .= $cs_lang['not_own'] . cs_html_br(1);
  }
  if(empty($cs_computers['computers_name'])) {
    $error .= $cs_lang['no_name'] . cs_html_br(1);
  }
  if(empty($cs_computers['computers_software'])) {
    $error .= $cs_lang['no_software'] . cs_html_br(1);
  }
  if(empty($cs_computers['computers_mainboard'])) {
    $error .= $cs_lang['no_mainboard'] . cs_html_br(1);
  }
}
else {

  $cells = 'computers_name, computers_software, computers_mainboard, computers_memory, computers_processors, computers_graphics, computers_sounds, computers_harddisks, computers_drives, computers_screens, computers_interfaces, computers_networks, computers_more, users_id';
  $cs_computers = cs_sql_select(__FILE__,'computers',$cells,"computers_id = '" . $computers_id . "'");
}
if(!isset($_POST['submit'])) {
  $data['head']['body'] = $cs_lang['body_edit'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {

  foreach($cs_computers AS $key => $value)
    $data['com'][$key] = cs_secure($value);

  $data['com']['referer'] = empty($_SERVER['HTTP_REFERER']) ? 'center' : $_SERVER['HTTP_REFERER'];
  $data['com']['id'] = $computers_id;

  echo cs_subtemplate(__FILE__,$data,'computers','edit');
}
else {

  $computers_cells = array_keys($cs_computers);
  $computers_save = array_values($cs_computers);
  cs_sql_update(__FILE__,'computers',$computers_cells,$computers_save,$_POST['id']);
  
  #$referrer = strpos($_POST['referer'],'manage') === false ? 'center' : 'manage';
  $referrer = $account['access_computers'] < 3 ? 'center' : 'manage';
  cs_redirect($cs_lang['changes_done'],'computers',$referrer);
} 
