<?php
// ClanSphere 2008 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('maps');

$data = array();


if(empty($_GET['id']) AND empty($_POST['maps_id'])) {
  $data['maps']['action'] = $cs_lang['remove'];
  $data['maps']['link'] = cs_url('maps','manage');
  echo cs_subtemplate(__FILE__,$data,'maps','no_selection');
  
} elseif (empty($_POST['agree']) AND empty($_POST['cancel'])) {
  $data['maps']['action'] = cs_url('maps','remove');
  $data['maps']['maps_id'] = (int) $_GET['id'];
  $data['maps']['message'] = sprintf($cs_lang['really'],$data['maps']['maps_id']);
  echo cs_subtemplate(__FILE__,$data,'maps','remove');
  
} else {
    if (isset($_POST['agree'])) {
  $id = (int) $_POST['maps_id'];
  
  $maps = cs_sql_select(__FILE__,'maps','maps_picture',"maps_id = '" . $id . "'");
  if(!empty($maps['maps_picture'])) cs_unlink('maps',$maps['maps_picture']);
  
  cs_sql_delete(__FILE__,'maps',$id);
  cs_redirect($cs_lang['del_true'], 'maps');
  } 
  if (isset($_POST['cancel'])) 
      cs_redirect($cs_lang['del_false'], 'maps');
}

?>