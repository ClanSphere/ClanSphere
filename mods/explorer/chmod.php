<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

if(empty($_POST['submit'])) {
	
	if (!empty($cs_main['mod_rewrite'])) $_GET['file'] = substr($_GET['params'], strpos($_GET['params'], 'explorer/chmod/file/')+20);
	
	$dir = substr($_GET['file'], 0, strrpos($_GET['file'],'/'));
	
  if(empty($_GET['file'])) {
  
    cs_redirect($cs_lang['no_selection'],'explorer','roots','dir=' . $dir);
    
  } else {

    $source = str_replace('..','',$_GET['file']);
    $chmod = substr(sprintf('%o', fileperms($_GET['file'])), -3);
    $data = array();
    
    $data['var']['source'] = $source;
    $data['var']['chmod'] = $chmod;
    $data['icn']['unknown'] = cs_html_img('symbols/files/filetypes/unknown.gif', 16, 16);
    
    $check = ' checked="checked"';
    $temp = $chmod;
    
    $rights = array();
    $rights['o_r'] = 400; $rights['o_w'] = 200; $rights['o_e'] = 100;
    $rights['g_r'] =  40; $rights['g_w'] =  20; $rights['g_e'] =  10;
    $rights['p_r'] =   4; $rights['p_w'] =   2; $rights['p_e'] =   1;
    
    foreach ($rights AS $name => $min) {
    	if ($temp >= $min) {
    		$temp -= $min;
    		$data['check'][$name] = $check;
    	} else
    	  $data['check'][$name] = '';
    }
    
    echo cs_subtemplate(__FILE__, $data, 'explorer', 'chmod');
  }
} else {
	
  $chmod = (int) $_POST['chmod'];
  
  $count = strlen($chmod);
  $missing = 4 - $count;
  $new_chmod = '';
  
  for($x = 0; $x < $missing; $x++)
    $new_chmod .= '0';
  
  $new_chmod .= $chmod;
  $new_chmod = octdec($new_chmod);
  
  $file = str_replace('..','',$_POST['file']);
  $dir = substr($file, 0, strrpos($file,'/'));
  
  @chmod($file, $new_chmod);
  
  $fileperms = octdec(substr(sprintf('%o', fileperms($_POST['file'])), -4));
  $message = $new_chmod == $fileperms ? $cs_lang['success'] : $cs_lang['error_chmod'];
  
  cs_redirect($message, 'explorer','roots','dir=' . $dir);
  
}

?>