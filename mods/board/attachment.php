<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$
chdir('../../');
@set_time_limit(10);
@ini_set('arg_separator.output','&amp;');
@ini_set('session.use_trans_sid','0');
@ini_set('session.use_cookies','1');
@ini_set('session.use_only_cookies','1');

$cs_logs = array('errors' => '', 'sql' => '', 'queries' => 0, 'warnings' => 0, 'dir' => 'logs');
require('system/core/functions.php');

if(file_exists('setup.php')) {
  require('setup.php');
  require('system/database/' . $cs_db['type'] . '.php');
  $cs_db['con'] = cs_sql_connect($cs_db);

  $cs_main = cs_sql_option(__FILE__,'clansphere');
  
  require('system/output/xhtml_10.php');
  require('system/core/content.php');
  require('system/core/tools.php');
  require('system/core/account.php');

  cs_tasks('system/extensions', 1); # load extensions
}
else {
  echo '<a href="install.php">Installation required</a> or missing setup.php';
}

if(!empty($_GET['id'])) { 
  $id = $_GET['id'];
  $cs_thread_file = cs_sql_select(__FILE__,'boardfiles','*',"boardfiles_id = '" . cs_sql_escape($id) . "'",0,0,1);
}
elseif (!empty($_GET['name'])) {
  $name = $_GET['name'];
  $cs_thread_file = cs_sql_select(__FILE__,'boardfiles','*',"boardfiles_name = '" . cs_sql_escape($name) . "'",0,0,1);
}
else {
  die('404 File not found!'); 
}

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

if(!is_file($file_path)) {
  die("<b>404 File not found!</b>");
}

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