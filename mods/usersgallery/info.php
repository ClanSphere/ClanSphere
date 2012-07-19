<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery', 1);

$mod_info['name']    = $cs_lang['usergallery'];
$mod_info['version']  = $cs_main['version_name'];
$mod_info['released']  = $cs_main['version_date'];
$mod_info['creator'] = 'ClanSphere';
$mod_info['team']    = 'ClanSphere';
$mod_info['url']    = 'www.clansphere.net';
$mod_info['text']    = $cs_lang['info_text_users_gallery'];
$mod_info['icon']     = 'usergallery';
$mod_info['show']     = array('users/view' => 1, 'users/settings' => 2);
$mod_info['references'] = array('users' => 'usersgallery');
$mod_info['categories'] = FALSE;
$mod_info['comments']  = TRUE;
$mod_info['protected']  = FALSE;
$mod_info['tables']    = array('usersgallery');