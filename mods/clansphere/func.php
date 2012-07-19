<?php
function get_size($dir) { 
  //echo 'DEBUG-Dir:' . $dir . '</br>';
  $handle = opendir($dir);
  $size = 0; 
  while(($file = readdir($handle)) !== FALSE) { 
    if($file == '.' || $file == '..' || $file == '.git') continue; 
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

function get_disk_free_space() {
  global $cs_main;
  try {
    $retval = disk_free_space($cs_main['def_path']);
  }
  
  catch (Exception $e) {
    $cs_err[1] = 'ERROR....';
    $cs_err[2] = $e;
    
    $retval = $cs_err;
  }
  return $retval;  
}

function get_directorysize($dir) {
  global $cs_main;
  try {
    $retval =  get_size($cs_main['def_path'] . $dir);
  }
  
  catch (Exception $e) {
    $cs_err[1] = 'ERROR....';
    $cs_err[2] = $e;
    
    $retval = $cs_err;
  }
  return $retval;  
}