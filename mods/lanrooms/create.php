<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanrooms');

if(isset($_POST['submit'])) {

  $cs_lanrooms['lanpartys_id'] = $_POST['lanpartys_id'];
  $cs_lanrooms['lanrooms_name'] = $_POST['lanrooms_name'];

  $error = 0;
  $errormsg = '';

  if(empty($cs_lanrooms['lanpartys_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_lanparty'] . cs_html_br(1);
  }
  else {
  	$where = "lanpartys_id = '" . cs_sql_escape($cs_lanrooms['lanpartys_id']) . "' AND ";
  	$where .= "lanrooms_name = '" . cs_sql_escape($cs_lanrooms['lanrooms_name']) . "'";
  	$search_collision = cs_sql_count(__FILE__,'lanrooms',$where);
  	if(!empty($search_collision)) {
    	$error++;
    	$errormsg .= $cs_lang['name_lan_exists'] . cs_html_br(1);
  	}
  }

  if(empty($cs_lanrooms['lanrooms_name'])) {
    $error++;
    $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
  }
}
else {
  $cs_lanrooms['lanpartys_id'] = 0;
  $cs_lanrooms['lanrooms_name'] = '';
}


if(!isset($_POST['submit'])) {
  $data['lang']['body'] = $cs_lang['body_create'];
}

if(!empty($error)) {
  $data['lang']['body'] = $errormsg;
}


if(!empty($error) OR !isset($_POST['submit'])) {
  $data['url']['form'] = cs_url('lanrooms','create');
  
  $lan_data = cs_sql_select(__FILE__,'lanpartys','lanpartys_name, lanpartys_id',0,'lanpartys_name',0,0);
  $lan_data_loop = count($lan_data);

  if(empty($lan_data_loop)) {
    $data['lan'] = '';
  }

  for($run=0; $run<$lan_data_loop; $run++) {
    $data['lan'][$run]['id'] = $lan_data[$run]['lanpartys_id'];
    $data['lan'][$run]['name'] = $lan_data[$run]['lanpartys_name'];
  }

  $data['lanroom']['name'] = $cs_lanrooms['lanrooms_name'];

  echo cs_subtemplate(__FILE__,$data,'lanrooms','create');
}
else {
  $lanrooms_cells = array_keys($cs_lanrooms);
  $lanrooms_save = array_values($cs_lanrooms);
  cs_sql_insert(__FILE__,'lanrooms',$lanrooms_cells,$lanrooms_save);
	
  cs_redirect($cs_lang['create_done'],'lanrooms');
}
?>