<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanvotes');

if(isset($_POST['submit'])) {

  $cs_lanvotes['lanpartys_id'] = $_POST['lanpartys_id'];
  $cs_lanvotes['lanvotes_status'] = $_POST['lanvotes_status'];
  $cs_lanvotes['lanvotes_start'] = cs_datepost('start','unix');
  $cs_lanvotes['lanvotes_end'] = cs_datepost('end','unix');
  $cs_lanvotes['lanvotes_question'] = $_POST['lanvotes_question'];
	$cs_lanvotes['lanvotes_election'] = $_POST['lanvotes_election'];

  $error = 0;
  $errormsg = '';

  if(empty($cs_lanvotes['lanpartys_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_lanparty'] . cs_html_br(1);
  }
  else {
  	$where = "lanpartys_id = '" . cs_sql_escape($cs_lanvotes['lanpartys_id']) . "' AND ";
  	$where .= "lanvotes_question = '" . cs_sql_escape($cs_lanvotes['lanvotes_question']) . "'";
  	$search_collision = cs_sql_count(__FILE__,'lanvotes',$where);
  	if(!empty($search_collision)) {
    	$error++;
    	$errormsg .= $cs_lang['question_lan_exists'] . cs_html_br(1);
  	}
  }

  if(empty($cs_lanvotes['lanvotes_start'])) {
    $error++;
    $errormsg .= $cs_lang['no_start'] . cs_html_br(1);
  }
  
  if(empty($cs_lanvotes['lanvotes_end'])) {
    $error++;
    $errormsg .= $cs_lang['no_end'] . cs_html_br(1);
  }
  elseif($cs_lanvotes['lanvotes_start'] >= $cs_lanvotes['lanvotes_end']) {
    $error++;
    $errormsg .= $cs_lang['wrong_times'] . cs_html_br(1);
  }

  if(empty($cs_lanvotes['lanvotes_question'])) {
    $error++;
    $errormsg .= $cs_lang['no_question'] . cs_html_br(1);
  }
  
  if(empty($cs_lanvotes['lanvotes_election'])) {
    $error++;
    $errormsg .= $cs_lang['no_election'] . cs_html_br(1);
  }
}
else {
  $cs_lanvotes['lanpartys_id'] = 0;
  $cs_lanvotes['lanvotes_status'] = 0;
  $cs_lanvotes['lanvotes_start'] = cs_time();
  $cs_lanvotes['lanvotes_end'] = cs_time();
  $cs_lanvotes['lanvotes_question'] = '';
	$cs_lanvotes['lanvotes_election'] = '';
}

if(!isset($_POST['submit'])) {
  $data['lang']['body'] = $cs_lang['body_create'];
}

if(!empty($error)) {
  $data['lang']['body'] = $errormsg;
}


if(!empty($error) OR !isset($_POST['submit'])) {
  $data['url']['form'] = cs_url('lanvotes','create');

  $lan_data = cs_sql_select(__FILE__,'lanpartys','lanpartys_name, lanpartys_id',0,'lanpartys_name',0,0);
  $lanpartys_data_loop = count($lan_data);

  if(empty($lanpartys_data_loop)) {
    $data['lanvotes'] = '';
  }

  for($run=0; $run<$lanpartys_data_loop; $run++) {
    $data['lanpartys'][$run]['id'] = $lan_data[$run]['lanpartys_id'];
    $data['lanpartys'][$run]['name'] = $lan_data[$run]['lanpartys_name'];
  }

  $sel = array(1 => 0,3 => 0,4 => 0,5 => 0);
  if(isset($_POST['submit'])) {
    $cs_lanvotes['lanvotes_status'] == 3 ? $sel[3] = 1 : $sel[3] = 0;
    $cs_lanvotes['lanvotes_status'] == 4 ? $sel[4] = 1 : $sel[4] = 0;
    $cs_lanvotes['lanvotes_status'] == 5 ? $sel[5] = 1 : $sel[5] = 0;
  }
  $data['lang']['status_1'] = cs_html_option($cs_lang['status_1'],1,0);
  $data['lang']['status_3'] = cs_html_option($cs_lang['status_3'],3,$sel[3]);
  $data['lang']['status_4'] = cs_html_option($cs_lang['status_4'],4,$sel[4]);
  $data['lang']['status_5'] = cs_html_option($cs_lang['status_5'],5,$sel[5]);

  $data['lanvotes']['start'] = cs_dateselect('start','unix',$cs_lanvotes['lanvotes_start']);
  $data['lanvotes']['end'] = cs_dateselect('end','unix',$cs_lanvotes['lanvotes_end']);
  $data['lanvotes']['question'] = $cs_lanvotes['lanvotes_question'];
  $data['lanvotes']['election'] = $cs_lanvotes['lanvotes_election'];
  
  echo cs_subtemplate(__FILE__,$data,'lanvotes','create');
}
else {

  $cs_lanvotes['lanvotes_since'] = cs_time();

  $lanvotes_cells = array_keys($cs_lanvotes);
  $lanvotes_save = array_values($cs_lanvotes);
  cs_sql_insert(__FILE__,'lanvotes',$lanvotes_cells,$lanvotes_save);
  
  cs_redirect($cs_lang['create_done'],'lanvotes');
}
?>