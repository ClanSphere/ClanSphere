<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery', 1);

$files_gl = cs_files();

if(!isset($files_gl['picture']))
  $files_gl['picture'] = array('name' => '', 'size' => '', 'tmp_name' => '');

$data = array();

require_once('mods/gallery/functions.php');

$cs_option = cs_sql_option(__FILE__,'gallery');
$img_filetypes = array('gif','jpg','png');

$cs_gallery['usersgallery_name'] = '';
$cs_gallery['usersgallery_titel'] = '';
$cs_gallery['folders_id'] = 0;
$cs_gallery['usersgallery_access'] = 0;
$cs_gallery['usersgallery_status'] = 1;
$cs_gallery['usersgallery_description'] = '';
$cs_gallery['usersgallery_vote'] = '1';
$cs_gallery['usersgallery_time'] = cs_time();
$cs_gallery['users_id'] = $account['users_id'];
$gray = '0';
$file_up = 0;

if (file_exists('uploads/usersgallery/pics/' . $cs_gallery['users_id'] . '.' . $files_gl['picture']['name'])) {
  $filename_tmp = ( str_split($files_gl['picture']['name'], strrpos($files_gl['picture']['name'], '.')) );
  $filename_counter = 0;
  while (file_exists('uploads/usersgallery/pics/' . $cs_gallery['users_id'] . '.' . $filename_tmp[0] . '_' . $filename_counter . $filename_tmp[1]))
    $filename_counter++;
  $files_gl['picture']['name'] = $filename_tmp[0] . '_' . $filename_counter . $filename_tmp[1];
}

if(isset($_POST['submit'])) {
  $file_up = isset($_POST['file_up']) ? $_POST['file_up'] : 0;
  if ($file_up == 0) {
    $cs_gallery['usersgallery_name'] = $cs_gallery['users_id'] . '.' . $files_gl['picture']['name'];
  } elseif ($file_up == 1) {
    $cs_gallery['usersgallery_name'] = $cs_gallery['users_id'] . '.' . $_POST['picture']['name'];
  }
  
  $cs_gallery['usersgallery_titel'] = $_POST['gallery_titel'];
  $cs_gallery['folders_id'] = empty($_POST['folders_name']) ? $_POST['folders_id'] : make_folders_create('usersgallery',$_POST['folders_name'], $account['users_id']);
  $cs_gallery['usersgallery_access'] =  $_POST['gallery_access'];
  $cs_gallery['usersgallery_description'] = $_POST['description'];
  $cs_gallery['usersgallery_status'] =  isset($_POST['gallery_status']) ? $_POST['gallery_status'] : 0;
  $cs_gallery['usersgallery_vote'] = isset($_POST['gallery_vote']) ? $_POST['gallery_vote'] : 0;
  $gray = isset($_POST['gray']) ? $_POST['gray'] : 0;


  $error = '';

  $check_file = $files_gl['picture']['name'];
  $where = "usersgallery_name = '" . cs_sql_escape($check_file) . "'";
  $pic_check = cs_sql_select(__FILE__,'usersgallery','*',$where,'usersgallery_id DESC',0,0);
  $loop_pic_check = count($pic_check);

  if(!empty($loop_pic_check))
    $error .= $cs_lang['img_is'] . cs_html_br(1);
  if(empty($cs_gallery['folders_id']))
    $error .= $cs_lang['no_cat'] . cs_html_br(1);
  if(empty($files_gl['picture']['tmp_name']))
    $error .= $cs_lang['error_pic'] . cs_html_br(1);
  if(empty($_POST['gallery_titel']))
    $error .= $cs_lang['no_titel'] . cs_html_br(1);

  if(!empty($files_gl['picture']['tmp_name']))
    $img_size = getimagesize($files_gl['picture']['tmp_name']);
  else
    $img_size = 0;
  if(!empty($files_gl['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
    $error .= $cs_lang['ext_error'] . cs_html_br(1);
  }
  elseif(!empty($files_gl['picture']['tmp_name'])) {
    $filename = $cs_gallery['users_id'] . '.' . $files_gl['picture']['name'];
    if($img_size[0]>$cs_option['width'])
      $error .= $cs_lang['too_wide'] . cs_html_br(1);
    if($img_size[1]>$cs_option['height'])
      $error .= $cs_lang['too_high'] . cs_html_br(1);
    if($files_gl['picture']['size']>$cs_option['size2']) {
      $size = $files_gl['picture']['size'] - $cs_option['size2'];
      $size = cs_filesize($size);
      $error .= sprintf($cs_lang['too_big'], $size) . cs_html_br(1);
    }
    $where = 'users_id = "' . $cs_gallery['users_id'] . '"';
    $count_user_files = cs_sql_count(__FILE__,'usersgallery',$where);
    if($count_user_files >= $cs_option['max_files']) {
      $error .= $cs_lang['too_many_f'] . cs_html_br(1);
    }
    if(extension_loaded('gd') AND !empty($gray)) {
      require_once('mods/gallery/gd_2.php');
      cs_gray($files_gl['picture']['tmp_name']);
    }
    if(empty($error) AND cs_upload('usersgallery/pics', $filename, $files_gl['picture']['tmp_name']) OR !empty($error) AND extension_loaded('gd') AND cs_resample($files_gl['picture']['tmp_name'], 'uploads/usersgallery/pics/' . $filename, $cs_option['width'], $cs_option['height']))
    {
      if(empty($error) AND !extension_loaded('gd') AND cs_upload('usersgallery/thumbs', 'Thumb_' . $filename, $files_gl['picture_thumb']['tmp_name']) OR empty($error) AND extension_loaded('gd') AND cs_resample('uploads/usersgallery/pics/' . $filename, 'uploads/usersgallery/thumbs/' . 'Thumb_' . $filename, $cs_option['thumbs'], $cs_option['thumbs']) OR !empty($error) AND extension_loaded('gd') AND cs_resample('uploads/usersgallery/pics/' . $filename, 'uploads/usersgallery/thumbs/' . 'Thumb_' . $filename, $cs_option['thumbs'], $cs_option['thumbs']))
      {
      } else {
        $error .= $cs_lang['upload_error'] . cs_html_br(1);
      }
    } else {
      $error .= $cs_lang['upload_error'] . cs_html_br(1);
    }
  }


}

if(!isset($_POST['submit']))
  $data['head']['body'] = $cs_lang['body_picture'];
elseif(!empty($error) OR empty($files_gl['picture']['tmp_name']))
  $data['head']['body'] = $error;


if(!isset($_POST['submit']) OR !empty($error)) {

  $data['data'] = $cs_gallery;

  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2]  = $cs_lang['max_width'] . $cs_option['width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $cs_option['height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($cs_option['size2']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['data']['infobox'] = cs_abcode_clip($matches);


  $data['data']['folders'] = make_folders_select('folders_id',$cs_gallery['folders_id'],$cs_gallery['users_id'],'usersgallery');

  $data['access']['options'] = '';
  $levels = 0;
  while($levels < 6) {
    $cs_gallery['usersgallery_access'] == $levels ? $sel = 1 : $sel = 0;
    $data['access']['options'] .= cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
    $levels++;
  }

  $data['status']['options'] = ''; 
  $levels = 0;
  while($levels < 2) {
    $cs_gallery['usersgallery_status'] == $levels ? $sel = 1 : $sel = 0;
    $data['status']['options'] .= cs_html_option($cs_lang['show_' . $levels],$levels,$sel);
    $levels++;
  }

  $data['abcode']['smileys'] = cs_abcode_smileys('description');
  $data['abcode']['features'] = cs_abcode_features('description');
  
  $checked = 'checked="checked"';
  $data['check']['gray'] = empty($gray) ? '' : $checked;
  
  $data['data']['usersgallery_name'] = cs_secure($data['data']['usersgallery_name']);
  $data['data']['usersgallery_titel'] = cs_secure($data['data']['usersgallery_titel']);
  $data['data']['usersgallery_description'] = cs_secure($data['data']['usersgallery_description']);

  echo cs_subtemplate(__FILE__,$data,'usersgallery','users_create');
}
else {

  $cells = array_keys($cs_gallery);
  $save = array_values($cs_gallery);
  cs_sql_insert(__FILE__,'usersgallery',$cells,$save);

  cs_redirect($cs_lang['create_done'],'usersgallery','center');
}