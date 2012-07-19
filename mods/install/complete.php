<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

# clear cache data to prevent errors
cs_cache_clear();

function cs_set_env($dir) {

  $error = 0;
  $dir = $dir . '/';
  $dh = opendir($dir);

  while (false !== ($filename = readdir($dh))) {
    if($filename != '.' AND $filename != '..') {
      $nextcheck = $dir . $filename;
      @chmod($dir,0777) OR $error++;
    }
  }
  closedir($dh);
  empty($error) ? $result = true : $result = false;
  return $result;
}

$set_uploads = cs_set_env('uploads');

$data = array();

$data['errors']['show'] = '';

# do not delete files in development environments
if(!is_dir('.git')) {

  if(!unlink('uninstall.sql')) $data['errors']['show'] .= $cs_lang['remove_file'] . " 'uninstall.sql'" . cs_html_br(1);
  if(!unlink('install.sql'))   $data['errors']['show'] .=  $cs_lang['remove_file'] . " 'install.sql'" . cs_html_br(1);
  if(!unlink('install.php'))   $data['errors']['show'] .=  $cs_lang['remove_file'] . " 'install.php'" . cs_html_br(1);
}

if(empty($set_logs) OR empty($set_uploads) OR empty($set_cache)) $data['errors']['show'] .=  $cs_lang['err_chmod'];

echo cs_subtemplate(__FILE__, $data, 'install', 'complete');