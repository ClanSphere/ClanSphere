<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('games');

require_once 'mods/categories/functions.php';

$files = cs_files();

$options = cs_sql_option(__FILE__, 'games');
$img_filetypes = array('image/gif' => 'gif');

$games_error = 0;
$games_form = 1;

if(empty($_POST['datum_month']) OR empty($_POST['datum_day']) OR empty($_POST['datum_year'])) {
  $games_release = cs_date('unix',cs_time(),0,1,'Y-m-d');  
}
else {
  $games_release = $_POST['datum_year'] . '-' . $_POST['datum_month'] . '-' .   $_POST['datum_day'];
}

$symbol = empty($_POST['symbol']) ? '' : $_POST['symbol'];
$games_name = '';
$games_version = '';
$games_creator = '';
$games_url = ''; 
$categories_id = empty($_POST['categories_id']) ? 0 : $_POST['categories_id'];
$games_usk = empty($_POST['games_usk']) ? '' : $_POST['games_usk'];
$errormsg = '';

if(!empty($_POST['games_name'])) {
  $games_name = $_POST['games_name'];
} else {
  $errormsg .= $cs_lang['name_error'] . cs_html_br(1);
  $games_error++;
}

$categories_id = empty($_POST['categories_name']) ? $categories_id : cs_categories_create('games',$_POST['categories_name']);

if(empty($categories_id)) {
  $errormsg .= $cs_lang['cat_error'] . cs_html_br(1);
  $games_error++;
}

if(!empty($files['symbol']['tmp_name'])) {
  $symbol_error = 1;
  foreach($img_filetypes AS $allowed => $new_ext) {
    if($allowed == $files['symbol']['type']) {
      $symbol_error = 0;
      $extension = $new_ext;
    }
  }
  $img_size = getimagesize($files['symbol']['tmp_name']);

  if(!empty($symbol_error) AND $img_size[2] != 1) {
    $errormsg .= $cs_lang['ext_error'] . cs_html_br(1); 
    $symbol_error++;
  }

  if($img_size[0] > $options['max_width']) {
    $errormsg .= $cs_lang['too_wide'] . cs_html_br(1); 
    $symbol_error++;
  }

  if($img_size[1] > $options['max_height']) { 
    $errormsg .= $cs_lang['too_high'] . cs_html_br(1);
    $symbol_error++;
  }

  if($files['symbol']['size'] > $options['max_size']) {
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

if(!empty($_POST['games_version'])) {
  $games_version = $_POST['games_version'];
}

$data['lang']['body'] = !isset($_POST['submit']) ? $cs_lang['body_create'] : $errormsg;

if(isset($_POST['submit']) && empty($games_error) && empty($symbol_error)) {

  $games_cells = array('games_name','games_version','games_released','games_creator','categories_id','games_url','games_usk');
  $games_save = array($games_name,$games_version,$games_release,$games_creator,$categories_id,$games_url,$games_usk);
  cs_sql_insert(__FILE__,'games',$games_cells,$games_save);

  $where = "games_name = '" . cs_sql_escape($games_name) . "'";
  $getid = cs_sql_select(__FILE__,'games','games_id',$where);

  if(!empty($files['symbol']['tmp_name']) AND $symbol_error == 0) {
    $filename = $getid['games_id'] . '.' . $extension;
    cs_upload('games',$filename,$files['symbol']['tmp_name']);
  }
  else {
    copy('uploads/games/0.gif', 'uploads/games/' . (int) $getid['games_id'] . '.gif');
  }

  cs_redirect($cs_lang['create_done'],'games');
}

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
$matches[2] = $cs_lang['max_width'] . ': ' . $options['max_width'] . ' px' . cs_html_br(1);
$matches[2] .= $cs_lang['max_height'] . ': ' . $options['max_height'] . ' px' . cs_html_br(1);
$matches[2] .= $cs_lang['max_size'] . ': ' . cs_filesize($options['max_size']) . cs_html_br(1);
$matches[2] .= $cs_lang['filetypes'] . $return_types;
$data['games']['clip'] = cs_abcode_clip($matches);

echo cs_subtemplate(__FILE__,$data,'games','create');