<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('games');
require_once 'mods/categories/functions.php';

$img_max['width'] = 30;
$img_max['height'] = 30;
$img_max['size'] = 15360;
$img_filetypes = array('image/gif' => 'gif');

$games_error = 3; 
$games_form = 1;


if(empty($_POST['datum_month']) OR empty($_POST['datum_day']) OR empty($_POST['datum_year'])) {
  $games_release = '';  
}
else {
  $games_release = $_POST['datum_year'] . '-' . $_POST['datum_month'] . '-' .   $_POST['datum_day'];
}

$symbol = '';
$games_name = '';
$games_version = '';
$games_creator = '';
$games_url = ''; 
$categories_id = empty($_POST['categories_id']) ? 0 : $_POST['categories_id'];
$games_usk = ''; 
$errormsg = '';


if(!empty($_POST['games_name'])) {
  $games_name = $_POST['games_name'];
  $games_error--;
}
else {
  $errormsg .= $cs_lang['name_error'] . cs_html_br(1);
}  

if(!empty($_POST['symbol'])) {
 $symbol = $_POST['symbol'];
}

if(!empty($_POST['games_version'])) {
 $games_version = $_POST['games_version'];
 $games_error--;
}
else {
$errormsg .= $cs_lang['version_error'] . cs_html_br(1);
}

if(!empty($_POST['games_usk'])) {
 $games_usk = $_POST['games_usk'];
}

$categories_id = empty($_POST['categories_name']) ? $categories_id : cs_categories_create('games',$_POST['categories_name']);

if(!empty($categories_id)) {
  $games_error--;
}
else {
  $errormsg .= $cs_lang['cat_error'] . cs_html_br(1);
}

if(!empty($_FILES['symbol']['tmp_name'])) {
  $symbol_error = 1;
  foreach($img_filetypes AS $allowed => $new_ext) {
    if($allowed == $_FILES['symbol']['type']) {
      $symbol_error = 0;
      $extension = $new_ext;
    }
  }
  $img_size = getimagesize($_FILES['symbol']['tmp_name']);
  
  if($img_size[0]>$img_max['width']) {
    $errormsg .= $cs_lang['too_wide'] . cs_html_br(1); 
    $symbol_error++;
  }

  if($img_size[1]>$img_max['height']) { 
    $errormsg .= $cs_lang['too_high'] . cs_html_br(1);
    $symbol_error++;
  }
  
  if($_FILES['symbol']['size']>$img_max['size']) {
    $errormsg .= $cs_lang['too_big'] . cs_html_br(1); 
    $symbol_error++;
  }
}

if(!empty($_POST['games_creator'])) {
  $games_creator = $_POST['games_creator'];
}

if(!empty($_POST['games_url'])) {
  $games_url = $_POST['games_url'];
}

if(!isset($_POST['submit'])) {
  $data['lang']['body'] = $cs_lang['body_create'];
}
else {
  $data['lang']['body'] = $errormsg;
}

if(isset($_POST['submit'])) {
  if(empty($games_error)) {
    $games_form = 0;
        
    $games_cells = array('games_name','games_version','games_released','games_creator','categories_id','games_url','games_usk');
    $games_save = array($games_name,$games_version,$games_release,$games_creator,$categories_id,$games_url,$games_usk);
    cs_sql_insert(__FILE__,'games',$games_cells,$games_save);
    
        
    if(!empty($_FILES['symbol']['tmp_name']) AND $symbol_error == 0) {
      $where = "games_name = '" . cs_sql_escape($games_name) . "'";
      $getid = cs_sql_select(__FILE__,'games','games_id',$where);
      $filename = $getid['games_id'] . '.' . $extension;
      cs_upload('games',$filename,$_FILES['symbol']['tmp_name']);
    }
  
  }  
  cs_redirect($cs_lang['create_done'],'games');
}


if(!empty($games_form)) {
  $data['url']['form'] = cs_url('games','create');
  
  $data['games']['name'] = $games_name;
  $data['games']['version'] = $games_version;
  $data['games']['genre'] = cs_categories_dropdown('games',$categories_id);
  $data['games']['release'] = cs_dateselect('datum','date',$games_release);
  $data['games']['creator'] = $games_creator;
  $data['games']['homepage'] = $games_url;
        
  $usknum[0]['games_usk'] = '00';
  $usknum[0]['name'] = $cs_lang['usk_00'];
  $usknum[1]['games_usk'] = '06';
  $usknum[1]['name'] = $cs_lang['usk_06'];
  $usknum[2]['games_usk'] = '12';
  $usknum[2]['name'] = $cs_lang['usk_12'];
  $usknum[3]['games_usk'] = '16';
  $usknum[3]['name'] = $cs_lang['usk_16'];
  $usknum[4]['games_usk'] = '18';
  $usknum[4]['name'] = $cs_lang['usk_18'];
  $data['games']['usk'] = cs_dropdown('games_usk','name',$usknum,$games_usk);
    
  $matches[1] = $cs_lang['pic_infos'];
  $return_types = '';
  foreach($img_filetypes AS $add => $value) {
    $return_types .= empty($return_types) ? $add : ', ' . $add;
  }
  $matches[2] = $cs_lang['max_width'] . $img_max['width'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_height'] . $img_max['height'] . ' px' . cs_html_br(1);
  $matches[2] .= $cs_lang['max_size'] . cs_filesize($img_max['size']) . cs_html_br(1);
  $matches[2] .= $cs_lang['filetypes'] . $return_types;
  $data['games']['clip'] = cs_abcode_clip($matches);
  
  echo cs_subtemplate(__FILE__,$data,'games','create');
}
?>
