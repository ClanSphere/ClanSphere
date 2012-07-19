<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

include_once 'mods/explorer/functions.php';

$target = empty($_REQUEST['dir']) ? '' : $_REQUEST['dir'];
$target = empty($_POST['data_folder']) ? $target : $_POST['data_folder'];
$dir = cs_explorer_path($target, 'raw');
$lsd = cs_explorer_path($dir, 'escape');

if(empty($_POST['submit'])) {

  $data = array();
  $data['var']['dir'] = $dir;

  echo cs_subtemplate(__FILE__, $data, 'explorer', 'create_dir');
}
else {

  if (substr($dir,-1,1) != '/' && !empty($dir)) $dir .= '/';

  $dir_created = str_replace('..','',$dir . $_POST['folder_name']);

  $message = mkdir($dir_created, 0755) ? $cs_lang['success'] : $cs_lang['error'];

  cs_redirect($message,'explorer','roots','dir=' . $lsd);
}