<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

include_once('mods/explorer/functions.php');

$data = array();

$max_data = $account['users_limit'];

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];
$dir = empty($_GET['dir']) ? '.' : $_GET['dir'];
if(!empty($_GET['where'])) $dir = $_GET['where'];
$dir = cs_explorer_path($dir, 'raw');
$lsd = cs_explorer_path($dir, 'escape');

$count = 0;
$success = 1;
$dirs = array();
$files = array();

$target = $cs_main['def_path'] . '/' . $dir . '/';

if (is_dir($target) AND chdir($target)) {

  $goal = opendir('.');
  
  while(false !== ($curr_data = readdir($goal))) {
    if($curr_data != '..' && $curr_data != '.' && $curr_data != '.git') {
      if (is_dir($curr_data)) {
        $dirs[] = $curr_data;
      } else {
        $files[] = $curr_data;
      }
    }
  }
  closedir($goal);
  sort($dirs);
  sort($files);
  
  $datas = array_merge($dirs,$files);
  $count = count($datas);
  chdir($cs_main['def_path']);
}

$more = $lsd == '.' ? '' : 'dir=' . $lsd;

$data['lang']['getmsg'] = cs_getmsg();
$data['link']['new_file'] = cs_link($cs_lang['new_file'],'explorer','create',$more);
$data['link']['new_dir'] = cs_link($cs_lang['new_dir'],'explorer','create_dir',$more);
$data['link']['upload_file'] = cs_link($cs_lang['upload_file'],'explorer','upload',$more);
$data['pages']['show'] = cs_pages('explorer','roots',$count,$start,$lsd,'',$max_data);

$data['path']['show'] = cs_link($cs_lang['home'],'explorer','roots') . '/';

if ($dir != '.') {
  $output_folder = '';
  $folders = explode('/',$dir);

  foreach ($folders AS $folder) {
    $output_folder .= empty($output_folder) ? $folder : cs_explorer_path('/', 'escape') . $folder;
    $data['path']['show'] .= cs_link($folder,'explorer','roots','dir='.$output_folder) . '/';
  }
}

if(!empty($success)) {

  $img_edit = cs_icon('editpaste');
  $img_access = cs_icon('access');
  $img_del = cs_icon('editdelete');
  $img_info = cs_icon('documentinfo');

  $y = -1;

  require_once 'mods/clansphere/filetype.php';

  for($x = $start; ($x < $count) && ($y < $max_data); $x++) {

    $y++;

    $file_raw = $dir == '.' ? $datas[$x] : $dir . '/' . $datas[$x];
    $file = cs_explorer_path($file_raw, 'escape');

    chdir($target);
    $type = is_dir($datas[$x]) ? 'dir' : strtolower(substr(strrchr($datas[$x],'.'),1));
    chdir($cs_main['def_path']);

    $save[$y]['name'] = $datas[$x];
    $save[$y]['chmod'] = substr(sprintf('%o', fileperms($file_raw)), -4);
    $save[$y]['access'] = cs_link($img_access,'explorer','chmod','file='.$file);
    $save[$y]['remove'] = cs_link($img_del,'explorer','remove','file='.$file,0,$cs_lang['remove']);
    $save[$y]['info'] = cs_link($img_info,'explorer','information','file='.$file);
    $save[$y]['edit'] = $type != 'dir' ? cs_link($img_edit,'explorer','edit','file='.$file) : '';

    $view = cs_link($datas[$x],'explorer','view','file='.$file);

    $save[$y]['symbol'] = cs_filetype($type);
    if ($type == 'jpg' || $type == 'jpeg' || $type == 'png' || $type == 'gif' || $type == 'bmp') {
      $save[$y]['name'] = cs_link($datas[$x],'explorer','view','file='.$file);
    } elseif ($type == 'dir') {
      $save[$y]['name'] = cs_link($datas[$x],'explorer','roots','dir='.$file);
    } elseif ($type == 'html' || $type == 'htm' || $type = 'php' || $type == 'txt' || $type == 'sql') {
      $save[$y]['name'] = cs_link($datas[$x],'explorer','view','file='.$file);
    }
  }
  $data['files'] = !empty($save) ? $save : array();
} else {
  $data['files'] = '';
}

echo cs_subtemplate(__FILE__,$data,'explorer','roots');