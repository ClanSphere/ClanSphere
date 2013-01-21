<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('servers');

if(isset($_POST['submit'])) {

  $save = array();
  $save['max_navlist'] = (int) $_POST['max_navlist'];

  require_once 'mods/clansphere/func_options.php';

  cs_optionsave('servers', $save);

  cs_redirect($cs_lang['changes_done'],'options','roots');
}
else {
  $data = array();
  $data['op'] = cs_sql_option(__FILE__,'servers');
  echo cs_subtemplate(__FILE__,$data,'servers','options');
}