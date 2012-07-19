<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

include_once 'mods/explorer/functions.php';

$dir = cs_explorer_path($_REQUEST['file'], 'raw');
$lsd = cs_explorer_path($dir, 'escape');
$red_lsd = cs_explorer_path($dir, 'escape', 1);

$data = array();

if(empty($_POST['submit'])) {

  if(empty($dir)) {
    cs_redirect($cs_lang['no_file'], 'explorer', 'roots');
  } elseif(!file_exists($cs_main['def_path'] . '/' . $dir)) {
    cs_redirect($cs_lang['not_found'] . ': ' . $dir, 'explorer', 'roots');
  } elseif (!$file = fopen($cs_main['def_path'] . '/' . $dir,'r')) {
    cs_redirect($cs_lang['file_not_opened'], 'explorer', 'roots');
  } else {

    $content = fread($file,filesize($cs_main['def_path'] . '/' . $dir));
    fclose($file);

    $ending = strtolower(substr(strrchr($dir,'.'),1));

    if ($ending == 'php') {

      $data['if']['phpfile'] = true;
      include_once 'mods/explorer/abcode.php';

      $data['abcode']['tools'] = cs_abcode_tools('data_content');
      $data['abcode']['html1'] = cs_abcode_toolshtml('data_content');
      $data['abcode']['sql'] = cs_abcode_sql('data_content');
      $data['abcode']['html2'] = cs_abcode_toolshtml2('data_content');

    } else {
      $data['if']['phpfile'] = false;
    }

    $data['var']['content'] = cs_secure($content);
    $data['var']['source'] = $dir;
    $data['icn']['unknown'] = cs_html_img('symbols/files/filetypes/unknown.gif', 16, 16);

    echo cs_subtemplate(__FILE__, $data, 'explorer', 'edit');
  }
}
else {

  $data = fopen($cs_main['def_path'] . '/' . $dir,'w');
  # set stream encoding if possible to avoid converting issues
  if(function_exists('stream_encoding'))
    stream_encoding($data, $cs_main['charset']);
  $message = fwrite($data,$_POST['data_content']) ? $cs_lang['changes_done'] : $cs_lang['error_edit'];
  fclose($data);

  cs_redirect($message, 'explorer', 'roots', 'dir=' . $red_lsd);
}