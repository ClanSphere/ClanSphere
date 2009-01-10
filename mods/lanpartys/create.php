<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanpartys');

if(isset($_POST['submit'])) {
  $cs_lanpartys['lanpartys_name'] = $_POST['lanpartys_name'];
  $cs_lanpartys['lanpartys_url'] = $_POST['lanpartys_url'];
  $cs_lanpartys['lanpartys_maxguests'] = $_POST['lanpartys_maxguests'];
  $cs_lanpartys['lanpartys_money'] = $_POST['lanpartys_money'];
  $cs_lanpartys['lanpartys_needage'] = $_POST['lanpartys_needage'];
  $cs_lanpartys['lanpartys_location'] = $_POST['lanpartys_location'];
  $cs_lanpartys['lanpartys_adress'] = $_POST['lanpartys_adress'];
  $cs_lanpartys['lanpartys_postalcode'] = $_POST['lanpartys_postalcode'];
  $cs_lanpartys['lanpartys_place'] = $_POST['lanpartys_place'];
  $cs_lanpartys['lanpartys_bankaccount'] = $_POST['lanpartys_bankaccount'];
  $cs_lanpartys['lanpartys_network'] = $_POST['lanpartys_network'];
  $cs_lanpartys['lanpartys_tournaments'] = $_POST['lanpartys_tournaments'];
  $cs_lanpartys['lanpartys_features'] = $_POST['lanpartys_features'];
  $cs_lanpartys['lanpartys_more'] = $_POST['lanpartys_more'];
  $cs_lanpartys['lanpartys_start'] = cs_datepost('start','unix');
  $cs_lanpartys['lanpartys_end'] = cs_datepost('end','unix');

  $error = 0;
  $errormsg = '';
	
  if(empty($cs_lanpartys['lanpartys_name'])) {
    $error++;
    $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
  }

  $where = "lanpartys_name = '" . cs_sql_escape($cs_lanpartys['lanpartys_name']) . "'";
  $search = cs_sql_count(__FILE__,'lanpartys',$where);
  
  if(!empty($search)) {
    $error++;
    $errormsg .= $cs_lang['lanparty_exists'] . cs_html_br(1);
  }
}
else {
  $cs_lanpartys['lanpartys_name'] = '';
  $cs_lanpartys['lanpartys_url'] = '';
  $cs_lanpartys['lanpartys_start'] = cs_time();
  $cs_lanpartys['lanpartys_end'] = cs_time();
  $cs_lanpartys['lanpartys_maxguests'] = '';
  $cs_lanpartys['lanpartys_money'] = '';
  $cs_lanpartys['lanpartys_needage'] = 16;
  $cs_lanpartys['lanpartys_location'] = '';
  $cs_lanpartys['lanpartys_adress'] = '';
  $cs_lanpartys['lanpartys_postalcode'] = '';
  $cs_lanpartys['lanpartys_place'] = '';
  $cs_lanpartys['lanpartys_bankaccount'] = '';
  $cs_lanpartys['lanpartys_network'] = '';
  $cs_lanpartys['lanpartys_tournaments'] = '';
  $cs_lanpartys['lanpartys_features'] = '';
  $cs_lanpartys['lanpartys_more'] = '';
}


if(!isset($_POST['submit'])) {
  $data['lang']['body'] = $cs_lang['body_create'];
}

if(!empty($error)) {
  $data['lang']['body'] = $errormsg;
}

if(!empty($error) OR !isset($_POST['submit'])) {
  $data['url']['form'] = cs_url('lanpartys','create');
  
  $data['lanpartys']['start'] = cs_dateselect('start','unix',$cs_lanpartys['lanpartys_start']);
  $data['lanpartys']['end'] = cs_dateselect('end','unix',$cs_lanpartys['lanpartys_end']);
  $data['lanpartys']['abcode_bankaccount'] = cs_abcode_features('lanpartys_bankaccount');
  $data['lanpartys']['abcode_network'] = cs_abcode_features('lanpartys_network');
  $data['lanpartys']['abcode_tournaments'] = cs_abcode_features('lanpartys_tournaments');
  $data['lanpartys']['abcode_features'] = cs_abcode_features('lanpartys_features');
  $data['lanpartys']['abcode_more'] = cs_abcode_features('lanpartys_more');
  
  echo cs_subtemplate(__FILE__,$data,'lanpartys','create');
}
else {
  settype($cs_lanpartys['lanpartys_maxguests'],'integer');
  $cs_lanpartys['lanpartys_pictures'] = '';

  $lanpartys_cells = array_keys($cs_lanpartys);
  $lanpartys_save = array_values($cs_lanpartys);
  cs_sql_insert(__FILE__,'lanpartys',$lanpartys_cells,$lanpartys_save);

	
  cs_redirect($cs_lang['create_done'],'lanpartys');
}
?>