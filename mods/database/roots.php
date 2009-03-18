<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('database');

global $cs_db;
$data['if']['cs_db'] = false;

$data['roots']['import_url'] = cs_url('database','import');
$data['roots']['export_url'] = cs_url('database','export');
$data['roots']['statistic_url'] = cs_url('database','statistic');

echo cs_subtemplate(__FILE__,$data,'database','roots');

?>