<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanshop');

$mod_info['name']		= $cs_lang['mod'];
$mod_info['version']	= $cs_main['version_name'];
$mod_info['released']	= $cs_main['version_date'];
$mod_info['creator']	= 'Drag0n';
$mod_info['team']		= 'ClanSphere';
$mod_info['url']		= 'www.clansphere.net';
$mod_info['text']		= $cs_lang['mod_info'];
$mod_info['icon']		= 'warehause';
$mod_info['show']		= array('clansphere/admin' => 3,'users/settings' => 2);
$mod_info['categories']	= TRUE;
$mod_info['comments']	= FALSE;
$mod_info['protected']	= FALSE;
$mod_info['tables']		= array('lanshop_articles','lanshop_orders'); 

?>