<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('articles');

$data = array();

if(isset($_POST['submit'])) {
  
  require_once 'mods/clansphere/func_options.php';
  
  $save = array();
  $save['max_navlist'] = (int) $_POST['max_navlist'];
  $save['max_navtop'] = (int) $_POST['max_navtop'];
  
  cs_optionsave('articles', $save);

  cs_redirect($cs_lang['changes_done'],'options','roots');
  
}
$op_articles = cs_sql_option(__FILE__,'articles');
$data['op']['max_navlist'] = $op_articles['max_navlist'];
$data['op']['max_navtop'] = $op_articles['max_navtop'];
echo cs_subtemplate(__FILE__,$data,'articles','options');