<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('squads');
$data = array();

$op_squads = cs_sql_option(__FILE__,'squads');

$data['head']['mod'] = $cs_lang[$op_squads['label'].'s'];
$data['head']['getmsg'] = cs_getmsg();

if(isset($_POST['submit'])) {

  settype($_POST['max_width'],'integer');
  settype($_POST['max_height'],'integer');
  settype($_POST['max_size'],'integer');
  settype($_POST['def_order'],'integer');

  $opt_where = "options_mod = 'squads' AND options_name = ";
  $def_cell = array('options_value');
  $def_cont = array($_POST['max_width']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_width'");
  $def_cont = array($_POST['max_height']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_height'");
  $def_cont = array($_POST['max_size']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_size'");
  $def_cont = array($_POST['def_order']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_order'");
  $def_cont = array($_POST['label']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'label'");

  cs_redirect($cs_lang['changes_done'],'squads','options');
}
else {

  $sel = 'selected="selected"';
  $data['op']['squad'] = '';
  $data['op']['group'] = '';
  $data['op']['section'] = '';
  $data['op']['team'] = '';
  $data['op']['class'] = '';

  if($op_squads['label'] == 'squad') {
    $data['op']['squad'] = $sel;
  }
  if($op_squads['label'] == 'group') {
    $data['op']['group'] = $sel;
  }
  if($op_squads['label'] == 'section') {
    $data['op']['section'] = $sel;
  }
  if($op_squads['label'] == 'team') {
    $data['op']['team'] = $sel;
  }
  if($op_squads['label'] == 'class') {
    $data['op']['class'] = $sel;
  }

  $data['op']['max_width'] = $op_squads['max_width'];
  $data['op']['max_height'] = $op_squads['max_height'];
  $data['op']['max_size'] = $op_squads['max_size'];
  $data['op']['def_order'] = $op_squads['def_order'];
  
  echo cs_subtemplate(__FILE__,$data,'squads','options');
}

?>