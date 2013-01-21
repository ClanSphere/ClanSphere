<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('boardranks');
$data = array();

if(isset($_POST['submit'])) {
  
  $boardranks_min = $_POST['boardranks_min'];
  $boardranks_name = $_POST['boardranks_name'];
  
  $error = '';
  
  if($boardranks_min == '') {
    $error .= $cs_lang['no_min'] . cs_html_br(1); 
  }
  if(empty($boardranks_name)) {
    $error .= $cs_lang['no_name'] . cs_html_br(1);
  }
  
} else {
  $boardranks_min = '';
  $boardranks_name = '';
}

if(!isset($_POST['submit']) OR empty($error)) {
  $data['head']['body'] = $cs_lang['body'];
} elseif(!empty($error)) {
  $data['head']['body'] = $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {
  $data['boardranks']['min'] = $boardranks_min;
  $data['boardranks']['name'] = $boardranks_name;
  
  echo cs_subtemplate(__FILE__,$data,'boardranks','create');
  
}
else {
  
  $cells = array('boardranks_min','boardranks_name');
  $content = array($boardranks_min,$boardranks_name);
  cs_sql_insert(__FILE__,'boardranks',$cells,$content);
  
  cs_redirect($cs_lang['create_done'],'boardranks');
}