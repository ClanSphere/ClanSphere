<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('buddys');

$mod_info['name']		= $cs_lang['mod_name'];
$mod_info['version']	= $cs_main['version_name'];
$mod_info['released']	= $cs_main['version_date'];
$mod_info['creator']	= 'Denni';
$mod_info['team']		= 'ClanSphere';
$mod_info['url']		= 'www.clansphere.net';
$mod_info['text']		= $cs_lang['mod_text'];
$mod_info['icon'] 		= 'xchat';
$mod_info['show'] 		= array('users/view' => 1, 'users/settings' => 2);
$mod_info['categories']	= FALSE;
$mod_info['comments']	= FALSE;
$mod_info['protected']	= FALSE;
$mod_info['tables']		= array('buddys');


?>