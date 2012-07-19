<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('abcode');

$data = array();

$data['lang']['getmsg'] = cs_getmsg();

if(!isset($_POST['submit'])) {

  $data['options'] = cs_sql_option(__FILE__,'abcode');

  $rte_html_array = cs_checkdirs('mods', 'abcode/rte_html');
  $rte_more_array = cs_checkdirs('mods', 'abcode/rte_more');

  $data['dropdown']['rte_html'] = cs_dropdown('rte_html','name',$rte_html_array,$data['options']['rte_html'], 'dir');
  $data['dropdown']['rte_more'] = cs_dropdown('rte_more','name',$rte_more_array,$data['options']['rte_more'], 'dir');

  $abc[0]['def_func'] = 'img';
  $abc[0]['name'] = $cs_lang['img'];
  $abc[1]['def_func'] = 'str';
  $abc[1]['name'] = $cs_lang['str'];
  $data['dropdown']['def_func'] = cs_dropdown('def_func','name',$abc,$data['options']['def_func']);

  $data['checked']['def_abcode'] = empty($data['options']['def_abcode']) ? '' : ' checked="checked"';

  echo cs_subtemplate(__FILE__,$data,'abcode','options');
}
else {

  require_once 'mods/clansphere/func_options.php';

  $save = array();
  $save['rte_html'] = $_POST['rte_html'];
  $save['rte_more'] = $_POST['rte_more'];
  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];
  $save['def_func'] = $_POST['def_func'];
  $save['image_width'] = $_POST['image_width'];
  $save['image_height'] = $_POST['image_height'];
  $save['word_cut'] = $_POST['word_cut'] > 65535 ? 65535 : (int) $_POST['word_cut'];
  $save['def_abcode'] = empty($_POST['def_abcode']) ? 0 : 1;

  cs_optionsave('abcode', $save);

  cs_redirect($cs_lang['changes_done'], 'options', 'roots');
}