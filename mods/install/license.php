<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

if(isset($_POST['submit'])) {

  $license = isset($_POST['accept']) ? $_POST['accept'] : 0;
  $errormsg = '';

  if(empty($license)) {
    $errormsg .= $cs_lang['not_accepted'] . cs_html_br(1);
  }
  
  if (empty($errormsg)) {
    cs_redirect('','install','settings','lang=' . $account['users_lang']);
  }
}


if(!empty($errormsg) OR !isset($_POST['submit'])) {
  
  $data = array();

  $data['form']['lang'] = $account['users_lang'];
  if (!empty($errormsg)) $cs_lang['body_license'] = $errormsg;

  echo cs_subtemplate(__FILE__, $data, 'install', 'license');

}