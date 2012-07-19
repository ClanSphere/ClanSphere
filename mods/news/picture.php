<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('news');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$files = cs_files();

$cs_news_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $cs_news_id = $cs_post['id'];

$op_news = cs_sql_option(__FILE__,'news');
$img_filetypes = array('gif','jpg','png');

$news = cs_sql_select(__FILE__,'news','news_pictures',"news_id = '" . $cs_news_id . "'");
$news_string = $news['news_pictures'];
$news_pics = empty($news_string) ? array() : explode("\n",$news_string);
$count_pics = count($news_pics);
$next = empty($count_pics) ? '' : explode('-', current(explode(".", $news_pics[$count_pics-1])));
$news_next = empty($count_pics) ? 1 : $next[1] + 1;

$error = 0;
$message = '';

if(!empty($_GET['delete'])) {
  $target = $_GET['delete'] - 1;
  cs_unlink('news', 'picture-' . $news_pics[$target]);
  cs_unlink('news', 'thumb-' . $news_pics[$target]);
  $news_pics[$target] = FALSE;
  $news_pics = array_filter($news_pics);
  $news_string = implode("\n",$news_pics);
  $cells = array('news_pictures');
  $content = array($news_string);
  cs_sql_update(__FILE__,'news',$cells,$content,$cs_news_id);
}
elseif(!empty($_POST['submit'])) {
  
  $img_size = getimagesize($files['picture']['tmp_name']);
  if(empty($img_size) OR $img_size[2] > 3) {

    $message .= $cs_lang['ext_error'] . cs_html_br(1);
    $error++;
  }
  if($img_size[0]>$op_news['max_width']) {

    $message .= $cs_lang['too_wide'] . cs_html_br(1);
    $error++;
  }
  if($img_size[1]>$op_news['max_height']) { 

    $message .= $cs_lang['too_high'] . cs_html_br(1);
    $error++;
  }
  if($files['picture']['size']>$op_news['max_size']) { 

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
    $target = $cs_news_id . '-' . $news_next . '.' . $ext;
    $picture_name = 'picture-' . $target;
    $thumb_name = 'thumb-' . $target;
    if(cs_resample($files['picture']['tmp_name'], 'uploads/news/' . $thumb_name, 80, 200) 
    AND cs_upload('news', $picture_name, $files['picture']['tmp_name'])) {

      $cells = array('news_pictures');
      $news_string = empty($news_string) ? array($target) : array($news_string . "\n" . $target);
      cs_sql_update(__FILE__,'news',$cells,$news_string,$cs_news_id);
  
      $data['head']['topline'] = $cs_lang['success'];
      
      $news = cs_sql_select(__FILE__,'news','news_pictures',"news_id = '" . $cs_news_id . "'");
      $news_string = $news['news_pictures'];
      $news_pics = empty($news_string) ? array() : explode("\n",$news_string);
      
    }
    else {
        $message .= $cs_lang['up_error'];
        $error++;
    }
  }
}
if(!empty($error) OR empty($_POST['submit'])) {

  if(!empty($message)) {
    $data['head']['topline'] = $message;
  }
  elseif(empty($_GET['delete'])) {
    $data['head']['topline'] = $cs_lang['picture_body'];
  }
  else {
    $data['head']['topline'] = $cs_lang['remove_done'];
  }
}

$data['head']['news_id'] = $cs_news_id;
$data['lang']['submit'] = $cs_lang['save'];

$matches[1] = $cs_lang['pic_infos'];
$return_types = '';
foreach($img_filetypes AS $add) {
  $return_types .= empty($return_types) ? $add : ', ' . $add;
}
$matches[2] = $cs_lang['max_width'] . ': ' . $op_news['max_width'] . ' px' . cs_html_br(1);
$matches[2] .= $cs_lang['max_height'] . ': ' .  $op_news['max_height'] . ' px' . cs_html_br(1);
$matches[2] .= $cs_lang['max_size'] . ': ' .  cs_filesize($op_news['max_size']) . cs_html_br(1);
$matches[2] .= $cs_lang['filetypes'] . $return_types;
$data['head']['infobox'] = cs_abcode_clip($matches);



if(empty($news_string)) {
  $data['pictures'][0]['view_link'] = $cs_lang['nopic'];
  $data['pictures'][0]['remove_link'] = '';
}
else {
  $run = 0;
  foreach($news_pics AS $pic) {
     $link = cs_html_img('uploads/news/thumb-' . $pic);
     $data['pictures'][$run]['view_link'] = cs_html_link('uploads/news/picture-' . $pic,$link) . ' ';
     $set = 'id=' . $cs_news_id . '&amp;delete=' . ($run + 1);
     $data['pictures'][$run]['remove_link'] = cs_link($cs_lang['remove'],'news','picture',$set);
    $run++;
  }
}

echo cs_subtemplate(__FILE__,$data,'news','picture');