<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('ckeditor');

if(isset($_POST['submit'])) {

  $save = array();
  $save['skin'] = $_POST['skin'];
  $save['height'] = $_POST['height'];
  
  require_once 'mods/clansphere/func_options.php';
  
  cs_optionsave('ckeditor', $save);
  
  cs_redirect($cs_lang['success'], 'options', 'roots');
}

$data = array();

$data['op'] = cs_sql_option(__FILE__,'ckeditor');

$skin[0]['skin'] = 'kama';
$skin[0]['path'] = 'kama';
$skin[1]['skin'] = 'office2003';
$skin[1]['path'] = 'office2003';
$skin[2]['skin'] = 'v2';
$skin[2]['path'] = 'v2';

$data['op']['skin'] = cs_dropdown('skin', 'path', $skin, $data['op']['skin']);

echo cs_subtemplate(__FILE__,$data,'ckeditor','options');