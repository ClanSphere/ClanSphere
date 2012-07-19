<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

if(isset($_POST['submit'])) {

  $pwd['current'] = $_POST['pwd_current'];
  $pwd['new'] = $_POST['pwd_new'];
  $pwd['again'] = $_POST['pwd_again'];
  $cs_user = cs_sql_select(__FILE__,'users','users_pwd',"users_id = '" . $account['users_id'] . "'");

  global $cs_db;
  if($cs_db['hash'] == 'md5') { 
    $sec_pwd = md5($pwd['current']);
    $new_pwd = md5($pwd['new']);
  }
  elseif($cs_db['hash'] == 'sha1') { 
    $sec_pwd = sha1($pwd['current']);
    $new_pwd = sha1($pwd['new']);  
  }

  $error = '';
  
  if($cs_user['users_pwd'] != $sec_pwd) {
    $error .= $cs_lang['wrong_current_pwd'] . cs_html_br(1);
  }

  $pwd2 = str_replace(' ','',$pwd['new']);
  $pwdchars = strlen($pwd2);
  if($pwdchars<4) {
    $error .= $cs_lang['short_pwd'] . cs_html_br(1);
  }
  
  if($pwd['new'] != $pwd['again']) {
    $error .= $cs_lang['not_match'] . cs_html_br(1);
  }
}
else {
  $pwd = array('current' => '', 'new' => '', 'again' => '');
}
if(!isset($_POST['submit'])) {
  $data['head']['body'] = $cs_lang['change_password'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['users']['current_pwd'] = '';
  $data['users']['new_pwd'] = '';
  $data['users']['pwd_again'] = '';

  $matches[1] = $cs_lang['secure_stages'];
  $matches[2] = $cs_lang['stage_1'] . $cs_lang['stage_1_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_2'] . $cs_lang['stage_2_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_3'] . $cs_lang['stage_3_text'] . cs_html_br(1);
  $matches[2] .= $cs_lang['stage_4'] . $cs_lang['stage_4_text'];
  $data['users']['secure_clip'] = cs_abcode_clip($matches);
  
  echo cs_subtemplate(__FILE__,$data,'users','password');
}
else {

  $users_cells = array('users_pwd');
  $users_save = array($new_pwd);
  cs_sql_update(__FILE__,'users',$users_cells,$users_save,$account['users_id']);

  cs_redirect($cs_lang['changes_done'],'users','home');
}