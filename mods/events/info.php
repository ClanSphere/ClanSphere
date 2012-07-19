<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$mod_info['name']    = $cs_lang['mod_name'];
$mod_info['version']  = $cs_main['version_name'];
$mod_info['released']  = $cs_main['version_date'];
$mod_info['creator'] = 'ClanSphere';
$mod_info['team']    = 'ClanSphere';
$mod_info['url']    = 'www.clansphere.net';
$mod_info['text']    = $cs_lang['mod_text'];
$mod_info['icon']    = 'cal';
$mod_info['show']    = array('users/settings' => 2, 'clansphere/admin' => 3, 'options/roots' => 5);
$mod_info['categories']  = TRUE;
$mod_info['comments']  = TRUE;
$mod_info['protected']  = FALSE;
$mod_info['tables']    = array('events', 'eventguests');
$mod_info['navlist']  = array('navbirthday' => 'max_navbirthday',
                'navnext' => 'max_navnext');