<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gbook');

$mod_info['name']    = $cs_lang['mod_name'];
$mod_info['version']  = $cs_main['version_name'];
$mod_info['released']  = $cs_main['version_date'];
$mod_info['creator'] = 'ClanSphere';
$mod_info['team']    = 'ClanSphere';
$mod_info['url']    = 'www.clansphere.net';
$mod_info['text']    = $cs_lang['mod_text'];
$mod_info['icon']    = 'easymoblog';
$mod_info['show']    = array('clansphere/admin' => 3,'users/view' => 1,'users/settings' => 2, 'options/roots' => 5);
$mod_info['references'] = array('users' => 'gbook', 'users_where' => 'gbook_lock = 1', 'users_column' => 'gbook_users_id');
$mod_info['categories'] = FALSE;
$mod_info['comments']  = FALSE;
$mod_info['protected']   = FALSE;
$mod_info['tables']   = array('gbook');