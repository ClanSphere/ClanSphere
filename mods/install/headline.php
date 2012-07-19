<?php

$cs_lang = cs_translate('install');

$step = array();

$step['500'] = 'error';
$step['list'] = 'language_choose';
$step['compatible'] = 'install_check';
$step['license'] = 'license';
$step['settings'] = 'configuration';
$step['sql'] = 'database';
$step['sql_select'] = 'database_modselect';
$step['admin'] = 'create_admin_head';
$step['complete'] = 'last_check';
$step['convert'] = 'convert_head';

$current = $step[$cs_main['action']];

echo $cs_lang[$current];