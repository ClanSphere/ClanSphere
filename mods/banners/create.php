<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('banners');
$files = cs_files();

require_once('mods/categories/functions.php');

$op_banners = cs_sql_option(__FILE__,'banners');
$img_filetypes = array('gif','jpg','png');

if(isset($_POST['submit'])) {
  $cs_banners['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : cs_categories_create('banners',$_POST['categories_name']);
  $cs_banners['banners_name'] = $_POST['banners_name'];
  $cs_banners['banners_url'] = $_POST['banners_url'];
  $cs_banners['banners_picture'] = $_POST['banners_picture'];
  $cs_banners['banners_alt'] = $_POST['banners_alt'];
  $cs_banners['banners_order'] = empty($_POST['banners_order']) ? $op_banners['def_order'] : $_POST['banners_order'];
  
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
      $extension = 'gif'; break;
    case 2:
      $extension = 'jpg'; break;
    case 3:
      $extension = 'png'; break;
    }
    
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
  $search = cs_sql_count(__FILE__,'banners',$where);

  if(!empty($search)) {
    $error++;
    $message .= $cs_lang['banner_exists'] . cs_html_br(1);
  }
}
else {
  $cs_banners['banners_name'] = '';
  $cs_banners['banners_url'] = '';
  $cs_banners['banners_picture'] = '';
  $cs_banners['banners_alt'] = '';
  $cs_banners['banners_order'] = $op_banners['def_order'];
  $cs_banners['categories_id'] = 0;
}

if(!isset($_POST['submit'])) {
  $data['lang']['body'] = $cs_lang['body_create'];
}
elseif(!empty($error)) {
  $data['lang']['body'] = $message;
}
else {
  $data['lang']['body'] = $cs_lang['create_done'];
}

if(!empty($error) OR !isset($_POST['submit'])) {
  $data['action']['form'] = cs_url('banners','create');
  $data['banners']['name'] = $cs_banners['banners_name'];
  $data['banners']['category'] = cs_categories_dropdown('banners',$cs_banners['categories_id']); 
  $data['banners']['url'] = $cs_banners['banners_url'];
  $data['banners']['or_img_url'] = $cs_banners['banners_picture'];
  $data['banners']['alt'] = $cs_banners['banners_alt'];
  $data['banners']['order'] = $cs_banners['banners_order'];
  
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
  
  echo cs_subtemplate(__FILE__,$data,'banners','create');
}
else {
  settype($cs_banners['banners_order'],'integer');

  $banners_cells = array_keys($cs_banners);
  $banners_save = array_values($cs_banners);
  cs_sql_insert(__FILE__,'banners',$banners_cells,$banners_save);

  if(!empty($files['picture']['tmp_name'])) {
    $where = "banners_name = '" . cs_sql_escape($cs_banners['banners_name']) . "'";
    $getid = cs_sql_select(__FILE__,'banners','banners_id',$where);
    $filename = 'picture-' . $getid['banners_id'] . '.' . $extension;
    cs_upload('banners',$filename,$files['picture']['tmp_name']);
    
    $cs_banners2['banners_picture'] = 'uploads/banners/' . $filename;
    $banners2_cells = array_keys($cs_banners2);
    $banners2_save = array_values($cs_banners2);      
    cs_sql_update(__FILE__,'banners',$banners2_cells,$banners2_save,$getid['banners_id']);
  }
  cs_redirect($cs_lang['create_done'],'banners');
}