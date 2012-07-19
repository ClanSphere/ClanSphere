<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

include_once 'mods/explorer/functions.php';

$target = empty($_REQUEST['dir']) ? '' : $_REQUEST['dir'];
$dir = cs_explorer_path($target, 'raw');
$lsd = cs_explorer_path($dir, 'escape');

$data = array();

if(empty($_POST['submit'])) {

  include_once 'mods/explorer/abcode.php';

  $data['var']['dir'] = $dir;
  
  $data['abcode']['tools'] = cs_abcode_tools('data_content');
  $data['abcode']['html1'] = cs_abcode_toolshtml('data_content');
  $data['abcode']['sql'] = cs_abcode_sql('data_content');
  $data['abcode']['html2'] = cs_abcode_toolshtml2('data_content');

  echo cs_subtemplate(__FILE__, $data, 'explorer', 'create');

}
else {

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

  while(file_exists($file_test . $ending)) {
    $x++;
    $file_test = $file . $x;
  }

  $file = $file_test . $ending;

  $data = fopen($file,'w');
  # set stream encoding if possible to avoid converting issues
  if(function_exists('stream_encoding'))
    stream_encoding($data, $cs_main['charset']);
  fwrite($data,$_POST['data_content']);
  fclose($data);

  $message = is_file($file) ? sprintf($cs_lang['file_created'],$file) : $cs_lang['file_error'];
  $red_lsd = cs_explorer_path($dir, 'escape');

  cs_redirect($message, 'explorer','roots','dir='.$red_lsd);
}