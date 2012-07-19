<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

$files_gl = cs_files();

$data = array();

$option = cs_sql_option(__FILE__,'categories');
$option2 = cs_sql_option(__FILE__,'gallery');
$img_filetypes = array('gif','jpg','png');

require_once('mods/gallery/functions.php');

$folders['sub_id'] = '';
$folders['folders_name'] = '';
$folders['folders_mod'] = 'gallery';
$folders['folders_url'] = '';
$folders['folders_text'] = '';
$folders['folders_access'] = 0;
$folders['folders_position'] = 1;
$folders['folders_advanced'] = '';
$adv_vote = 1;
$adv_close = 0;
$adv_dl = 1;
$adv_dlo = 0;

if(isset($_POST['submit'])) {

  $folders['users_id'] = 0;
  $folders['sub_id'] = $_POST['sub_id'];
  $folders['folders_name'] = $_POST['folders_name1'];
  $folders['folders_url'] = $_POST['folders_url'];
  $folders['folders_text'] = $_POST['folders_text'];
  $folders['folders_access'] = $_POST['folders_access'];
  $folders['folders_position'] = $_POST['folders_position'];
  
    $adv_vote = isset($_POST['adv_vote']) ? $_POST['adv_vote'] : 0;
    $adv_close = isset($_POST['adv_close']) ? $_POST['adv_close'] : 0;
    $adv_dl = isset($_POST['adv_download']) ? $_POST['adv_download'] : 0;
    $adv_dlo = isset($_POST['adv_download_original']) ? $_POST['adv_download_original'] : 0;  
  $advanced = array($adv_vote,$adv_close,$adv_dl,$adv_dlo);
  $folders['folders_advanced'] = implode(",",$advanced);

  $error = '';

  if(!empty($files_gl['picture']['tmp_name'])) {
    $img_size = getimagesize($files_gl['picture']['tmp_name']);
    if(!empty($files_gl['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
      $error .= $cs_lang['ext_error'] . cs_html_br(1);
    } elseif(!empty($files_gl['picture']['tmp_name'])) {
      switch($img_size[2]) {
        case 1:
          $extension = 'gif'; break;
        case 2:
          $extension = 'jpg'; break;
        case 3:
          $extension = 'png'; break;
      }
      if($img_size[0] > $option['max_width'])
        $error .= $cs_lang['too_wide'] . cs_html_br(1);
      if($img_size[1] > $option['max_height'])
        $error .= $cs_lang['too_high'] . cs_html_br(1);
      if($files_gl['picture']['size'] > $option['max_size'])
        $error .= $cs_lang['too_big'] . cs_html_br(1);
    }
  }
  if(empty($folders['folders_name']))
    $error .= $cs_lang['error_name'] . cs_html_br(1);

  $where = "folders_name = '" . cs_sql_escape($folders['folders_name']) . "' AND folders_mod = 'gallery'";
  $search = cs_sql_count(__FILE__,'folders',$where);
  if(!empty($search))
    $error .= $cs_lang['cat_exists'] . cs_html_br(1);
}

if(!isset($_POST['submit']))
  $data['head']['body'] = $cs_lang['body_folder'];
elseif(!empty($error))
  $data['head']['body'] = $error;

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['data'] = $folders;
  $data['data']['folders_select'] = make_folders_select('sub_id',$folders['sub_id'],'0','gallery');

  $levels = 0;
  $data['data']['folders_access'] = '';
  while($levels < 6) {
    $folders['folders_access'] == $levels ? $sel = 1 : $sel = 0;
    $data['data']['folders_access'] .= cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
    $levels++;
  }
   
  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $option['max_width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $option['max_height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($option['max_size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['data']['info_clip'] = cs_abcode_clip($matches);
  
  $checked = 'checked="checked"';
  $data['check']['vote'] = empty($adv_vote) ? '' : $checked;
  $data['check']['close'] = empty($adv_close) ? '' : $checked;
  $data['check']['dl'] = empty($adv_dl) ? '' : $checked;
  $data['check']['dlo'] = empty($adv_dlo) ? '' : $checked;

  
 echo cs_subtemplate(__FILE__,$data,'gallery','folders_create');
}
else {

  $folder_cells = array_keys($folders);
  $folder_save = array_values($folders);
  cs_sql_insert(__FILE__,'folders',$folder_cells,$folder_save);
 
  if(!empty($files_gl['picture']['tmp_name'])) {
    $id = cs_sql_insertid(__FILE__);
    $filename = 'picture-' . $id . '.' . $extension;
    cs_upload('folders',$filename,$files_gl['picture']['tmp_name']);

    $cells = array('folders_picture');
    $save = array($filename);
    cs_sql_update(__FILE__,'folders',$cells,$save,$id);
  }

  cs_redirect($cs_lang['create_done'],'gallery','folders_manage');
}