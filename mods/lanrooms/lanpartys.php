<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanrooms');

if(empty($_GET['save_id'])) {
  $lanpartys_id = empty($_REQUEST['id']) ? 0 : $_REQUEST['id'];
  $lanpartys_id = empty($_REQUEST['where']) ? $lanpartys_id : $_REQUEST['where'];
  settype($lanpartys_id,'integer');
  $where = "lanpartys_id = '" . $lanpartys_id . "'";
  $first_room = cs_sql_select(__FILE__,'lanrooms','lanrooms_id',$where,'lanrooms_name');
  $lanrooms_id = empty($_REQUEST['lanrooms_id']) ? $first_room['lanrooms_id'] : $_REQUEST['lanrooms_id'];
}
else {
  settype($_GET['save_id'],'integer');

  $where = "lanroomd_id = '" . $_GET['save_id'] . "'";
  $save_room = cs_sql_select(__FILE__,'lanroomd','lanrooms_id',$where);
  $lanrooms_id = $save_room['lanrooms_id'];
  $where = "lanrooms_id = '" . $lanrooms_id . "'";
  $save_lan = cs_sql_select(__FILE__,'lanrooms','lanpartys_id',$where);
  $lanpartys_id = $save_lan['lanpartys_id'];

  $error = 0;
  $errormsg = '';

  if(empty($lanrooms_id)) {
    $error++;
    $errormsg .= $cs_lang['no_room'] . cs_html_br(1);
  }
  
  if(empty($lanpartys_id)) {
    $error++;
    $errormsg .= $cs_lang['no_party'] . cs_html_br(1);
  }

  $where = "lanroomd_id = '" . $_GET['save_id'] . "' AND users_id != '" . $account['users_id'] . "'";
  $search = cs_sql_count(__FILE__,'languests',$where);
  
  if(!empty($search)) {
    $error++;
    $errormsg .= $cs_lang['target_used'] . cs_html_br(1);
  }

  $self = "lanpartys_id = '" . $lanpartys_id . "' AND users_id = '" . $account['users_id'] . "'";
  $target = cs_sql_select(__FILE__,'languests','languests_status, languests_id',$self);
  
  if($target['languests_status'] != 4) {
    $error++;
    $errormsg .= $cs_lang['target_denied'] . cs_html_br(1);
  }

  $lan = "lanpartys_id = '" . $lanpartys_id . "'";
  $lanstart = cs_sql_select(__FILE__,'lanpartys','lanpartys_start',$lan);
  
  if($lanstart['lanpartys_start'] < cs_time()) {
    $error++;
    $errormsg .= $cs_lang['lan_started'] . cs_html_br(1);
  }

  if(empty($error)) {
  	$languests_cells = array('lanroomd_id');
  	$languests_save = array($_GET['save_id']);
  	cs_sql_update(__FILE__,'languests',$languests_cells,$languests_save,$target['languests_id']);
  }
}

$data['lang']['addons'] = cs_addons('lanpartys','view',$lanpartys_id,'lanrooms');

$data['url']['form'] = cs_url('lanrooms','lanpartys');
$data['data']['id'] = $lanpartys_id;
  
$where = "lanpartys_id = '" . $lanpartys_id . "'";
$room_data = cs_sql_select(__FILE__,'lanrooms','lanrooms_name, lanrooms_id',$where,'lanrooms_name',0,0);
$lan_data_loop = count($room_data);
if(empty($lan_data_loop)) {
  $data['lan'] = '';
}

for($run=0; $run<$lan_data_loop; $run++) {
  $data['lan'][$run]['id'] = $room_data[$run]['lanrooms_id'];
  $data['lan'][$run]['name'] = $room_data[$run]['lanrooms_name'];
}

if(empty($_GET['save_id'])) {
  $data['lang']['body'] = $cs_lang['body_lanpartys'];
}
elseif(!empty($error)) {
  $data['lang']['body'] = $errormsg;
}
else {
  $data['lang']['body'] = $cs_lang['target_done'];
}

$self = "lanpartys_id = '" . $lanpartys_id . "' AND users_id = '" . $account['users_id'] . "'";
$target = cs_sql_select(__FILE__,'languests','languests_status, lanroomd_id',$self);
$free = $target['languests_status'] == 4 ? 'save_id' : 0;

echo cs_subtemplate(__FILE__,$data,'lanrooms','lanpartys');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'leftc');
include('mods/lanrooms/functions.php');
echo cs_lanroom('lanrooms','lanpartys',$lanrooms_id,$target['lanroomd_id'],$free);
echo cs_html_roco(0);
echo cs_html_table(0);
?>
