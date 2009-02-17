<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('replays');

$cs_replays = cs_sql_option(__FILE__,'replays');

if(isset($_POST['submit'])) {  
  $filesize = (int) $_POST['file_size'] * 1024;
  $opt_where = 'options_mod=\'replays\' AND options_name=';
  $def_cell = array('options_value');  
  $def_cont = array($filesize);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'file_size\'');
  $def_cont = array($_POST['file_type']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . '\'file_type\'');
  
  cs_redirect($cs_lang['changes_done'],'replays','options');
}
else {
  $data['head']['getmsg'] = cs_getmsg();
  
  $size = round($cs_replays['file_size'] / 1024);
  $data['op']['filesize'] = $size;
  $data['op']['filetypes'] = $cs_replays['file_type'];

  echo cs_subtemplate(__FILE__,$data,'replays','options');
}

?>