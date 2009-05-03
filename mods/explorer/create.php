<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

if(empty($_POST['submit'])) {
  
  include_once 'mods/explorer/abcode.php';
  $data = array();
  
  $data['var']['dir'] = empty($_GET['dir']) || $_GET['dir'] == '.' ? '' : str_replace('..','',$_GET['dir']);
  
  $data['abcode']['tools'] = cs_abcode_tools('data_content');
  $data['abcode']['html1'] = cs_abcode_toolshtml('data_content');
  $data['abcode']['sql'] = cs_abcode_sql('data_content');
  $data['abcode']['js'] = cs_abcode_js('data_content');
  $data['abcode']['html2'] = cs_abcode_toolshtml2('data_content');
  
  echo cs_subtemplate(__FILE__, $data, 'explorer', 'create');
  
} else {
  
  $dir = str_replace('..','',$_POST['data_folder']);
  
  if (substr($dir,-1) != '/' && !empty($dir))
    $dir .= '/';
  
  $filename = empty($_POST['data_name']) ? 'unnamed' : str_replace('..', '', $_POST['data_name']);
  $file = $dir . $filename;
  $ending = !empty($_POST['data_type']) ? str_replace('..','',$_POST['data_type']) : '';
  
  if (empty($ending) && strpos($file,'.') !== false) {
    $ending = strtolower(strrchr($file,'.'));
    $endingpos = strlen($file) - strlen($ending);
    $file = substr($file,0,$endingpos);
  }
  
  $x = 1;
  $file_test = $file;
  
  while(@file_exists($file_test . $ending)) {
    $x++;
    $file_test = $file . $x;
  }
  
  $file = $file_test . $ending;
  
  $data = @fopen($file,'w');
  @fwrite($data,$_POST['data_content']);
  @fclose($data);
  
  $message = is_file($file) ? sprintf($cs_lang['file_created'],$file) : $cs_lang['file_error'];
  
  cs_redirect($message, 'explorer','roots','dir='.$dir);
  
}