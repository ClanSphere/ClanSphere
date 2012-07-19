<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

require_once('mods/users/functions.php');

$error = 0;
$errormsg = '';

if(isset($_POST['submit'])) {

  $create['users_lang'] = $_POST['lang'];
  $create['users_nick'] = $_POST['nick'];
  $create_['password'] = $_POST['password'];
  $create['users_email'] = $_POST['email'];

  $nick2 = str_replace(' ','',$create['users_nick']);
  $nickchars = strlen($nick2);
  if($nickchars<4) {
    $error++;
    $errormsg .= $cs_lang['short_nick'] . cs_html_br(1);
  }

  $pwd2 = str_replace(' ','',$create_['password']);
  $pwdchars = strlen($pwd2);
  if($pwdchars<4) {
    $error++;
    $errormsg .= $cs_lang['short_pwd'] . cs_html_br(1);
  }

  $pattern = "=^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([0-9a-z](-?[0-9a-z])*\.)+[a-z]{2}([zmuvtg]|fo|me)?$=i";
  if(!preg_match($pattern,$create['users_email'])) {
    $error++;
    $errormsg .= $cs_lang['email_false'] . cs_html_br(1);
  }
}
else {

  $create['users_lang'] = $account['users_lang'];
  $create['users_nick'] = '';
  $create_['password'] = '';
  $create['users_email'] = '';
}


if(!empty($error) OR !isset($_POST['submit'])) {
  
  $data = array();
  
  if (isset($_POST['submit'])) $data['lang']['create_admin'] = $errormsg;

  $langs = cs_checkdirs('lang');
  $i = 0;
  $data['langs'] = array();
  
  foreach ($langs AS $lang) {
    $data['langs'][$i]['name'] = $lang['name'];
    $data['langs'][$i]['selected'] = $lang['name'] == $create['users_lang'] ? ' selected="selected"' : '';
    $i++;
  }
  
  $data['value']['users_nick'] = $create['users_nick'];
  $data['value']['users_email'] = $create['users_email'];
  $data['value']['users_password'] = $create_['password'];
  
  
  echo cs_subtemplate(__FILE__, $data, 'install', 'admin');
  
} else {

  $dstime = date('I');
  $create['users_timezone'] = empty($dstime) ? date('Z') : date('Z') - 3600;
  $create['users_dstime'] = 0;
  $access = cs_sql_select(__FILE__,'access','access_id','access_clansphere = 5');
  create_user($access['access_id'],$create['users_nick'],$create_['password'],$create['users_lang'],$create['users_email'],'fam',$create['users_timezone'],$create['users_dstime']);
  
  // Options
  $def_cell = array('options_value');
  cs_sql_update(__FILE__,'options',$def_cell,array($create['users_timezone']),0,'options_mod = \'clansphere\' AND options_name = \'def_timezone\'');
  cs_sql_update(__FILE__,'options',$def_cell,array($_POST['clanlabel']),0,'options_mod = \'clans\' AND options_name = \'label\'');
  cs_sql_update(__FILE__,'options',$def_cell,array($_POST['squadlabel']),0,'options_mod = \'squads\' AND options_name = \'label\'');
  cs_sql_update(__FILE__,'options',$def_cell,array($_POST['memberlabel']),0,'options_mod = \'members\' AND options_name = \'label\'');

  
  cs_redirect('','install','complete','lang='.$create['users_lang']);
}