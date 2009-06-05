<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('contact');

$data = array();

if(isset($_POST['submit'])) {

  $save = array();
  $save['def_org'] = $_POST['def_org'];
  $save['def_mail'] = $_POST['def_mail'];

  require_once 'mods/clansphere/func_options.php';
  
  cs_optionsave('contact', $save);

  cs_redirect($cs_lang['success'], 'options','roots');

} 
else {

	$data['options'] = cs_sql_option(__FILE__, 'contact');

  echo cs_subtemplate(__FILE__,$data,'contact','options');
}