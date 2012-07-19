<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('categories');

if (isset($_POST['submit'])) {
  
  require_once 'mods/clansphere/func_options.php';
  
  $save = array();
  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];
  $save['def_mod'] = $_POST['def_mod'];
  
  cs_optionsave('categories', $save);

  cs_redirect($cs_lang['changes_done'], 'options', 'roots');
  
} else {
  
  $data = array();
  $data['op'] = cs_sql_option(__FILE__,'categories');
  $data['head']['getmsg'] = cs_getmsg();

  $modules = cs_checkdirs('mods');
  $run = 0;
  foreach($modules as $mods) {
    if(!empty($mods['categories'])) {
        $mods['dir'] == $data['op']['def_mod'] ? $sel = 1 : $sel = 0;
        $data['mod'][$run]['sel'] = cs_html_option($mods['name'],$mods['dir'],$sel);
      $run++;
    }
  }

  echo cs_subtemplate(__FILE__,$data,'categories','options');
}