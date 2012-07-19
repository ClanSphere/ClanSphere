<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$head = array('mod' => $cs_lang['mod_name'], 'action' => $cs_lang['settings'], 'topline' => $cs_lang['settings_info'], 'message' => cs_getmsg());

$opt_array = array(
  $cs_lang['profile'] => array(
    'file' => 'profile',
    'icon' => 'personal',
    'name' => $cs_lang['profile'],
    'show' => array('users/settings' => 1)
  ),
  $cs_lang['picture'] => array(
    'file' => 'picture',
    'icon' => 'camera_unmount',
    'name' => $cs_lang['picture'],
    'show' => array('users/settings' => 1)
  ),
  $cs_lang['password'] => array(
    'file' => 'password',
    'icon' => 'password',
    'name' => $cs_lang['password'],
    'show' => array('users/settings' => 1)
  ),
  $cs_lang['setup'] => array(
    'file' => 'setup',
    'icon' => 'looknfeel',
    'name' => $cs_lang['setup'],
    'show' => array('users/settings' => 1)
  ),
  $cs_lang['close'] => array(
    'file' => 'close',
    'icon' => 'gpg',
    'name' => $cs_lang['close'],
    'show' => array('users/settings' => 1)
  ),
  $cs_lang['avatar'] => array(
    'dir' => 'board',
    'file' => 'avatar',
    'icon' => 'babelfish',
    'name' => $cs_lang['avatar'],
    'show' => array('users/settings' => 1)
  ),
  $cs_lang['signature'] => array(
    'dir' => 'board',
    'file' => 'signature',
    'icon' => 'colors',
    'name' => $cs_lang['signature'],
    'show' => array('users/settings' => 1)
  ));

require_once('mods/clansphere/functions.php');
echo cs_manage('users', 'settings', 'users', 'center', $opt_array, $head);