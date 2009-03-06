<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

if((substr(phpversion(), 0, 3) >= '5.0') AND (substr(phpversion(), 0, 3) < '6.0'))
  @error_reporting(E_ALL | E_STRICT);
else
  @error_reporting(E_ALL);

@ini_set('arg_separator.output','&amp;');
@ini_set('session.use_trans_sid','0');
@ini_set('session.use_cookies','1');
@ini_set('session.use_only_cookies','1');
@ini_set('display_errors','on');
@ini_set('magic_quotes_runtime','off');

if(substr(phpversion(), 0, 3) >= '5.1')
  @date_default_timezone_set('Europe/Berlin');

$cs_micro = explode(' ', microtime()); # starting parsetime
$cs_logs = array('php_errors' => '', 'errors' => '', 'sql' => '', 'queries' => 0, 'warnings' => 0, 'dir' => 'logs');

chdir('../../');
require 'system/core/functions.php';
@set_error_handler("php_error");

require 'system/core/servervars.php';
require 'system/core/tools.php';
require 'system/core/abcode.php';
require 'system/core/templates.php';
require 'system/output/xhtml_10_old.php';

if(file_exists('setup.php')) {
    
  require 'setup.php';
  require 'system/database/' . $cs_db['type'] . '.php';
  $cs_db['con'] = cs_sql_connect($cs_db);
  unset($cs_db['pwd']);
  unset($cs_db['user']);

  $cs_main = cs_sql_option(__FILE__,'clansphere');

  require 'system/core/content.php';
  require 'system/core/account.php';

  cs_tasks('system/extensions', 1); # load extensions
  cs_tasks('system/runstartup'); # load startup files

  $cs_main['debug'] = false;

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
}
else
  cs_error_internal('setup');

?>