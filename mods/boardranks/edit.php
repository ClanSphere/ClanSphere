<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('boardranks');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

$boardranks_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id'])) $boardranks_id = $cs_post['id'];

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
  
  $cs_boardranks = cs_sql_select(__FILE__,'boardranks','boardranks_min, boardranks_name',"boardranks_id ='" . $boardranks_id . "'");
  $boardranks_min = $cs_boardranks['boardranks_min'];
  $boardranks_name = $cs_boardranks['boardranks_name'];
}

if(!isset($_POST['submit']) OR empty($error)) {
  $data['head']['body'] = $cs_lang['body'];
} elseif(!empty($error)) {
  $data['head']['body'] = $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {
  $data['boardranks']['min'] = $boardranks_min;
  $data['boardranks']['name'] = $boardranks_name;
  $data['boardranks']['id'] = $boardranks_id;
  
  echo cs_subtemplate(__FILE__,$data,'boardranks','edit');
  
}
else {
  
  $cells = array('boardranks_min','boardranks_name');
  $content = array($boardranks_min,$boardranks_name);
  cs_sql_update(__FILE__,'boardranks',$cells,$content,$boardranks_id);
  
  cs_redirect($cs_lang['changes_done'],'boardranks');
}