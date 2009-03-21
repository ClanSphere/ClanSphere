<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('categories');
$data = array();

$op_categories = cs_sql_option(__FILE__,'categories');

if(isset($_POST['submit'])) {
  
  require('mods/clansphere/func_options.php');
  $save = array();
  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];
  $save['def_mod'] = $_POST['def_mod'];
  cs_optionsave('categories', $save);

  cs_redirect($cs_lang['changes_done'],'categories','options');
}
else {
  $data['head']['getmsg'] = cs_getmsg();
  
  $data['op']['max_width'] = $op_categories['max_width'];
  $data['op']['max_height'] = $op_categories['max_height'];
  $data['op']['max_size'] = $op_categories['max_size'];

  $modules = cs_checkdirs('mods');
  $run = 0;
  foreach($modules as $mods) {
    if(!empty($mods['categories'])) {
        $mods['dir'] == $op_categories['def_mod'] ? $sel = 1 : $sel = 0;
        $data['mod'][$run]['sel'] = cs_html_option($mods['name'],$mods['dir'],$sel);
      $run++;
    }
  }

  echo cs_subtemplate(__FILE__,$data,'categories','options');
}
?>