<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');
$advanced = 0;

if(empty($_REQUEST['where']) OR empty($_REQUEST['where'])) 
  header('location:' . $_SERVER['PHP_SELF'] . '?mod=files');

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
  strpos($_SERVER['PHP_SELF'],'content.php') !== false && !empty($account['access_ajax']) ? $cs_main['ajax_js'] .= 'window.location.href = "' . $mirror[1] . '";' : header('location:' .$mirror[1]);
}  
elseif(!empty($advanced))
{
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'headb',0,2); 
  echo $cs_lang['mod'];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc',0,0,'75%');
  echo cs_html_big(1);
  echo cs_html_span(1,'font-size: 15pt');
  echo $cs_files['files_name'];
  echo cs_html_span(0);
  echo cs_html_big(0);
  echo cs_html_br(1);
  echo $cs_lang['connect'];
  echo cs_html_br(2);
  echo cs_html_img('symbols/files/wait.gif',0,0,0); 
  echo cs_html_roco(2,'leftc',0,0,'25%');
  echo cs_html_big(1);
  echo cs_html_span(1,'font-size: 15pt');
  echo $cs_lang['help'];
  echo cs_html_span(0);
  echo cs_html_big(0);
  echo cs_html_br(1);
  echo $cs_lang['help_1'];
  echo cs_html_br(2);
  echo cs_html_big(1);
  echo cs_html_link($mirror[1],'Download manuell Starten',0);
  echo cs_html_big(0);
  echo cs_html_roco(0);

  //echo cs_html_roco(1,'centerb',0,2);
  //echo cs_link($cs_lang['back'],'files','view','where=' . $files_id);
  //echo cs_html_roco(0);
  echo cs_html_table(0);

  //$downloadfile = $temp[$mirror_id];
  /*print("<meta http-equiv=refresh content='3; URL=$downloadfile'>");
  header("Content-disposition: attachment; filename = $downloadfile");
  header("Content-Type: application/force-download");
  header("Content-Transfer-Encoding: binary");
  header("Pragma: no-cache");
  header("Expires: 0");*/
}
?>