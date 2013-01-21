<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');
$cs_get = cs_get('id');
$cs_post = cs_post('id');
$files_id = empty($cs_get['id']) ? $cs_post['id'] : $cs_get['id'];

if(isset($cs_post['agree'])) {
  $previews = cs_sql_select(__FILE__,'files','files_previews',"files_id = '" . $files_id . "'");
  $file_string = $previews['files_previews'];
  $file_pics = empty($file_string) ? array() : explode("\n",$file_string);
  foreach($file_pics AS $pics) {
    cs_unlink('files', 'picture-' . $pics);
    cs_unlink('files', 'thumb-' . $pics);
  }
  cs_sql_delete(__FILE__,'files',$files_id);
  $query = "DELETE FROM {pre}_comments WHERE comments_mod='files' AND ";
  $query .= "comments_fid='" . $files_id . "'";
  cs_sql_query(__FILE__,$query);
  $query = "DELETE FROM {pre}_voted WHERE voted_mod='files' AND ";
  $query .= "voted_fid='" . $files_id . "'";
  cs_sql_query(__FILE__,$query);

  cs_redirect($cs_lang['del_true'], 'files');
}

if(isset($cs_post['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'files');
}

$file = cs_sql_select(__FILE__,'files','files_name','files_id = ' . $files_id);
if(!empty($file)) {
  $data = array();
  $data['lang']['del_rly'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_remove'],$file['files_name']);
  $data['file']['id'] = $files_id;
  echo cs_subtemplate(__FILE__,$data,'files','remove');
}
else {
  cs_redirect('','files');
}