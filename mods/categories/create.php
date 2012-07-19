<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('categories');

$files_gl = cs_files();

$op_categories = cs_sql_option(__FILE__,'categories');
$img_filetypes = array('gif','jpg','png');

include 'mods/categories/functions.php';

if(isset($_POST['submit'])) {

  $cs_categories['categories_name'] = $_POST['categories_name'];
  $cs_categories['categories_mod'] = $_POST['categories_mod'];
  $cs_categories['categories_url'] = $_POST['categories_url'];
  $cs_categories['categories_text'] = $_POST['categories_text'];
  $cs_categories['categories_access'] = $_POST['categories_access'];
  $cs_categories['categories_order'] = $_POST['categories_order'];
  $cs_categories['categories_subid'] = (int) $_POST['categories_id'];
  
  $error = '';

  $img_size = false;
  if(!empty($files_gl['picture']['tmp_name']))
    $img_size = getimagesize($files_gl['picture']['tmp_name']);

  if(!empty($files_gl['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
    $error .= $cs_lang['ext_error'] . cs_html_br(1);
  }
  elseif(!empty($files_gl['picture']['tmp_name'])) {

    switch($img_size[2]) {
    case 1:
      $extension = 'gif'; break;
    case 2:
      $extension = 'jpg'; break;
    case 3:
      $extension = 'png'; break;
    }
    
    if($img_size[0]>$op_categories['max_width']) {
      $error .= $cs_lang['too_wide'] . cs_html_br(1);
    }
    if($img_size[1]>$op_categories['max_height']) { 
      $error .= $cs_lang['too_high'] . cs_html_br(1);
    }
    if($files_gl['picture']['size']>$op_categories['max_size']) { 
      $error .= $cs_lang['too_big'] . cs_html_br(1);
    }
  }

  if(empty($cs_categories['categories_name'])) {
    $error .= $cs_lang['no_name'] . cs_html_br(1);
  }
  
  $where = "categories_name = '" . cs_sql_escape($cs_categories['categories_name']) . "'";
  $where .= " AND categories_mod = '" . cs_sql_escape($cs_categories['categories_mod']) . "'";
  $search = cs_sql_count(__FILE__,'categories',$where);
  if(!empty($search)) {
    $error .= $cs_lang['cat_exists'] . cs_html_br(1);
  }
}
else {
  $cs_categories['categories_name'] = '';
  $cs_categories['categories_mod'] = empty($_REQUEST['where']) ? $op_categories['def_mod'] : $_REQUEST['where'];
  $cs_categories['categories_url'] = '';
  $cs_categories['categories_text'] = '';
  $cs_categories['categories_order'] = 0;
  $cs_categories['categories_access'] = 0;
  $cs_categories['categories_subid'] = 0;
}

if(!isset($_POST['submit'])) {
  $data['head']['body'] = $cs_lang['body_create'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {
  
  $data['cat'] = $cs_categories;

  $data['cat']['subcat_of'] = cs_categories_dropdown2($cs_categories['categories_mod'],$cs_categories['categories_subid'],0);

  $run = 0;
  $modules = cs_checkdirs('mods');
  foreach($modules as $mods) {
    $check_axx = empty($account['access_' . $mods['dir'] . '']) ? 0 : $account['access_' . $mods['dir'] . ''];
    if(!empty($mods['categories']) AND $check_axx > 2) {
        $mods['dir'] == $cs_categories['categories_mod'] ? $sel = 1 : $sel = 0;
        $data['mod'][$run]['sel'] = cs_html_option($mods['name'],$mods['dir'],$sel);
      $run++;
    }
  }

  $levels = 0;
  $sel = 0;
  while($levels < 6) {
    $cs_categories['categories_access'] == $levels ? $sel = 1 : $sel = 0;
    $data['access'][$levels]['sel'] = cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
    $levels++;
  }

  $data['cat']['abcode_smileys'] = cs_abcode_smileys('categories_text');
  $data['cat']['abcode_features'] = cs_abcode_features('categories_text');

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

  echo cs_subtemplate(__FILE__,$data,'categories','create');
}
else {

  $categories_cells = array_keys($cs_categories);
  $categories_save = array_values($cs_categories);
  cs_sql_insert(__FILE__,'categories',$categories_cells,$categories_save);

  if(!empty($files_gl['picture']['tmp_name'])) {
    $where = "categories_name = '" . cs_sql_escape($cs_categories['categories_name']) . "'";
    $getid = cs_sql_select(__FILE__,'categories','categories_id',$where);
    $filename = 'picture-' . $getid['categories_id'] . '.' . $extension;
    cs_upload('categories',$filename,$files_gl['picture']['tmp_name']);
    
    $cs_categories2['categories_picture'] = $filename;
    $categories2_cells = array_keys($cs_categories2);
    $categories2_save = array_values($cs_categories2);      
    cs_sql_update(__FILE__,'categories',$categories2_cells,$categories2_save,$getid['categories_id']);
  }
  cs_redirect($cs_lang['create_done'],'categories','manage','where=' . $cs_categories['categories_mod']);
}