<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

require_once 'system/database/pdo.php';

function cs_sql_connect($cs_db, $test = 0) {

  $error = '';
  if(!extension_loaded('pdo') OR !extension_loaded('pdo_pgsql')) {
    $error = 'PHP extensions pdo and pdo_pgsql must be activated!';
  }
  else {
    $param = empty($cs_db['place']) ? '' : 'host=' . $cs_db['place'] . ';';
    $param .= 'dbname=' . $cs_db['name'];
    try {
      $connect = new PDO('pgsql:' . $param, $cs_db['user'], $cs_db['pwd']);
    }
    catch(PDOException $err) {
      $error = $err->getMessage();
    }
  }

  if(empty($test) AND empty($error)) {
    return $connect;
  }
  elseif(empty($test)) {
    cs_error_sql(__FILE__, 'cs_sql_connect', $error, 1);
  }
  else {
    return $error;
  }
}

function cs_sql_version($cs_file) {

  global $cs_db;
  $sql_infos = array('data_free' => 0, 'data_size' => 0, 'index_size' => 0, 'tables' => 0, 'names' => array());
  $sql_infos['type'] = 'PostgreSQL (pdo_pgsql)';
  $sql_infos['host'] = $cs_db['place'];
  $sql_infos['encoding'] = 'PDO encoding';
  $sql_infos['client'] = $cs_db['con']->getAttribute(PDO::ATTR_CLIENT_VERSION);
  $sql_infos['server'] = $cs_db['con']->getAttribute(PDO::ATTR_SERVER_VERSION);
  return $sql_infos;
}