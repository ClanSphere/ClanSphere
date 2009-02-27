<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

if (empty($_POST['submit'])) {
  
  $dir = empty($_GET['dir']) ? '' : str_replace('..','',$_GET['dir']);
  if (!empty($_POST['dir'])) $dir = str_replace('..','',$_POST['dir']);

  $data = array();
  
  $post_max_size = str_replace('M',' Mb', ini_get('post_max_size'));
  $data['lang']['max_upload'] = sprintf($cs_lang['max_upload'], $post_max_size);
  
  #$data['if']['modsdir'] = substr($dir,0,5) == 'mods/' && strpos(substr($dir,5),'/') == strrpos(substr($dir,5),'/') && empty($_POST['accessadd']) ? true : false;
  $data['if']['modsdir'] = false;
  $data['var']['dir'] = $dir;
  $data['var']['name'] = empty($_POST['name']) ? '' : str_replace('..','',$_POST['name']);
  
  #$data['if']['accessentry'] = isset($_POST['accessadd']) && file_exists($dir . '/access.php') ? true : false;
  $data['if']['accessentry'] = false;
  
  $clip = array(1 => $cs_lang['infobox'], 2 => nl2br($cs_lang['possible']));
  $data['clip']['info'] = cs_abcode_clip($clip);
  
  echo cs_subtemplate(__FILE__, $data, 'explorer', 'upload');
  
} else {
  
  $dir = empty($_POST['dir']) ? '' : str_replace('..','',$_POST['dir']);
  
  $filename = $dir;
  $extension = strtolower(substr(strrchr($_FILES['file']['name'],'.'),1));
  
  if (empty($_POST['name'])) {
    $filename .= str_replace('..','',$_FILES['file']['name']);
    $action = substr($_FILES['file']['name'],0,strlen($_FILES['file']['name']) - strlen($extension) - 1);
  } else {
    $filename .= str_replace('..','',$_POST['name']);
    $filename .= '.' . strtolower($extension);
    $action = $_POST['name'];
  }
  
  $message = move_uploaded_file($_FILES['file']['tmp_name'],$filename) ? $cs_lang['success'] : $cs_lang['error_upload'];
  
  cs_redirect($message,'explorer','roots','dir='.$dir);

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

?>