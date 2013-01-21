<?php
// ClanSphere 2010 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('medals');

$files_gl = cs_files();

$data = array();

if (!empty($_POST['submit'])) {
  
  $error = '';
  $save = array();
  
  $medals_id = (int) $_POST['medals_id'];
  
  $save['medals_name'] = $_POST['medals_name'];
  $save['medals_text'] = empty($_POST['medals_text']) ? '' : $_POST['medals_text'];
  
  if (!empty($_POST['delete_picture'])) {
    $save['medals_extension'] = '';
    $ext = preg_replace('/[\W]/s', '', $_POST['delete_picture']);
    cs_unlink('medals', 'medal-' . $medals_id . '.' . $ext);
  }
  
  if (empty($save['medals_name']))
    $error .= cs_html_br(1) . $cs_lang['no_name'];
  
  if(!empty($files_gl['medals_picture']['tmp_name'])) {
    $img_size = getimagesize($files_gl['medals_picture']['tmp_name']);
    switch($img_size[2]) {
      case 1:
        $extension = 'gif'; break;
      case 2:
        $extension = 'jpg'; break;
      case 3:
        $extension = 'png'; break;
    }
    
    if (empty($extension))
      $error .= cs_html_br(1) . $cs_lang['wrong_ext'];
    else
      $save['medals_extension'] = $extension;
  }
}

if (!empty($_POST['submit']) && empty($error)) {

  $cells = array_keys($save);
  $values = array_values($save);
  
  cs_sql_update(__FILE__,'medals',$cells,$values,$medals_id);
  
  if (!empty($files_gl['medals_picture']['tmp_name'])) {
    $filename = 'medal-' . $medals_id . '.' . $extension;
    cs_upload('medals',$filename,$files_gl['medals_picture']['tmp_name']);
  }
  
  cs_redirect($cs_lang['changes_done'], 'medals');
  
}

if (empty($_POST['submit'])) {

  $medals_id = (int) $_GET['id'];
  
  $data['medals'] = cs_sql_select(__FILE__,'medals','medals_name, medals_extension, medals_text',"medals_id = '" . $medals_id . "'");
  
  if (empty($data['medals']['medals_extension'])) {
    $data['if']['current_pic'] = false;
  } else {
    $data['if']['current_pic'] = true;
    $data['form']['img_path'] = 'uploads/medals/medal-' . $medals_id . '.' . $data['medals']['medals_extension'];
  }
  
  $data['form']['medals_id'] = $medals_id;
  
} else {
  $data['medals']['medals_name'] = $save['medals_name'];
  $data['medals']['medals_text'] = $save['medals_text'];
}

$data['medals']['message'] = empty($error) ? $cs_lang['errors_here'] : $cs_lang['error_occured'] . $error;

$data['form']['abcode'] = cs_abcode_features('medals_text');
$data['form']['dirname'] = $cs_main['php_self']['dirname'];
  
echo cs_subtemplate(__FILE__,$data,'medals','edit');