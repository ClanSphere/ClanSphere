<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanpartys');

$op_lanpartys = cs_sql_option(__FILE__,'lanpartys');

if(isset($_POST['submit'])) {
  settype($_POST['max_width'],'integer');
  settype($_POST['max_height'],'integer');
  settype($_POST['max_size'],'integer');

  $opt_where = "options_mod = 'lanpartys' AND options_name = ";
  $def_cell = array('options_value');
  $def_cont = array($_POST['max_width']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_width'");
  $def_cont = array($_POST['max_height']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_height'");
  $def_cont = array($_POST['max_size']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_size'");

  cs_redirect($cs_lang['changes_done'],'lanpartys','options');
}
else {
  $data['url']['form']= cs_url('lanpartys','options');
  $data['lanpartys']['max_width'] = $op_lanpartys['max_width'];
  $data['lanpartys']['max_height'] = $op_lanpartys['max_height'];
  $data['lanpartys']['max_size'] = $op_lanpartys['max_size'];
  $data['lang']['getmsg'] = cs_getmsg();
  
  echo cs_subtemplate(__FILE__,$data,'lanpartys','options');
}
?>