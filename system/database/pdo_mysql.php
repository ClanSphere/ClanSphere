<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

require_once 'system/database/pdo.php';

function cs_sql_connect($cs_db, $test = 0) {

  $error = '';
  if(!extension_loaded('pdo') OR !extension_loaded('pdo_mysql')) {
    $error = 'PHP extensions pdo and pdo_mysql must be activated!';
  }
  else {
    $param = empty($cs_db['place']) ? '' : 'host=' . $cs_db['place'] . ';';
    $param .= 'dbname=' . $cs_db['name'];
    try {
      $connect = new PDO('mysql:' . $param, $cs_db['user'], $cs_db['pwd']);
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
  $sql_infos = array('data_size' => 0, 'index_size' => 0, 'tables' => 0, 'names' => array());
  $sql_query = 'SHOW TABLE STATUS WHERE NAME LIKE \'' . $cs_db['prefix'] . '\_%\'';
  if($sql_data = $cs_db['con']->query($sql_query)) {
    $new_result = $sql_data->fetchAll(PDO::FETCH_ASSOC);
    $sql_data = NULL;
    foreach($new_result AS $row) {
      $sql_infos['data_size'] = $sql_infos['data_size'] + $row['Data_length'];
      $sql_infos['index_size'] = $sql_infos['index_size'] + $row['Index_length'];
      $sql_infos['tables']++;
      $sql_infos['names'][] .= $row['Name'];
    }
  }
  else {
    $error = $cs_db['con']->errorInfo();
    cs_error_sql($cs_file, 'cs_sql_version', $error[2]);
  }
  cs_log_sql($cs_file, $sql_query);

  $sql_infos['type'] = 'MySQL (pdo_mysql)';
  $sql_infos['host'] = $cs_db['con']->getAttribute(PDO::ATTR_CONNECTION_STATUS);
  $sql_infos['encoding'] = 'PDO encoding';
  $sql_infos['client'] = $cs_db['con']->getAttribute(PDO::ATTR_CLIENT_VERSION);
  $sql_infos['server'] = $cs_db['con']->getAttribute(PDO::ATTR_SERVER_VERSION);
  return $sql_infos;
}