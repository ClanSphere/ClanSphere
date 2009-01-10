<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

$mod_info['name']		= $cs_lang['mod'];
$mod_info['version']	= $cs_main['version_name'];
$mod_info['released']	= $cs_main['version_date'];
$mod_info['creator']	= 'NosNos';
$mod_info['team']		= 'ClanSphere';
$mod_info['url']		= 'www.clansphere.net';
$mod_info['text']		= $cs_lang['info_text'];
$mod_info['icon'] 		= 'image';
$mod_info['show'] 		= array('clansphere/admin' => 3, 'options/roots' => 5);
$mod_info['categories'] = FALSE;
$mod_info['comments']	= TRUE;
$mod_info['protected']	= FALSE;
$mod_info['tables']		= array('gallery');

?>