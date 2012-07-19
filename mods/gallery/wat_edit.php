<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

$files_gl = cs_files();

$cs_post = cs_post('id');
$cs_get = cs_get('id');

$wm_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $wm_id = $cs_post['id'];

$img_max['width'] = 200;
$img_max['height'] = 200;
$img_max['size'] = 76800;
$img_filetypes = array('gif','png');

$where = "categories_id = '" . $wm_id . "'";
$cs_gallery_wm = cs_sql_select(__FILE__,'categories','categories_name, categories_picture',$where);

if(isset($_POST['submit'])) {
  
  $cs_gallery_wm['categories_name'] = $_POST['categories_name'];
  $cs_gallery_wm['categories_mod'] = 'gallery-watermark';
  
  $error = '';

  if(!empty($files_gl['picture']['tmp_name'])) {
    $img_size = getimagesize($files_gl['picture']['tmp_name']);
      switch($img_size[2]) {
      case 1:
        $ext = 'gif'; break;
      case 3:
        $ext = 'png'; break;
    }

    if($img_size[0]>$img_max['width']) 
      $error .= $cs_lang['too_wide'] . cs_html_br(1);
    if($img_size[1]>$img_max['height']) 
      $error .= $cs_lang['too_high'] . cs_html_br(1);
    
    if($files_gl['picture']['size']>$img_max['size']) { 
      $size = $files_gl['picture']['size'] - $img_max['size'];
      $size = cs_filesize($size);
      $error .= sprintf($cs_lang['too_big'], $size) . cs_html_br(1);
    }
  } else {
    $error .= $cs_lang['no_watermark'] . cs_html_br(1);
  }
  

  if(!empty($cs_gallery_wm['categories_name'])) {
    $where = "categories_name = '" . cs_sql_escape($cs_gallery_wm['categories_name']) . "' AND categories_mod = 'gallery-watermark' ";
    $where .= "AND categories_id != '" . $wm_id . "'";
    $check_name = cs_sql_count(__FILE__,'categories',$where);
    if(!empty($check_name))
      $error .= $cs_lang['watermark_exists'] . cs_html_br(1);
  } else {
    $error .= $cs_lang['no_name'] . cs_html_br(1);
  } 
}

if(!isset($_POST['submit'])) 
  $data['head']['body'] = $cs_lang['body_edit'];
elseif(!empty($error)) 
  $data['head']['body'] = $error;


if(!empty($error) OR !isset($_POST['submit'])) {

  $data['data'] = $cs_gallery_wm;

  $select = 'categories_picture, categories_name'; 
  $where = "categories_id = '" . $wm_id . "'";
  $cs_gallery_wm = cs_sql_select(__FILE__,'categories',$select,$where);

  $data['wm']['current'] = cs_html_img('uploads/categories/' . $cs_gallery_wm['categories_picture']);

  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $img_max['width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $img_max['height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($img_max['size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['picup']['clip'] = cs_abcode_clip($matches);

  $data['wm']['id'] = $wm_id;
  
 echo cs_subtemplate(__FILE__,$data,'gallery','wat_edit');
}
else {

  $wm_cells = array_keys($cs_gallery_wm);
  $wm_save = array_values($cs_gallery_wm);
  cs_sql_update(__FILE__,'categories',$wm_cells,$wm_save,$wm_id);

  if(!empty($files_gl['picture']['tmp_name'])) {
    $filename = 'watermark-' . $wm_id . '.' . $ext;
   cs_upload('categories',$filename,$files_gl['picture']['tmp_name']);
  
    $cells = array('categories_picture');
    $save = array($filename);      
   cs_sql_update(__FILE__,'categories',$cells,$save,$wm_id);
  }
  
 cs_redirect($cs_lang['changes_done'],'gallery','wat_manage');
}