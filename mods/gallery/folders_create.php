<?php
// ClanSphere 2006 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');
$option = cs_sql_option(__FILE__,'categories');
$option2 = cs_sql_option(__FILE__,'gallery');
require_once('mods/gallery/functions.php');

empty($_REQUEST['more']) ? $advance = '0' : $advance = '1';

$img_filetypes = array('gif','jpg','png');
$id = $account['users_id'];
$count = cs_sql_count(__FILE__, 'folders',"folders_mod='gallery'");
if(isset($_POST['submit'])) {
  $error = 0;
  $message = '';

  $folders['users_id'] = $id;
  $folders['sub_id'] = $_POST['sub_id'];
  $folders['folders_mod'] = 'gallery';
  $folders['folders_name'] = $_POST['folders_name1'];
  $folders['folders_url'] = $_POST['folders_url'];
  $folders['folders_text'] = $_POST['folders_text'];
  $folders['folders_access'] = $_POST['folders_access'];
  $folders['folders_position'] = $_POST['folders_position'];
  $advance = isset($_POST['advance-']) ? 0 : 1;
  $advance = isset($_POST['advance+']) ? 1 : 0;
  if(!isset($_POST['advance+']) AND !isset($_POST['advance-'])) {
    $advance = isset($_POST['advance']) ? $_POST['advance'] : 0;
  }
  if(isset($_POST['advance-']) OR isset($_POST['advance+'])) {
    $error++;
    $message .= $cs_lang['body_create'] . cs_html_br(1);
  }
  if(isset($_FILES['picture']))
  {
    $img_size = getimagesize($_FILES['picture']['tmp_name']);
    if(!empty($_FILES['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
      $message .= $cs_lang['ext_error'] . cs_html_br(1);
      $error++;
    } elseif(!empty($_FILES['picture']['tmp_name'])) {
      switch($img_size[2]) {
        case 1:
          $extension = 'gif'; break;
        case 2:
          $extension = 'jpg'; break;
        case 3:
          $extension = 'png'; break;
      }
      if($img_size[0]>$option['max_width']) {
        $message .= $cs_lang['too_wide'] . cs_html_br(1);
        $error++;
      }
      if($img_size[1]>$option['max_height']) {
        $message .= $cs_lang['too_high'] . cs_html_br(1);
        $error++;
      }
      if($_FILES['picture']['size']>$option['max_size']) {
        $message .= $cs_lang['too_big'] . cs_html_br(1);
        $error++;
      }
    }
  }
  if(empty($folders['folders_name'])) {
    $error++;
    $message .= $cs_lang['error_name'] . cs_html_br(1);
  }
  $where = "folders_name = '" . cs_sql_escape($folders['folders_name']) . "'";
  $where .= " AND folders_mod = 'gallery'";
  $search = cs_sql_count(__FILE__,'folders',$where);
  if(!empty($search)) {
    $error++;
    $message .= $cs_lang['cat_exists'] . cs_html_br(1);
  }
} else {
  $folders['sub_id'] = '';
  $folders['folders_name'] = '';
  $folders['folders_mod'] = 'gallery';
  $folders['folders_url'] = '';
  $folders['folders_text'] = '';
  $folders['folders_access'] = 0;
  $folders['folders_position'] = 1;
}
$data['body']['folders'] = '';
$data['error']['message'] = '';
$data['error']['error'] = '';
$data['error']['icon'] = '';
if(!isset($_POST['submit'])) {
  $data['body']['folders'] = $cs_lang['body_folder'];
} elseif(!empty($error)) {
  $data['error']['icon'] = cs_icon('important');
  $data['error']['message'] = $message;
} else {
  $data['body']['folders'] = $cs_lang['create_done'];
  $noshow = 1;
}

if(!empty($error) OR !isset($_POST['submit']) && empty($noshow)) {
  $data['url']['gallery_folders_create'] = cs_url('gallery','folders_create');
  $data['data']['folders_name'] = $folders['folders_name'];
  $data['data']['folders_position'] = $folders['folders_position'];
  $data['data']['folders_select'] = make_folders_select('sub_id',$folders['sub_id'],'0','gallery');
  $var = cs_html_select(1,'folders_access');
    $levels = 0;
    $sel = 0;
    while($levels < 6) {
      $folders['folders_access'] == $levels ? $sel = 1 : $sel = 0;
      $var .= cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
      $levels++;
    }
  $var .= cs_html_select(0);
  $data['data']['folders_access'] = $var;
  $data['data']['folders_url'] = $folders['folders_url'];
  $data['data']['folders_text'] = $folders['folders_text'];
  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $option['max_width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $option['max_height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($option['max_size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['data']['info_clip'] = cs_abcode_clip($matches);
  echo cs_subtemplate(__FILE__,$data,'gallery','folders_create');
} else {
  $folder_cells = array_keys($folders);
  $folder_save = array_values($folders);
  cs_sql_insert(__FILE__,'folders',$folder_cells,$folder_save);
  if(!empty($_FILES['picture']['tmp_name'])) {
    $where = "folders_name = '" . cs_sql_escape($folders['folders_name']) . "' AND ";
    $where .= "users_id = '" . $id . "'";
    $getid = cs_sql_select(__FILE__,'folders','folders_id',$where);
    $filename = 'picture-' . $getid['folders_id'] . '.' . $extension;
    cs_upload('folders',$filename,$_FILES['picture']['tmp_name']);

    $folders2['folders_picture'] = $filename;
    $cells = array_keys($folders2);
    $save = array_values($folders2);
    cs_sql_update(__FILE__,'folders',$cells,$save,$getid['folders_id']);
  }

  cs_redirect($cs_lang['create_done'],'gallery','manage','page=folders');
}

?>