<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('banners');

$op_banners = cs_sql_option(__FILE__,'banners');

if(isset($_POST['submit'])) {
  
  require 'mods/clansphere/func_options.php';
  
  $save = array();
  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];
  $save['def_order'] = (int) $_POST['def_order'];
  
  cs_optionsave('banners', $save);
  
  cs_redirect($cs_lang['success'],  'options', 'roots');
  
} else {
  
  $data['lang']['getmsg'] = cs_getmsg();
  $data['action']['form'] = cs_url('banners','options');
  $data['options']['max_width'] = $op_banners['max_width'];
  $data['options']['max_height'] = $op_banners['max_height'];
  $data['options']['max_size'] = $op_banners['max_size'];
  $data['options']['def_order'] = $op_banners['def_order'];
  
  echo cs_subtemplate(__FILE__,$data,'banners','options');
  
}

?>