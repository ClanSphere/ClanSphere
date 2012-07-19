<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery', 1);
$cs_post = cs_post('id');
$cs_get = cs_get('id');

$gallery_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $gallery_id = $cs_post['id'];
settype($gallery_id, 'integer');

$cs_gallery = cs_sql_select(__FILE__,'usersgallery','*',"usersgallery_id = " . (int) $gallery_id);
$pic = cs_secure($cs_gallery['usersgallery_name']);

if ($cs_gallery['users_id'] != $account['users_id'] OR $account['access_usersgallery'] < 4)
  cs_redirect($cs_lang['del_false'],'usersgallery','center');

if (isset($_POST['agree'])) {
  cs_unlink('usersgallery', $pic, 'pics');
  cs_unlink('usersgallery', 'Thumb_' . $pic, 'thumbs');

  cs_sql_delete(__FILE__,'usersgallery',$gallery_id);
  $query = "DELETE FROM {pre}_voted WHERE voted_mod='usersgallery' AND ";
  $query .= "voted_fid='" . $gallery_id . "'";
  cs_sql_query(__FILE__,$query);
  $query = "DELETE FROM {pre}_comments WHERE comments_mod='usersgallery' AND ";
  $query .= "comments_fid='" . $gallery_id . "'";
  cs_sql_query(__FILE__,$query);

  cs_redirect($cs_lang['del_true'],'usersgallery','center');
}

if (isset($_POST['cancel']))
  cs_redirect($cs_lang['del_false'],'usersgallery','center');
else {
  $id = cs_secure($cs_gallery['usersgallery_id']);
  $data['this']['img'] = cs_html_img("mods/gallery/image.php?usersthumb=" . $id);
  $data['head']['body'] = sprintf($cs_lang['del_pic_rly'],$pic);
  $data['hidden']['id'] = $gallery_id;

  echo cs_subtemplate(__FILE__,$data,'usersgallery','users_remove');
}