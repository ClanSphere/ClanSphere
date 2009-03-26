<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('logs');
global $cs_logs;

$log_id = !empty($_GET['art']) ? (int) $_GET['art'] : 0;
$folder = $log_id == 1 ? 'errors' : 'actions';
$id = (int) $_GET['id'];

$log = empty($_GET['log']) ? 0 : $_GET['log'];
$data = array();

$cs_sort[1] = 'logs_name DESC';
$cs_sort[2] = 'logs_name ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$handle = opendir($cs_logs['dir'] . '/' .$folder);
$temp_file = array();
while ($file = readdir ($handle)) {
   if (strrchr($file,".") != ".log") continue;
   $temp_file[] = $file;
}
closedir($handle);

if($sort == 2)
  rsort($temp_file);


$handle = explode('--------',file_get_contents($cs_logs['dir'] . '/' . $folder . '/' . $temp_file[$log]));
array_shift($handle);

$data['logs'] = array();
$run = 0;

foreach($handle AS $temps)
{       
  $explode = explode("\n",$temps);
	$data['logs'][$run] = array('id' => $run,'time' => $explode[1],'message' => $explode[3],
    'file' => $explode[2], 'file2' => $explode[4]);
	if ($folder == 'errors') {
		$data['logs'][$run]['ip'] = $explode[6];
		$data['logs'][$run]['browser'] = $explode[5];
	}
  $run++;  
}

$data['var']['art'] = $log_id;
$data['var']['log'] = $log;

$data['log'] = $data['logs'][$id];
$data['log']['date'] = substr($temp_file[$log],0,strrpos($temp_file[$log],'.'));

$data['if']['error'] = $folder == 'errors' ? true : false;
$data['if']['log'] = $folder != 'errors' ? true : false;


echo cs_subtemplate(__FILE__, $data, 'logs', 'view');


?>