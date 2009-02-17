<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanpartys');

$cs_lanpartys_id = empty($_REQUEST['where']) ? $_GET['id'] : $_REQUEST['where'];
settype($cs_lanpartys_id,'integer');

$op_lanpartys = cs_sql_option(__FILE__,'lanpartys');
$img_filetypes = array('gif','jpg','png');

$lanpartys = cs_sql_select(__FILE__,'lanpartys','lanpartys_pictures','lanpartys_id = ' . $cs_lanpartys_id);
$lanpartys_string = $lanpartys['lanpartys_pictures'];
$lanpartys_pics = empty($lanpartys_string) ? array() : explode("\n",$lanpartys_string);
$lanpartys_next = count($lanpartys_pics) + 1;

$error = 0;
$message = '';

if(!empty($_GET['delete'])) {
  $target = $_GET['delete'] - 1;
  
  cs_unlink('lanpartys', 'picture-' . $lanpartys_pics[$target]);
  cs_unlink('lanpartys', 'thumb-' . $lanpartys_pics[$target]);
  
  $lanpartys_pics[$target] = FALSE;
  $lanpartys_pics = array_filter($lanpartys_pics);
  $lanpartys_string = implode("\n",$lanpartys_pics);
  $cells = array('lanpartys_pictures');
  $content = array($lanpartys_string);
 
  cs_sql_update(__FILE__,'lanpartys',$cells,$content,$cs_lanpartys_id);
}
elseif(!empty($_POST['submit'])) {
  $img_size = getimagesize($_FILES['picture']['tmp_name']);
  
  if(empty($img_size) OR $img_size[2] > 3) {
    $message .= $cs_lang['ext_error'] . cs_html_br(1);
  $error++;
  }
  
  if($img_size[0]>$op_lanpartys['max_width']) {
    $message .= $cs_lang['too_wide'] . cs_html_br(1);
    $error++;
  }
  
  if($img_size[1]>$op_lanpartys['max_height']) { 
    $message .= $cs_lang['too_high'] . cs_html_br(1);
    $error++;
  }
  
  if($_FILES['picture']['size']>$op_lanpartys['max_size']) { 
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
    
  $target = $cs_lanpartys_id . '-' . $lanpartys_next . '.' . $ext;
    $picture_name = 'picture-' . $target;
    $thumb_name = 'thumb-' . $target;
    
  if(cs_resample($_FILES['picture']['tmp_name'], 'uploads/lanpartys/' . $thumb_name, 80, 200) 
    AND cs_upload('lanpartys', $picture_name, $_FILES['picture']['tmp_name'])) {
      $cells = array('lanpartys_pictures');
      $content = empty($lanpartys_string) ? array($target) : array($lanpartys_string . "\n" . $target);
      cs_sql_update(__FILE__,'lanpartys',$cells,$content,$cs_lanpartys_id);

    cs_redirect($cs_lang['success'],'lanpartys','picture','id=' . $cs_lanpartys_id);
    }
    else {
        $message .= $cs_lang['up_error'];
        $error++;
    }
  }
}

if(!empty($error) OR empty($_POST['submit'])) {
  if(!empty($message)) {
    $data['lang']['body'] = $message;
  }
  elseif(empty($_GET['delete'])) {
    $data['lang']['body'] = $cs_lang['body_picture'];
  }
  else {
    $data['lang']['body'] = $cs_lang['remove_done'];
  }

  $data['url']['form'] = cs_url('lanpartys','picture');

  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . ': ' . $op_lanpartys['max_width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . ': ' . $op_lanpartys['max_height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . ': ' . cs_filesize($op_lanpartys['max_size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['lanpartys']['clip'] = cs_abcode_clip($matches);

  $data['data']['id'] = $cs_lanpartys_id;

  if(empty($lanpartys_string)) {
    $data['lanpartys']['img'] = $cs_lang['nopic'];
  }
  else {
    $run = 1;
    foreach($lanpartys_pics AS $pic) {
      $link = cs_html_img('uploads/lanpartys/thumb-' . $pic);
      $data['lanpartys']['img'] = cs_html_link('uploads/lanpartys/picture-' . $pic,$link) . ' ';
      $set = 'id=' . $cs_lanpartys_id . '&amp;delete=' . $run++;
      $data['lanpartys']['img'] .= cs_link($cs_lang['remove'],'lanpartys','picture',$set);
    }
  }
 echo cs_subtemplate(__FILE__,$data,'lanpartys','picture');
}
?>