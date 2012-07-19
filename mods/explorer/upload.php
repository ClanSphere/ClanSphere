<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

include_once 'mods/explorer/functions.php';

$target = empty($_REQUEST['dir']) ? '' : $_REQUEST['dir'];
$dir = cs_explorer_path($target, 'raw');
$lsd = cs_explorer_path($dir, 'escape');

$files_gl = cs_files();

$data = array();

if (empty($_POST['submit'])) {
  
  $post_max_size = str_replace('M',' Mb', ini_get('post_max_size'));
  $data['lang']['max_upload'] = sprintf($cs_lang['max_upload'], $post_max_size);

  #$data['if']['modsdir'] = substr($dir,0,5) == 'mods/' && strpos(substr($dir,5),'/') == strrpos(substr($dir,5),'/') && empty($_POST['accessadd']) ? true : false;
  $data['if']['modsdir'] = false;
  $data['var']['dir'] = $dir;
  $data['var']['name'] = empty($_POST['name']) ? '' : str_replace('..','',$_POST['name']);
  $data['icn']['dir'] = cs_html_img('symbols/files/filetypes/dir.gif',16,16);

  #$data['if']['accessentry'] = isset($_POST['accessadd']) && file_exists($dir . '/access.php') ? true : false;
  $data['if']['accessentry'] = false;

  $clip = array(1 => $cs_lang['infobox'], 2 => nl2br($cs_lang['possible']));
  $data['clip']['info'] = cs_abcode_clip($clip);

  echo cs_subtemplate(__FILE__, $data, 'explorer', 'upload');

}
else {

  $filename = $dir . '/';
  $extension = strtolower(substr(strrchr($files_gl['file']['name'],'.'),1));

  if (empty($_POST['name'])) {
    $filename .= str_replace('..','',$files_gl['file']['name']);
    $action = substr($files_gl['file']['name'],0,strlen($files_gl['file']['name']) - strlen($extension) - 1);
  } else {
    $filename .= str_replace('..','',$_POST['name']);
    $filename .= '.' . strtolower($extension);
    $action = $_POST['name'];
  }
  
  $message = move_uploaded_file($files_gl['file']['tmp_name'],$filename) ? $cs_lang['success'] : $cs_lang['error_upload'];
  
  cs_redirect($message,'explorer','roots','dir='.$lsd);

  /*
  if (isset($_POST['minaxx'])) {
    $array = file($dir.'/access.php');
    $string = '';
    $count_array = count($array);
    
    for ($run = 0; $run < $count_array; $run++) {
      if ($run == 4)
        $string .= '$axx_file[\''.$action.'\'] = '.$_POST['minaxx'].";\n\r";
      $string .= $array[$run];
    }
    
    $accessfile = fopen($dir.'/access.php','w');
    fwrite($accessfile, $string);
    fclose($accessfile);
  }*/
}