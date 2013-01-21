<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

require_once 'mods/clansphere/func_options.php';

$data = array();
$i = 0;
$modules = cs_checkdirs('mods');
if(isset($_POST['submit'])) {
  foreach ($modules AS $mod) {
    if(isset($mod['navlist'])) {
      if(isset($_POST[$mod['tables'][0]])) {
        foreach($mod['navlist'] AS $navlist) {
          $save = array();
          $save[$navlist] = $_POST[$mod['tables'][0]][$navlist];
          if(empty($save[$navlist])) {
            $save[$navlist] = 0;
          }
          cs_optionsave($mod['tables'][0], $save);
        }
      }
    }
  }
  global $cs_lang;
  cs_redirect($cs_lang['success'], 'options', 'roots');
}
else {
  foreach ($modules AS $mod) {
    if(isset($mod['navlist'])) {
      $cs_lang = cs_translate($mod['dir']);
      $cs_option = cs_sql_option(__FILE__,$mod['tables'][0]);
      $data['mods'][$i]['mod'] = $mod['name'];
      $a =0;
      foreach($mod['navlist'] AS $navlist) {
        $data['mods'][$i]['navlist'][$a]['type'] =   $cs_lang[$navlist];
        $data['mods'][$i]['navlist'][$a]['value'] = $cs_option[$navlist];
        $data['mods'][$i]['navlist'][$a]['ivalue'] = $mod['tables'][0] . '[' . $navlist . ']';
        $a++;
      }
      $i++;
    }
  }
}

echo cs_subtemplate(__FILE__,$data,'modules','options');