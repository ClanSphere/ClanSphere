<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('access');

$cs_access = cs_sql_select(__FILE__,'access','*',"access_id = '" . $account['access_id'] . "'");
unset($cs_access['access_id']);
$data = array();
$run = 0;

$data['lang']['name'] = cs_secure($cs_access['access_name']);
$data['lang']['clansphere'] = $account['access_clansphere'] . ' - ' . $cs_lang['clansphere_' . $account['access_clansphere'] . ''];

$modules = cs_checkdirs('mods');

foreach($modules as $mod) {
  $acc_dir = 'access_' . $mod['dir'];
  if(array_key_exists($acc_dir,$cs_access) AND $mod['dir'] != 'clansphere' AND !empty($account[$acc_dir])) {
    if(!empty($mod['icon'])) {
      $data['access'][$run]['icon'] = cs_icon($mod['icon']);
    }
    else {
      $data['access'][$run]['icon'] = '';
    }

    $data['access'][$run]['name'] = $mod['name'];
    $mod_acc = $cs_access[$acc_dir];
    $data['access'][$run]['access'] =  $mod_acc . ' - ' . $cs_lang['lev_' . $mod_acc];
    $run++;
  }
}

echo cs_subtemplate(__FILE__,$data,'access','view');