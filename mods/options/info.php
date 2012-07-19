<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('options');

$mod_info['name']    = $cs_lang['options'];
$mod_info['version']  = $cs_main['version_name'];
$mod_info['released']  = $cs_main['version_date'];
$mod_info['creator'] = 'ClanSphere';
$mod_info['team']    = 'ClanSphere';
$mod_info['url']    = 'www.clansphere.net';
$mod_info['text']    = $cs_lang['text'];
$mod_info['icon']    = 'package_settings';
$mod_info['show']    = array('clansphere/system' => 4);
$mod_info['categories']  = FALSE;
$mod_info['comments']  = FALSE;
$mod_info['protected']  = TRUE;
$mod_info['tables']    = array('options');