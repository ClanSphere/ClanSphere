<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$data = array();

$key = empty($_GET['key']) ? '' : $_GET['key'];
$key = preg_replace('/[^\w]/s','', $key);
$uemail = empty($_GET['email']) ? '' : $_GET['email'];
$pattern = "=^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([0-9a-z](-?[0-9a-z])*\.)+[a-z]{2}([zmuvtg]|fo|me)?$=i";
$uemail = preg_match($pattern, $uemail) ? $uemail : '';

$select = 'users_id';
$where = "users_regkey = '" . cs_sql_escape($key) . "' AND users_email = '" . cs_sql_escape($uemail) . "' AND users_active = 0";
$cs_user = cs_sql_select(__FILE__,'users',$select,$where,0,0);
$users_count = count($cs_user);

if(empty($users_count)) {
  $data['head']['body_text'] = $cs_lang['no_activation'];
  $data['activate']['link'] = cs_url('users','login');
}
else {
  $users_cells = array('users_active');
  $users_save = array('1');
  cs_sql_update(__FILE__,'users', $users_cells,$users_save,$cs_user['users_id']);
  $data['head']['body_text'] = $cs_lang['account_activated'];
  $data['activate']['link'] = cs_url('users','home');
}

$data['head']['action'] = $cs_lang['activate_acc'];
echo cs_subtemplate(__FILE__,$data,'users','head');
echo cs_subtemplate(__FILE__,$data,'users','activate');