<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$head = array('mod' => 'ClanSphere', 'action' => $cs_lang['head_system'], 'topline' => $cs_lang['body_system']);

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
  ), $cs_lang['cache'] => array(
    'file' => 'cache',
    'icon' => 'ark',
    'name' => $cs_lang['cache'],
    'show' => array('clansphere/system' => 4)
  ), $cs_lang['version'] => array(
    'file' => 'version',
    'icon' => 'agt_update-product',
    'name' => $cs_lang['version'],
    'show' => array('clansphere/system' => 5)
  ), $cs_lang['support'] => array(
    'file' => 'support',
    'icon' => 'krdc',
    'name' => $cs_lang['support'],
    'show' => array('clansphere/system' => 4)
  ), $cs_lang['charset'] => array(
    'file' => 'charset',
    'icon' => 'txt',
    'name' => $cs_lang['charset'],
    'show' => array('clansphere/system' => 5)
  )
);

require_once('mods/clansphere/functions.php');

echo cs_manage('clansphere', 'system', 'clansphere', 'roots', $sys_array, $head);