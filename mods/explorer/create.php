<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('explorer');
include_once 'mods/explorer/abcode.php';

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['explorer'] . ' - ' . $cs_lang['create'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');

if(empty($_POST['submit'])) {
  echo $cs_lang['data_create'];
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_br(1);
  
  $dir = (empty($_GET['dir']) or $_GET['dir'] == '.') ? '' : $_GET['dir'];
  
  echo cs_html_form(1,'explorer_create','explorer','create');
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftc');
  echo cs_icon('folder_yellow') . $cs_lang['directory'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('data_folder',$dir,'text',60,40);  
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kate') . $cs_lang['f_name'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('data_name','','text',50,30);
  echo cs_html_select(1,'data_type');
  echo cs_html_option('.php','.php',1);
  echo cs_html_option('.sql','.sql');
  echo cs_html_option('.html','.html');
  echo cs_html_option('.htm','.htm');
  echo cs_html_option('.tpl','.tpl');
  echo cs_html_option('.txt','.txt');
  echo cs_html_select(0);
  echo cs_html_roco(0);
  
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
  echo cs_html_textarea('data_content','','50','35');
  echo cs_html_roco(0);
  
  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('submit',$cs_lang['create'],'submit');
  echo cs_html_input('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  
  echo cs_html_table(0);
  echo cs_html_form(0);
  
} else {
  
  $dir = $_POST['data_folder'];
  
  if (substr($dir,-1,1) != '/') {
    $dir .= '/';
  }
  $dir = $dir == '/' ? '' : $dir;
  
  $file = $dir . $_POST['data_name'];
  
  $x = 1;
  while(@fopen($file . $_POST['data_type'],'r')) {
    $x++;
    $file .= $x;
  }
  
  $file .= $_POST['data_type'];
  
  $data = @fopen($file,'w');
  @fwrite($data,$_POST['data_content']);
  @fclose($data);
  
  if(is_file($file)) 
    cs_redirect(sprintf($cs_lang['file_created'],$file),'explorer','roots','dir='.$dir);
  else 
    cs_redirect($cs_lang['file_error'],'explorer','roots','dir='.$dir);
  
  echo cs_html_roco(0);
  echo cs_html_table(0);
  
}

?>