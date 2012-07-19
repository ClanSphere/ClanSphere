<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');
$data = array();

$select = 'users_id, users_nick, users_name, users_surname, users_picture, users_country, users_register, users_active, users_hidden';
$data['users'] = cs_sql_select(__FILE__,'users',$select,'users_active = 1 AND users_delete = 0','{random}',0,1);

$data['users']['picture'] = empty($data['users']['users_picture']) ? $cs_lang['nopic'] :
  cs_html_img('uploads/users/' . $data['users']['users_picture']);
$data['users']['nick'] = cs_user($data['users']['users_id'],$data['users']['users_nick'], $data['users']['users_active']);
$data['users']['flag'] = cs_html_img('symbols/countries/' . $data['users']['users_country'] . '.png',11,16);
$data['users']['since'] = cs_date('unix',$data['users']['users_register'],0,1);


$hidden = explode(',',$data['users']['users_hidden']);
$allow = 0;
if($data['users']['users_id'] == $account['users_id'] OR $account['access_users'] > 4) {
  $allow = 1;
}

$name = cs_secure($data['users']['users_name']);
if(in_array('users_name',$hidden)) {
  $name = empty($allow) ? '' : cs_html_italic(1) . $name . cs_html_italic(0);
}
$surname = cs_secure($data['users']['users_surname']);
if(in_array('users_surname',$hidden)) {
  $surname = empty($allow) ? '' : cs_html_italic(1) . $surname . cs_html_italic(0);
}
if(empty($name) && empty($surname)) {
  $name = $cs_lang['noname'];
  $surname = '';
}

$data['users']['name'] = $name;
$data['users']['surname'] = $surname;

echo cs_subtemplate(__FILE__,$data,'users','navrand');
