<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

$files_gl = cs_files();

require_once('mods/gallery/functions.php');

$cs_option = cs_sql_option(__FILE__,'gallery');
$img_filetypes = array('gif','jpg','png');

$data['body']['picture_create'] = '';
$data['error']['icon'] = '';
$data['error']['error'] = '';
$data['error']['message'] = '';

if(isset($_POST['submit'])) {
  if (isset($files_gl['picture']['name'])) {
    if (file_exists('uploads/gallery/pics/' . $files_gl['picture']['name'])) {
      $filename_tmp = ( str_split($files_gl['picture']['name'], strrpos($files_gl['picture']['name'], '.')) );
      $filename_counter = 0;
      while (file_exists('uploads/gallery/pics/' . $filename_tmp[0] . '_' . $filename_counter . $filename_tmp[1]))
        $filename_counter++;
      $files_gl['picture']['name'] = $filename_tmp[0] . '_' . $filename_counter . $filename_tmp[1];
    }
  }
  else
    $files_gl['picture']['name'] = 0;

  $file_up = !empty($_POST['file_up']) ? $_POST['file_up'] : 0;
  if ($file_up == 0) {
    $cs_gallery['gallery_name'] = $files_gl['picture']['name'];
  }  elseif ($file_up == 1) {
    $cs_gallery['gallery_name'] = $_POST['gallery_name'];
  }

  $cs_gallery['gallery_titel'] = $_POST['gallery_titel'];
  $cs_gallery['folders_id'] = empty($_POST['folders_name']) ? $_POST['folders_id'] : make_folders_create('gallery',$_POST['folders_name']);
  $cs_gallery['users_id'] = $account['users_id'];
  $cs_gallery['gallery_access'] =  isset($_POST['gallery_access']) ? $_POST['gallery_access'] : 0;
  $cs_gallery['gallery_watermark'] = isset($_POST['gallery_watermark']) ? $_POST['gallery_watermark'] : '';
  $cs_gallery['gallery_description'] = $_POST['gallery_description'];
  $cs_gallery['gallery_status'] =  isset($_POST['gallery_status']) ? $_POST['gallery_status'] : 1;
  $cs_gallery['gallery_time'] = cs_time();
  $gray = isset($_POST['gray']) ? $_POST['gray'] : 0;
  $gallery_watermark_trans = isset($_POST['gallery_watermark_trans']) ? $_POST['gallery_watermark_trans'] : '20';
  $watermark_pos = isset($_POST['watermark_pos']) ? $_POST['watermark_pos'] : '1';

  $error = '';

  if($file_up == 0 AND empty($files_gl['picture']['tmp_name'])) {
    $error .= $cs_lang['error_pic'] . cs_html_br(1);
  }
  if(empty($_POST['gallery_titel'])) {
    $error .= $cs_lang['no_titel'] . cs_html_br(1);
  }
  if(empty($cs_gallery['folders_id'])) {
    $error .= $cs_lang['no_cat'] . cs_html_br(1);
  }
  $check_name = cs_sql_count(__FILE__,'gallery',"gallery_name = '" . cs_sql_escape($cs_gallery['gallery_name']) . "'");
  if (!empty($check_name)) {
    $error .= $cs_lang['img_is'] . cs_html_br(1);
  }

  if($file_up == 0) {
    $img_size = empty($files_gl['picture']['tmp_name']) ? false : getimagesize($files_gl['picture']['tmp_name']);
    if(!empty($files_gl['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
      $error .= $cs_lang['ext_error'] . cs_html_br(1);
    }
    elseif(!empty($files_gl['picture']['tmp_name'])) {
      $filename = $files_gl['picture']['name'];
      $s_error = 0;
      if($img_size[0]>$cs_option['width']) {
        $error .= $cs_lang['too_wide'] . cs_html_br(1);
        $s_error++; //size_error
      }
      if($img_size[1]>$cs_option['height']) {
        $error .= $cs_lang['too_high'] . cs_html_br(1);
        $s_error++; //size_error
      }
      if($files_gl['picture']['size']>$cs_option['size']) {
        $size = $files_gl['picture']['size'] - $cs_option['size'];
        $size = cs_filesize($size);
        $error .= sprintf($cs_lang['too_big'], $size) . cs_html_br(1);
      }
      if(extension_loaded('gd') AND !empty($gray)) {
        require_once('mods/gallery/gd_2.php');
        cs_gray($files_gl['picture']['tmp_name']);
      }

      if(empty($s_error) AND cs_upload('gallery/pics', $filename, $files_gl['picture']['tmp_name']) OR !empty($s_error) AND extension_loaded('gd') AND cs_resample($files_gl['picture']['tmp_name'], 'uploads/gallery/pics/' . $filename, $cs_option['width'], $cs_option['height'])) {

        if(extension_loaded('gd') AND cs_resample('uploads/gallery/pics/' . $filename, 'uploads/gallery/thumbs/' . 'Thumb_' . $filename, $cs_option['thumbs'], $cs_option['thumbs'])) {

          $error .= empty($s_error) ? '' : $cs_lang['err_auto_size'];
          $s_error = 0;
          $file_up = 1;
        } else {
          $error .= $cs_lang['upload_error'] . cs_html_br(1);
        }
      } else {
        $error .= $cs_lang['upload_error'] . cs_html_br(1);
      }
    }
  }
}
else {
  $cs_gallery['gallery_titel'] = '';
  $cs_gallery['folders_id'] = '';
  $cs_gallery['gallery_access'] =  0;
  $cs_gallery['gallery_watermark'] = '';
  $cs_gallery['gallery_watermark_pos'] = '';
  $cs_gallery['gallery_description'] = '';
  $cs_gallery['gallery_status'] =  1;
  $gallery_watermark_trans = '20';
  $gray = '0';
  $watermark_pos = '1';
  $file_up = 0;
}

if(!isset($_POST['submit'])) {
  $data['body']['picture_create'] = $cs_lang['body_edit'];
}
elseif(!empty($error)) {
  $data['error']['icon'] = cs_icon('important');
  $data['error']['error'] = $cs_lang['error_occured'] . cs_html_br(1);
  $data['error']['message'] = $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['data'] = $cs_gallery;
  $data['data']['folders_select'] = make_folders_select('folders_id',$cs_gallery['folders_id'],'0','gallery');

  if(empty($file_up)) {
    $data['if']['file_up'] = FALSE;
    $data['if']['no_up'] = TRUE;
    $matches[1] = $cs_lang['pic_infos'];
    $return_types = '';
    foreach($img_filetypes AS $add) {
      $return_types .= empty($return_types) ? $add : ', ' . $add;
    }
    $matches[2] = $cs_lang['max_width'] . $cs_option['width'] . ' px' . cs_html_br(1);
    $matches[2] .= $cs_lang['max_height'] . $cs_option['height'] . ' px' . cs_html_br(1);
    $matches[2] .= $cs_lang['max_size'] . cs_filesize($cs_option['size']) . cs_html_br(1);
    $matches[2] .= $cs_lang['filetypes'] . $return_types;
    $data['data']['info_clip'] = cs_abcode_clip($matches);
  } elseif($file_up ==1) {
    $data['if']['no_up'] = FALSE;
    $data['if']['file_up'] = TRUE;
    $data['hidden']['gallery_name'] = $cs_gallery['gallery_name'];
    $data['show']['picture'] = cs_html_img('mods/gallery/image.php?picname=' . $cs_gallery['gallery_name']);
  }

  $var = cs_html_select(1,'gallery_access');
  $levels = 0;
  while($levels < 6) {
    $cs_gallery['gallery_access'] == $levels ? $sel = 1 : $sel = 0;
    $var .= cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
    $levels++;
  }
  $var .= cs_html_select(0);
  $data['data']['gallery_access'] = $var;

  $var = cs_html_select(1,'gallery_status');
  $levels = 0;
  while($levels < 2) {
    $cs_gallery['gallery_status'] == $levels ? $sel = 1 : $sel = 0;
    $var .= cs_html_option($cs_lang['show_' . $levels],$levels,$sel);
    $levels++;
  }
  $var .= cs_html_select(0);
  $data['data']['gallery_status'] = $var;

  if(extension_loaded('gd')) {
    $no_cat_data_watermark = array('0' => array('categories_id' => '', 'categories_mod' => 'gallery-watermark', 'categories_name' => $cs_lang['no_watermark'], 'categories_picture' => ''));
    $cat_data_watermark_1 = cs_sql_select(__FILE__,'categories','*',"categories_mod = 'gallery-watermark'",'categories_name',0,0);
    if(empty($cat_data_watermark_1)) {
      $cat_data_watermark = $no_cat_data_watermark;
    } else {
      $cat_data_watermark = array_merge($no_cat_data_watermark, $cat_data_watermark_1);
    }
    $search_value = $cs_gallery['gallery_watermark'];
    if(!empty($search_value)) {
      foreach ($cat_data_watermark as $key => $row) {
        foreach($row as $cell) {
          if (strpos($cell, $search_value) !== FALSE) {
            $watermark_id = $key;
          }
        }
      }
    }
    $el_id = 'watermark_1';
    $onc = "document.getElementById('" . $el_id . "').src='" . $cs_main['php_self']['dirname'] . "uploads/categories/' + this.form.";
    $onc .= "gallery_watermark.options[this.form.gallery_watermark.selectedIndex].value";
    $select1 = cs_html_select(1,'gallery_watermark',"onchange=\"" . $onc . "\"");
    foreach ($cat_data_watermark as $datax) {
      $datax['categories_picture'] == $cs_gallery['gallery_watermark'] ? $sel = 1 : $sel = 0;
      $select1 .= cs_html_option($datax['categories_name'],$datax['categories_picture'],$sel);
    }
    $select1 .= cs_html_select(0) . ' ';
    $data['data']['w_select'] = $select1;
    if(!empty($watermark_id)) {
      $url = 'uploads/categories/' . $cs_gallery['gallery_watermark'];
    }  else {
      $url = 'symbols/gallery/nowatermark.png';
    }
    $data['data']['w_img'] = cs_html_img($url,'','','id="' . $el_id . '"');
    $data['data']['w_position'] = cs_html_select(1,'watermark_pos');
    $levels = 1;
    while($levels < 10) {
      $watermark_pos == $levels ? $sel = 1 : $sel = 0;
      $data['data']['w_position'] .= cs_html_option($cs_lang['watermark_' . $levels],$levels,$sel);
      $levels++;
    }
    $data['data']['w_position'] .= cs_html_select(0);
    $data['data']['w_trans'] = $gallery_watermark_trans;
  }

  $data['abcode']['smileys'] = cs_abcode_smileys('gallery_description');
  $data['abcode']['features'] = cs_abcode_features('gallery_description');

  $checked = 'checked="checked"';
  $data['check']['gray'] = empty($gray) ? '' : $checked;

 echo cs_subtemplate(__FILE__,$data,'gallery','picture_create');
}
else {

  $cs_gallery['gallery_watermark_pos'] = $watermark_pos;
  $cells = array_keys($cs_gallery);
  $save = array_values($cs_gallery);
  cs_sql_insert(__FILE__,'gallery',$cells,$save);

  cs_redirect($cs_lang['create_done'],'gallery','manage');
}