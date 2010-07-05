<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => true, 'init_tpl' => false, 'init_mod' => true);

chdir('../../');

require_once 'system/core/functions.php';

cs_init($cs_main);

chdir('mods/board/');

if(!empty($_GET['id'])) {
    $id = $_GET['id'];
    $tables = 'boardfiles fil INNER JOIN {pre}_threads thr ON thr.threads_id = fil.threads_id ';
    $tables .= 'INNER JOIN {pre}_board brd ON brd.board_id = thr.board_id ';
    $tables .= 'LEFT OUTER JOIN {pre}_boardpws bpw ON bpw.board_id = brd.board_id AND bpw.users_id = \'' . $account['users_id'] . '\'';
    $where = 'brd.board_access <= \'' . $account['access_board'] . '\' fil.boardfiles_id = \'' . cs_sql_escape($id) . '\'';
    $where = 'fil.boardfiles_id = \'' . cs_sql_escape($id) . '\'';
    $cs_thread_file = cs_sql_select(__FILE__,$tables,'*',$where,0,0,1);
    if(!empty($cs_thread_file)) {
      if(!empty($cs_thread_file['board_pwd'])) {
        if(empty($cs_thread_file['boardpws_id'])) {
          die;
        }
      }
    }
    else {
      die;
    }
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
    $file_path = "../../uploads/board/files/".$cs_thread_file['boardfiles_id'].'.'.$ext;
}
else {
    $file_path = "../../uploads/board/files/".$cs_thread_file['boardfiles_name'];
}

if(!is_file($file_path))
die(cs_error_internal(0, 'File not found'));

if($ext == 'jpg' OR $ext=='JPG' OR $ext == 'jpeg' OR $ext=='JPEG' OR $ext == 'gif' OR $ext=='GIF' OR $ext == 'bmp' OR $ext=='BMP' OR $ext == 'png' OR $ext=='PNG') {
    echo "<img src='$file_path' alt='$file'></img>";
}
else {

  # disable browser / proxy caching
  header("Cache-Control: max-age=0, no-cache, no-store, must-revalidate");
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

  $varMimeTypes = Array('doc' => 'application/msword',
                        'pdf' => 'application/pdf', 
                        'zip' => 'application/zip',
                        'txt' => 'text/plain', 
                        'sql' => 'text/plain', 
                        'htm' => 'text/html', 
                        'html'=> 'text/html');

  header("Content-Description: File Transfer");
  header("Content-Type: " . $varMimeTypes[$ext]);
  header("Content-Disposition: attachment; filename=". $cs_thread_file['boardfiles_name'] .";");
  header("Content-Transfer-Encoding: binary");
  @readfile($file_path);
}