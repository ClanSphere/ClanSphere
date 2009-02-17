<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['show'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');


if (empty($_GET['file'])) {
  
  echo $cs_lang['no_file'];
  echo ' ' . cs_link($cs_lang['back'],'explorer','roots');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  
} else {
  
  $dir = '';
  $single_dirs = explode('/',$_GET['file']);
  $count_dirs = count($single_dirs) - 1;
  
  for ($x = 0; $x < $count_dirs; $x++) {
    $dir .= $single_dirs[$x] . '/';
  }
  
  $file = $_GET['file'];

  switch (strtolower(substr(strrchr($file,'.'),1))) {
    
    case 'php':
      $code = file_get_contents($file);
      $code = str_replace('<br />',"\r\n",$code);
      $content = cs_secure('[php]'.$code.'[/php]',1,0,0);
      break;
      
    case 'jpg':
    case 'jpeg':
    case 'png':
    case 'gif':
    case 'bmp':
      $content = cs_html_div(1,'text-align: center;') . cs_html_img($file) . cs_html_div(0);
      break;
    
    case 'htm':
    case 'html':
      $content = cs_secure(file_get_contents($file),1,0,0);
      break;
    
    case 'tpl':
      if (empty($_GET['code'])) {
        $content = file_get_contents($file);
        $add = cs_link($cs_lang['code'],'explorer','view','file='.$file.'&amp;code=1');
        $notable = 1;
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
  
  echo $cs_lang['view_file'];
  if (!empty($add))
    echo ' '.$add;
  echo ' ' . cs_link($cs_lang['back'],'explorer','roots','dir='.$dir);
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_br(1);
  
  if (empty($notable)) {
    echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'headb');
    echo $cs_lang['show'] . ' - ' . $file;
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftb');
    echo $content;
    echo cs_html_roco(0);
    echo cs_html_table(0);
  } else {
    echo $content;
  }
}

?>