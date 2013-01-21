<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('maps');
$cs_get = cs_get('id');
$cs_post = cs_post('id');
$maps_id = empty($cs_get['id']) ? $cs_post['id'] : $cs_get['id'];

if(isset($cs_post['agree'])) {
  $maps = cs_sql_select(__FILE__,'maps','maps_picture',"maps_id = '" . $maps_id . "'");
  if(!empty($maps['maps_picture'])) {
    cs_unlink('maps',$maps['maps_picture']);
  }
  cs_sql_delete(__FILE__,'maps',$maps_id);
  cs_redirect($cs_lang['del_true'], 'maps');
}

if(isset($cs_post['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'maps');
}

$map = cs_sql_select(__FILE__,'maps','maps_name','maps_id = ' . $maps_id,0,0,1);
if(!empty($map)) {
  $data = array();
  $data['maps']['action'] = cs_url('maps','remove');
  $data['maps']['maps_id'] = $maps_id;
  $data['maps']['message'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_name'],$map['maps_name']);
  echo cs_subtemplate(__FILE__,$data,'maps','remove');
}
else {
  cs_redirect('','maps');
}