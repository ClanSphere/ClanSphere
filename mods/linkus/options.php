<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('linkus');

$op_linkus = cs_sql_option(__FILE__,'linkus');

if(isset($_POST['submit'])) {  
  
  require_once 'mods/clansphere/func_options.php';
  
  $save = array();
  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];
  
  cs_optionsave('linkus', $save);

  cs_redirect($cs_lang['success'], 'options','roots');
  
} else {
  
  $data['lang']['getmsg'] = cs_getmsg();
  $data['action']['form'] = cs_url('linkus','options');
  $data['options']['max_width'] = $op_linkus['max_width'];
  $data['options']['max_height'] = $op_linkus['max_height'];
  $data['options']['max_size'] = $op_linkus['max_size'];
  
  echo cs_subtemplate(__FILE__,$data,'linkus','options');
  
}