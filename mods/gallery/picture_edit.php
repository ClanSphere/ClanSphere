<?php

// ClanSphere 2006 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
require_once('mods/gallery/functions.php');

$gallery_id = $_REQUEST['id'];
settype($gallery_id,'integer');

$reset_counter = 0;
$new_time = 0;
$error = 0;
$message = '';

$data['body']['picture_create'] = '';
$data['error']['icon'] = '';
$data['error']['error'] = '';
$data['error']['message'] = '';

if(isset($_POST['submit'])) {
  $cs_gallery['folders_id'] = empty($_POST['folders_name']) ? $_POST['folders_id'] : make_folders_create('gallery',$_POST['folders_name']);
  $cs_gallery['gallery_name'] = isset($_POST['gallery_name']) ? $_POST['gallery_name'] : 0;
  $cs_gallery['gallery_close'] = isset($_POST['gallery_close']) ? $_POST['gallery_close'] : 0;
  $cs_gallery['gallery_titel'] = $_POST['gallery_titel'];
  $cs_gallery['gallery_access'] = !empty($_POST['gallery_access']) ? $_POST['gallery_access'] : 0;
  $cs_gallery['gallery_status'] = !empty($_POST['gallery_status']) ? $_POST['gallery_status'] : 0;
  $cs_gallery['gallery_description'] = $_POST['gallery_description'];
  $cs_gallery['gallery_vote'] = isset($_POST['gallery_vote']) ? $_POST['gallery_vote'] : 0;
  //$download[0] = Picture Download on/off
  $download[0] = isset($_POST['gallery_download']) ? $_POST['gallery_download'] : 0;
  //$download[1] = Zip Download on/off (no watermark @ the picture)
  $download[1] = isset($_POST['gallery_download_zip']) ? $_POST['gallery_download_zip'] : 0;
  $cs_gallery['gallery_download'] = $download[0] . '|--@--|' . $download[1];
  $cs_gallery['gallery_watermark'] = $_POST['watermark'];

  if(empty($cs_gallery['gallery_titel'])) {
    $error++;
    $message .= $cs_lang['no_titel'] . cs_html_br(1);
  }
  if (empty($cs_gallery['folders_id'])) {
    $error++;
    $message .= $cs_lang['no_cat'] . cs_html_br(1);
  }
  if(!empty($cs_gallery['gallery_watermark']))  {
    //$watermark[0] = The Watermark Position @ the Picture
    $watermark[0] = $_POST['watermark_pos'];
    //$watermark[1] = The Watermark Transparency @ the Picture
    $watermark[1] = $_POST['watermark_trans'];
    $cs_gallery['gallery_watermark_pos'] = $watermark[0] . '|--@--|' . $watermark[1];
  }  else {
    $watermark[0] = '';
    $watermark[1] = '';
  }

  if(!empty($_POST['new_time'])) {
    $new_time = 1;
    $cs_gallery['gallery_time']  = cs_time();
  }

  if(!empty($_POST['reset_counter'])) {
    $reset_counter = 1;
    $cs_gallery['gallery_count'] = 0;
  }

} else {
  $fileerror = 1;
  $select = 'folders_id, gallery_name, gallery_titel, gallery_access, gallery_status, ';
  $select .= 'gallery_description, gallery_vote, gallery_download, gallery_watermark, ';
  $select .= 'gallery_watermark_pos, gallery_close';
  $cs_gallery = cs_sql_select(__FILE__,'gallery',$select,"gallery_id = '" . $gallery_id . "'");
  //$download[0] = Picture Download on/off
  //$download[1] = Zip Download on/off (no watermark @ the picture)
  $download = explode("|--@--|", $cs_gallery['gallery_download']);
  //$watermark[0] = The Watermark Position @ the Picture
  //$watermark[1] = The Watermark Transparency @ the Picture
  $watermark = explode("|--@--|", $cs_gallery['gallery_watermark_pos']);
}

if(!isset($_POST['submit'])) {
  $data['body']['picture_create'] = $cs_lang['body_edit'];
} elseif(!empty($error)) {
  $data['error']['icon'] = cs_icon('important');
  $data['error']['error'] = $cs_lang['error_occured'] . cs_html_br(1);
  $data['error']['message'] = $message;
} else {
  $cells = array_keys($cs_gallery);
  $save = array_values($cs_gallery);
  cs_sql_update(__FILE__,'gallery',$cells,$save,$gallery_id);
  $data['head']['action'] = $cs_lang['picture'];
  $data['link']['continue'] = cs_link($cs_lang['continue'],'gallery','manage');
  echo cs_subtemplate(__FILE__,$data,'gallery','done');
  cs_redirect($cs_lang['changes_done'],'gallery','manage');
}

if(!empty($error) OR !isset($_POST['submit'])) {
  $data['url']['gallery_picture_edit'] = cs_url('gallery','picture_edit');
  $data['data']['picture'] = cs_html_img('mods/gallery/image.php?picname=' . $cs_gallery['gallery_name']);
  $data['data']['gallery_titel'] = $cs_gallery['gallery_titel'];
  $data['data']['folders_select'] = make_folders_select('folders_id',$cs_gallery['folders_id'],'0','gallery');

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
      $cat_data_watermark = array_merge ($no_cat_data_watermark, $cat_data_watermark_1);
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
    $onc .= "watermark.options[this.form.watermark.selectedIndex].value";
    $var = cs_html_select(1,'watermark',"onchange=\"" . $onc . "\"");
    foreach ($cat_data_watermark as $datax) {
      $datax['categories_picture'] == $cs_gallery['gallery_watermark'] ? $sel = 1 : $sel = 0;
      $var .= cs_html_option($datax['categories_name'],$datax['categories_picture'],$sel);
    }
    $var .= cs_html_select(0) . ' ';
    $data['data']['w_select'] = $var;
    if(!empty($watermark_id)) {
      $url = 'uploads/categories/' . $cat_data_watermark[$watermark_id]['categories_picture'];
    }  else {
      $url = 'symbols/gallery/nowatermark.png';
    }
    $data['data']['w_img'] = cs_html_img($url,'','','id="' . $el_id . '"');
    $data['data']['w_position'] = cs_html_select(1,'watermark_pos');
    $levels = 1;
    while($levels < 10) {
      $watermark[0] == $levels ? $sel = 1 : $sel = 0;
      $data['data']['w_position'] .= cs_html_option($levels . ' - ' . $cs_lang['watermark_' . $levels],$levels,$sel);
      $levels++;
    }   
    $data['data']['w_position'] .= cs_html_select(0);  
    if(empty($watermark[1])) {
    $watermark[1] = '0';
    }
    $data['data']['w_trans'] = cs_html_input('watermark_trans',$watermark[1],'text',2,2);
  }
  

  $data['abcode']['smileys'] = cs_abcode_smileys('gallery_description');
  $data['abcode']['features'] = cs_abcode_features('gallery_description');
  $data['data']['gallery_description'] = $cs_gallery['gallery_description'];
  $data['data']['vote'] = cs_html_vote('gallery_vote','1','checkbox',$cs_gallery['gallery_vote']);
  $data['data']['download'] = cs_html_vote('gallery_download','1','checkbox',$download[0]);
//  $data['data']['gray'] = cs_html_vote('gray','1','checkbox',$gray);
  $data['data']['new_time'] = cs_html_vote('new_time','1','checkbox',$new_time);
  $data['data']['reset_counter'] = cs_html_vote('reset_counter','1','checkbox',$reset_counter);
  $data['data']['download_zip'] =  cs_html_vote('gallery_download_zip','1','checkbox',$download[1]);
  $data['data']['close'] = cs_html_vote('gallery_close','1','checkbox',$cs_gallery['gallery_close']);
  $data['data']['hidden_name'] = cs_html_vote('gallery_name',$cs_gallery['gallery_name'],'hidden');
  $data['data']['hidden_id'] = cs_html_vote('id',$gallery_id,'hidden');
  echo cs_subtemplate(__FILE__,$data,'gallery','picture_edit');
}
?>