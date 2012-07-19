<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('buddys');

$data = array();

$buddys_id = $_GET['id'];
settype($buddys_id,'integer');

if(!isset($_POST['submit']) AND !isset($_POST['preview'])) {
  $data['lang']['body'] = $cs_lang['body_edit'];
}
elseif(isset($_POST['preview'])) {
  $data['lang']['body'] = $cs_lang['preview'];
}


if(isset($_POST['submit']) OR isset($_POST['preview'])) {
  $cs_buddys['buddys_notice'] = $_POST['buddys_notice'];
}
else {
  $cells = 'buddys_notice';
  $cs_buddys = cs_sql_select(__FILE__,'buddys',$cells,"buddys_id = '" . $buddys_id . "'");
}

if(isset($_POST['preview'])) 
{

  $data['if']['preview']  = TRUE;
  $data['if']['form']     = TRUE;
  $data['if']['done']     = FALSE;
  
  $data['edit']['buddys_notice']  = cs_secure($cs_buddys['buddys_notice'],1,1);
  $data['edit']['id']             = $buddys_id;

}

if(isset($_POST['preview']) OR !isset($_POST['submit'])) 
{
  if(!isset($_POST['preview'])) {
  $data['if']['preview']  = FALSE;
  $data['if']['form']     = TRUE;
  $data['if']['done']     = FALSE;
  }
  
  $data['edit']['abcode_smileys']     = cs_abcode_smileys('buddys_notice');
  $data['edit']['abcode_features']    = cs_abcode_features('buddys_notice');
  $data['edit']['buddys_notice']      = cs_secure($cs_buddys['buddys_notice']);
  $data['edit']['id']                 = $buddys_id;
}
else 
{
  
  $buddys_id = $_POST['id'];
  settype($buddys_id,'integer');
  
  $data['if']['preview']  = FALSE;
  $data['if']['form']     = FALSE;
  $data['if']['done']     = TRUE;
  
  $buddys_cells = array_keys($cs_buddys);
  $buddys_save = array_values($cs_buddys);
  cs_sql_update(__FILE__,'buddys',$buddys_cells,$buddys_save,$buddys_id);
  
  cs_redirect($cs_lang['changes_done'], 'buddys','center') ;

} 

echo cs_subtemplate(__FILE__,$data,'buddys','edit');