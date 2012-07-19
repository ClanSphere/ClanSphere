<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('servers');

cs_scriptload('servers', 'javascript', 'js/servers.js');
include_once 'mods/servers/servers.class.php';

$data = array();
$objServers = Servers::__getInstance();

// Submit Post
if(isset($_POST['submit'])) {

  $servers_error = 0;
  $errormsg = $cs_lang['error_occurred'] . cs_html_br(1);

  $data['servers']['id'] = $_POST['id'];
  $data['create']['servers_name'] = $_POST['servers_name'];
  $data['create']['servers_ip'] = $_POST['servers_ip'];
  $data['create']['servers_port'] = $_POST['servers_port'];
  $data['create']['games_id'] = $_POST['games_id'];
  $data['create']['servers_info'] = $_POST['servers_info'];
  $data['create']['servers_slots'] = $_POST['servers_slots'];
  $data['create']['servers_type'] = $_POST['servers_type'];
  $data['create']['servers_stats'] = $_POST['servers_stats'];
  $data['create']['servers_class'] = $_POST['servers_class'];
  $data['create']['servers_query'] = $_POST['servers_query'];
  $data['create']['servers_order'] = $_POST['servers_order'];

  if(empty($data['create']['servers_name'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
  }
  if(empty($data['create']['servers_ip'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_ip'] . cs_html_br(1);
  }
  if(empty($data['create']['servers_port'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_port'] . cs_html_br(1);
  }
  if(empty($data['create']['games_id'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_game'] . cs_html_br(1);
  }
  if(empty($data['create']['servers_type'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_type'] . cs_html_br(1);
  }
  if(empty($data['create']['servers_class'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_class'] . cs_html_br(1);
  }
  if(empty($data['create']['servers_query'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_query'] . cs_html_br(1);
  }

  // Create new Entry
}
else {
  $data['servers']['id'] = empty($_GET['id']) ? 0 : $_GET['id'];
  $select = 'servers_name, servers_ip, servers_port, games_id, servers_info, servers_slots, servers_stats';
  $select .= ', servers_type, servers_class, servers_query, servers_order';
  $where = 'servers_id = \'' . $data['servers']['id'] . '\'';
  $data['create'] = cs_sql_select(__FILE__,'servers',$select,$where,0,0,1);
}
if(!isset($_POST['submit'])) {
  $data['body']['create'] = $cs_lang['body_create'];
}
elseif(!empty($servers_error)) {
  $data['body']['create'] = $errormsg;
}

if(!empty($servers_error) OR !isset($_POST['submit'])) {
  $games_array = cs_sql_select(__FILE__,'games','games_name, games_id',0,0,0,0);
  $run=0;
  if(empty($games_array))
  $data['games'] = array();
  else {
    foreach($games_array AS $games) {
      $data['games'][$run]['name'] = $games['games_name'];
      $data['games'][$run]['value'] = $games['games_id'];
      $data['games'][$run]['selected'] = $games['games_id'] == $data['create']['games_id'] ? 'selected="selected"' : '';
      $run++;
    }
  }

  $server_stats = array(
  array('name' => $cs_lang['no'], 'value' => '0'),
  array('name' => $cs_lang['yes'], 'value' => '1')
  );
  $run=0;
  foreach($server_stats AS $stats) {
    $selected = ($stats['value'] == $data['create']['servers_stats']) ? 'selected="selected"' : '';
    $data['stats'][$run]['name'] = $stats['name'];
    $data['stats'][$run]['value'] = $stats['value'];
    $data['stats'][$run]['selected'] = $selected;
    $run++;
  }

  $server_array = $objServers->getServerQueryList();

  $run = 0;
  foreach($server_array AS $type => $key) {
    $data['classes'][$run]['name'] = $key['name'];
    $data['classes'][$run]['class'] = $type;
    if(isset($key['prot'])) {
      $data['classes'][$run]['class'] .= ";" . $key['prot'];
    }
    $select = $data['classes'][$run]['class'] == $data['create']['servers_class'] ? $select = 'selected="selected"' : $select = '';
    $data['classes'][$run]['select'] = $select;
    $data['classes'][$run]['port'] = $key['port'];
    $run++;
  }

  $servers_type = array(
    array('gtype' => $cs_lang['clanserver'], 'type' => '1', 'selected' => ''),
    array('gtype' => $cs_lang['pubserver'], 'type' => '2', 'selected' => ''),
    array('gtype' => $cs_lang['voiceserver'], 'type' => '3', 'selected' => '')
  );
  $run=0;
  foreach($servers_type AS $type) {
    $selected = ($type['type'] == $data['create']['servers_type']) ? 'selected="selected"' : '';
    $data['typ'][$run]['name'] = $type['gtype'];
    $data['typ'][$run]['type'] = $type['type'];
    $data['typ'][$run]['selected'] = $selected;
    $run++;
  }
} else {

  settype($data['create']['servers_slots'], 'integer');
  settype($data['create']['servers_order'], 'integer');

  // Update SQL Data
  $servers_cells = array_keys($data['create']);
  $servers_save = array_values($data['create']);
  cs_sql_update(__FILE__,'servers',$servers_cells,$servers_save,$data['servers']['id']);

  // Create Finish
  cs_redirect($cs_lang['create_done'],'servers');
}

echo cs_subtemplate(__FILE__,$data,'servers','edit');