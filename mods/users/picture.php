<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$op_users = cs_sql_option(__FILE__,'users');
$img_filetypes = array('gif','jpg','png');
if (empty($_POST)) cs_ajaxfiles_clear();

$user = cs_sql_select(__FILE__,'users','users_picture',"users_id = '" . $account['users_id'] . "'");
$userpic = $user['users_picture'];

$del = 0;
$files = cs_files();
$data['if']['extended'] = FALSE;

if(isset($_POST['delete']) AND $_POST['delete'] == TRUE AND !empty($userpic) && $userpic != 'nopicture.jpg') {
  
  $del = 1;
  cs_unlink('users', $userpic);
  $cells = array('users_picture');
  $content = empty($op_users['def_picture']) ? array('') : array('nopicture.jpg');
  cs_sql_update(__FILE__,'users',$cells,$content,$account['users_id']);
  
  cs_redirect($cs_lang['success'],'users','picture');

}
elseif(!empty($files['picture']['tmp_name'])) {

  $error = '';
  
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
    $filename = 'picture-' . $account['users_id'] . '.' . $ext;
    
    if($img_size[0] > $op_users['max_width']) {
      $error .= $cs_lang['too_wide'] . cs_html_br(1);
    }
    if($img_size[1] > $op_users['max_height']) { 
      $error .= $cs_lang['too_high'] . cs_html_br(1);
    }
    if($files['picture']['size']>$op_users['max_size']) { 
      $error .= $cs_lang['too_big'] . cs_html_br(1);
    }
    if(empty($error) AND cs_upload('users', $filename, $files['picture']['tmp_name']) OR !empty($error) AND extension_loaded('gd') AND cs_resample($files['picture']['tmp_name'], 'uploads/users/' . $filename, $op_users['max_width'], $op_users['max_height'])) {
      $error = '';
      if($userpic != $filename && !empty($userpic) && $userpic != 'nopicture.jpg') {
        cs_unlink('users', $userpic);
      }
      $cells = array('users_picture');
      $content = array($filename);
      cs_sql_update(__FILE__,'users',$cells,$content,$account['users_id']);
  
      cs_redirect($cs_lang['success'],'users','picture');
    }
    else {
        $error .= $cs_lang['up_error'];
    }
  }
}

if(empty($error))
  $data['head']['body'] = $cs_lang['picture_manage'];
else
  $data['head']['body'] = $error;

if(!empty($error) OR empty($files['picture']['tmp_name']) AND empty($del)) {

  if(empty($userpic)) {
    $data['users']['current_pic'] = $cs_lang['nopic'];
  }
  else {
    $data['if']['extended'] = TRUE;
    $place = 'uploads/users/' . $userpic;
    $size = getimagesize($cs_main['def_path'] . '/' . $place);
    $data['users']['current_pic'] = cs_html_img($place,$size[1],$size[0]);
  }

  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $op_users['max_width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $op_users['max_height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($op_users['max_size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['users']['picup_clip'] = cs_abcode_clip($matches);

  echo cs_subtemplate(__FILE__,$data,'users','picture');
}