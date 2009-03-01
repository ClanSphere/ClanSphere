<?php

$cs_lang = cs_translate('medals');
$data = array();

if (!empty($_POST['submit'])) {
  
  $error = '';
  $save = array();
  
  $users_nick = cs_sql_escape($_POST['users_nick']);
  $users_id = cs_sql_select(__FILE__,'users','users_id', "users_nick = '" . $users_nick . "'");
  
  $medals_id = (int) $_POST['medals_id'];
  
  $save['users_id'] = !empty($users_id) ? (int) $users_id['users_id'] : 0;
  $save['medals_name'] = $_POST['medals_name'];
  if (!empty($_POST['update_date'])) { $save['medals_date'] = cs_time(); }
  $save['medals_text'] = empty($_POST['medals_text']) ? '' : $_POST['medals_text'];
  
  if (!empty($_POST['delete_picture'])) {
    $save['medals_extension'] = '';
    unlink($cs_main['php_self']['dirname'] . 'uploads/medals/medal-' . $medals_id . '.' . $_POST['delete_picture']);
  }
  
  if (empty($save['users_id']))
    $error .= cs_html_br(1) . $cs_lang['user_not_found'];
  
  if (empty($save['medals_name']))
    $error .= cs_html_br(1) . $cs_lang['no_name'];
  
  if(!empty($_FILES['medals_picture']['tmp_name'])) {
    $img_size = getimagesize($_FILES['medals_picture']['tmp_name']);
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
  
  if (!empty($_FILES['medals_picture']['tmp_name'])) {
    $filename = 'medal-' . $medals_id . '.' . $extension;
    cs_upload('medals',$filename,$_FILES['medals_picture']['tmp_name']);
  }
  
  cs_redirect($cs_lang['changes_done'], 'medals');
  
}

if (empty($_POST['submit'])) {

  $medals_id = (int) $_GET['id'];
  
  $tables = 'medals md LEFT JOIN {pre}_users usr ON md.users_id = usr.users_id';
  $cells  = 'md.medals_name AS medals_name, md.medals_text AS medals_text, ';
  $cells .= 'usr.users_nick AS users_nick, md.medals_extension AS medals_extension'; 
  
  $data['medals'] = cs_sql_select(__FILE__,$tables,$cells,"md.medals_id = '" . $medals_id . "'");
  
  if (empty($data['medals']['medals_extension'])) {
    $data['if']['current_pic'] = false;
  } else {
    $data['if']['current_pic'] = true;
    $data['form']['img_path'] = 'uploads/medals/medal-' . $medals_id . '.' . $data['medals']['medals_extension'];
  }
  
  $data['form']['medals_id'] = $medals_id;
  
} else {
  $data['medals']['users_nick'] = $_POST['users_nick'];
  $data['medals']['medals_name'] = $save['medals_name'];
  $data['medals']['medals_text'] = $save['medals_text'];
}

$data['medals']['message'] = empty($error) ? $cs_lang['errors_here'] : $cs_lang['error_occured'] . $error;

$data['form']['abcode'] = cs_abcode_features('medals_text');
$data['form']['dirname'] = $cs_main['php_self']['dirname'];
  
echo cs_subtemplate(__FILE__,$data,'medals','edit');

?>