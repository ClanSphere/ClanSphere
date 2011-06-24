<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('database');

global $cs_db;

$sql_infos = cs_sql_version(__FILE__);

$data['sqlinfo']['type'] = $sql_infos['type'];
$data['sqlinfo']['subtype'] = empty($sql_infos['subtype']) ? '' : $sql_infos['subtype'];
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
else
  $data['sqlinfo']['usage'] = '-';

$data['roots']['optimize_tables_url'] = cs_url('database','optimize');
$data['roots']['import_url'] = cs_url('database','import');
$data['roots']['export_url'] = cs_url('database','export');
$data['roots']['statistic_url'] = cs_url('database','statistic');

// integrity checks
$errors = '';
$static = array();
$modules = cs_checkdirs('mods');
$names = array_flip($sql_infos['names']);
$count = count($names);

foreach($modules as $mod) {

  if($mod['dir'] != 'install' AND file_exists('mods/' . $mod['dir'] . '/access.php') AND !isset($account['access_' . $mod['dir'] . '']))
    $errors .= sprintf($cs_lang['access_not_found'], $mod['dir']) . cs_html_br(1);

  if(!empty($mod['tables'][0])) {

    asort($mod['tables']);

    foreach($mod['tables'] AS $mod_table) {

      $found = empty($static[$mod_table]) ? '' : $static[$mod_table];

      if(empty($found)) {
        $static[$mod_table] = $mod['dir'];

        if(isset($names['' . $cs_db['prefix'] . '_' . $mod_table]))
          unset($names['' . $cs_db['prefix'] . '_' . $mod_table]);
        elseif(!empty($count))
          $errors .= sprintf($cs_lang['table_not_found'], $mod_table, $mod['dir']) . cs_html_br(1);
      }
      else
        $errors .= sprintf($cs_lang['table_double_owned'], $mod_table, $found, $mod['dir']) . cs_html_br(1);
    }
  }
}

$names = array_flip($names);
$lnpre = strlen($cs_db['prefix']) + 1;

foreach($names AS $missing)
  $errors .= sprintf($cs_lang['table_not_owned'], substr($missing, $lnpre)) . cs_html_br(1);

$data['integrity']['errors'] = empty($errors) ? $cs_lang['db_check_passed'] : $errors;

echo cs_subtemplate(__FILE__,$data,'database','roots');