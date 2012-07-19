<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('linkus');

$files_gl = cs_files();

$op_linkus = cs_sql_option(__FILE__,'linkus');

$data = array();

$img_max['width'] = $op_linkus['max_width'];
$img_max['height'] = $op_linkus['max_height'];
$img_max['size'] = $op_linkus['max_size'];
$img_filetypes = array('image/png' => 'png','image/jpeg' => 'jpg','image/gif' => 'gif');

if(isset($_POST['submit'])) {
  
  $cs_linkus['linkus_name'] = $_POST['linkus_name'];
  $cs_linkus['linkus_url'] = $_POST['linkus_url'];

  $error = '';
  
  if(empty($cs_linkus['linkus_name'])) {
    $error .= $cs_lang['no_name'] . cs_html_br(1);
  }
  if(empty($cs_linkus['linkus_url'])) {
    $error .= $cs_lang['no_url'] . cs_html_br(1);
  }
  if(empty($files_gl['symbol']['tmp_name'])) {
    $error .= $cs_lang['no_pic'] . cs_html_br(1);
  }
  elseif(!empty($files_gl['symbol']['tmp_name'])) {
    $error .= $cs_lang['ext_error'] . cs_html_br(1);
    foreach($img_filetypes AS $allowed => $new_ext) {
      if($allowed == $files_gl['symbol']['type']) {
        $error = '';
        $extension = $new_ext;
      } 
    }
    $img_size = getimagesize($files_gl['symbol']['tmp_name']);
    if($img_size[0]>$img_max['width']) {
      $error .= $cs_lang['too_wide'] . cs_html_br(1); 
    }
    if($img_size[1]>$img_max['height']) { 
      $error .= $cs_lang['too_high'] . cs_html_br(1);
    }
    if($files_gl['symbol']['size']>$img_max['size']) {
      $error .= $cs_lang['too_big'] . cs_html_br(1); 
    }
  }
}
else {
  $cs_linkus['linkus_name'] = '';
  $cs_linkus['linkus_url'] = '';
}

if(!isset($_POST['submit'])) {
  $data['head']['body'] = $cs_lang['body_create'];
}elseif(!empty($error)) {
  $data['head']['body'] = $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['linkus'] = $cs_linkus;

    $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add => $value) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $img_max['width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $img_max['height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($img_max['size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
   $data['linkus']['picup_clip'] = cs_abcode_clip($matches);

  echo cs_subtemplate(__FILE__,$data,'linkus','create');
}
else{
  
  $linkus_cells = array_keys($cs_linkus);
  $linkus_save = array_values($cs_linkus);
  cs_sql_insert(__FILE__,'linkus',$linkus_cells,$linkus_save);
    
        
  if(!empty($files_gl['symbol']['tmp_name'])) {
    $where = "linkus_name = '" . cs_sql_escape($cs_linkus['linkus_name']) . "'";
    $getid = cs_sql_select(__FILE__,'linkus','linkus_id',$where);
    $filename = $getid['linkus_id'] . '.' . $extension;
    cs_upload('linkus',$filename,$files_gl['symbol']['tmp_name']);
  }
    
  $linkus_cells = array('linkus_banner');
  $linkus_save = array($filename);
  cs_sql_update(__FILE__,'linkus',$linkus_cells,$linkus_save,$getid['linkus_id']);    
    
  cs_redirect($cs_lang['create_done'],'linkus');  
}
