<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

if(empty($_POST['submit']) && empty($_POST['cancel'])) {
  
	if (!empty($cs_main['mod_rewrite'])) $_GET['file'] = substr($_GET['params'], strpos($_GET['params'], 'explorer/remove/file/')+21);
  $source = str_replace('..','',$_GET['file']);

  if(empty($source)) {
    cs_redirect($cs_lang['no_file'], 'explorer','roots') ;
  } elseif(!file_exists($source)) {
    cs_redirect($cs_lang['not_found'] . ': ' . $source, 'explorer','roots') ;
  } else {
    
    $data = array();
    $data['lang']['really_delete'] = sprintf($cs_lang['really_delete'],$source);
    $data['var']['source'] = $source;
    
    echo cs_subtemplate(__FILE__, $data, 'explorer', 'remove');
  }

} elseif (!empty($_POST['cancel'])) {
  
  $dir = substr($_POST['file'], 0, strrpos($_POST['file'],'/'));
  
  cs_redirect($cs_lang['del_false'], 'explorer','roots','dir=' . $dir) ;
  
} else {
  
  $file = str_replace('..','',$_POST['file']);
  $dir = substr($file, 0, strrpos($file,'/'));
  
  if (is_dir($file)) {
    
    include_once 'mods/explorer/functions.php';
    
    cs_remove_dir($file);
    $message = !is_dir($file) ? $cs_lang['dir_removed'] : $cs_lang['dir_error'];
    
  } else { 
    $message = unlink($file) ? $cs_lang['file_removed'] : $cs_lang['file_remove_error'];
  }
  
  cs_redirect($message, 'explorer','roots','dir=' . $dir);
}

?>