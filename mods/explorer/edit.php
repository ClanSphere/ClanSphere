<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');
include_once 'mods/explorer/abcode.php';

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['edit'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');

if(empty($_POST['submit'])) {
	if(empty($_GET['file'])) {
		echo $cs_lang['no_file'] . '. ' . cs_link($cs_lang['back'],'explorer','roots');
		echo cs_html_roco(0);
		echo cs_html_table(0);
	} else {
		if(!file_exists($_GET['file'])) {
			
			echo $cs_lang['not_found'] . '. ' . cs_link($cs_lang['back'],'explorer','roots');
			echo cs_html_roco(0);
			echo cs_html_table(0);
			
		} else {
			if (@!$file = fopen($_GET['file'],"r")) {
				
				echo $cs_lang['file_not_opened'] .' '. cs_link($cs_lang['back'],'explorer','roots');
				echo cs_html_roco(0);
				echo cs_html_table(0);
				
			} else {
			
				echo $cs_lang['edit_file'];
				echo cs_html_roco(0);
				echo cs_html_table(0);
				echo cs_html_br(1);
						
				$content = fread($file,filesize($_GET['file']));
				
				echo cs_html_form(1,'upload_edit','explorer','edit');
				echo cs_html_table(1,'forum',1);
        
        echo cs_html_roco(1,'leftc',0,0,'20%');
      	echo cs_html_div(1,'display:none;','id="break"') .cs_html_br(1). cs_html_div(0);
      	echo cs_html_div(1,'display:none;','id="parameters"') . cs_html_div(0);
      	echo cs_icon('kate') . $cs_lang['content'];
        
        echo cs_html_roco(2,'leftb',0,0,'80%');
      	echo cs_html_input('tab',$cs_lang['tab'],'button',0,0,'accesskey="t" onclick="javascript:abc_insert(\'\t\',\'\',\'data_content\',\'\')"');
      	echo cs_abcode_tools('data_content');
      	echo cs_abcode_toolshtml('data_content');
      	echo cs_html_br(1);
      	echo cs_abcode_sql('data_content');
      	echo cs_abcode_js('data_content');	
      	echo cs_abcode_toolshtml2('data_content');
        
      	echo cs_html_br(1);
      	echo cs_html_textarea('data_content',$content,'50','35');
        echo cs_html_roco(0);
        
				echo cs_html_roco(1,'leftc');
				echo cs_icon('ksysguard') . $cs_lang['options'];
				echo cs_html_roco(2,'leftb');
				echo cs_html_input('file',$_GET['file'],'hidden');
				echo cs_html_input('submit',$cs_lang['edit'],'submit');
				echo cs_html_input('reset',$cs_lang['reset'],'reset');
				echo cs_html_roco(0);
				echo cs_html_table(0);
				echo cs_html_form(0);
				
				fclose($file);
			}
		}
	}
} else {
	
	$parent_dir = '';
	$parent_single_dirs = explode('/',$_POST['file']);
	$count_dirs = count($parent_single_dirs) - 1;
  
	for ($x = 0; $x < $count_dirs; $x++) {
		$parent_dir .= $parent_single_dirs[$x] . '/';
	}
	
	$data = fopen($_POST['file'],'w');
	
	if(fwrite($data,$_POST['data_content'])) 
      cs_redirect($cs_lang['changes_done'], 'explorer','roots','&dir='.$parent_dir) ;
   else
      cs_redirect($cs_lang['error_edit'], 'explorer','roots','&dir='.$parent_dir) ;
      
	echo cs_html_roco(0);
	echo cs_html_table(0);
}

?>