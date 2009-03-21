<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$
$cs_lang = cs_translate('users');
$data = array();

$select = 'users_id, users_nick, users_name, users_surname, users_picture, users_country, users_register, users_active';
$data['users'] = cs_sql_select(__FILE__,'users',$select,"users_active = '1'",'RAND()',0,1);

$data['users']['picture'] = empty($data['users']['users_picture']) ? $cs_lang['nopic'] :
  cs_html_img('uploads/users/' . $data['users']['users_picture']);
$data['users']['nick'] = cs_user($data['users']['users_id'],$data['users']['users_nick'], $data['users']['users_active']);
$data['users']['flag'] = cs_html_img('symbols/countries/' . $data['users']['users_country'] . '.png',11,16);
$data['users']['since'] = cs_date('unix',$data['users']['users_register'],0,1);
if(empty($data['users']['users_name']) && empty($data['users']['users_surname'])) {
  $data['users']['name'] = $cs_lang['noname'];
  $data['users']['surname'] = '';
} else {
  $data['users']['name'] = $data['users']['users_name'];
  $data['users']['surname'] = $data['users']['users_surname'];
}
echo cs_subtemplate(__FILE__,$data,'users','navrand');
?>