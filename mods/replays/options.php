<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('replays');

if(isset($_POST['submit'])) {  
  
  $save = array();
  $save['file_size'] = (int) $_POST['file_size'] * 1024;
  $save['file_type'] = $_POST['file_type'];
  
  require 'mods/clansphere/func_options.php';
  
  cs_optionsave('replays', $save);
  
  cs_redirect($cs_lang['changes_done'],'options','roots');

} else {
  
  $data = array();
  $data['op'] = cs_sql_option(__FILE__,'replays');
  
  $data['op']['filesize'] = round($data['op']['file_size'] / 1024);

  echo cs_subtemplate(__FILE__,$data,'replays','options');
}

?>