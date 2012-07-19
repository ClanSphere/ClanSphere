<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery', 1);
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

require_once('mods/gallery/functions.php');

$gallery_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $gallery_id = $cs_post['id'];
settype($gallery_id, 'integer');

$edit = cs_sql_select(__FILE__,'usersgallery','*',"usersgallery_id = '" . (int) $gallery_id . "'");

$cs_option = cs_sql_option(__FILE__,'gallery');

$gallery_count_reset = 0;
$new_time = 0;


if(isset($_POST['submit'])) {

  $edit['usersgallery_titel'] = $_POST['gallery_titel'];
  $edit['folders_id'] = empty($_POST['folders_name']) ? $_POST['folders_id'] : make_folders_create('usersgallery',$_POST['folders_name'], $account['users_id']);
  $edit['usersgallery_access'] = $_POST['gallery_access'];
  $edit['usersgallery_status'] = $_POST['gallery_status'];
  $edit['usersgallery_description'] = $_POST['gallery_description'];
  $edit['usersgallery_vote'] = isset($_POST['gallery_vote']) ? $_POST['gallery_vote'] : 0;

  if(!empty($_POST['new_time']))
    $edit['usersgallery_time'] = cs_time();
  if(!empty($_POST['gallery_count_reset']))
    $edit['usersgallery_count'] = 0;


  $error = '';

  if($edit['users_id'] != $account['users_id'] AND $account['access_usersgallery'] < 4)
    $error .= $cs_lang['not_own'] . cs_html_br(1);
  if(empty($edit['usersgallery_titel']))
    $error .= $cs_lang['no_titel'] . cs_html_br(1);
  if(empty($edit['folders_id']))
    $error .= $cs_lang['no_cat'] . cs_html_br(1);

}

if(!isset($_POST['submit']))
  $data['head']['body'] = $cs_lang['body_picture'];
elseif(!empty($error))
  $data['head']['body'] = $error;


if(!empty($error) OR !isset($_POST['submit'])) {

  $data['data'] = $edit;
  $data['current']['img'] = cs_html_img('mods/gallery/image.php?usersthumb=' . $edit['usersgallery_id']);
  $data['folders']['select'] = make_folders_select('folders_id',$edit['folders_id'],$account['users_id'],'usersgallery');

  $data['access']['options'] = '';
  $levels = 0;
  while($levels < 6) {
    $edit['usersgallery_access'] == $levels ? $sel = 1 : $sel = 0;
    $data['access']['options'] .= cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
    $levels++;
  }

  $data['status']['options'] = ''; 
  $levels = 0;
  while($levels < 2) {
    $edit['usersgallery_status'] == $levels ? $sel = 1 : $sel = 0;
    $data['status']['options'] .= cs_html_option($cs_lang['show_' . $levels],$levels,$sel);
    $levels++;
  }

  $data['abcode']['smileys'] = cs_abcode_smileys('gallery_description');
  $data['abcode']['features'] = cs_abcode_features('gallery_description');
  
  $checked = 'checked="checked"';
  $data['check']['newtime'] = empty($new_time) ? '' : $checked;
  $data['check']['count'] = empty($gallery_count_reset) ? '' : $checked;
    
  $data['hidden']['id'] = $gallery_id;

  $data['data']['usersgallery_name'] = cs_secure($data['data']['usersgallery_name']);
  $data['data']['usersgallery_titel'] = cs_secure($data['data']['usersgallery_titel']);
  $data['data']['usersgallery_description'] = cs_secure($data['data']['usersgallery_description']);

  echo cs_subtemplate(__FILE__,$data,'usersgallery','users_edit');
}
else {

  $cells = array_keys($edit);
  $save = array_values($edit);
 cs_sql_update(__FILE__,'usersgallery',$cells,$save,$gallery_id);

 cs_redirect($cs_lang['changes_done'],'usersgallery','center');
}