<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('categories');

$cs_post = cs_post('id');
$cs_get = cs_get('id');

$data = array();

$categories_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $categories_id = $cs_post['id'];

$op_categories = cs_sql_option(__FILE__,'categories');
$img_filetypes = array('gif','jpg','png');
$files = cs_files();

$data['if']['more'] = FALSE;

include 'mods/categories/functions.php';

if(isset($_POST['submit'])) {

  $cs_categories['categories_name'] = $_POST['categories_name'];
  $cs_categories['categories_url'] = $_POST['categories_url'];
  $cs_categories['categories_text'] = $_POST['categories_text'];
  $cs_categories['categories_access'] = $_POST['categories_access'];
  $cs_categories['categories_picture'] = $_POST['categories_picture'];
  $cs_categories['categories_order'] = $_POST['categories_order'];
  $cs_categories['categories_subid'] = (int) $_POST['categories_id'];
  
  $error = '';

  if(isset($_POST['delete']) AND $_POST['delete'] == TRUE AND !empty($cs_categories['categories_picture'])) {
    cs_unlink('categories', $cs_categories['categories_picture']);
    $cs_categories['categories_picture'] = '';
  }

  $img_size = false;
  if(!empty($files['picture']['tmp_name']))
    $img_size = getimagesize($files['picture']['tmp_name']);

  if(!empty($files['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
    $error .= $cs_lang['ext_error'] . cs_html_br(1);
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
    $filename = 'picture-' . $categories_id . '.' . $ext;
    
    if($img_size[0]>$op_categories['max_width']) {
      $error .= $cs_lang['too_wide'] . cs_html_br(1);
    }
    if($img_size[1]>$op_categories['max_height']) { 
      $error .= $cs_lang['too_high'] . cs_html_br(1);
    }
    if($files['picture']['size']>$op_categories['max_size']) { 
      $error .= $cs_lang['too_big'] . cs_html_br(1);
    }
    if(empty($error) AND cs_upload('categories', $filename, $files['picture']['tmp_name']) OR !empty($error) AND extension_loaded('gd') AND cs_resample($files['picture']['tmp_name'], 'uploads/categories/' . $filename, $op_categories['max_width'], $op_categories['max_height'])) {
      $error = '';
      if($cs_categories['categories_picture'] != $filename AND !empty($cs_categories['categories_picture'])) {
        cs_unlink('categories', $cs_categories['categories_picture']);
      }
      $cs_categories['categories_picture'] = $filename;
    }
    else {
      $error .= $cs_lang['up_error'];
    }
  }

  if(empty($cs_categories['categories_name'])) {
    $error .= $cs_lang['no_name'] . cs_html_br(1);
  }
  
  $where = "categories_name = '" . cs_sql_escape($cs_categories['categories_name']) . "'";
  $where .= " AND categories_mod = '" . cs_sql_escape($_POST['cat_mod']) . "'";
  $where .= " AND categories_id != '" . $categories_id . "'";
  $search = cs_sql_count(__FILE__,'categories',$where);
  if(!empty($search)) {
    $error .= $cs_lang['cat_exists'] . cs_html_br(1);
  }
}
else {
  $cs_categories = cs_sql_select(__FILE__,'categories','*',"categories_id = '" . $categories_id . "'");
}

if(!isset($_POST['submit'])) {
  $data['head']['body'] = $cs_lang['body_edit'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {
  
  $data['cat'] = $cs_categories;


  $cat_mod = empty($_POST['cat_mod']) ? $cs_categories['categories_mod'] : $_POST['cat_mod'];
  $data['cat']['subcat_of'] = cs_categories_dropdown2($cat_mod,$cs_categories['categories_subid'],0);
  
  $modules = cs_checkdirs('mods');
  foreach($modules as $mods) {
    if($mods['dir'] == $cat_mod) {
      $data['cat']['mod_name'] = $mods['name'];
      break;
    }
  }
  $data['cat']['cat_mod'] = $cat_mod;
  
  $levels = 0;
  $sel = 0;
  while($levels < 6) {
    $cs_categories['categories_access'] == $levels ? $sel = 1 : $sel = 0;
    $data['access'][$levels]['sel'] = cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
    $levels++;
  }
  
  $data['cat']['abcode_smileys'] = cs_abcode_smileys('categories_text');
  $data['cat']['abcode_features'] = cs_abcode_features('categories_text');

  $data['cat']['current_pic'] = $cs_lang['nopic'];
  if(!empty($cs_categories['categories_picture'])) {
    $data['if']['more'] = TRUE;
    $place = 'uploads/categories/' . $cs_categories['categories_picture'];
    $size = getimagesize($cs_main['def_path'] . '/' . $place);
    $data['cat']['current_pic'] = cs_html_img($place,$size[1],$size[0]);
  }

  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $op_categories['max_width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $op_categories['max_height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($op_categories['max_size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['cat']['picup_clip'] = cs_abcode_clip($matches);

  $data['cat']['id'] = $categories_id;

  echo cs_subtemplate(__FILE__,$data,'categories','edit');
}
else {

  $categories_cells = array_keys($cs_categories);
  $categories_save = array_values($cs_categories);
  cs_sql_update(__FILE__,'categories',$categories_cells,$categories_save,$categories_id);
  
  $check = cs_sql_count(__FILE__, 'categories', 'categories_id = "' . $cs_categories['categories_subid'] . '" AND categories_subid = "' . $categories_id . '"');
  
  if (!empty($check))
    cs_sql_update(__FILE__, 'categories', array('categories_subid'), array(0), $cs_categories['categories_subid']);
  
  $cs_categories = cs_sql_select(__FILE__,'categories','categories_mod',"categories_id = '" . $categories_id . "'",0,0,1);
  cs_redirect($cs_lang['changes_done'],'categories','manage','where=' . $cs_categories['categories_mod']);
} 
  
