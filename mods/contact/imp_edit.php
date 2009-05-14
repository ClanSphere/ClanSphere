<?php
// ClanSphere 2009 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('contact');

$filename = 'uploads/imprint/imprint.txt';
$imp_form = 1;
$imprint = '';
$data = array();

if (file_exists($filename)) {
  $fp = fopen ($filename, "r");
  $content = fread ($fp, filesize($filename));
  fclose ($fp);
}

if(!empty($_POST['imprint'])) {
  $imprint = empty($cs_main['rte_html']) ? $_POST['imprint'] : cs_abcode_inhtml($_POST['imprint'], 'add');
} 
if (!isset($_POST['submit']) AND file_exists($filename)) {   
  $imprint = explode("{laststandbreak}", $content); 
}

if(isset($_POST['submit'])) {
  $imp_form = 0;  
  $data['if']['done']     = TRUE;
  $data['if']['form']     = FALSE;
  $data['if']['wizzard']  = FALSE;
  
  if (file_exists($filename)) {
    cs_unlink('imprint', 'imprint.txt');
  }
  $fp = fopen ($filename, "w");
    chmod($filename,0777);
    $imp_time = cs_time();
    $content  = $imp_time; 
    $content .= '{laststandbreak}';
    $content .= $imprint;
    fwrite ($fp, $content);
    chmod($filename,0644);
    fclose ($fp);
  
  if($account['access_wizard'] == 5) {
    $wizard = cs_sql_count(__FILE__,'options',"options_name = 'done_cont' AND options_value = '1'");
    if(empty($wizard)) {
      $data['if']['wizzard'] = TRUE;
    }
  }
}
if(!empty($imp_form)) {

  $data = array();
  $data['imprint']['content'] = file_exists($filename) ? $imprint[1] : '';

  if(empty($cs_main['rte_html'])) {
		$data['if']['abcode'] = TRUE;
		$data['if']['rte_html'] = FALSE;
    $data['abcode']['features'] = cs_abcode_features('imprint');
  } else {
  	$data['if']['abcode'] = FALSE;
		$data['if']['rte_html'] = TRUE;
		$data['rte']['html'] = cs_rte_html('imprint',$data['imprint']['content']);
  }

  $data['if']['done']     = FALSE;
  $data['if']['form']     = TRUE;
  $data['if']['wizzard']  = FALSE;
}

$data['url']['contact_imp_edit'] = cs_url('contact','imp_edit');

echo cs_subtemplate(__FILE__,$data,'contact','imp_edit');