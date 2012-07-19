<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('errors');

$data = array();
$data['head']['mod'] = $cs_lang['mod_name'];
$data['head']['action'] = $cs_lang['403_action'];
$data['head']['icon'] = cs_icon('error',64);
$data['head']['topline'] = $cs_lang['403_body'];

echo cs_subtemplate(__FILE__,$data,'errors','403');