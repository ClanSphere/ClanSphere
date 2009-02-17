<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

$mod_info['name']    = $cs_lang['mod'];
$mod_info['version']  = $cs_main['version_name'];
$mod_info['released']  = $cs_main['version_date'];
$mod_info['creator']  = 'Fr33z3m4n';
$mod_info['team']    = 'ClanSphere';
$mod_info['url']    = 'www.clansphere.net';
$mod_info['text']    = $cs_lang['mod_text'];
$mod_info['icon']     = 'download';
$mod_info['show']     = array('clansphere/admin' => 3);
$mod_info['categories']  = TRUE;
$mod_info['comments']  = TRUE;
$mod_info['protected']  = FALSE;
$mod_info['tables']    = array('files');

?>
