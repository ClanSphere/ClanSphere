<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => true, 'init_tpl' => false);

require_once 'system/core/functions.php';

cs_init($cs_main);


if(!empty($_GET['id'])) { 
  $id = $_GET['id'];
  $cs_thread_file = cs_sql_select(__FILE__,'boardfiles','*',"boardfiles_id = '" . cs_sql_escape($id) . "'",0,0,1);
}
elseif (!empty($_GET['name'])) {
  $name = $_GET['name'];
  $cs_thread_file = cs_sql_select(__FILE__,'boardfiles','*',"boardfiles_name = '" . cs_sql_escape($name) . "'",0,0,1);
}
else
  die(cs_error_internal(0, 'File not found'));

$com_cells = array('boardfiles_downloaded');
$com_save = array((1+$cs_thread_file['boardfiles_downloaded']));
cs_sql_update(__FILE__,'boardfiles',$com_cells,$com_save,$cs_thread_file['boardfiles_id']);

$file = $cs_thread_file['boardfiles_name'];
$extension = strlen(strrchr($file,"."));
$name = strlen($file);
$ext = substr($file,$name - $extension + 1,$name); 

if(!empty($id)) { 
  $file_path = "uploads/board/files/".$cs_thread_file['boardfiles_id'].'.'.$ext;
}
else {  
  $file_path = "uploads/board/files/".$cs_thread_file['boardfiles_name'];
}

if(!is_file($file_path))
  die(cs_error_internal(0, 'File not found'));

if($ext == 'jpg' OR $ext=='JPG' OR $ext == 'jpeg' OR $ext=='JPEG' OR $ext == 'gif' OR $ext=='GIF' OR $ext == 'bmp' OR $ext=='BMP' OR $ext == 'png' OR $ext=='PNG') {
  echo "<img src='../../$file_path' alt='$file'></img>";  
}
else {
  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: public");
  header("Content-Description: File Transfer");
  header("Content-Type: application/force-download");
  header("Content-Disposition: attachment; filename=". $cs_thread_file['boardfiles_name'] .";");
  header("Content-Transfer-Encoding: binary");
  @readfile($file_path);
}

?>