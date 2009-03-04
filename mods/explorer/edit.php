<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');


if(empty($_POST['submit'])) {
  
	if (isset($cs_main['mod_rewrite'])) $_GET['file'] = substr($_GET['params'], strpos($_GET['params'], 'explorer/edit/file/')+19);
	$source = str_replace('..', '', $_GET['file']);
  
	if(empty($source)) {
    cs_redirect($cs_lang['no_file'], 'explorer', 'roots');
  } elseif(!file_exists($source)) {
    cs_redirect($cs_lang['not_found'] . ': ' . $source, 'explorer', 'roots');
  } elseif (@!$file = fopen($source,"r")) {
    cs_redirect($cs_lang['file_not_opened'], 'explorer', 'roots');
  } else {
    
  	$content = fread($file,filesize($_GET['file']));
    fclose($file);
    
    $data = array();
    $ending = strtolower(substr(strrchr($source,'.'),1));
    
    if ($ending == 'php') {
     
      $data['if']['phpfile'] = true;
      include_once 'mods/explorer/abcode.php';
      
      $data['abcode']['tools'] = cs_abcode_tools('data_content');
      $data['abcode']['html1'] = cs_abcode_toolshtml('data_content');
      $data['abcode']['sql'] = cs_abcode_sql('data_content');
      $data['abcode']['js'] = cs_abcode_js('data_content');
      $data['abcode']['html2'] = cs_abcode_toolshtml2('data_content');
     
    } else {
    	$data['if']['phpfile'] = false;
    }
    
    $data['var']['content'] = $content;
    $data['var']['source'] = $source;
    $data['icn']['unknown'] = cs_html_img('symbols/files/filetypes/unknown.gif', 16, 16);
    
    echo cs_subtemplate(__FILE__, $data, 'explorer', 'edit');
  }
} else {
  
  $parent_dir = '';
  $parent_single_dirs = explode('/',$_POST['file']);
  $count_dirs = count($parent_single_dirs) - 1;
  
  for ($x = 0; $x < $count_dirs; $x++) {
    $parent_dir .= $parent_single_dirs[$x] . '/';
  }
  
  $data = fopen($_POST['file'],'w');
  $message = fwrite($data,$_POST['data_content']) ? $cs_lang['changes_done'] : $cs_lang['error_edit'];
  fclose($data);
  
  cs_redirect($message, 'explorer', 'roots', 'dir=' . $parent_dir);
  
}

?>