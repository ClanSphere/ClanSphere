<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$languages = cs_checkdirs('lang');

$cookie_lang = empty($_COOKIE['cs_lang']) ? '' : $_COOKIE['cs_lang'];
$cs_user['users_lang'] = empty($_GET['lang']) ? $cookie_lang : $_GET['lang'];

$allow = 0;

foreach($languages as $mod) {
  if($mod['dir'] == $cs_user['users_lang']) { $allow++; }
}
$cs_user['users_lang'] = empty($allow) ? $cs_main['def_lang'] : $cs_user['users_lang'];

if(empty($account['users_id']) AND $cookie_lang != $cs_user['users_lang']) {
  setcookie('cs_lang',$cs_user['users_lang'], $cookie['lifetime'], $cookie['path'], $cookie['domain']);
}
elseif(!empty($account['users_id']) AND $account['users_lang'] != $cs_user['users_lang']) {
  $users_cells = array_keys($cs_user);
  $users_save = array_values($cs_user);
  cs_sql_update(__FILE__,'users',$users_cells,$users_save,$account['users_id']);
}

$account['users_lang'] = $cs_user['users_lang'];

?>