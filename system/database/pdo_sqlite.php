<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

require_once 'system/database/pdo.php';

function cs_sql_connect($cs_db, $test = 0) {

  $error = '';
  if(!extension_loaded('pdo') OR !extension_loaded('pdo_sqlite')) {
    $error = 'PHP extensions pdo and pdo_sqlite must be activated!';
  }
  else {
    try {
      $connect = new PDO('sqlite:' . $cs_db['name']);
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

  $replace = str_replace('{optimize}','VACUUM',$replace);
  $replace = str_replace('{serial}','integer',$replace);
  $replace = str_replace('{engine}','',$replace);
  return preg_replace("=int\((.*?)\)=si",'integer',$replace);
}

function cs_sql_version($cs_file) {

  global $cs_db;
  $sql_infos = array('data_free' => 0, 'data_size' => 0, 'index_size' => 0, 'tables' => 0, 'names' => array());
  $sql_infos['type'] = 'SQLite 3 (pdo_sqlite)';
  $sql_infos['host'] = 'localhost';
  $sql_infos['encoding'] = 'PDO encoding';
  $sql_infos['client'] = $cs_db['con']->getAttribute(PDO::ATTR_CLIENT_VERSION);
  $sql_infos['client'] = str_replace('undefined', '', $sql_infos['client']);
  $sql_infos['server'] = $cs_db['con']->getAttribute(PDO::ATTR_SERVER_VERSION);
  $sql_infos['server'] = str_replace('undefined', '', $sql_infos['server']);

  $sql_query = 'SELECT COUNT(*) FROM sqlite_master WHERE type = \'table\' AND name LIKE \'' . $cs_db['prefix'] . '_%\'';
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