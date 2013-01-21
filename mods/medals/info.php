<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('medals');

$mod_info['name']  = $cs_lang['mod_name'];
$mod_info['version'] = $cs_main['version_name'];
$mod_info['released'] = $cs_main['version_date'];
$mod_info['creator'] = 'ClanSphere';
$mod_info['team']  = 'ClanSphere';
$mod_info['url'] = 'www.clansphere.net';
$mod_info['text']  = $cs_lang['modtext'];
$mod_info['icon']  = 'medals';
$mod_info['show'] = array('clansphere/admin' => 3,'users/view' => 1);
$mod_info['references'] = array('users' => 'medalsuser');
$mod_info['categories']  = FALSE;
$mod_info['protected'] = FALSE;
$mod_info['tables'] = array('medals','medalsuser');
