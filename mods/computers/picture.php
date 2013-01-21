<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('computers');

$files_gl = cs_files();

$cs_post = cs_post('id');
$cs_get = cs_get('id');

$cs_computers_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $cs_computers_id = $cs_post['id'];

$op_computers = cs_sql_option(__FILE__,'computers');
$img_filetypes = array('gif','jpg','png');

$select = 'computers_pictures, users_id';
$computer = cs_sql_select(__FILE__,'computers',$select,"computers_id = '" . $cs_computers_id . "'");
$computer_string = $computer['computers_pictures'];
$computer_pics = empty($computer_string) ? array() : explode("\n",$computer_string);
$computer_next = count($computer_pics) + 1;

$error = '';

if(!empty($_GET['delete'])) {
  $target = $_GET['delete'] - 1;
  cs_unlink('computers', 'picture-' . $computer_pics[$target]);
  cs_unlink('computers', 'thumb-' . $computer_pics[$target]);
  $computer_pics[$target] = FALSE;
  $computer_pics = array_filter($computer_pics);
  $computer_string = implode("\n",$computer_pics);
  $cells = array('computers_pictures');
  $content = array($computer_string);
  cs_sql_update(__FILE__,'computers',$cells,$content,$cs_computers_id);
}
elseif(!empty($_POST['submit'])) {
  
  if($computer['users_id'] != $account['users_id'] AND $account['access_computers'] < 4) {
    $error .= $cs_lang['not_own'] . cs_html_br(1);
  }
  $img_size = getimagesize($files_gl['picture']['tmp_name']);
  if(empty($img_size) OR $img_size[2] > 3) {
    $error .= $cs_lang['ext_error'] . cs_html_br(1);
  }
  if($img_size[0]>$op_computers['max_width']) {
    $error .= $cs_lang['too_wide'] . cs_html_br(1);
  }
  if($img_size[1]>$op_computers['max_height']) { 
    $error .= $cs_lang['too_high'] . cs_html_br(1);
  }
  if($files_gl['picture']['size']>$op_computers['max_size']) { 
    $error .= $cs_lang['too_big'] . cs_html_br(1);
  }

  if(empty($error)) {

    switch($img_size[2]) {
      case 1:
      $ext = 'gif'; break;
      case 2:
      $ext = 'jpg'; break;
      case 3:
      $ext = 'png'; break;
    }
    $target = $cs_computers_id . '-' . $computer_next . '.' . $ext;
    $picture_name = 'picture-' . $target;
    $thumb_name = 'thumb-' . $target;
    if(cs_resample($files_gl['picture']['tmp_name'], 'uploads/computers/' . $thumb_name, 150, 300) 
    AND cs_upload('computers', $picture_name, $files_gl['picture']['tmp_name'])) {

      $cells = array('computers_pictures');
      $content = empty($computer_string) ? array($target) : array($computer_string . "\n" . $target);
      cs_sql_update(__FILE__,'computers',$cells,$content,$cs_computers_id);

      cs_redirect($cs_lang['success'],'computers','picture','id=' . $cs_computers_id);
    }
    else {
      $error .= $cs_lang['up_error'];
    }
  }
}

$data = array();
$data['if']['own'] = $computer['users_id'] == $account['users_id'] ? true : false;

if(!empty($error)) {
  $data['head']['body'] = $error;
}
elseif(isset($_GET['delete'])) {
  cs_redirect($cs_lang['remove_done'],'computers','picture','id=' . $cs_computers_id);
}
else {
  $data['head']['body'] = $cs_lang['body_picture'];
}

if(!empty($error) OR empty($_POST['submit'])) {

  $data['head']['getmsg'] = cs_getmsg();

  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $op_computers['max_width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $op_computers['max_height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($op_computers['max_size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['com']['abcode_clip'] = cs_abcode_clip($matches);

  $data['com']['id'] = $cs_computers_id;
  
  if(empty($computer_string)) {
    $data['pictures'][0]['thumb'] = $cs_lang['nopic'];
    $data['pictures'][0]['url_remove'] = '';
  }
  else {
    $run = 0;
    foreach($computer_pics AS $pic) {
      $link = cs_html_img('uploads/computers/thumb-' . $pic);
      $data['pictures'][$run]['thumb'] = cs_html_link('uploads/computers/picture-' . $pic,$link) . ' ';
      $remove = 'id=' . $cs_computers_id . '&amp;delete=' . ($run + 1);
      $data['pictures'][$run]['url_remove'] = cs_link($cs_lang['remove'],'computers','picture',$remove);
      $run++;
    }
  }

  echo cs_subtemplate(__FILE__,$data,'computers','picture');
}