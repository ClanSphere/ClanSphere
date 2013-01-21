<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('fightus');

$data = array();

if(isset($_POST['submit'])) {
  
  require_once 'mods/clansphere/func_options.php';
  
  $save = array();
  $save['max_usershome'] = (int) $_POST['max_usershome'];
  
  cs_optionsave('fightus', $save);

  cs_redirect($cs_lang['changes_done'],'options','roots');
  
}
$op_articles = cs_sql_option(__FILE__,'fightus');
$data['op']['max_usershome'] = $op_articles['max_usershome'];

echo cs_subtemplate(__FILE__,$data,'fightus','options');