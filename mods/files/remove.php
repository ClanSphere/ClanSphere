<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');
$cs_post = cs_post('id');
$cs_get = cs_get('id');

$files_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $files_id = $cs_post['id'];


if(isset($_POST['agree'])) {
  
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

if(isset($_POST['cancel']))
  cs_redirect($cs_lang['del_false'], 'files');

else {
	
	$data['lang']['del_rly'] = sprintf($cs_lang['del_rly'],$files_id);
	$data['file']['id'] = $files_id;

  echo cs_subtemplate(__FILE__,$data,'files','remove');
}