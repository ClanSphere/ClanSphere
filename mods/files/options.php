<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

$data = array();

if(isset($_POST['submit'])) {

  require_once 'mods/clansphere/func_options.php';

  $save = array();
  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];
  $save['max_navlist'] = (int) $_POST['max_navlist'];
  $save['max_headline'] = (int) $_POST['max_headline'];
  $save['max_navtop'] = (int) $_POST['max_navtop'];
  $save['max_headline_navtop'] = (int) $_POST['max_headline_navtop'];

  cs_optionsave('files', $save);

  cs_redirect($cs_lang['changes_done'],'options','roots');
}
$data['op'] = cs_sql_option(__FILE__,'files');

echo cs_subtemplate(__FILE__,$data,'files','options');