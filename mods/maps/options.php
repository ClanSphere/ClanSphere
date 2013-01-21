<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('maps');

$data = array();

if(isset($_POST['submit'])) {

  require_once 'mods/clansphere/func_options.php';

  $save = array();
  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];

  cs_optionsave('maps', $save);

  cs_redirect($cs_lang['changes_done'],'options','roots');
}

$data['op'] = cs_sql_option(__FILE__,'maps');
echo cs_subtemplate(__FILE__,$data,'maps','options');