<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('contact');

$data = array();

if(isset($_POST['submit'])) {

  $save = array();
  $save['def_org'] = $_POST['def_org'];
  $save['def_mail'] = $_POST['def_mail'];
  $save['smtp_host'] = $_POST['smtp_host'];
  $save['smtp_port'] = $_POST['smtp_port'];
  $save['smtp_user'] = $_POST['smtp_user'];
  $save['smtp_pw'] = $_POST['smtp_pw'];

  require_once 'mods/clansphere/func_options.php';
  
  cs_optionsave('contact', $save);
  cs_redirect($cs_lang['success'], 'options','roots');
} 
else {

  $data['options'] = cs_sql_option(__FILE__, 'contact');
  $data['sendmail']['path'] = ini_get('sendmail_path');

  echo cs_subtemplate(__FILE__,$data,'contact','options');
}