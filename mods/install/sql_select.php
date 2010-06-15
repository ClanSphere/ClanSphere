<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

$data = array();
$data['install']['ok'] = cs_html_img('symbols/' . $cs_main['img_path'] . '/16/submit.' . $cs_main['img_ext']);
$data['hidden']['lang'] = $account['users_lang'];
$data['form']['sql_select'] = cs_url('install','sql');

echo cs_subtemplate(__FILE__,$data,'install','sql_select');