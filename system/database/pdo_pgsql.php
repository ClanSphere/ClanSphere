<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

require('system/database/pdo.php');

function cs_sql_connect($cs_db) {

    if(!extension_loaded('pdo') OR !extension_loaded('pdo_pgsql')) {
        cs_error_sql(__FILE__, 'cs_sql_connect', 'pdo and pdo_pgsql extension must be activated!',1);
    }

  $param = empty($cs_db['place']) ? '' : 'host=' . $cs_db['place'] . ';';
  $param .= 'dbname=' . $cs_db['name'];
  try {
    $connect = new PDO('pgsql:' . $param, $cs_db['user'], $cs_db['pwd']);
    return $connect;
  }
  catch(PDOException $error) {
    cs_error_sql(__FILE__, 'cs_sql_connect', $error->getMessage(),1);
  }
}

function cs_sql_version($cs_file) {

  global $cs_db;
  $sql_infos = array('data_size' => 0, 'index_size' => 0, 'tables' => 0, 'names' => array());
  $sql_infos['type'] = 'PostgreSQL (pdo_pgsql)';
  $sql_infos['host'] = $cs_db['place'];
  $sql_infos['encoding'] = 'PDO encoding';
  $sql_infos['client'] = $cs_db['con']->getAttribute(PDO::ATTR_CLIENT_VERSION);
  $sql_infos['server'] = $cs_db['con']->getAttribute(PDO::ATTR_SERVER_VERSION);
  return $sql_infos;
}

?>