<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('abcode');

$mod_info['name']      = $cs_lang['mod_name'];
$mod_info['version']    = $cs_main['version_name'];
$mod_info['released']   = $cs_main['version_date'];
$mod_info['creator']  = 'Fr33z3m4n';
$mod_info['team']      = 'ClanSphere';
$mod_info['url']        = 'www.clansphere.net';
$mod_info['text']      = $cs_lang['mod_text'];
$mod_info['icon']      = 'kword';
$mod_info['show']       = array('clansphere/admin' => 3,'options/roots' => 5);
$mod_info['categories'] = FALSE;
$mod_info['comments']  = FALSE;
$mod_info['protected']  = TRUE;
$mod_info['tables']     = array('abcode');
