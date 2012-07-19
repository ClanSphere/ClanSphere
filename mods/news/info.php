<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('news');

$mod_info['name']    = $cs_lang['mod_name'];
$mod_info['version']  = $cs_main['version_name'];
$mod_info['released']  = $cs_main['version_date'];
$mod_info['creator'] = 'ClanSphere';
$mod_info['team']    = 'ClanSphere';
$mod_info['url']    = 'www.clansphere.net';
$mod_info['text']    = $cs_lang['modtext'];
$mod_info['icon']    = 'knode';
$mod_info['show']    = array('clansphere/admin' => 3, 'options/roots' => 5);
$mod_info['categories']  = TRUE;
$mod_info['comments']  = TRUE;
$mod_info['protected']  = FALSE;
$mod_info['tables']    = array('news');
$mod_info['startup'] = TRUE;
$mod_info['navlist'] = array('navlist' => 'max_navlist',
                             'navlist_headline' => 'max_headline', 
               'recent' => 'max_recent',);