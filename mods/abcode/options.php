<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('abcode');
$data = array();

$data['lang']['getmsg'] = cs_getmsg();

if(empty($_POST['submit'])) {
  $data['options'] = cs_sql_option(__FILE__,'abcode');

  $abc[0]['def_func'] = 'img';
  $abc[0]['name'] = $cs_lang['img'];
  $abc[1]['def_func'] = 'str';
  $abc[1]['name'] = $cs_lang['str'];

  $data['dropdown']['def_func'] = cs_dropdown('def_func','name',$abc,$data['options']['def_func']);

  $abcode_check = empty($data['options']['def_abcode']) ? 0 : 1;
  $data['checkbox']['def_abcode'] =  cs_html_vote('def_abcode','1','checkbox',$abcode_check);

  echo cs_subtemplate(__FILE__,$data,'abcode','options');
  
} else {
  
  require 'mods/clansphere/func_options.php';
  
  $save = array();
  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];
  $save['def_func'] = $_POST['def_func'];
  $save['image_width'] = $_POST['image_width'];
  $save['image_height'] = $_POST['image_height'];
  $save['word_cut'] = $_POST['word_cut'] > 65535 ? 65535 : (int) $_POST['word_cut'];
  $save['def_abcode'] = (int) $_POST['def_abcode'];
  
  cs_optionsave('abcode', $save);
  
  cs_redirect($cs_lang['changes_done'], 'abcode', 'options');
  
}

?>