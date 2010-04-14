<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$data = array();

$data['if']['old_php'] = version_compare(phpversion(), 5, '<');

$data['charset']['result_setup_file']  = '';
$data['charset']['result_tpl_setting'] = '';
$data['charset']['result_web_setting'] = '';
$data['charset']['result_php_setting'] = '';
$data['charset']['result_sql_setting'] = '';

$data['charset']['check_setup_file']  = empty(0) ? cs_icon('submit') : cs_icon('stop');
$data['charset']['check_tpl_setting'] = empty(0) ? cs_icon('submit') : cs_icon('stop');
$data['charset']['check_web_setting'] = empty(0) ? cs_icon('submit') : cs_icon('stop');
$data['charset']['check_php_setting'] = empty(0) ? cs_icon('submit') : cs_icon('stop');
$data['charset']['check_sql_setting'] = empty(0) ? cs_icon('submit') : cs_icon('stop');

echo cs_subtemplate(__FILE__, $data, 'clansphere', 'charset');