<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$cs_board = cs_sql_option(__FILE__,'board');

$files_gl = cs_files();

$img_max['width'] = $cs_board['avatar_width'];
$img_max['height'] = $cs_board['avatar_height'];
$img_max['size'] = $cs_board['avatar_size'];
$img_filetypes = array('image/pjpeg' => 'jpg','image/jpeg' => 'jpg','image/gif' => 'gif', 'image/png' => 'png');

$count_abo = cs_sql_count(__FILE__,'abonements','users_id=' .$account['users_id']);
$count_att = cs_sql_count(__FILE__,'boardfiles','users_id=' .$account['users_id']);

$data = array();
$data['if']['error'] = 0;

$data['link']['abos'] = cs_url('board','center');
$data['link']['abos_count'] = $count_abo;
$data['link']['attachments'] = cs_url('board','attachments');
$data['link']['attachments_count'] = $count_att;
$data['link']['signature'] = cs_url('board','signature');

$error = 1;
$doresize = 0;
$user = cs_sql_select(__FILE__,'users','users_avatar',"users_id = '" . $account['users_id'] . "'");
$useravatar = $user['users_avatar'];

if(isset($_POST['delete']) AND $_POST['delete'] == TRUE AND !empty($useravatar)) {
  $error = 0;
  cs_unlink('board', $useravatar);
  $cells = array('users_avatar');
  $content = array('');
  cs_sql_update(__FILE__,'users',$cells,$content,$account['users_id']);
  
  cs_redirect($cs_lang['remove_done'], 'board', 'avatar');
}
elseif(!empty($_POST['submit']) AND !empty($files_gl['picture']['tmp_name'])) {

  $message = $cs_lang['ext_error'] . cs_html_br(1);
  foreach($img_filetypes AS $allowed => $new_ext) {
    if($allowed == $files_gl['picture']['type']) {
      $message = '';
      $error = 0;
      $extension = $new_ext;
    }
  }
  $img_size = getimagesize($files_gl['picture']['tmp_name']);
  if($img_size[0]>$img_max['width']) { 
    if(extension_loaded('gd')){
      $doresize++;
      } else {
      $message .= $cs_lang['too_wide'] . cs_html_br(1);
      $error++;
    }
  }
  if($img_size[1]>$img_max['height']) { 
    if(extension_loaded('gd')){
      $doresize++;
      } else {
      $message .= $cs_lang['too_high'] . cs_html_br(1);
      $error++;
    }
  }
  if($files_gl['picture']['size']>$img_max['size']) { 
    if(extension_loaded('gd') AND !empty($doresize)){
      $doresize++;
      } else {
      $message .= $cs_lang['too_big'] . cs_html_br(1);
      $error++;
    }
  }
  if(empty($error)) {
    $filename = 'avatar-' . $account['users_id'] . '.' . $extension;
    if(extension_loaded('gd') AND !empty($doresize)){
      $dest = $cs_main['def_path'] . '/uploads/board/' . $filename;
      if(cs_resample($files_gl['picture']['tmp_name'], $dest, $img_max['width'], $img_max['height'])){
        $fileerror=0;
        } else {
        $fileerror=1;
       }
      } else {
      if(cs_upload('board',$filename,$files_gl['picture']['tmp_name'])){
        $fileerror=0;
        } else {
        $fileerror=1;
       }
      }
    if(empty($fileerror)){
      if($useravatar != $filename AND !empty($useravatar)) {
        cs_unlink('board', $useravatar);
      }
      $cells = array('users_avatar');
      $content = array($filename);
      cs_sql_update(__FILE__,'users',$cells,$content,$account['users_id']);

    cs_redirect($cs_lang['success'], 'board', 'avatar');
    }
    else {
      $message .= $cs_lang['up_error'];
      $error++;
    }
  }
}

$data['lang']['getmsg'] = cs_getmsg();

if(!empty($error) OR empty($_POST['submit'])) {

  if(!empty($message)) {
    $data['if']['error'] = 1;
    $data['avatar']['error'] = $message;
  }

  $data['action']['form'] = cs_url('board','avatar');

  if(empty($useravatar)) {
    $data['avatar']['img'] = $cs_lang['nopic'];
  }
  else {
    $place = 'uploads/board/' . $useravatar;
    $size = getimagesize($cs_main['def_path'] . '/' . $place);
    $data['avatar']['img'] = cs_html_img($place,$size[1],$size[0]);
  }

  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add => $value) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $img_max['width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $img_max['height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($img_max['size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . ': ' . $return_types;
  $data['avatar']['clip'] = cs_abcode_clip($matches);
}

echo cs_subtemplate(__FILE__,$data,'board','avatar');