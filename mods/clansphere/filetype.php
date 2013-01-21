<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_filetype($name) {

  global $cs_main; 

  switch ($name) {
  
    case 'ace': case 'zip': case 'rar': case 'tar': case '7z': case 'iso':
    $ext = 'archive';
    break;
  
    case 'bmp': case 'gif': case 'jpeg': case 'jpg': case 'png': case 'psd': case 'ico':
    $ext = 'image';
    break;
  
    case 'midi': case 'mp3': case 'wav': case 'wma': case 'ogg':
    $ext = 'sound';
    break;
  
    case 'pdf':
    $ext = 'pdf';
    break;
  
    case 'php':
    $ext = 'php';
    break;
  
    case 'dir':
    $ext = 'dir';
    break;
  
   case 'exe':
    $ext = 'executable';
    break;
  
    case 'sql':
    $ext = 'database';
    break;
  
    case 'html': case 'shtml': case 'xml':
    $ext = 'html';
    break;
  
    case 'txt': case 'ini':
    $ext = 'text';
    break;
  
    case 'doc': case 'docx': case 'tpl': case 'odt':
    $ext = 'document';
    break;
  
    case 'mov': case 'mpeg': case 'mpg': case 'rm': case 'wmv': case 'swf':   
    $ext = 'video';
    break;
  
    default:
    $ext = 'unknown';
  
  }  
      
  $iconpath = 'symbols/files/filetypes/' . $ext . '.gif';
  
  if(file_exists($iconpath)) {    
    return cs_html_img($iconpath,16,16,0,$name);
  }
  else {
    cs_error($iconpath,'cs_fileicon - File not found');
  }

}