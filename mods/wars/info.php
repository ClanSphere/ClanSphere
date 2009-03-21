<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');

$mod_info['name']    = $cs_lang['mod'];
$mod_info['version']  = $cs_main['version_name'];
$mod_info['released']  = $cs_main['version_date'];
$mod_info['creator']  = 'Drag0n';
$mod_info['team']    = 'ClanSphere';
$mod_info['url']    = 'www.clansphere.net';
$mod_info['text']    = $cs_lang['modtext'];
$mod_info['icon']    = 'wifi';
$mod_info['show']    = array('clansphere/admin' => 3,'options/roots' => 5,'users/view' => 1);
$mod_info['references'] = array('users' => 'players', 'users_where' => "players_played = 1");
$mod_info['categories'] = TRUE;
$mod_info['comments']  = TRUE;
$mod_info['protected']  = FALSE;
$mod_info['tables']    = array('wars','rounds','players'); 

?>