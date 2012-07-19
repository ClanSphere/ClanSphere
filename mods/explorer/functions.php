<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_remove_dir($path) {
  
  if (substr($path, -1, 1) != '/')
    $path .= '/';

  $normal_files = glob($path . '*');
  $hidden_files = glob($path . '\.?*');
  if(!is_array($normal_files)) $normal_files = array();
  if(!is_array($hidden_files)) $hidden_files = array();
  $all_files = array_merge($normal_files, $hidden_files);

  foreach ($all_files as $file) {

    if (preg_match("/(\.|\.\.)$/", $file))
      continue;

    if (is_file($file) === TRUE)
      unlink($file);
    elseif (is_dir($file) === TRUE)
      cs_remove_dir($file);
  }

  if (is_dir($path) === TRUE)
    rmdir($path);     
}

function cs_explorer_path($path, $method, $sub = 0) {

  # this function should be used to handle path data in and from urls
  # the following escaped slash sign should only reside here
  $slash_esc = '@_@';

  if($method == 'raw')
    $path = str_replace($slash_esc,'/',$path);

  $path = str_replace('..', '', $path);
  $path = ($path == '/') ? $path : rtrim($path, '/');

  if(!empty($sub))
    $path = substr($path, 0, strrpos($path, '/'));

  if($method == 'escape')
    $path = str_replace('/',$slash_esc,$path);

  return $path;
}