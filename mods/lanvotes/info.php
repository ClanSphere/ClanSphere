<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanvotes');

$mod_info['name']      = $cs_lang['mod'];
$mod_info['version']    = $cs_main['version_name'];
$mod_info['released']   = $cs_main['version_date'];
$mod_info['creator']  = 'Drag0n';
$mod_info['team']      = 'ClanSphere';
$mod_info['url']        = 'www.clansphere.net';
$mod_info['text']      = $cs_lang['mod_info'];
$mod_info['icon']       = 'package_games_arcade';
$mod_info['show']       = array('clansphere/admin' => 3,'users/settings' => 2,'lanpartys/view' => 1);
$mod_info['categories'] = FALSE;
$mod_info['comments']  = FALSE;
$mod_info['protected']  = FALSE;
$mod_info['tables']     = array('lanvoted','lanvotes');
?>
