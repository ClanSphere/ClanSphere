<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

$cs_post = cs_post('id');
$cs_get = cs_get('id');

$files_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $files_id = $cs_post['id'];

require_once('mods/categories/functions.php');

$files_newtime = 0;
$files_newcount = 0;

$data = array();
$data['file']['files_id'] = $files_id;
$size = 0;

if(isset($_POST['submit'])) {

  if(!empty($_POST['files_newtime'])) {
    $data['file']['files_time'] = cs_time();
    $files_newtime = 1;
  } 
  
  if(!empty($_POST['files_newcount'])) {
    $data['file']['files_count'] = '';
    $files_newcount = 1;
  }

  $data['file']['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
  cs_categories_create('files',$_POST['categories_name']);

  $data['file']['files_close'] = isset($_POST['files_close']) ? $_POST['files_close'] : 0; 
  $data['file']['files_vote'] = isset($_POST['files_vote']) ? $_POST['files_vote'] : 0;
  $data['file']['files_name'] = $_POST['files_name'];
  $data['file']['files_version'] = $_POST['files_version'];
  $data['file']['files_description'] = $_POST['files_description'];
  $data['file']['files_size'] = stripos($_POST['files_size'], ',') === FALSE ? $_POST['files_size'] : strtr($_POST['files_size'], ',', '.');
  $data['file']['files_size'] = round($data['file']['files_size'], 2);
  $size = $_POST['size'];
  $run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 2;
  $data['file']['files_mirror'] = '';
  for($run=0; $run < $run_loop; $run++)
  {
      $num = $run+1;
    if(!empty($_POST["files_mirror_url_$num"]) AND !empty($_POST["files_mirror_ext_$num"]) AND empty($_POST["files_mirror_remove_$num"]))
    {
      $data['file']["files_mirror"] = $data['file']["files_mirror"] . "\n-----\n" . $_POST["files_mirror_url_$num"] . "\n" . $_POST["files_mirror_name_$num"] . "\n". $_POST["files_mirror_ext_$num"] . "\n" . $_POST["files_access_$num"];
    }
  }
  
  $error = '';
  
  if(empty($data['file']['files_size']))
    $error .= $cs_lang['no_size'] . cs_html_br(1);
  else {
    if($size == 0) { 
      $data['file']['files_size'] = $data['file']['files_size'] * 1024;
    }
    elseif($size == 1) {
      $data['file']['files_size'] = $data['file']['files_size'] * 1024 * 1024;
    }
    elseif($size == 2) {
      $data['file']['files_size'] = $data['file']['files_size'] * 1024 * 1024 * 1024;
    }
  }

  if(empty($data['file']['categories_id']))
    $error .= $cs_lang['no_cat'] . cs_html_br(1);
  if(empty($data['file']['files_name']))
    $error .= $cs_lang['no_name'] . cs_html_br(1);
  if(empty($data['file']['files_description']))
    $error .= $cs_lang['no_text'] . cs_html_br(1);
  if(empty($data['file']['files_mirror']))
    $error .= $cs_lang['no_mirror'] . cs_html_br(1);

}
else
{
  $cells = 'categories_id, files_name, files_version, files_description, files_mirror, users_id, files_time AS time, files_close, files_vote, files_size, files_id';
  $data['file'] = cs_sql_select(__FILE__,'files',$cells,"files_id = '" . $files_id . "'");
}
if(isset($_POST['mirror']))
{
  $data['file']['categories_id'] = empty($_POST['categories_name']) ? $_POST['categories_id'] : 
  cs_categories_create('files',$_POST['categories_name']);
  $data['file']['files_close'] = isset($_POST['files_close']) ? $_POST['files_close'] : 0; 
  $data['file']['files_vote'] = isset($_POST['files_vote']) ? $_POST['files_vote'] : 0;
  $data['file']['files_name'] = $_POST['files_name'];
  $data['file']['files_version'] = $_POST['files_version'];
  $data['file']['files_description'] = $_POST['files_description'];
  $data['file']['files_size'] = stripos($_POST['files_size'], ',') === FALSE ? $_POST['files_size'] : strtr($_POST['files_size'], ',', '.');
  $data['file']['files_size'] = round($data['file']['files_size'], 2);
  $size = $_POST['size'];
    $_POST['run_loop']++;
}

if(!isset($_POST['submit']))
  $data['head']['message'] = $cs_lang['body_edit'];
elseif(!empty($error))
  $data['head']['message'] = $error;


if(!empty($error) OR !isset($_POST['submit'])) {

  $size = 0;
  $data['file']['files_size'] /= 1024;

  while($data['file']['files_size'] >= 1024 && $size < 2) {
    $data['file']['files_size'] /= 1024; 
    $size++;
  }
  
  for($l=0; $l < 3; $l++) {
    $data['levels'][$l]['value'] = $l;
    $data['levels'][$l]['name'] = $cs_lang['size_' . $l];
    $data['levels'][$l]['if']['selected'] = $size == $l ? true : false;
  } 
  

  $data['categories']['dropdown'] = cs_categories_dropdown2('files',$data['file']['categories_id']);
  $data['text']['smileys'] = cs_abcode_smileys('files_description');
  $data['text']['features'] = cs_abcode_features('files_description');
  
  $data['if']['closed'] = $data['file']['files_close'] ? true : false;
  $data['if']['votes'] = $data['file']['files_vote'] ? true : false;
  if(isset($_POST['mirror'])){
    $run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 1;
  } else {
    $files_mirror = $data['file']['files_mirror'];
    $temp = explode("-----", $files_mirror);
    $run_loop = count($temp);
  }
  $data['mirrors'] = array();
  for($run=1; $run < $run_loop; $run++){
      $num = $run+1;
      $data['mirrors'][$run-1]['run'] = $run;
      $data['mirrors'][$run-1]['num'] = $num;
      if(isset($_POST['mirror'])){
      $data['mirrors'][$run-1]['url'] = isset($_POST["files_mirror_url_$num"]) ? $_POST["files_mirror_url_$num"] : 'http://server.net/data.zip';
      $data['mirrors'][$run-1]['name'] = isset($_POST["files_mirror_name_$num"]) ? $_POST["files_mirror_name_$num"] : 'Mirror ' . $num;
      $data['mirrors'][$run-1]['ext'] = isset($_POST["files_mirror_ext_$num"]) ? $_POST["files_mirror_ext_$num"] : 'zip';
      $data['mirrors'][$run-1]['access'] = isset($_POST["files_access_$num"]) ? $_POST["files_access_$num"] : 0;
    } else {
      $temp_a = explode("\n", $temp[$run]);
      $data['mirrors'][$run-1]['url'] = $temp_a['1'];
      $data['mirrors'][$run-1]['name'] = $temp_a['2'];
      $data['mirrors'][$run-1]['ext'] = $temp_a['3'];
      $data['mirrors'][$run-1]['access'] = $temp_a['4'];
    }  
    $data['mirrors'][$run-1]['accesses'] = array();
    for($a = 0; $a < 6; $a++) {
      $data['mirrors'][$run-1]['accesses'][$a]['name'] = $a . ' - ' . $cs_lang['lev_' . $a];
      $data['mirrors'][$run-1]['accesses'][$a]['value'] = $a;
      $data['mirrors'][$run-1]['accesses'][$a]['selected'] = $a == $data['mirrors'][$run-1]['access'] ? ' selected="selected"' : '';
    }
  }
  
  $data['mirror']['run_loop'] = $run_loop;
  echo cs_subtemplate(__FILE__,$data,'files','edit');
}
else {
  $files_cells = array_keys($data['file']);
  $files_save = array_values($data['file']);
 cs_sql_update(__FILE__,'files',$files_cells,$files_save,$files_id);
    
 cs_redirect($cs_lang['changes_done'],'files');
}