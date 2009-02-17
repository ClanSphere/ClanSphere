<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
require_once('mods/usersgallery/functions.php');

$cs_gallery['users_id'] = $account['users_id'];
$cs_gallery['usersgallery_time'] = cs_time();

$cs_option = cs_sql_option(__FILE__,'gallery');

$error = 0;
$g_error = 0;
$f_error = 0;
$message = '';
$img_filetypes = array('gif','jpg','png');

if(isset($_POST['submit']))
{
  $file_up = isset($_POST['file_up']) ? $_POST['file_up'] : 0;
  if ($file_up == 0)
  {
    $cs_gallery['usersgallery_name'] = $cs_gallery['users_id'] . '.' . $_FILES['picture']['name'];
  }
  elseif ($file_up == 1)
  {
    $cs_gallery['usersgallery_name'] = $cs_gallery['users_id'] . '.' . $_POST['picture']['name'];
  }
  if (!empty($_POST['folders_name'])) {
    $save = array();
    $save['users_id'] = $account['users_id'];
    $save['folders_mod'] = 'usersgallery';
    $save['folders_name'] = $_POST['folders_name'];
    $save_cells = array_keys($save);
    $save_values = array_values($save);
    cs_sql_insert(__FILE__,'folders',$save_cells,$save_values);
    $created_folder = cs_sql_insertid(__FILE__);
  }
  $cs_gallery['usersgallery_titel'] = $_POST['gallery_titel'];
  $cs_gallery['folders_id'] = empty($created_folder) ? (int) $_POST['folders_id'] : $created_folder;
  $cs_gallery['usersgallery_access'] =  $_POST['gallery_access'];
  $cs_gallery['usersgallery_description'] = $_POST['description'];
  $cs_gallery['usersgallery_status'] =  isset($_POST['gallery_status']) ? $_POST['gallery_status'] : 0;
  $cs_gallery['usersgallery_vote'] = isset($_POST['gallery_vote']) ? $_POST['gallery_vote'] : 0;
  $cs_gallery['usersgallery_close'] = isset($_POST['gallery_close']) ? $_POST['gallery_close'] : 0;
  $gray = isset($_POST['gray']) ? $_POST['gray'] : 0;
  $download = isset($_POST['download']) ? $_POST['download'] : 0;
  $download_original = isset($_POST['download_original']) ? $_POST['download_original'] : 0;
  $cs_gallery['usersgallery_download'] = $download . '|--@--|' . $download_original;
} else {
  $cs_gallery['usersgallery_name'] = '';
  $cs_gallery['usersgallery_titel'] = '';
  $cs_gallery['folders_id'] = 0;
  $cs_gallery['usersgallery_access'] = 0;
  $cs_gallery['usersgallery_status'] = 1;
  $cs_gallery['usersgallery_description'] = '';
  $cs_gallery['usersgallery_close'] = '0';
  $cs_gallery['usersgallery_vote'] = '1';
  $download = '1';
  $download_original = '1';
  $gray = '0';
  $file_up = 0;
}

$data['head']['mod'] = cs_link($cs_lang['mod'],'usersgallery','center');

if(isset($_POST['submit'])) {
  if(empty($_FILES['picture']['tmp_name'])) {
    $g_error++;
    $message .= $cs_lang['error_pic'] . cs_html_br(1);
  }
  if(empty($_POST['gallery_titel'])) {
    $g_error++;
    $message .= $cs_lang['no_titel'] . cs_html_br(1);
  }
  $check_file = $_FILES['picture']['name'];
  $where = "usersgallery_name = '" . cs_sql_escape($check_file) . "'";
  $pic_check = cs_sql_select(__FILE__,'usersgallery','*',$where,'usersgallery_id DESC',0,0);
  $loop_pic_check = count($pic_check);

  if(!empty($loop_pic_check))
  {
    $g_error++;
    $message .= $cs_lang['img_is'] . cs_html_br(1);
  }
  if(empty($cs_gallery['folders_id']))
  {
    $g_error++;
    $message .= $cs_lang['no_cat'] . cs_html_br(1);
  }
  if(empty($_POST['description']))
  {
    $g_error++;
    $message .= $cs_lang['no_description'] . cs_html_br(1);
  }
  $img_size = getimagesize($_FILES['picture']['tmp_name']);
  if(!empty($_FILES['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3)
  {
    $message .= $cs_lang['ext_error'] . cs_html_br(1);
    $error++;
  }
  elseif(!empty($_FILES['picture']['tmp_name']))
  {
      $filename = $cs_gallery['users_id'] . '.' . $_FILES['picture']['name'];
    if($img_size[0]>$cs_option['width'])
    {
      $message .= $cs_lang['too_wide'] . cs_html_br(1);
      $error++;
    }
    if($img_size[1]>$cs_option['height'])
    {
      $message .= $cs_lang['too_high'] . cs_html_br(1);
      $error++;
    }
    if($_FILES['picture']['size']>$cs_option['size'])
    {
      $size = $_FILES['picture']['size'] - $cs_option['size2'];
      $size = cs_filesize($size);
      $message .= sprintf($cs_lang['too_big'], $size) . cs_html_br(1);
      $error++;
    }
    $where = "users_id = '" . $cs_gallery['users_id'] . "'";
    $count_user_files = cs_sql_count(__FILE__,'usersgallery',$where);
    if($count_user_files >= $cs_option['max_files'])
    {
      $message .= $cs_lang['too_many_f'] . cs_html_br(1);
      $g_error++;
    }
    if(extension_loaded('gd') AND !empty($gray))
    {
      require_once('mods/gallery/gd_2.php');
      cs_gray($_FILES['picture']['tmp_name']);
    }
    if(empty($g_error) AND empty($error) AND cs_upload('usersgallery/pics', $filename, $_FILES['picture']['tmp_name']) OR empty($g_error) AND !empty($error) AND extension_loaded('gd') AND cs_resample($_FILES['picture']['tmp_name'], 'uploads/usersgallery/pics/' . $filename, $cs_option['width'], $cs_option['height']))
    {
      if(empty($g_error) AND empty($error) AND !extension_loaded('gd') AND cs_upload('usersgallery/thumbs', 'Thumb_' . $filename, $_FILES['picture_thumb']['tmp_name']) OR empty($g_error) AND empty($error) AND extension_loaded('gd') AND cs_resample('uploads/usersgallery/pics/' . $filename, 'uploads/usersgallery/thumbs/' . 'Thumb_' . $filename, $cs_option['thumbs'], $cs_option['thumbs']) OR empty($g_error) AND !empty($error) AND extension_loaded('gd') AND cs_resample('uploads/usersgallery/pics/' . $filename, 'uploads/usersgallery/thumbs/' . 'Thumb_' . $filename, $cs_option['thumbs'], $cs_option['thumbs']))
      {
        $error = 0;
      } else {
        $error = 1;
        $message .= $cs_lang['upload_error'] . cs_html_br(1);
      }
    } else {
      $error = 1;
      $message .= $cs_lang['upload_error'] . cs_html_br(1);
    }
  }
  if(empty($error) AND empty($g_error))
  {
    $gallery_cells = array_keys($cs_gallery);
    $gallery_save = array_values($cs_gallery);
    cs_sql_insert(__FILE__,'usersgallery',$gallery_cells,$gallery_save);

    cs_redirect($cs_lang['create_done'],'usersgallery','center');
  }
}

if(!empty($g_error) OR !empty($error) OR empty($_FILES['picture']['tmp_name']))
{
  $data['error']['icon'] = !empty($message) ? cs_icon('important') : '';
  $data['error']['error'] = !empty($message) ? $cs_lang['error'] . cs_html_br(1) : '';
  $data['error']['message'] = !empty($message) ? $message : '';
  $data['body']['picture'] = empty($message) ? $cs_lang['body_picture'] : '';
}


if(!isset($_POST['submit']) OR !empty($error) OR !empty($g_error))
{
  $data['url']['usersgallery_users_create'] = cs_url('usersgallery','users_create');
  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2]  = $cs_lang['max_width'] . $cs_option['width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $cs_option['height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($cs_option['size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['data']['infobox'] = cs_abcode_clip($matches);

##############################--- NO GD ---Thumbs --- START ----####################################
  if(!extension_loaded('gd')) {
    echo cs_html_roco(1,'leftc');
    echo cs_icon('download') . $cs_lang['upload_thumb'] . ' *';
    echo cs_html_roco(2,'leftb',0,2);
    echo cs_html_input('picture_thumb','','file');

    echo cs_html_br(2);
    $matches[1] = $cs_lang['pic_infos'];
    $return_types = '';
    foreach($img_filetypes AS $add => $value) {
      $return_types .= empty($return_types) ? $add : ', ' . $add;
    }
    $matches[2] = $cs_lang['max_width'] . $cs_option['thumbs'] . ' px' . cs_html_br(1);
    $matches[2] .= $cs_lang['max_height'] . $cs_option['thumbs'] . ' px' . cs_html_br(1);
    $matches[2] .= $cs_lang['max_size'] . cs_filesize('10240') . cs_html_br(1);
    $matches[2] .= $cs_lang['filetypes'] . $return_types;
    echo cs_abcode_clip($matches);
    echo cs_html_roco(0);
  }
##############################--- NO GD --- Thumbs --- ENDE ----####################################

  $data['data']['title'] = $cs_gallery['usersgallery_titel'];
  $data['data']['folders'] = make_folders_select('folders_id',$cs_gallery['folders_id'],$cs_gallery['users_id'],'usersgallery');

  $data['data']['access'] = cs_html_select(1,'gallery_access');
  $levels = 0;
  while($levels < 6) {
    $cs_gallery['usersgallery_access'] == $levels ? $sel = 1 : $sel = 0;
    $data['data']['access'] .= cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
    $levels++;
  }
  $data['data']['access'] .= cs_html_select(0);

  $data['data']['status'] = cs_html_select(1,'gallery_status');
  $levels = 0;
  while($levels < 2) {
    $cs_gallery['usersgallery_status'] == $levels ? $sel = 1 : $sel = 0;
    $data['data']['status'] .= cs_html_option($cs_lang['show_' . $levels],$levels,$sel);
    $levels++;
  }
  $data['data']['status'] .= cs_html_select(0);
  $data['abcode']['smileys'] = cs_abcode_smileys('description');
  $data['abcode']['features'] = cs_abcode_features('description');
  $data['data']['description'] = $cs_gallery['usersgallery_description'];

  $data['data']['votes'] = cs_html_vote('gallery_vote','1','checkbox',$cs_gallery['usersgallery_vote']) . $cs_lang['vote_endi'];
  $data['data']['downloads'] = cs_html_vote('download','1','checkbox',$download) . $cs_lang['download_endi'];
  $data['data']['gray'] = '';
  if(extension_loaded('gd')) {
    $data['data']['gray'] = cs_html_vote('gray','1','checkbox',$gray) . $cs_lang['gray'];
  }
  $data['data']['comments'] = cs_html_vote('gallery_close','1','checkbox',$cs_gallery['usersgallery_close']) . $cs_lang['gallery_close'];
  echo cs_subtemplate(__FILE__,$data,'usersgallery','users_create');
}
?>