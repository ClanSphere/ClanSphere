<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('logs');

$data = array();
$data['if']['wizard'] = FALSE;

global $cs_logs;

if(!empty($_REQUEST['where'])) {
  $log_id = $_REQUEST['where'];
}
elseif(!empty($_POST['log_id'])) {
  $log_id = $_POST['log_id'];
}
else {
  $log_id = 1;
}

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'logs_name DESC';
$cs_sort[2] = 'logs_name ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$run = 0;

if($log_id == 1)
  $folder = 'errors';
elseif($log_id == 2)
  $folder = 'actions';
else
  $folder = 'errors';

if(!empty($_REQUEST['down'])) {
  $down_url = $cs_main['php_self']['dirname'] . $cs_logs['dir'] . '/' . $folder . '/' . $_REQUEST['down'];
  header('Location: ' . $down_url);
}
if(!empty($_REQUEST['del'])) { 
  cs_unlink('../' . $cs_logs['dir'] . '/' . $folder, $_REQUEST['del']);
  cs_redirect(NULL, 'logs', 'roots','where=' . $log_id);
}
$handle = opendir($cs_logs['dir'] . '/' . $folder);  
while ($file = readdir ($handle)) {
  if ($file != "." && $file != ".." && strrchr($file,".") == ".log") {
    $temp_file[$run] = $file;
    $run++;
  }
}
closedir($handle);
if(empty($temp_file)) {
  $temp_file = array();
}
$count_handle = count($temp_file);
if($sort == 2) {
  rsort($temp_file);
} 

$data['head']['dropdown'] = cs_html_select(1,'log_id');
$levels = 1;
while($levels < 3) {
  $log_id == $levels ? $sel = 1 : $sel = 0;
  $data['head']['dropdown'] .= cs_html_option($cs_lang['lev_' . $levels],$levels,$sel);
  $levels++;
}
$data['head']['dropdown'] .= cs_html_select(0);

$data['head']['count'] = $count_handle;
$data['head']['pages'] = cs_pages('logs','roots',$count_handle,$start,$log_id,$sort,$account['users_limit']);

if($account['access_wizard'] == 5) {
  $wizard = cs_sql_count(__FILE__,'options',"options_name = 'done_logs' AND options_value = '1'");
  if(empty($wizard)) {
  $data['if']['wizard'] = TRUE;
    $data['wizard']['show'] = cs_link($cs_lang['show'],'wizard','roots');
    $data['wizard']['task_done'] = cs_link($cs_lang['task_done'],'wizard','roots','handler=logs&amp;done=1');
  }
}

$data['sort']['name'] = cs_sort('logs','roots',$start,$log_id,1,$sort);

$temp_limit = $start + $account['users_limit'];
if($temp_limit > $count_handle) {
  $count_limit = $count_handle;
}
else {
  $count_limit = $temp_limit;
}
if(!empty($count_limit)) {
  $z = 0;
  for ($i = $start; $i < $count_limit; $i++) {
    $data['log'][$z]['name'] = $temp_file[$i];
    $handle = file_get_contents($cs_logs['dir'] . '/' . $folder . '/' . $temp_file[$i]);
    $handle = explode('--------',$handle);
    $handle_count = count($handle) - 1;
    $data['log'][$z]['handle'] = $handle_count;
    $data['log'][$z]['details'] = cs_link($cs_lang['details'],'logs','view','art=' .$log_id .'&amp;log=' . $i);
    $data['log'][$z]['download'] = cs_link($cs_lang['down'],'logs','roots','where=' .$log_id .'&amp;down=' . $temp_file[$i], 'noajax');
    $data['log'][$z]['delete'] = cs_link($cs_lang['del'],'logs','roots','where=' .$log_id .'&amp;del=' . $temp_file[$i]);
    $z++;
  }
} else {
  $data['log'] = array();  
}

echo cs_subtemplate(__FILE__,$data,'logs','roots');