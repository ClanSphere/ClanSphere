
<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('database');

$modules = cs_checkdirs('mods');

$static = array();
$total_tables = 0;
$total_datasets = 0;
$run = 0;

global $cs_db;

$sql_infos = cs_sql_version(__FILE__);

$names = array_flip($sql_infos['names']);

foreach($modules as $mod) {

  if((isset($account['access_' . $mod['dir'] . '']) OR $mod['dir'] == 'captcha' OR $mod['dir'] == 'pictures') AND !empty($mod['tables'][0])) {

  $tables = '';
  $counts = '';

  if(!empty($mod['icon'])) {
    $data['statistic'][$run]['icon'] = cs_icon($mod['icon']);
  }
  else {
    $data['statistic'][$run]['icon'] = ''; 
  }

  $data['statistic'][$run]['url'] = cs_url('modules','view','dir=' . $mod['dir']);
  $data['statistic'][$run]['name'] = $mod['name'];

    asort($mod['tables']);
    foreach($mod['tables'] AS $mod_table) {

      unset($names['' . $cs_db['prefix'] . '_' . $mod_table]);

      if(isset($static[$mod_table])) {
        cs_error(__FILE__, 'SQL-Table "' . $mod_table . '" is owned by two modules: "' . $static[$mod_table] . '" and "' . $mod['dir'] . '"');
      }
      else {
        $static[$mod_table] = $mod['dir'];
        $tables .= $mod_table . cs_html_br(1);
        $datasets = cs_sql_count(__FILE__, $mod_table);
        $counts .= $datasets . cs_html_br(1);
        $total_tables++;
        $total_datasets = $total_datasets + $datasets;
      }
    }
    $data['statistic'][$run]['tables'] = $tables;
    $data['statistic'][$run]['counts'] = $counts;
  $run++;
  }
}

$data['data']['tables'] = $total_tables;
$data['data']['dataset'] = $total_datasets;

$names = array_flip($names);

foreach($names AS $missing) {
 cs_error(__FILE__, 'SQL-Table "' . $missing . '" exists without an ownership');
}

echo cs_subtemplate(__FILE__,$data,'database','statistic');