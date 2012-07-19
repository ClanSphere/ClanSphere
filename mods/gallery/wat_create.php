<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

$files_gl = cs_files();

$data = array();

$img_max['width'] = 200;
$img_max['height'] = 200;
$img_max['size'] = 76800;
$img_filetypes = array('gif','png');

$cs_categories['categories_name'] = '';
$cs_categories['categories_mod'] = 'gallery-watermark';


if(isset($_POST['submit'])) {

  $cs_categories['categories_name'] = $_POST['categories_name'];
  
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

  if(!empty($cs_categories['categories_name'])) {
    $where = "categories_name = '" . cs_sql_escape($cs_categories['categories_name']) . "' AND categories_mod = 'gallery-watermark'";
    $check_name = cs_sql_count(__FILE__,'categories',$where);
    if(!empty($check_name))
      $error .= $cs_lang['watermark_exists'] . cs_html_br(1);
  } else {
    $error .= $cs_lang['no_name'] . cs_html_br(1);
  } 

} 

if(!isset($_POST['submit'])) 
  $data['head']['body'] = $cs_lang['body_create'];
elseif(!empty($error)) 
  $data['head']['body'] = $error;


if(!empty($error) OR !isset($_POST['submit'])) {

  $data['data'] = $cs_categories;

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

 echo cs_subtemplate(__FILE__,$data,'gallery','wat_create');
}
else {

  $categories_cells = array_keys($cs_categories);
  $categories_save = array_values($cs_categories);
 cs_sql_insert(__FILE__,'categories',$categories_cells,$categories_save);

  if(!empty($files_gl['picture']['tmp_name'])) {
    $id = cs_sql_insertid(__FILE__);
    $filename = 'watermark-' . $id . '.' . $ext;
   cs_upload('categories',$filename,$files_gl['picture']['tmp_name']);
  
    $categories2_cells = array('categories_picture');
    $categories2_save = array($filename);      
   cs_sql_update(__FILE__,'categories',$categories2_cells,$categories2_save,$id);
  }
  
 cs_redirect($cs_lang['create_done'],'gallery','wat_manage');
}