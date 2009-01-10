<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

$data = array();
$data['install']['ok'] = cs_html_img('symbols/crystal_project/16/submit.png');
$data['hidden']['lang'] = $account['users_lang'];
$data['form']['sql_select'] = cs_url('install','sql');

echo cs_subtemplate(__FILE__,$data,'install','sql_select');

?>