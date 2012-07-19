<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('static');

$mod_info['name']    = $cs_lang['mod_name'];
$mod_info['version']  = $cs_main['version_name'];
$mod_info['released']  = $cs_main['version_date'];
$mod_info['creator'] = 'ClanSphere';
$mod_info['team']    = 'clansphere Team';
$mod_info['url']    = 'www.clansphere.net';
$mod_info['text']    = $cs_lang['mod_text'];
$mod_info['icon']    = 'misc';
$mod_info['show']    = array('clansphere/admin' => 3, 'options/roots' => 5);
$mod_info['categories']  = FALSE;
$mod_info['comments']  = TRUE;
$mod_info['protected']  = FALSE;
$mod_info['tables']    = array('static');