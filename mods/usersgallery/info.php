<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gallery');

$mod_info['name']		= $cs_lang['usergallery'];
$mod_info['version']	= $cs_main['version_name'];
$mod_info['released']	= $cs_main['version_date'];
$mod_info['creator']	= 'NosNos';
$mod_info['team']		= 'Clansphere';
$mod_info['url']		= 'www.clansphere.net';
$mod_info['text']		= $cs_lang['info_text_users_gallery'];
$mod_info['icon'] 		= 'image';
$mod_info['show'] 		= array('users/view' => 1, 'users/settings' => 2);
$mod_info['categories'] = FALSE;
$mod_info['comments']	= TRUE;
$mod_info['protected']	= FALSE;
$mod_info['tables']		= array('usersgallery');

?>