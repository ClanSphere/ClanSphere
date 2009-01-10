<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clans');

$op_clans = cs_sql_option(__FILE__,'clans');

if(isset($_POST['submit'])) {
  settype($_POST['max_width'],'integer');
  settype($_POST['max_height'],'integer');
  settype($_POST['max_size'],'integer');

  $opt_where = "options_mod = 'clans' AND options_name = ";
  $def_cell = array('options_value');
  $def_cont = array($_POST['max_width']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_width'");
  $def_cont = array($_POST['max_height']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_height'");
  $def_cont = array($_POST['max_size']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_size'");
  $def_cont = array($_POST['label']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'label'");
	
  cs_redirect($cs_lang['changes_done'],'clans','options');
}
else {
  $data['lang']['getmsg'] = cs_getmsg();
  $data['url']['form'] = cs_url('clans','options');
  $data['lang']['mod'] = $cs_lang[$op_clans['label']];
  
  if($op_clans['label'] == 'clan') {
    $data['clans']['clan'] = 'selected="selected"';
  }
  else {
    $data['clans']['clan'] = '';
  }
  
  if($op_clans['label'] == 'association') {
    $data['clans']['association'] = 'selected="selected"';
  }
  else {
    $data['clans']['association'] = '';
  }
  
  if($op_clans['label'] == 'club') {
    $data['clans']['club'] = 'selected="selected"';
  }
  else {
    $data['clans']['club'] = '';
  }
  
  if($op_clans['label'] == 'guild') {
    $data['clans']['guild'] = 'selected="selected"';
  }
  else {
    $data['clans']['guild'] = '';
  }
  
  if($op_clans['label'] == 'enterprise') {
    $data['clans']['enterprise'] = 'selected="selected"';
  }
  else {
    $data['clans']['enterprise'] = '';
  }
  
  if($op_clans['label'] == 'school') {
    $data['clans']['school'] = 'selected';
  }
  else {
    $data['clans']['school'] = '';
  }
  
  $data['clans']['max_width'] = $op_clans['max_width'];
  $data['clans']['max_height'] = $op_clans['max_height'];
  $data['clans']['max_size'] = $op_clans['max_size'];
	
  echo cs_subtemplate(__FILE__,$data,'clans','options');
}
?>