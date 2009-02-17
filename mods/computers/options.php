<?php
// ClanSphere 2008 - www.clansphere.net
// Id: options.php (Tue Nov 25 18:09:38 CET 2008) fAY-pA!N

$cs_lang = cs_translate('computers');

$op_computers = cs_sql_option(__FILE__,'computers');

if(isset($_POST['submit'])) {

  settype($_POST['max_width'],'integer');
  settype($_POST['max_height'],'integer');
  settype($_POST['max_size'],'integer');

  $opt_where = "options_mod = 'computers' AND options_name = ";
  $def_cell = array('options_value');
  $def_cont = array($_POST['max_width']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_width'");
  $def_cont = array($_POST['max_height']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_height'");
  $def_cont = array($_POST['max_size']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_size'");

  cs_redirect($cs_lang['changes_done'],'computers','options');
}
else {
  
  $data['head']['getmsg'] = cs_getmsg();
  
  $data['com']['max_width'] = $op_computers['max_width'];
  $data['com']['max_height'] = $op_computers['max_height'];
  $data['com']['max_size'] = $op_computers['max_size'];

  echo cs_subtemplate(__FILE__,$data,'computers','options');

}

?>