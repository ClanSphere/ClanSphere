<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$select = 'users_email, users_register, users_laston, users_hidden, users_active, users_invisible';
$cs_user = cs_sql_select(__FILE__,'users',$select,"users_id = '" . $account['users_id'] . "'");
$hidden = explode(',',$cs_user['users_hidden']);

$data['head']['mod'] = $cs_lang['mod_name'];
$data['head']['action'] = $cs_lang['home'];
$data['head']['body_text'] = $cs_lang['home_info'];
echo cs_subtemplate(__FILE__,$data,'users','head');

if($cs_user['users_invisible'] == 1) {
  $if_invis = ' (' . $cs_lang['invisible'] . ')';
}else{
  $if_invis = '';
}

$data['users']['link'] = cs_user($account['users_id'], $account['users_nick'], $cs_user['users_active']) . $if_invis;
$data['lang']['getmsg'] = cs_getmsg();

if(in_array('users_email',$hidden)) {
  $cs_user['users_email'] = cs_html_italic(1) . $cs_user['users_email'] . cs_html_italic(0);
}
$data['users']['email'] = empty($cs_user['users_email']) ? '--' : $cs_user['users_email'];
$data['users']['register'] = cs_date('unix',$cs_user['users_register'],1);
$data['users']['laston'] =  cs_date('unix',$cs_user['users_laston'],1);
$data['users']['access_name'] = cs_secure($account['access_name']);

echo cs_subtemplate(__FILE__,$data,'users','home');

$plugins = cs_checkdirs('mods','users/home');
ksort($plugins);

foreach($plugins as $mod) {
  $acc_dir = 'access_' . $mod['dir'];
  if(array_key_exists($acc_dir,$account) AND $account[$acc_dir] >= $mod['show']['users/home']) {
    include_once('mods/' . $mod['dir'] . '/users_home.php');
  }
}