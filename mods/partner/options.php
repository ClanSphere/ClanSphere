<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('partner');

$op_partner = cs_sql_option(__FILE__,'partner');

$data = array();

if (!empty($_POST['submit'])) {
  
  // Check for wrong input
  
  $error = '';
  
}

if (empty($_POST['submit']) || !empty($error)) {
	$sel = 'selected="selected"';
	if($op_partner['method'] == 'random') { $data['sel']['random'] = $sel; } else { $data['sel']['random'] = ''; }
	if($op_partner['method'] == 'rotation') { $data['sel']['rotation'] = $sel; } else { $data['sel']['rotation'] = ''; }
	
	$data['partner']['def_width_navimg'] = $op_partner['def_width_navimg'];
	$data['partner']['def_height_navimg'] = $op_partner['def_height_navimg'];
	$data['partner']['max_size_navimg'] = $op_partner['max_size_navimg'];
	
	$data['partner']['def_width_listimg'] = $op_partner['def_width_listimg'];
	$data['partner']['def_height_listimg'] = $op_partner['def_height_listimg'];
	$data['partner']['max_size_listimg'] = $op_partner['max_size_listimg'];
	
	$data['partner']['def_width_rotimg'] = $op_partner['def_width_rotimg'];
	$data['partner']['def_height_rotimg'] = $op_partner['def_height_rotimg'];
	$data['partner']['max_size_rotimg'] = $op_partner['max_size_rotimg'];
	
	$data['head']['body_text'] = empty($error) ? $cs_lang['errors_here'] : $error;
	echo cs_subtemplate(__FILE__,$data,'partner','options');
	
}
else 
{
	settype($_POST['def_width_navimg'],'integer');
	settype($_POST['def_height_navimg'],'integer');
	settype($_POST['max_size_navimg'],'integer');
	
	settype($_POST['def_width_listimg'],'integer');
	settype($_POST['def_height_listimg'],'integer');
	settype($_POST['max_size_listimg'],'integer');
	
	settype($_POST['def_width_rotimg'],'integer');
	settype($_POST['def_height_rotimg'],'integer');
	settype($_POST['max_size_rotimg'],'integer');

  $opt_where = "options_mod = 'partner' AND options_name = ";
  $def_cell = array('options_value');
  
  $def_cont = array($_POST['def_width_navimg']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_width_navimg'");
  $def_cont = array($_POST['def_height_navimg']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_height_navimg'");
  $def_cont = array($_POST['max_size_navimg']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_size_navimg'");
  
  $def_cont = array($_POST['def_width_listimg']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_width_listimg'");
  $def_cont = array($_POST['def_height_listimg']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_height_listimg'");
  $def_cont = array($_POST['max_size_listimg']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_size_listimg'");
  
  $def_cont = array($_POST['def_width_rotimg']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_width_rotimg'");
  $def_cont = array($_POST['def_height_rotimg']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_height_rotimg'");
  $def_cont = array($_POST['max_size_rotimg']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_size_rotimg'");
  
  $def_cont = array($_POST['method']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'method'");
  
  $data['done']['link'] = cs_url('options','roots');
  $data['done']['action'] = $cs_lang['create'];
  $data['done']['message'] = $cs_lang['success'];
  echo cs_subtemplate(__FILE__,$data,'partner','done');
}



?>