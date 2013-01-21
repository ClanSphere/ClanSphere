<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

include_once 'mods/explorer/functions.php';

$dir = cs_explorer_path($_REQUEST['file'], 'raw');
$lsd = cs_explorer_path($dir, 'escape');
$red_lsd = cs_explorer_path($dir, 'escape', 1);

if(empty($_POST['submit']) && empty($_POST['cancel'])) {

  if(empty($dir)) {
    cs_redirect($cs_lang['no_file'], 'explorer','roots') ;
  } elseif(!file_exists($cs_main['def_path'] . '/' . $dir)) {
    cs_redirect($cs_lang['not_found'] . ': ' . $dir, 'explorer','roots') ;
  } else {

    $data = array();
    $data['lang']['really_delete'] = sprintf($cs_lang['really_delete'],$dir);
    $data['var']['source'] = $lsd;
    
    echo cs_subtemplate(__FILE__, $data, 'explorer', 'remove');
  }

} elseif (!empty($_POST['cancel'])) {

  cs_redirect($cs_lang['del_false'], 'explorer','roots','dir=' . $red_lsd) ;
  
} else {
  
  if (is_dir($cs_main['def_path'] . '/' . $dir)) {

    cs_remove_dir($dir);
    $message = !is_dir($cs_main['def_path'] . '/' . $dir) ? $cs_lang['dir_removed'] : $cs_lang['dir_error'];
    
  } else { 
    $message = unlink($cs_main['def_path'] . '/' . $dir) ? $cs_lang['file_removed'] : $cs_lang['file_remove_error'];
  }
  
  cs_redirect($message, 'explorer','roots','dir=' . $red_lsd);
}