<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('languests');
$cs_languests['languests_since'] = cs_time();

if(isset($_POST['submit'])) {
  $cs_languests['lanpartys_id'] = $_POST['lanpartys_id'];
  $cs_languests['users_id'] = $_POST['users_id'];
  $cs_languests['languests_status'] = $_POST['languests_status'];
  $cs_languests['languests_money'] = $_POST['languests_money'];
  $cs_languests['languests_notice'] = $_POST['languests_notice'];
  $cs_languests['languests_team'] = $_POST['languests_team'];
  $cs_languests['languests_paytime'] = cs_datepost('pay','unix');

  settype($cs_languests['lanpartys_id'],'integer');
  settype($cs_languests['users_id'],'integer');

  $error = 0;
  $errormsg = '';

  if(empty($cs_languests['users_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_user'] . cs_html_br(1);
  }
  
  if(empty($cs_languests['lanpartys_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_lanparty'] . cs_html_br(1);
  }
  else {
  	$where = "lanpartys_id = '" . $cs_languests['lanpartys_id'] . "' AND users_id = '";
  	$where .= $cs_languests['users_id'] . "'";
  	$search_collision = cs_sql_count(__FILE__,'languests',$where);
  	
	if(!empty($search_collision)) {
      $error++;
      $errormsg .= $cs_lang['user_lan_exists'] . cs_html_br(1);
  	}
    
	$where2 = "lanpartys_id = '" . $cs_languests['lanpartys_id'] . "'";
  	$maxguests = cs_sql_select(__FILE__,'lanpartys','lanpartys_maxguests',$where2);
  	$where3 = "lanpartys_id = '" . $cs_languests['lanpartys_id'] . "' AND languests_status > 3";
  	$search_max = cs_sql_count(__FILE__,'languests',$where3);
  	
	if($search_max >= $maxguests['lanpartys_maxguests']) {
      $error++;
      $errormsg .= $cs_lang['lan_full'] . cs_html_br(1);
  	}
  }
}
else {
  $cs_languests['lanpartys_id'] = 0;
  $cs_languests['users_id'] = 0;
  $cs_languests['languests_status'] = 0;
  $cs_languests['languests_money'] = '';
  $cs_languests['languests_paytime'] = 0;
  $cs_languests['languests_notice'] = '';
  $cs_languests['languests_team'] = '';
}


if(!isset($_POST['submit'])) {
  $data['lang']['body'] = $cs_lang['body_create'];
}

if(!empty($error)) {
  $data['lang']['body'] = $errormsg;
}

if(!empty($error) OR !isset($_POST['submit'])) {
  $data['url']['form'] = cs_url('languests','create');

  $lanpartys_data = cs_sql_select(__FILE__,'lanpartys','lanpartys_name, lanpartys_id',0,'lanpartys_name',0,0);
  $lanpartys_data_loop = count($lanpartys_data);

  if(empty($lanpartys_data_loop)) {
    $data['lanpartys'] = '';
  }

  for($run=0; $run<$lanpartys_data_loop; $run++) {
    $data['lanpartys'][$run]['id'] = $lanpartys_data[$run]['lanpartys_id'];
    $data['lanpartys'][$run]['name'] = $lanpartys_data[$run]['lanpartys_name'];	
  }

  $users_data = cs_sql_select(__FILE__,'users','users_nick,users_id',0,'users_nick',0,0);
  $users_data_loop = count($users_data);

  if(empty($users_data_loop)) {
    $data['user'] = '';
  }

  for($run=0; $run<$users_data_loop; $run++) {
    $data['user'][$run]['id'] = $users_data[$run]['users_id'];
    $data['user'][$run]['name'] = $users_data[$run]['users_nick'];
  }

  $data['languests']['team'] = $cs_languests['languests_team'];
  
  $sel = array(1 => 0,3 => 0,4 => 0,5 => 0);
  if(isset($_POST['submit'])) {
    $cs_languests['languests_status'] == 3 ? $sel[3] = 1 : $sel[3] = 0;
    $cs_languests['languests_status'] == 4 ? $sel[4] = 1 : $sel[4] = 0;
    $cs_languests['languests_status'] == 5 ? $sel[5] = 1 : $sel[5] = 0;
  }

  $data['languests']['money'] = $cs_languests['languests_money'];
  $data['languests']['paytime'] = cs_dateselect('pay','unix',$cs_languests['languests_paytime']);
  $data['languests']['notice'] = $cs_languests['languests_notice'];

  
  echo cs_subtemplate(__FILE__,$data,'languests','create');
}
else {

  $languests_cells = array_keys($cs_languests);
  $languests_save = array_values($cs_languests);
  cs_sql_insert(__FILE__,'languests',$languests_cells,$languests_save);
	
  cs_redirect($cs_lang['create_done'],'languests');
}
?>