<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

if(isset($_POST['submit'])) {

  settype($_POST['max_width'],'integer');
  settype($_POST['max_height'],'integer');
  settype($_POST['max_size'],'integer');

  $opt_where = "options_mod = 'events' AND options_name = ";
  $def_cell = array('options_value');
  $def_cont = array($_POST['max_width']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_width'");
  $def_cont = array($_POST['max_height']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_height'");
  $def_cont = array($_POST['max_size']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'max_size'");
  $def_cont = array(empty($_POST['show_wars']) ? 0 : 1);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'show_wars'");
  $def_cont = array(empty($_POST['req_fullname']) ? 0 : 1);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'req_fullname'");
  $def_cont = array(empty($_POST['req_fulladress']) ? 0 : 1);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'req_fulladress'");
  $def_cont = array(empty($_POST['req_phone']) ? 0 : 1);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'req_phone'");
  $def_cont = array(empty($_POST['req_mobile']) ? 0 : 1);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'req_mobile'");
  
  cs_redirect($cs_lang['changes_done'],'events','options');
}
else {

  $data = array();

  $data['op'] = cs_sql_option(__FILE__,'events');

  $data['lang']['getmsg'] = cs_getmsg();

  $checked = ' checked="checked"';
  $data['checked']['show_wars'] = !empty($data['op']['show_wars']) ? $checked : '';
  $data['checked']['req_fullname'] = !empty($data['op']['req_fullname']) ? $checked : '';
  $data['checked']['req_fulladress'] = !empty($data['op']['req_fulladress']) ? $checked : '';
  $data['checked']['req_phone'] = !empty($data['op']['req_phone']) ? $checked : '';
  $data['checked']['req_mobile'] = !empty($data['op']['req_mobile']) ? $checked : '';
  
  echo cs_subtemplate(__FILE__,$data,'events','options');
}

?>