<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

$data = array();

require_once('mods/categories/functions.php');

$data['file']['files_time'] = cs_time();
$data['file']['users_id'] = $account['users_id'];

$filetypes = array('application/pdf' => 'pdf','text/plain' => 'txt');

$data['file']['files_close'] = 0;
$data['file']['files_vote'] = 0;
$data['file']['categories_id'] = 0;
$data['file']['files_name'] = '';
$data['file']['files_version'] = '';
$data['file']['files_description'] = '';
$data['file']['files_name'] = '';
$data['file']['files_size'] = '';
$data['file']['files_mirror'] = '';
$size = '';

if(isset($_POST['submit']))
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
  $run_loop = isset($_POST['run_loop']) ? (int) $_POST['run_loop'] : 1;

  for($run=1; $run <= $run_loop; $run++)
  {
    if(!empty($_POST["files_mirror_url_$run"]) AND !empty($_POST["files_mirror_ext_$run"]))
    {
      $data['file']['files_mirror'] .= "\n-----\n" . $_POST["files_mirror_url_$run"] . "\n" . $_POST["files_mirror_name_$run"] . "\n" . $_POST["files_mirror_ext_$run"] . "\n" . $_POST["files_access_$run"];
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

  $flood = cs_sql_select(__FILE__,'files','files_time',0,'files_time DESC');
  $maxtime = $flood['files_time'] + $cs_main['def_flood'];
  if($maxtime > cs_time()) {
    $diff = $maxtime - cs_time();
    $error .= sprintf($cs_lang['flood_on'], $diff);
  }
}

if(isset($_POST['mirror'])) {
  $_POST['run_loop']++;
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
  $run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 1;

} else {
  $files_mirror = $data['file']['files_mirror'];
  $temp = explode("-----", $files_mirror);
  $run_loop = count($temp);
}

if(!isset($_POST['submit']))
$data['head']['message'] = $cs_lang['body_create'];
elseif(!empty($error))
$data['head']['message'] = $error;

if(!empty($error) OR !isset($_POST['submit']))
{
  $size = 0;
  $data['file']['files_size'] /= 1024;

  while($data['file']['files_size'] >= 1024 && $size < 2) {
    $data['file']['files_size'] = $data['file']['files_size'] / 1024;
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

  $run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 1;
  $data['mirrors'] = array();

  for($run=0; $run < $run_loop; $run++){
    $num = $run+1;
    $data['mirrors'][$run]['run'] = $run+1;
    $data['mirrors'][$run]['num'] = $num;

    $data['mirrors'][$run]['url'] = isset($_POST["files_mirror_url_$num"]) ? $_POST["files_mirror_url_$num"] : 'http://server.net/data.zip';
    $data['mirrors'][$run]['name'] = isset($_POST["files_mirror_name_$num"]) ? $_POST["files_mirror_name_$num"] : 'Mirror ' . $num;
    $data['mirrors'][$run]['ext'] = isset($_POST["files_mirror_ext_$num"]) ? $_POST["files_mirror_ext_$num"] : 'zip';
    $data['mirrors'][$run]['access'] = isset($_POST["files_access_$num"]) ? $_POST["files_access_$num"] : 0;
     
    $data['mirrors'][$run]['accesses'] = array();
    for($a = 0; $a < 6; $a++) {
      $data['mirrors'][$run]['accesses'][$a]['name'] = $a . ' - ' . $cs_lang['lev_' . $a];
      $data['mirrors'][$run]['accesses'][$a]['value'] = $a;
      $data['mirrors'][$run]['accesses'][$a]['selected'] = $a == $data['mirrors'][$run]['access'] ? ' selected="selected"' : '';
    }
  }
  $data['if']['closed'] = $data['file']['files_close'] ? true : false;
  $data['if']['votes'] = $data['file']['files_vote'] ? true : false;
  $data['mirror']['run_loop'] = $run_loop;

  echo cs_subtemplate(__FILE__,$data,'files','create');
}
else
{
  $files_cells = array_keys($data['file']);
  $files_save = array_values($data['file']);
  cs_sql_insert(__FILE__,'files',$files_cells,$files_save);

  cs_redirect($cs_lang['create_done'],'files');
}