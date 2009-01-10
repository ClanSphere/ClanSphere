<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');

include_once 'mods/explorer/functions.php';

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['remove'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');

if(empty($_POST['submit'])) {
	if(empty($_GET['file'])) {
		
		echo $cs_lang['no_file'] . '. ' . cs_link($cs_lang['back'],'explorer','roots');
		
	} else {
		
		if(!file_exists($_GET['file'])) {
			
			echo $cs_lang['not_found'] . '. ' . cs_link($cs_lang['back'],'explorer','roots');
			
		} else {
			
      echo sprintf($cs_lang['really_delete'],$_GET['file']);
			echo cs_html_roco(0);
			echo cs_html_roco(1,'centerb');
			echo cs_html_form(1,'upload_del','explorer','remove');
			echo cs_html_vote('file',$_GET['file'],'hidden');
			echo cs_html_vote('submit',$cs_lang['confirm'],'submit');
			echo cs_html_form(0);
			
		}
	}
	
} else {
	
	$file = $_POST['file'];
	$dir = '';
	$single_dirs = explode('/',$file);
	$count_dirs = count($single_dirs) - 1;
  
	for ($x = 0; $x < $count_dirs; $x++) {
		$dir .= $single_dirs[$x] . '/';
	}
	
	if(is_dir($file)) {
		
		cs_remove_dir($file);
		
		if(!is_dir($file)) {
        cs_redirect($cs_lang['dir_removed'], 'explorer','roots','&dir='.$dir) ;
		} else {
			cs_redirect($cs_lang['dir_error'], 'explorer','roots','&dir='.$dir) ;
		}
		
	} else {
		
		if (unlink($file)) {
			
			cs_redirect($cs_lang['file_removed'], 'explorer','roots','&dir='.$dir) ;
			
		} else {
			
			cs_redirect($cs_lang['file_remove_error'], 'explorer','roots','&dir='.$dir) ;
			
		}
	}
}
echo cs_html_roco(0);
echo cs_html_table(0);

?>