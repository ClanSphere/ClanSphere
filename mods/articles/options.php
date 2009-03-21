<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('articles');

$data = array();

if(isset($_POST['submit'])) {
  
  require 'mods/clansphere/func_options.php';
  
  $save = array();
  $save['max_navlist'] = (int) $_POST['max_navlist'];
  
  cs_optionsave('articles', $save);

  cs_redirect($cs_lang['changes_done'],'options','roots');
  
}
$op_articles = cs_sql_option(__FILE__,'articles');
$data['op']['max_navlist'] = $op_articles['max_navlist'];
echo cs_subtemplate(__FILE__,$data,'articles','options');
?>