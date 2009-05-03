<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

function cs_remove_dir($path) {
  
  if (substr($path, -1, 1) != '/') {
       $path .= '/';
   }

   $normal_files = glob($path . '*');
   $hidden_files = glob($path . '\.?*');
   $all_files = array_merge($normal_files, $hidden_files);

   foreach ($all_files as $file) {
     
       if (preg_match("/(\.|\.\.)$/", $file)) {
               continue;
       }

       if (is_file($file) === TRUE) {
         
          unlink($file);
           
       } elseif (is_dir($file) === TRUE) {
         
           cs_remove_dir($file);
           
       }
   }

   if (is_dir($path) === TRUE) {
       rmdir($path);     
   }

}