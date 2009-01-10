<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('languests');

$languests_id = empty($_REQUEST['languests_id']) ? 0 : $_REQUEST['languests_id'];
settype($languests_id,'integer');
$search = "languests_id = '" . $languests_id . "'";
$lanparty = cs_sql_select(__FILE__,'languests','languests_status, lanpartys_id, lanroomd_id',$search);
$lanpartys_id = $lanparty['lanpartys_id'];

if(empty($_GET['save_id'])) {
	$where = "lanpartys_id = '" . $lanpartys_id . "'";
	$first_room = cs_sql_select(__FILE__,'lanrooms','lanrooms_id',$where,'lanrooms_name');
	$lanrooms_id = empty($_REQUEST['lanrooms_id']) ? $first_room['lanrooms_id'] : $_REQUEST['lanrooms_id'];
}
else {
	settype($_GET['save_id'],'integer');

	$where = "lanroomd_id = '" . $_GET['save_id'] . "'";
	$save_room = cs_sql_select(__FILE__,'lanroomd','lanrooms_id',$where);
	$lanrooms_id = $save_room['lanrooms_id'];

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
	if(empty($languests_id)) {
    $error++;
    $errormsg .= $cs_lang['no_guest'] . cs_html_br(1);
  }

  $where = "lanroomd_id = '" . $_GET['save_id'] . "' AND languests_id != '" . $languests_id . "'";
  $search = cs_sql_count(__FILE__,'languests',$where);
  if(!empty($search)) {
    $error++;
    $errormsg .= $cs_lang['target_used'] . cs_html_br(1);
  }

  if($lanparty['languests_status'] != 4) {
    $error++;
    $errormsg .= $cs_lang['target_denied'] . cs_html_br(1);
  }

	if(empty($error)) {
  	$languests_cells = array('lanroomd_id');
  	$languests_save = array($_GET['save_id']);
  	cs_sql_update(__FILE__,'languests',$languests_cells,$languests_save,$languests_id);
		$lanparty['lanroomd_id'] = $_GET['save_id'];
	}
}


$data['url']['form']= cs_url('lanpartys','rooms');
$where = "lanpartys_id = '" . $lanpartys_id . "'";
$room_data = cs_sql_select(__FILE__,'lanrooms','lanrooms_name, lanrooms_id',$where,'lanrooms_name',0,0);
$room_data_loop = count($room_data);

if(empty($room_data_loop)) {
  $data['room'] = '';
}

for($run=0; $run<$room_data_loop; $run++) {
  $data['room'][$run]['id'] = $room_data[$run]['lanrooms_id'];
  $data['room'][$run]['name'] = $room_data[$run]['lanrooms_name'];
}

$data['data']['id'] = $lanpartys_id;


if(empty($_GET['save_id'])) {
	$data['lang']['body'] = $cs_lang['body_rooms'];
}
elseif(!empty($error)) {
	$data['lang']['body'] = $errormsg;
}
else {
	$data['lang']['body'] = $cs_lang['target_done'];
}


$free = $lanparty['languests_status'] == 4 ? 'languests_id=' . $languests_id . '&amp;save_id' : 0;
include('mods/lanrooms/functions.php');
$data['languests']['map'] =  cs_lanroom('languests','rooms',$lanrooms_id,$lanparty['lanroomd_id'],$free);

echo cs_subtemplate(__FILE__,$data,'languests','rooms');
?>
