<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

$files_gl = cs_files();

$cs_events_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $cs_events_id = $cs_post['id'];

$op_events = cs_sql_option(__FILE__,'events');
$img_filetypes = array('gif','jpg','png');

$war = cs_sql_select(__FILE__,'events','events_pictures',"events_id = '" . $cs_events_id . "'");
$war_string = $war['events_pictures'];
$war_pics = empty($war_string) ? array() : explode("\n",$war_string);
$war_next = count($war_pics) + 1;

$error = '';

if(!empty($_GET['delete'])) {
  $target = $_GET['delete'] - 1;
  cs_unlink('events', 'picture-' . $war_pics[$target]);
  cs_unlink('events', 'thumb-' . $war_pics[$target]);
  $war_pics[$target] = FALSE;
  $war_pics = array_filter($war_pics);
  $war_string = implode("\n",$war_pics);
  $cells = array('events_pictures');
  $content = array($war_string);
  cs_sql_update(__FILE__,'events',$cells,$content,$cs_events_id);
  cs_redirect($cs_lang['remove_done'],'events','picture','id=' . $cs_events_id);
}
elseif(isset($_POST['submit'])) {
  
  $img_size = getimagesize($files_gl['picture']['tmp_name']);
  if(empty($img_size) OR $img_size[2] > 3)
    $error .= $cs_lang['ext_error'] . cs_html_br(1);
  if($img_size[0]>$op_events['max_width'])
    $error .= $cs_lang['too_wide'] . cs_html_br(1);
  if($img_size[1]>$op_events['max_height'])
    $error .= $cs_lang['too_high'] . cs_html_br(1);
  if($files_gl['picture']['size']>$op_events['max_size'])
    $error .= $cs_lang['too_big'] . cs_html_br(1);

  if(empty($error)) {

    switch($img_size[2]) {
    case 1:
      $ext = 'gif'; break;
    case 2:
      $ext = 'jpg'; break;
    case 3:
      $ext = 'png'; break;
    }
    $target = $cs_events_id . '-' . $war_next . '.' . $ext;
    $picture_name = 'picture-' . $target;
    $thumb_name = 'thumb-' . $target;
    if(cs_resample($files_gl['picture']['tmp_name'], 'uploads/events/' . $thumb_name, 80, 200) 
    AND cs_upload('events', $picture_name, $files_gl['picture']['tmp_name'])) {

      $cells = array('events_pictures');
      $content = empty($war_string) ? array($target) : array($war_string . "\n" . $target);
      cs_sql_update(__FILE__,'events',$cells,$content,$cs_events_id);
        
    cs_redirect($cs_lang['success'],'events','picture','id=' . $cs_events_id);
    }
    else {
        $error .= $cs_lang['up_error'];
    }
  }
}

if(!isset($_POST['submit']))
  $data['head']['body'] = $cs_lang['body_picture'];
elseif(!empty($error))
  $data['head']['body'] = $error;

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['head']['getmsg'] = cs_getmsg();

  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] .': '. $op_events['max_width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] .': '. $op_events['max_height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] .': '. cs_filesize($op_events['max_size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['picup']['clip'] = cs_abcode_clip($matches);
  
  $data['events']['id'] = $cs_events_id;

  if(empty($war_string)) {
    $data['pictures'][0]['view_link'] = $cs_lang['nopic'];
    $data['pictures'][0]['remove_link'] = '';
  }
  else {
  $run = 0;
    foreach($war_pics AS $pic) {
      $link = cs_html_img('uploads/events/thumb-' . $pic);
      $data['pictures'][$run]['view_link'] = cs_html_link('uploads/events/picture-' . $pic,$link) . ' ';
      $set = 'id=' . $cs_events_id . '&amp;delete=' . ($run + 1);
      $data['pictures'][$run]['remove_link'] = cs_link($cs_lang['remove'],'events','picture',$set);
      $run++;
    }
  }

  echo cs_subtemplate(__FILE__,$data,'events','picture');
}