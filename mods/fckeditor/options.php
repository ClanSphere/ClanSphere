<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('fckeditor');

if(isset($_POST['submit'])) {

  $save = array();
  $save['skin'] = $_POST['skin'];
  $save['height'] = $_POST['height'];
  
  require 'mods/clansphere/func_options.php';
  
  cs_optionsave('fckeditor', $save);
  
  cs_redirect($cs_lang['success'], 'options', 'roots');
}

$data = array();

$data['op'] = cs_sql_option(__FILE__,'fckeditor');

$skin[0]['skin'] = 'default';
$skin[0]['path'] = 'default';
$skin[1]['skin'] = 'office2003';
$skin[1]['path'] = 'office2003';
$skin[2]['skin'] = 'silver';
$skin[2]['path'] = 'silver';

$data['op']['skin'] = cs_dropdown('skin', 'path', $skin, $data['op']['skin']);

echo cs_subtemplate(__FILE__,$data,'fckeditor','options');