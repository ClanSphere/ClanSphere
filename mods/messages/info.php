<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');

$mod_info['name']    = $cs_lang['mod_name'];
$mod_info['version']  = $cs_main['version_name'];
$mod_info['released']  = $cs_main['version_date'];
$mod_info['creator'] = 'ClanSphere';
$mod_info['team']    = 'ClanSphere';
$mod_info['url']    = 'www.clansphere.net';
$mod_info['text']    = $cs_lang['info_text'];
$mod_info['icon']    = 'email';
$mod_info['show']     = array('options/roots' => 5, 'users/settings' => 2);
$mod_info['categories'] = FALSE;
$mod_info['comments']  = FALSE;
$mod_info['protected']   = FALSE;
$mod_info['tables']   = array('autoresponder','messages'); 