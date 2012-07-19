<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$data = array('langs' => array());
$data['form']['url'] = cs_url($cs_main['def_mod'], $cs_main['def_action'], $cs_main['def_parameters']);
$langs = cs_checkdirs('lang');
$row = 0;

foreach($langs as $lang) {
  $data['langs'][$row]['name'] = $lang['name'];
  $data['langs'][$row]['img'] = $cs_main['php_self']['dirname'] . 'symbols/countries/' . $lang['symbol'] . '.png';
  $data['langs'][$row]['selected'] = $lang['name'] == $account['users_lang'] ? ' selected="selected"' : '';
  $row++;
}

echo cs_subtemplate(__FILE__,$data,'users','navlang');