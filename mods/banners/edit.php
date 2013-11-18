<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('banners');
require_once('mods/categories/functions.php');
$files = cs_files();

$banners_id = $_REQUEST['id'];
settype($banners_id,'integer');

$op_banners = cs_sql_option(__FILE__,'banners');
$img_filetypes = array('gif','jpg','png');

if(isset($_POST['submit'])) {
  $cs_banners['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : cs_categories_create('banners',$_POST['categories_name']);
  $cs_banners['banners_name'] = $_POST['banners_name'];
  $cs_banners['banners_url'] = $_POST['banners_url'];
  $cs_banners['banners_alt'] = $_POST['banners_alt'];
  $cs_banners['banners_order'] = empty($_POST['banners_order']) ? $op_banners['def_order'] : $_POST['banners_order'];
  $cs_banners['banners_picture'] = $_POST['banners_picture'];

  $error = 0;
  $message = '';

  $img_size = false;
  if(!empty($files['picture']['tmp_name']))
    $img_size = getimagesize($files['picture']['tmp_name']);

  if(!empty($files['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
    $message .= $cs_lang['ext_error'] . cs_html_br(1);
    $error++;
  }
  elseif(!empty($files['picture']['tmp_name'])) {
    switch($img_size[2]) {
    case 1:
      $ext = 'gif'; break;
    case 2:
      $ext = 'jpg'; break;
    case 3:
      $ext = 'png'; break;
    }
    
  $filename = 'picture-' . $banners_id . '.' . $ext;
    
    if($img_size[0]>$op_banners['max_width']) {
      $message .= $cs_lang['too_wide'] . cs_html_br(1);
      $error++;
    }
    
  if($img_size[1]>$op_banners['max_height']) { 
      $message .= $cs_lang['too_high'] . cs_html_br(1);
      $error++;
    }
    
  if($files['picture']['size']>$op_banners['max_size']) { 
      $message .= $cs_lang['too_big'] . cs_html_br(1);
      $error++;
    }
    
  if(empty($error) AND cs_upload('banners', $filename, $files['picture']['tmp_name']) OR !empty($error) AND extension_loaded('gd') AND cs_resample($files['picture']['tmp_name'], 'uploads/banners/' . $filename, $op_banners['max_width'], $op_banners['max_height'])) {
      $error = 0;
      $message = '';
      
    if($cs_banners['banners_picture'] != $filename AND file_exists($cs_banners['banners_picture'])) {
        unlink($cs_banners['banners_picture']);
      }
      $cs_banners['banners_picture'] = 'uploads/banners/' . $filename;
    }
    else {
      $message .= $cs_lang['up_error'];
      $error++;
    }
  }
  
  if(empty($files['picture']['tmp_name']) AND empty($cs_banners['banners_picture'])) {
    $error++;
    $message .= $cs_lang['no_pic'] . cs_html_br(1);
  }
  
  if(empty($cs_banners['banners_name'])) {
    $error++;
    $message .= $cs_lang['no_name'] . cs_html_br(1);
  }
  
  if(empty($cs_banners['banners_url'])) {
    $error++;
    $message .= $cs_lang['no_url'] . cs_html_br(1);
  }
  
  if(empty($cs_banners['categories_id'])) {
    $error++;
    $message .= $cs_lang['no_cat'] . cs_html_br(1);
  }
  
  $where = "banners_name = '" . cs_sql_escape($cs_banners['banners_name']) . "'";
  $where .= " AND banners_id != '" . $banners_id . "'";
  $search = cs_sql_count(__FILE__,'banners',$where);
  
  if(!empty($search)) {
    $error++;
    $message .= $cs_lang['banner_exists'] . cs_html_br(1);
  }
}
else {
  $cells = 'banners_name, banners_url, banners_alt, banners_order, banners_picture, categories_id';
  $cs_banners = cs_sql_select(__FILE__,'banners',$cells,"banners_id = '" . $banners_id . "'");
}

if(!isset($_POST['submit'])) {
  $data['lang']['body'] = $cs_lang['body_edit'];
}
elseif(!empty($error)) {
  $data['lang']['body'] = $message;
}

if(!empty($error) OR !isset($_POST['submit'])) {
  $data['action']['form'] = cs_url('banners','edit',1);
  $data['banners']['name'] = $cs_banners['banners_name'];
  $data['banners']['category'] = cs_categories_dropdown('banners',$cs_banners['categories_id']); 
  $data['banners']['url'] = $cs_banners['banners_url'];
  $data['banners']['or_img_url'] = $cs_banners['banners_picture'];
  $data['banners']['alt'] = $cs_banners['banners_alt'];
  $data['banners']['order'] = $cs_banners['banners_order']; 

  if(empty($cs_banners['banners_picture'])) {
    $data['banners']['pic_current'] = $cs_lang['nopic'];
  }
  else {
    $data['banners']['pic_current'] = cs_html_img($cs_banners['banners_picture']);
  }
  
  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $op_banners['max_width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $op_banners['max_height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($op_banners['max_size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['banners']['clip'] = cs_abcode_clip($matches);
  
  $data['data']['id'] = $banners_id;
  
  echo cs_subtemplate(__FILE__,$data,'banners','edit');
}
else {
  settype($cs_banners['banners_order'],'integer');

  $banners_cells = array_keys($cs_banners);
  $banners_save = array_values($cs_banners);
  cs_sql_update(__FILE__,'banners',$banners_cells,$banners_save,$banners_id);
  
  cs_redirect($cs_lang['changes_done'], 'banners') ;
}