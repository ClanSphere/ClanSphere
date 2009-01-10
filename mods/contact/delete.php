<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('contact');

$form = 1;

if(isset($_POST['agree'])) {
	$form = 0;
  $data['if']['agree']  = TRUE;
  $data['if']['cancel'] = FALSE;
  $data['if']['form']   = FALSE;
  $id                   = $_POST['id'];
  settype($id,'integer');
  
  cs_sql_delete(__FILE__,'mail',$id);

}

if(isset($_POST['cancel'])) {
	$form = 0;
  $data['if']['agree']  = FALSE;
  $data['if']['cancel'] = TRUE;
  $data['if']['form']   = FALSE;
}

if(!empty($form)) {
  $data['if']['agree']  = FALSE;
  $data['if']['cancel'] = FALSE;
  $data['if']['form']   = TRUE;
  
  $id                         = $_GET['id'];
  settype($id,'integer');
  $data['remove']['confirm']  = sprintf($cs_lang['really'],$id);
  $data['remove']['id']       = $id;
}

echo cs_subtemplate(__FILE__,$data,'contact','delete');

?>