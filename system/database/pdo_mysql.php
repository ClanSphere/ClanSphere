<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

require('system/database/pdo.php');

function cs_sql_connect($cs_db) {

    if(!extension_loaded('pdo') OR !extension_loaded('pdo_mysql')) {
        cs_error_sql(__FILE__, 'cs_sql_connect', 'pdo and pdo_mysql extension must be activated!',1);
    }

	$param = empty($cs_db['place']) ? '' : 'host=' . $cs_db['place'] . ';';
	$param .= 'dbname=' . $cs_db['name'];
	try {
		$connect = new PDO('mysql:' . $param, $cs_db['user'], $cs_db['pwd']);
		return $connect;
	}
	catch(PDOException $error) {
		cs_error_sql(__FILE__, 'cs_sql_connect', $error->getMessage(),1);
	}
}

function cs_sql_version($cs_file) {

	global $cs_db;
  $sql_infos = array('data_size' => 0, 'index_size' => 0, 'tables' => 0);
  $sql_query = 'SHOW TABLE STATUS';
	if($sql_data = $cs_db['con']->query($sql_query)) {
		$new_result = $sql_data->fetchAll(PDO::FETCH_ASSOC);
		$sql_data = NULL;
    foreach($new_result AS $row) {
      $sql_infos['data_size'] = $sql_infos['data_size'] + $row['Data_length'];
      $sql_infos['index_size'] = $sql_infos['index_size'] + $row['Index_length'];
      $sql_infos['tables']++;
    }
	}
	else {
		$error = $cs_db['con']->errorInfo();
		cs_error_sql($cs_file, 'cs_sql_version', $error[2]);
	}
  cs_log_sql($sql_query);

	$sql_infos['type'] = 'MySQL (pdo_mysql)';
	$sql_infos['host'] = $cs_db['con']->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	$sql_infos['client'] = $cs_db['con']->getAttribute(PDO::ATTR_CLIENT_VERSION);
	$sql_infos['server'] = $cs_db['con']->getAttribute(PDO::ATTR_SERVER_VERSION);
	return $sql_infos;
}

?>