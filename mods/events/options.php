<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$data = array();

if (!empty($_POST['submit'])) {
  $error = '';
  // Check for errors
}

if (empty($_POST['submit']) || !empty($error)) {
  $op_events = cs_sql_option(__FILE__,'events');
  
  $data['lang']['getmsg'] = cs_getmsg();
  $checked = ' checked="checked"';
  $data['checked']['show_wars'] = !empty($op_events['show_wars']) ? $checked : '';
  
  echo cs_subtemplate(__FILE__,$data,'events','options');
}

if (!empty($_POST['submit']) && empty($error)) {
  
  $opt_where = "options_mod = 'events' AND options_name = ";
  $def_cell = array('options_value');
  
  $def_cont = array(empty($_POST['show_wars']) ? 0 : 1);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'show_wars'");
  
  cs_redirect($cs_lang['changes_done'],'events','options'); 
}

?>