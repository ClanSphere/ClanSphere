<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clans');

$op_clans = cs_sql_option(__FILE__,'clans');

$mod_info['name']      = $cs_lang[$op_clans['label']];
$mod_info['version']    = $cs_main['version_name'];
$mod_info['released']   = $cs_main['version_date'];
$mod_info['creator'] = 'ClanSphere';
$mod_info['team']      = 'ClanSphere';
$mod_info['url']        = 'www.clansphere.net';
$mod_info['text']      = $cs_lang['modtext'];
$mod_info['icon']      = 'kdmconfig';
$mod_info['show']       = array('clansphere/admin' => 3,'users/settings' => 2,'users/view' => 1,'options/roots' => 5);
$mod_info['references'] = array('users' => 'members');
$mod_info['categories'] = FALSE;
$mod_info['comments']  = FALSE;
$mod_info['protected']  = FALSE;
$mod_info['tables']     = array('clans');