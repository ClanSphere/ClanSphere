<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('banners');

$op_banners = cs_sql_option(__FILE__,'banners');

if(isset($_POST['submit'])) {

  require_once 'mods/clansphere/func_options.php';

  $save = array();
  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];
  $save['def_order'] = (int) $_POST['def_order'];
  $save['max_navlist'] = (int) $_POST['max_navlist'];
  $save['max_navright'] = (int) $_POST['max_navright'];

  cs_optionsave('banners', $save);

  cs_redirect($cs_lang['success'],  'options', 'roots');
}
else {

  $data['lang']['getmsg'] = cs_getmsg();
  $data['action']['form'] = cs_url('banners','options');
  $data['options']['max_width'] = $op_banners['max_width'];
  $data['options']['max_height'] = $op_banners['max_height'];
  $data['options']['max_size'] = $op_banners['max_size'];
  $data['options']['def_order'] = $op_banners['def_order'];
  $data['options']['max_navlist'] = $op_banners['max_navlist'];
  $data['options']['max_navright'] = $op_banners['max_navright'];

  echo cs_subtemplate(__FILE__,$data,'banners','options');
}