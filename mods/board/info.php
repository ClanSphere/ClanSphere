<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$mod_info['name']    = $cs_lang['mod_name'];
$mod_info['version']  = $cs_main['version_name'];
$mod_info['released']  = $cs_main['version_date'];
$mod_info['creator']  = 'Fr33z3m4n';
$mod_info['team']    = 'ClanSphere';
$mod_info['url']    = 'www.clansphere.net';
$mod_info['text']    = $cs_lang['modtext'];
$mod_info['icon']     = 'tutorials';
$mod_info['show']     = array('clansphere/admin' => 3, 'options/roots' => 5, 'users/settings' => 2, 'users/view' => 1, 'users/home' => 1);
$mod_info['references'] = array('users' => 'comments', 'users_where' => "comments_mod = 'board'");
$mod_info['categories'] = TRUE;
$mod_info['comments']  = FALSE;
$mod_info['protected']  = FALSE;
$mod_info['tables']    = array('abonements','board','boardpws','boardreport','read','threads','boardfiles','boardvotes');