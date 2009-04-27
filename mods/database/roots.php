<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('database');

global $cs_db;

$sql_infos = cs_sql_version(__FILE__);

$data['sqlinfo']['type'] = $sql_infos['type'];
$data['sqlinfo']['host'] = $sql_infos['host'];
$data['sqlinfo']['encoding'] = $sql_infos['encoding'];
$data['sqlinfo']['server'] = $sql_infos['server'];
$data['sqlinfo']['client'] = $sql_infos['client'];
$data['sqlinfo']['schema'] = $cs_db['name'];

if(!empty($sql_infos['tables'])) {
  $data['sqlinfo']['usage'] = $sql_infos['tables'] . ' ' . $cs_lang['tables'];
  $data['sqlinfo']['usage'] .= cs_html_br(1) . '--------------------------' . cs_html_br(1);
  $data['sqlinfo']['usage'] .= cs_filesize($sql_infos['data_size']) . ' ' . $cs_lang['data'];
  $data['sqlinfo']['usage'] .= cs_html_br(1);
  $data['sqlinfo']['usage'] .= cs_filesize($sql_infos['index_size']) . ' ' . $cs_lang['indexe'];
  $data['sqlinfo']['usage'] .= cs_html_br(1) . '--------------------------' . cs_html_br(1);
  $data['sqlinfo']['usage'] .= cs_filesize($sql_infos['data_size'] + $sql_infos['index_size']) . ' ' . $cs_lang['total'];
  $data['sqlinfo']['usage'] .= cs_html_br(2);
  $data['sqlinfo']['usage'] .= cs_filesize($sql_infos['data_free']) . ' ' . $cs_lang['overhead'];
}
else {
  $data['sqlinfo']['usage'] = '-';
}

$data['roots']['optimize_tables_url'] = cs_url('database','optimize');
$data['roots']['import_url'] = cs_url('database','import');
$data['roots']['export_url'] = cs_url('database','export');
$data['roots']['statistic_url'] = cs_url('database','statistic');

echo cs_subtemplate(__FILE__,$data,'database','roots');