<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

include_once 'mods/explorer/functions.php';

$dir = cs_explorer_path($_GET['file'], 'raw');
$lsd = cs_explorer_path($dir, 'escape');
$red_lsd = cs_explorer_path($dir, 'escape', 1);

$data = array();

if (empty($dir)) {
  
  echo $cs_lang['no_file'];
  echo ' ' . cs_link($cs_lang['back'],'explorer','roots');
  
} else {
  
  $dirs = '';
  $single_dirs = explode('/',$dir);
  $count_dirs = count($single_dirs) - 1;
  
  for ($x = 0; $x < $count_dirs; $x++) {
    $dirs .= $single_dirs[$x] . '/';
  }

  $ending = strtolower(substr(strrchr($dir,'.'),1));

  switch ($ending) {
       
    case 'php':
      $code = file_get_contents($dir);
      $content = highlight_string($code, true);
      break;
      
    case 'jpg': case 'jpeg': case 'png': case 'gif': case 'bmp':
      $content = cs_html_img($dir);
      break;
    
    case 'tpl': case 'htm': case 'html':
      if (empty($_GET['code'])) {
        $content = file_get_contents($dir);
        $add = cs_link($cs_lang['code'],'explorer','view','code=1&amp;file='.$lsd);
        if ($ending == 'tpl') $notable = 1;
      } else {
        $content = cs_secure(file_get_contents($dir),1,0,0);
        $add = cs_link($cs_lang['design'],'explorer','view','file='.lsd);
      }
      break;
    
    default:
      $content = file_get_contents($dir);
      $content = nl2br($content);
      break;
  }
  
  $data['var']['dir'] = $red_lsd;
  $data['var']['file'] = $dir;
  $data['var']['content'] = $content;
  $data['if']['showtable'] = empty($notable) ? true : false;
  if (!empty($add)) $data['lang']['view_file'] = $cs_lang['view_file'] . ' ' . $add;
  
  echo cs_subtemplate(__FILE__, $data, 'explorer', 'view');
}