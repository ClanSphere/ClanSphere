<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');
$data = array();
if (isset($cs_main['mod_rewrite'])) $_GET['file'] = substr($_GET['params'], strpos($_GET['params'], '/file/')+6);

if (empty($_GET['file'])) {
  
  echo $cs_lang['no_file'];
  echo ' ' . cs_link($cs_lang['back'],'explorer','roots');
  
} else {
  
  $dir = '';
  $single_dirs = explode('/',$_GET['file']);
  $count_dirs = count($single_dirs) - 1;
  
  for ($x = 0; $x < $count_dirs; $x++) {
    $dir .= $single_dirs[$x] . '/';
  }
  
  $file = $_GET['file'];
  $ending = strtolower(substr(strrchr($file,'.'),1));

  switch ($ending) {
       
    case 'php':
      $code = file_get_contents($file);
      $content = highlight_string($code, true);
      break;
      
    case 'jpg': case 'jpeg': case 'png': case 'gif': case 'bmp':
      $content = cs_html_div(1,'text-align: center;') . cs_html_img($file) . cs_html_div(0);
      break;
    
    case 'tpl': case 'htm': case 'html':
      if (empty($_GET['code'])) {
        $content = file_get_contents($file);
        $add = cs_link($cs_lang['code'],'explorer','view','code=1&amp;file='.$file);
        if ($ending == 'tpl') $notable = 1;
      } else {
        $content = cs_secure(file_get_contents($file),1,0,0);
        $add = cs_link($cs_lang['design'],'explorer','view','file='.$file);
      }
      break;
    
    default:
      $content = file_get_contents($file);
      $content = nl2br($content);
      break;
  }
  
  $data['var']['dir'] = $dir;
  $data['var']['file'] = $file;
  $data['var']['content'] = $content;
  $data['if']['showtable'] = empty($notable) ? true : false;
  if (!empty($add)) $data['lang']['view_file'] = $cs_lang['view_file'] . ' ' . $add;
  
  echo cs_subtemplate(__FILE__, $data, 'explorer', 'view');
}

?>