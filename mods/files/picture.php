<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');
$cs_option = cs_sql_option(__FILE__,'files');
$cs_files_id = empty($_REQUEST['where']) ? $_GET['id'] : $_REQUEST['where'];
settype($cs_file_id,'integer');

$files_gl = cs_files();

$data = array();

$img_max['width'] = $cs_option['max_width'];
$img_max['height'] = $cs_option['max_height'];
$img_max['size'] = $cs_option['max_size'];
$img_filetypes = array('gif','jpg','png');

$file = cs_sql_select(__FILE__,'files','files_previews',"files_id = '" . $cs_files_id . "'");
$file_string = $file['files_previews'];
$file_pics = empty($file_string) ? array() : explode("\n",$file_string);
$file_next = count($file_pics) + 1;

$error = 0;
$message = '';

if(!empty($_GET['delete'])) {
  $target = $_GET['delete'] - 1;
  cs_unlink('files', 'picture-' . $file_pics[$target]);
  cs_unlink('files', 'thumb-' . $file_pics[$target]);
  $file_pics[$target] = FALSE;
  $file_pics = array_filter($file_pics);
  $file_string = implode("\n",$file_pics);
  $cells = array('files_previews');
  $content = array($file_string);
  cs_sql_update(__FILE__,'files',$cells,$content,$cs_files_id);
}
elseif(!empty($_POST['submit'])) {
  
  $img_size = getimagesize($files_gl['picture']['tmp_name']);
  if(empty($img_size) OR $img_size[2] > 3) {

    $message .= $cs_lang['ext_error'] . cs_html_br(1);
    $error++;
  }
  if($img_size[0]>$img_max['width']) {

    $message .= $cs_lang['too_wide'] . cs_html_br(1);
    $error++;
  }
  if($img_size[1]>$img_max['height']) { 

    $message .= $cs_lang['too_high'] . cs_html_br(1);
    $error++;
  }
  if($files_gl['picture']['size']>$img_max['size']) { 

    $message .= $cs_lang['too_big'] . cs_html_br(1);
    $error++;
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
    $target = $cs_files_id . '-' . $file_next . '.' . $ext;
    $picture_name = 'picture-' . $target;
    $thumb_name = 'thumb-' . $target;
    if(cs_resample($files_gl['picture']['tmp_name'], 'uploads/files/' . $thumb_name, 80, 200) 
    AND cs_upload('files', $picture_name, $files_gl['picture']['tmp_name'])) {

      $cells = array('files_previews');
      $content = empty($file_string) ? array($target) : array($file_string . "\n" . $target);
      cs_sql_update(__FILE__,'files',$cells,$content,$cs_files_id);

    
    cs_redirect($cs_lang['success'],'files','picture','id=' . $cs_files_id);
    }
    else {
        $message .= $cs_lang['up_error'];
        $error++;
    }
  }
}

if(!empty($message)) {
  $data['head']['text'] = $message;
}
elseif(empty($_GET['delete'])) {
  $data['head']['text'] = $cs_lang['body_picture'];
}
else {
  $data['head']['text'] = $cs_lang['remove_done'];
}

$data['head']['message'] = cs_getmsg();
$data['file']['id'] = $cs_files_id;
  
if(!empty($error) OR empty($_POST['submit'])) {
    $matches[1] = $cs_lang['pic_infos'];
    $return_types = '';
    foreach($img_filetypes AS $add) {
      $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $img_max['width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $img_max['height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($img_max['size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['upload']['clip'] = cs_abcode_clip($matches);
  
  $data['pictures'] = array();
  
  if(empty($file_string)) {
    $data['if']['nopics'] = true;
  }
  else {
    $data['if']['nopics'] = false;
    $run = 1;
    $i = 0;
    foreach($file_pics AS $pic) {
      $data['pictures'][$i]['sad'] =
      $data['pictures'][$i]['thumbpath'] = 'uploads/files/thumb-' . $pic;
      $data['pictures'][$i]['picpath'] = 'uploads/files/picture-' . $pic;
      $data['pictures'][$i]['id'] = $run;
      
      $run++;
      $i++;
    }
  }
}

echo cs_subtemplate(__FILE__,$data,'files','picture');
