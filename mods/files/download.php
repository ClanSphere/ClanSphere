<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');
$advanced = 0;

if(empty($_REQUEST['where'])) 
  cs_redirect(NULL, 'files', 'list');

$files_id = $_REQUEST['where'];
settype($files_id,'integer');
$mirror_id = $_REQUEST['target'];
settype($mirror_id,'integer');

$from = 'files';
$select = 'files_count, files_name, files_mirror';
$where = "files_id = '" . $files_id . "'"; 
$cs_files = cs_sql_select(__FILE__,$from,$select,$where,0,0,1); 
$files_loop = count($cs_files);
$files_count = $cs_files['files_count'];
$files_mirror = $cs_files['files_mirror']; 
 
$temp_mirror1 = explode("-----", $files_mirror);
$mirror = explode("\n", $temp_mirror1[$mirror_id]); 

$files_count = $files_count + 1;
$files_cells = array('files_count');
$files_save = array($files_count);
cs_sql_update(__FILE__,'files',$files_cells,$files_save,$files_id);

if(empty($advanced))
{
  header('Location: ' .$mirror[1]);
}  
elseif(!empty($advanced))
{
  $data['file']['wait'] = cs_html_img('symbols/files/wait.gif',0,0,0); 

  /*print("<meta http-equiv=refresh content='3; URL=$downloadfile'>");
  header("Content-disposition: attachment; filename = $downloadfile");
  header("Content-Type: application/force-download");
  header("Content-Transfer-Encoding: binary");
  header("Pragma: no-cache");
  header("Expires: 0");*/
}