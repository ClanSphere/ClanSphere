<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

function get_size($dir) { 
  //echo 'DEBUG-Dir:' . $dir . '</br>';
  $handle = opendir($dir);
  $size = 0; 
  while(($file = readdir($handle)) !== FALSE) { 
    if($file == '.' || $file == '..' || $file == '_svn' || $file == '.svn') continue; 
    $full_path = $dir.'/'.$file; 
    
  if(is_dir($full_path)) { 
      //echo 'DEBUG-Dirsize:' . $full_path;
      $size += get_size($full_path); 
    } 
    else { 
      //echo 'DEBUG-Filesize:' . $full_path . '</br>';
      $size += filesize($full_path);     
    } 
  } 
  closedir($handle); 
  
  return $size; 
}

?>