<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

require_once 'system/database/pdo.php';

function cs_sql_connect($cs_db, $test = 0) {

  $error = '';
  if(!extension_loaded('pdo') OR !extension_loaded('pdo_sqlsrv')) {
    $error = 'PHP extensions pdo and pdo_sqlsrv must be activated!';
  }
  else {
    $param = empty($cs_db['place']) ? '' : 'server=' . $cs_db['place'] . ';';
    $param .= 'Database=' . $cs_db['name'];
    try {
      $connect = new PDO('sqlsrv:' . $param, $cs_db['user'], $cs_db['pwd']);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

function cs_sql_replace($replace) {

  $replace = preg_replace("={optimize}(.*?[;])=si",'',$replace);
  $replace = str_replace('{serial}','int IDENTITY(1,1)',$replace);
  $replace = str_replace('{engine}','',$replace);
  return preg_replace("=int\((.*?)\)=si",'int',$replace);
}

function cs_sql_version($cs_file) {

  global $cs_db;
  $sql_infos = array('data_free' => 0, 'data_size' => 0, 'index_size' => 0, 'tables' => 0, 'names' => array());
  $client = $cs_db['con']->getAttribute(PDO::ATTR_CLIENT_VERSION);

  $sql_infos['type'] = 'Microsoft SQL Server (pdo_sqlsrv)';
  $sql_infos['host'] = $cs_db['place'];
  $sql_infos['encoding'] = 'PDO encoding';
  $sql_infos['client'] = is_array($client) ? $client['DriverVer'] . ' - ODBC ' . $client['DriverODBCVer'] : $client;
  $sql_infos['server'] = $cs_db['con']->getAttribute(PDO::ATTR_SERVER_VERSION);
  return $sql_infos;
}