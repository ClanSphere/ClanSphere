<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

require('system/database/pdo.php');

function cs_sql_connect($cs_db) {

    if(!extension_loaded('pdo') OR !extension_loaded('pdo_sqlite')) {
        cs_error_sql(__FILE__, 'cs_sql_connect', 'pdo and pdo_sqlite extension must be activated!',1);
    }

  try {
    $connect = new PDO('sqlite:' . $cs_db['name']);
    return $connect;
  }
  catch(PDOException $error) {
    cs_error_sql(__FILE__, 'cs_sql_connect', $error->getMessage(),1);
  }
}

function cs_sql_version($cs_file) {

  global $cs_db;
  $sql_infos = array('data_size' => 0, 'index_size' => 0, 'tables' => 0, 'names' => array());
  $sql_infos['type'] = 'SQLite 3 (pdo_sqlite)';
  $sql_infos['host'] = 'localhost';
  $sql_infos['encoding'] = 'PDO encoding';
  $sql_infos['client'] = $cs_db['con']->getAttribute(PDO::ATTR_CLIENT_VERSION);
  $sql_infos['client'] = str_replace('undefined', '', $sql_infos['client']);
  $sql_infos['server'] = $cs_db['con']->getAttribute(PDO::ATTR_SERVER_VERSION);
  $sql_infos['server'] = str_replace('undefined', '', $sql_infos['server']);

    $sql_query = "SELECT COUNT(*) FROM sqlite_master WHERE type = 'table'";
    if($sql_data = $cs_db['con']->query($sql_query, PDO::FETCH_NUM)) {
        $sql_result = $sql_data->fetch();
        $sql_data = NULL;
        $sql_infos['tables'] = $sql_result[0];
        $sql_infos['data_size'] = filesize($cs_db['name']);
    }
    else {
        $error = $cs_db['con']->errorInfo();
        cs_error_sql($cs_file, 'cs_sql_count', $error[2]);
        $sql_infos['tables'] = 0;
    }
    cs_log_sql($cs_file, $sql_query);
  return $sql_infos;
}

?>