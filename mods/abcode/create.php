<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('abcode');

$data = array();

$op_abcode = cs_sql_option(__FILE__,'abcode');
$img_filetypes = array('gif','jpg','png');
$files = cs_files();

$cs_abcode['abcode_func'] = empty($_POST['abcode_func']) ? '' : $_POST['abcode_func'];
$cs_abcode['abcode_pattern'] = empty($_POST['abcode_pattern']) ? '' : $_POST['abcode_pattern'];
$cs_abcode['abcode_result'] = empty($_POST['abcode_result']) ? '' : $_POST['abcode_result'];
$cs_abcode['abcode_order'] = empty($_POST['abcode_order']) ? 0 : (int) $_POST['abcode_order'];
$cs_abcode['abcode_file'] = '';

if(isset($_POST['submit'])) {

  $error = 0;
  $message = '';

  if(!empty($files['picture']['tmp_name']))
    $img_size = getimagesize($files['picture']['tmp_name']);
  else
    $img_size = array(1 => 0, 2 => 0);

  if(!empty($files['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
    $message .= $cs_lang['ext_error'] . cs_html_br(1);
    $error++;
  }
  elseif(!empty($files['picture']['tmp_name'])) {
    switch($img_size[2]) {
      case 1:
        $extension = 'gif'; break;
      case 2:
        $extension = 'jpg'; break;
      case 3:
        $extension = 'png'; break;
    }
    
    if($img_size[0]>$op_abcode['max_width']) {
      $message .= $cs_lang['too_wide'] . cs_html_br(1);
      $error++;
    }
  
    if($img_size[1]>$op_abcode['max_height']) { 
      $message .= $cs_lang['too_high'] . cs_html_br(1);
      $error++;
    }
  
    if($files['picture']['size']>$op_abcode['max_size']) { 
      $message .= $cs_lang['too_big'] . cs_html_br(1);
      $error++;
    }
  }

  if(empty($cs_abcode['abcode_func'])) {
    $error++;
    $message .= $cs_lang['no_func'] . cs_html_br(1);
  }
  
  if(empty($cs_abcode['abcode_pattern'])) {
    $error++;
    $message .= $cs_lang['no_pattern'] . cs_html_br(1);
  }
  
  if($cs_abcode['abcode_func'] == 'str' AND empty($cs_abcode['abcode_result'])) {
    $error++;
    $message .= $cs_lang['no_result'] . cs_html_br(1);
  }
  
  if($cs_abcode['abcode_func'] == 'img' AND empty($files['picture']['tmp_name'])) {
    $error++;
    $message .= $cs_lang['no_file'] . cs_html_br(1);
  }
  
  $where = "abcode_pattern = '" . cs_sql_escape($cs_abcode['abcode_pattern']) . "'";
  $search = cs_sql_count(__FILE__,'abcode',$where);
  
  if(!empty($search)) {
    $error++;
    $message .= $cs_lang['pattern_exists'] . cs_html_br(1);
  }
}

if(!isset($_POST['submit'])) {
  $data['lang']['body'] = $cs_lang['body_create'];
}

if(!empty($error)) {
  $data['lang']['body'] = $message;
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['action']['form'] = cs_url('abcode','create');

  $sel = 'selected="selected"';
  $data['word']['cut'] = !empty($op_abcode['word_cut']) ? 'maxlength="' . $op_abcode['word_cut'] . '"' : '';
  $data['select']['img'] = $cs_abcode['abcode_func'] == 'img' ? $sel : '';
  $data['select']['str'] = $cs_abcode['abcode_func'] == 'str' ? $sel : '';

  $data['abcode']['pattern'] = $cs_abcode['abcode_pattern'];
  $data['abcode']['result'] = $cs_abcode['abcode_result'];

  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $op_abcode['max_width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $op_abcode['max_height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($op_abcode['max_size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['lang']['clip'] = cs_abcode_clip($matches);

  $data['abcode']['order'] = $cs_abcode['abcode_order'];

  echo cs_subtemplate(__FILE__,$data,'abcode','create');
}
else {
  $abcode_cells = array_keys($cs_abcode);
  $abcode_save = array_values($cs_abcode);
  cs_sql_insert(__FILE__,'abcode',$abcode_cells,$abcode_save);

  if(!empty($files['picture']['tmp_name'])) {
    $where = "abcode_pattern = '" . cs_sql_escape($cs_abcode['abcode_pattern']) . "'";
    $getid = cs_sql_select(__FILE__,'abcode','abcode_id',$where);
    $filename = 'picture-' . $getid['abcode_id'] . '.' . $extension;
    cs_upload('abcode',$filename,$files['picture']['tmp_name']);
    
    $cs_abcode2['abcode_file'] = $filename;
    $abcode2_cells = array_keys($cs_abcode2);
    $abcode2_save = array_values($cs_abcode2);      
    cs_sql_update(__FILE__,'abcode',$abcode2_cells,$abcode2_save,$getid['abcode_id']);
  }

  cs_cache_delete('abcode_smileys');
  cs_cache_delete('abcode_content');

  cs_redirect($cs_lang['create_done'],'abcode');
}