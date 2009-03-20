<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('news');

if(isset($_POST['submit'])) {

  $abcode = array((int) $_POST['features'],(int) $_POST['smileys'],(int) $_POST['clip'],(int) $_POST['html'],(int) $_POST['php']);
  $abcode = implode(",",$abcode);

  $save = array();
  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];
  $save['max_navlist'] = (int) $_POST['max_navlist'];
  $save['max_recent'] = (int) $_POST['max_recent'];
  $save['def_public'] = (int) $_POST['def_public'];
  $save['rss_title'] = $_POST['rss_title'];
  $save['rss_description'] = $_POST['rss_description'];
  $save['abcode'] = $abcode;
  
  require 'mods/clansphere/func_options.php';
  
  cs_optionsave('news', $save);
  
  cs_redirect($cs_lang['success'], 'options', 'roots');

}

$data = array();
$data['op'] = cs_sql_option(__FILE__,'news');

$data['op']['public_no'] = empty($data['op']['def_public']) ? ' checked="checked"' : '';
$data['op']['public_yes'] = empty($data['op']['def_public']) ? '' : ' checked="checked"';

/* ABcode*/
$abcode = explode(",",$data['op']['abcode']);
$data['op']['features'] = empty($abcode[0]) ? '' : 'checked="checked"';
$data['op']['smileys'] = empty($abcode[1]) ? '' : 'checked="checked"';
$data['op']['clip'] = empty($abcode[2]) ? '' : 'checked="checked"';
$data['op']['html'] = empty($abcode[3]) ? '' : 'checked="checked"';
$data['op']['php'] = empty($abcode[4]) ? '' : 'checked="checked"';

echo cs_subtemplate(__FILE__,$data,'news','options');

?>