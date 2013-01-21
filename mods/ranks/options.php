<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('ranks');

$data = array();

if(isset($_POST['submit'])) {
  
  require_once 'mods/clansphere/func_options.php';
  
  $save = array();
  $save['max_navlist'] = (int) $_POST['max_navlist'];
  
  cs_optionsave('ranks', $save);

  cs_redirect($cs_lang['changes_done'],'options','roots');
  
}
$data['op'] = cs_sql_option(__FILE__,'ranks');

echo cs_subtemplate(__FILE__,$data,'ranks','options');