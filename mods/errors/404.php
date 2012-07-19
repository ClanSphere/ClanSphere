<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('errors');

$data = array();
$data['head']['mod'] = $cs_lang['mod_name'];
$data['head']['action'] = $cs_lang['404_action'];
$data['head']['icon'] = cs_icon('error',64);
$link = cs_link($cs_lang['webmaster'],'contact','mail');
$data['head']['topline'] = sprintf($cs_lang['404_body'],$link);

echo cs_subtemplate(__FILE__,$data,'errors','404');