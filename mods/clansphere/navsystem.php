<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$sys_array = array(
  $cs_lang['software'] => array(
    'file' => 'software',
    'icon' => 'kpackage',
    'name' => $cs_lang['software'],
    'show' => array('clansphere/system' => 5)
  ),$cs_lang['languages'] => array(
    'file' => 'lang_list',
    'icon' => 'locale',
    'name' => $cs_lang['languages'],
    'show' => array('clansphere/system' => 4)
  ),$cs_lang['cache'] => array(
    'file' => 'cache',
    'icon' => 'ark',
    'name' => $cs_lang['cache'],
    'show' => array('clansphere/system' => 4)
  ), $cs_lang['templates'] => array(
    'file' => 'temp_list',
    'icon' => 'style',
    'name' => $cs_lang['templates'],
    'show' => array('clansphere/system' => 4)
  ), $cs_lang['themes'] => array(
    'file' => 'themes_list',
    'icon' => 'kllckety',
    'name' => $cs_lang['themes'],
    'show' => array('clansphere/system' => 5)
  ), $cs_lang['storage'] => array(
    'file' => 'storage',
    'icon' => 'hdd_unmount',
    'name' => $cs_lang['storage'],
    'show' => array('clansphere/system' => 5)
  ), $cs_lang['variables'] => array(
    'file' => 'variables',
    'icon' => 'kdvi',
    'name' => $cs_lang['variables'],
    'show' => array('clansphere/system' => 5)
  ), $cs_lang['metatags'] => array(
    'file' => 'metatags',
    'icon' => 'knetconfig',
    'name' => $cs_lang['metatags'],
    'show' => array('clansphere/system' => 5)
  ), $cs_lang['support'] => array(
    'file' => 'support',
    'icon' => 'krdc',
    'name' => $cs_lang['support'],
    'show' => array('clansphere/system' => 4)
  )
);

$mod_array = cs_checkdirs('mods','clansphere/system');
$system = array_merge($sys_array,$mod_array);
ksort($system);

foreach($system as $mod) {
  array_key_exists('file',$mod) ? $mod['dir'] = 'clansphere' : $mod['file'] = 'roots';
  $acc_dir = 'access_' . $mod['dir'];
  
  if(array_key_exists($acc_dir,$account) AND $account[$acc_dir] >= $mod['show']['clansphere/system']) {
    echo cs_icon($mod['icon']);
    echo cs_link($mod['name'],$mod['dir'],$mod['file']);
    echo cs_html_br(1);
  }
}