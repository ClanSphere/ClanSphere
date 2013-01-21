<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_pictures_select($mod, $fid = 0) {
  
  settype($fid, 'integer');
  $cs_lang = cs_translate('pictures');
  
  $data = array();
  
  if (empty($fid))
    $data['if']['already'] = false;
  else {
    $where = "pictures_mod = '" . $mod . "' AND pictures_fid = " . $fid;
    $picture = cs_sql_select(__FILE__, 'pictures', 'pictures_file', $where);
    if (empty($picture))
      $data['if']['already'] = false;
    else {
      $data['if']['already'] = true;
      $data['picture']['file'] = $picture['pictures_file'];
    }
  }
  $string = cs_subtemplate(__FILE__,$data,'pictures','select');
  
  return $string;
}

function cs_pictures_delete ($var, $mod = 0) {
  
  if (!empty($mod)) {
    $where = "pictures_fid = '" . $var . "' AND pictures_mod = '" . $mod . "'";
    $pic = cs_sql_select(__FILE__, 'pictures', 'pictures_id, pictures_file', $where);
    if (empty($pic)) return true;
    
    $file = $pic['pictures_file'];
    $pictures_id = $pic['pictures_id'];
  } else {
    $pictures_id = (int) substr($var,8);
    $file = $var;
  }
  
  cs_sql_delete(__FILE__, 'pictures', $pictures_id);
  
  cs_unlink('pictures' . $file);
  
  return true;
}

function cs_pictures_upload($file, $mod, $fid, $ajaxclean = 1) {
  
  if (!empty($_POST['del_picture'])) cs_pictures_delete($_POST['del_picture']);
  if (empty($file['tmp_name'])) return true;
  
  settype($fid, 'integer');
  $types_allowed = array('image/jpeg','image/png','image/pjpeg','image/x-png');
  
  if (!in_array($file['type'], $types_allowed)) return false;
  
  $exts = array('image/jpeg' => 'jpg', 'image/png' => 'png', 'image/pjpeg' => 'jpg' ,'image/x-png' => 'png');
  $ext = $exts[$file['type']];
  
  $where = "pictures_fid = '" . $fid . "' AND pictures_mod = '" . $mod . "'";
  $already = cs_sql_select(__FILE__, 'pictures', 'pictures_id', $where);
  $pictures_id = $already['pictures_id'];
  
  if (empty($already)) {
    $vars = array();
    $vars['pictures_mod'] = $mod;
    $vars['pictures_fid'] = $fid;
    
    cs_sql_insert(__FILE__, 'pictures', array_keys($vars), array_values($vars));
    
    $pictures_id = cs_sql_insertid(__FILE__);
  }
  
  if (!cs_upload('pictures', 'picture-' . $pictures_id . '.' . $ext, $file['tmp_name'], $ajaxclean)) {
    cs_sql_delete(__FILE__, 'pictures', $pictures_id);
    return false;
  }
  
  $cells = array('pictures_file');
  $content = array('picture-' . $pictures_id . '.' . $ext);
  cs_sql_update(__FILE__, 'pictures', $cells, $content, $pictures_id);
  
  return true;
}