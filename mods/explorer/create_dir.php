<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

if(empty($_POST['submit'])) {
  
	if (!empty($cs_main['mod_rewrite'])) $_GET['dir'] = substr($_GET['dir'],4);
	$dir = (empty($_GET['dir']) or $_GET['dir'] == '.') ? '' : str_replace('..','',$_GET['dir']);
	
  $data = array();
  $data['var']['dir'] = $dir;
  
  echo cs_subtemplate(__FILE__, $data, 'explorer', 'create_dir');
  
} else {
  
  $dir = $_POST['data_folder'];
  if (substr($dir,-1,1) != '/' && !empty($dir)) $dir .= '/';
  
  $dir_created = str_replace('..','',$dir . $_POST['folder_name']);
  
  $message = mkdir($dir_created, 0755) ? $cs_lang['success'] : $cs_lang['error'];
  
  cs_redirect($message,'explorer','roots','dir=' . $dir);

}

?>