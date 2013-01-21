<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('abcode');
$cs_get = cs_get('id');
$cs_post = cs_post('id');
$files = cs_files();

$op_abcode = cs_sql_option(__FILE__,'abcode');
$img_filetypes = array(1 => 'gif',2 => 'jpg',3 => 'png');

if(isset($cs_post['submit'])) {
  
  $abcode_id = $cs_post['id'];
  
  $cs_abcode['abcode_func'] = $cs_post['abcode_func'];
  $cs_abcode['abcode_pattern'] = $cs_post['abcode_pattern'];
  $cs_abcode['abcode_result'] = $cs_post['abcode_result'];
  $cs_abcode['abcode_file'] = $cs_post['abcode_file'];
  $cs_abcode['abcode_order'] = empty($cs_post['abcode_order']) ? 0 : (int) $cs_post['abcode_order'];
  
  $error = '';

  if($cs_abcode['abcode_func'] == 'str' AND !empty($cs_abcode['abcode_file'])) {
    cs_unlink('abcode', $cs_abcode['abcode_file']);
    $cs_abcode['abcode_file'] = '';
  }

  if(!empty($files['picture']['tmp_name']))
    $img_size = getimagesize($files['picture']['tmp_name']);
  else
    $img_size = array(1 => 0, 2 => 0);
  
  if(!empty($files['picture']['tmp_name']) AND empty($img_size) OR $img_size[2] > 3) {
    $error .= $cs_lang['ext_error'] . cs_html_br(1);
  }
  elseif(!empty($files['picture']['tmp_name'])) {
    $ext = $img_filetypes[$img_size[2]];
    $filename = 'picture-' . $abcode_id . '.' . $ext;
    
    if($img_size[0]>$op_abcode['max_width'])
      $error .= $cs_lang['too_wide'] . cs_html_br(1);
    if($img_size[1]>$op_abcode['max_height'])
      $error .= $cs_lang['too_high'] . cs_html_br(1);
    if($files['picture']['size']>$op_abcode['max_size'])
      $error .= $cs_lang['too_big'] . cs_html_br(1);
    
    if(empty($error) AND cs_upload('abcode', $filename, $files['picture']['tmp_name']) OR !empty($error) AND extension_loaded('gd') AND cs_resample($files['picture']['tmp_name'], 'uploads/abcodes/' . $filename, $op_abcode['max_width'], $op_abcode['max_height'])) {
      $error = '';
      if($cs_abcode['abcode_file'] != $filename AND !empty($cs_abcode['abcode_file'])) {
        cs_unlink('abcode', $cs_abcode['abcode_file']);
      }
      
      $cs_abcode['abcode_file'] = $filename;
    }
    else {
      $error .= $cs_lang['up_error'];
    }
  }

  if(empty($cs_abcode['abcode_func']))
    $error .= $cs_lang['no_func'] . cs_html_br(1);
  if(empty($cs_abcode['abcode_pattern']))
    $error .= $cs_lang['no_pattern'] . cs_html_br(1);
  if($cs_abcode['abcode_func'] == 'str' && empty($cs_abcode['abcode_result']))
    $error .= $cs_lang['no_result'] . cs_html_br(1);
  
  if($cs_abcode['abcode_func'] == 'img' && empty($files['picture']['tmp_name'])
        && empty($cs_abcode['abcode_file']))
    $error .= $cs_lang['no_file'] . cs_html_br(1);
  
  $where = "abcode_pattern = '" . cs_sql_escape($cs_abcode['abcode_pattern']) . "'";
  $where .= " AND abcode_id !='" . $abcode_id . "'";
  $search = cs_sql_count(__FILE__,'abcode',$where);
  
  if(!empty($search)) {
    $error .= $cs_lang['pattern_exists'] . cs_html_br(1);
  }
}
else {
  $abcode_id = $cs_get['id'];
  
  $cells = 'abcode_func, abcode_pattern, abcode_result, abcode_file, abcode_order';
  $cs_abcode = cs_sql_select(__FILE__,'abcode',$cells,'abcode_id = \'' . $abcode_id . '\'');
}

if(!isset($cs_post['submit'])) {
  $data['lang']['body'] = $cs_lang['body_edit'];
}

if(!empty($error)) {
  $data['lang']['body'] = $error;
}

if(!empty($error) OR !isset($cs_post['submit'])) {
  
  $sel = 'selected="selected"';
  $data['word']['cut'] = !empty($op_abcode['word_cut']) ? 'maxlength="' . $op_abcode['word_cut'] . '"' : '';
  $data['select']['img'] = $cs_abcode['abcode_func'] == 'img' ? $sel : '';
  $data['select']['str'] = $cs_abcode['abcode_func'] == 'str' ? $sel : '';

  $data['abcode']['pattern'] = $cs_abcode['abcode_pattern'];
  $data['abcode']['result'] = $cs_abcode['abcode_result'];

  if(empty($cs_abcode['abcode_file'])) {
    $data['abcode']['pic'] = $cs_lang['nopic'];
  } else {
    $place = 'uploads/abcode/' . $cs_abcode['abcode_file'];
    $size = getimagesize($cs_main['def_path'] . '/' . $place);
    $data['abcode']['pic'] = cs_html_img($place,$size[1],$size[0]);
  }

  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $op_abcode['max_width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $op_abcode['max_height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($op_abcode['max_size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  
  $data['abcode']['clip'] = cs_abcode_clip($matches);
  $data['abcode']['file'] = $cs_abcode['abcode_file'];
  $data['abcode']['order'] = $cs_abcode['abcode_order'];
  $data['abcode']['id'] = $abcode_id;

  echo cs_subtemplate(__FILE__,$data,'abcode','edit');
}
else {
  $abcode_cells = array_keys($cs_abcode);
  $abcode_save = array_values($cs_abcode);
  cs_sql_update(__FILE__,'abcode',$abcode_cells,$abcode_save,$abcode_id);

  cs_cache_delete('abcode_smileys');
  cs_cache_delete('abcode_content');

  cs_redirect($cs_lang['changes_done'], 'abcode') ;
}