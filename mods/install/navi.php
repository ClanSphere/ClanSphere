<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('install');

$data = array();

$data['if']['sql_select'] = $cs_main['action'] == 'sql_select' ? 1 : 0;

$active = ' id="nav_active"';

$data['active']['lang'] = $cs_main['action'] == 'list' ? $active : '';
$data['active']['compatible'] = $cs_main['action'] == 'compatible' ? $active : '';
$data['active']['license'] = $cs_main['action'] == 'license' ? $active : '';
$data['active']['settings'] = $cs_main['action'] == 'settings' ? $active : '';
$data['active']['sql_select'] = $cs_main['action'] == 'sql_select' ? $active : '';
$data['active']['sql'] = $cs_main['action'] == 'sql' ? $active : '';
$data['active']['admin'] = $cs_main['action'] == 'admin' ? $active : '';
$data['active']['check'] = $cs_main['action'] == 'complete' ? $active : '';

$arrow = '&raquo; ';

$data['arr']['lang'] = $cs_main['action'] == 'list' ? $arrow : '';
$data['arr']['compatible'] = $cs_main['action'] == 'compatible' ? $arrow : '';
$data['arr']['license'] = $cs_main['action'] == 'license' ? $arrow : '';
$data['arr']['settings'] = $cs_main['action'] == 'settings' ? $arrow : '';
$data['arr']['sql_select'] = $cs_main['action'] == 'sql_select' ? $arrow : '';
$data['arr']['sql'] = $cs_main['action'] == 'sql' ? $arrow : '';
$data['arr']['admin'] = $cs_main['action'] == 'admin' ? $arrow : '';
$data['arr']['check'] = $cs_main['action'] == 'complete' ? $arrow : '';

echo cs_subtemplate(__FILE__,$data,'install','navi');