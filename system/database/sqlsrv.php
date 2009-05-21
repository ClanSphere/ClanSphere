<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

function cs_sql_connect($cs_db, $test = 0)
{
  $error = '';
  if(!extension_loaded('sqlsrv')) {
    $error = 'PHP extension sqlsrv must be activated!';
  }
  else {
    $cn_info = array('UID' => $cs_db['user'], 'PWD' => $cs_db['pwd'], 'Database' => $cs_db['name']);
    $connect = @sqlsrv_connect($cs_db['place'], $cn_info) OR $error = cs_sql_error();
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

function cs_sql_count($cs_file,$sql_table,$sql_where = 0, $distinct = 0) {

  global $cs_db;
  $row = empty($distinct) ? '*' : 'DISTINCT ' . $distinct;
  $sql_where = str_replace('"', '\'', $sql_where);
  
  $sql_query = 'SELECT COUNT(' . $row . ') FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  $sql_query .= empty($sql_where) ? '' : ' WHERE ' . $sql_where;
  
  $sql_query = str_replace('{pre}',$cs_db['prefix'],$sql_query);
  if (!$sql_data = sqlsrv_query($cs_db['con'], $sql_query)) {
    cs_error_sql($cs_file, 'cs_sql_count', cs_sql_error());
    return false;
  }
  sqlsrv_fetch($sql_data);
  $sql_result = sqlsrv_get_field($sql_data, 0);
  sqlsrv_free_stmt($sql_data);
  cs_log_sql($cs_file, $sql_query);
  return $sql_result;
}

function cs_sql_delete($cs_file,$sql_table,$sql_id,$sql_field = 0) {

  global $cs_db;
  settype($sql_id,'integer');
  if (empty($sql_field)) {
    $sql_field = $sql_table . '_id';
  }
  $sql_delete = 'DELETE FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  $sql_delete .= ' WHERE ' . $sql_field . ' = ' . $sql_id;
  sqlsrv_query($cs_db['con'], $sql_delete) or cs_error_sql($cs_file, 'cs_sql_delete', cs_sql_error());
  cs_log_sql($cs_file, $sql_delete,1);
}

function cs_sql_escape($string) {

  return str_replace("'","''",$string);
}

function cs_sql_insert($cs_file, $sql_table, $sql_cells, $sql_content)
{
  global $cs_db;
  $max = count($sql_cells);
  $set = " (";
  for ($run = 0; $run < $max; $run++) {
    $set .= $sql_cells[$run];
    if ($run != $max - 1) {
      $set .= ",";
    }
  }
  $set .= ") VALUES ('";
  for ($run = 0; $run < $max; $run++) {
    $set .= str_replace("'","''",$sql_content[$run]);
    if ($run != $max - 1) {
      $set .= "','";
    }
  }
  $set .= "')";
  
  $sql_insert = 'INSERT INTO ' . $cs_db['prefix'] . '_' . $sql_table . $set;
  sqlsrv_query($cs_db['con'], $sql_insert) or cs_error_sql($cs_file, 'cs_sql_insert', cs_sql_error());
  cs_log_sql($cs_file, $sql_insert);
}

function cs_sql_insertid($cs_file) {

  return cs_sql_query($cs_file, 'SELECT @@IDENTITY', 1);
}

function cs_sql_option($cs_file, $mod)
{
  global $cs_db;
  static $options = array();

  if (empty($options[$mod])) {

    if (!$options[$mod] = cs_cache_load('op_' . $mod)) {

      $sql_query = 'SELECT options_name, options_value FROM  ' . $cs_db['prefix'] . '_' . 'options';
      $sql_query .= " WHERE options_mod = '" . $mod . "'";
      $sql_data = sqlsrv_query($cs_db['con'], $sql_query) or cs_error_sql($cs_file, 'cs_sql_option', cs_sql_error, 1);

      while ($sql_result = sqlsrv_fetch_array($sql_data, SQLSRV_FETCH_ASSOC)) {
        $name = $sql_result['options_name'];
        $new_result[$name] = $sql_result['options_value'];
      }
      sqlsrv_free_stmt($sql_data);
      cs_log_sql($cs_file, $sql_query);
      $options[$mod] = isset($new_result) ? $new_result : 0;

      cs_cache_save('op_' . $mod, $options[$mod]);
    }
  }
  
  return $options[$mod];
}

function cs_sql_query($cs_file, $sql_query, $more = 0)
{
  global $cs_db;
  $sql_query = str_replace('{pre}', $cs_db['prefix'], $sql_query);
  if ($sql_data = sqlsrv_query($cs_db['con'], $sql_query)) {
    $result = array('affected_rows' => sqlsrv_rows_affected($sql_data));
    if(!empty($more)) {
      while ($sql_result = sqlsrv_fetch_array($sql_data, SQLSRV_FETCH_ASSOC)) {
        $result['more'][] = $sql_result;
      }
      sqlsrv_free_stmt($sql_data);
    }
  } else { 
    cs_error_sql($cs_file, 'cs_sql_query', cs_sql_error());
    $result = 0;
  }
  cs_log_sql($cs_file, $sql_query);
  return $result;
}

function cs_sql_select($cs_file, $sql_table, $sql_select, $sql_where = 0, $sql_order = 0, $first = 0, $max = 1, $cache = 0)
{
  if (!empty($cache) && $return = cs_cache_load($cache)) {
    return $return;
  }
  
  global $cs_db;
  settype($first, 'integer');
  settype($max, 'integer');
  $run = 0;
  $sql_where = str_replace('"', "'", $sql_where);

  if(!empty($max)) {
    $sql_select = ' TOP ' . $max . ' ' . $sql_select;
    if(!empty($first)) {
      $cell = explode(' ',$sql_table);
      $same_qry = ' ' . $cell[0] . '_id FROM ' . $cs_db['prefix'] . '_' . $sql_table;
      $same_qry .= empty($sql_where) ? '' : ' WHERE ' . $sql_where;
      $same_qry .= empty($sql_order) ? '' : ' ORDER BY ' . $sql_order;
      $sql_notin = '(' . $cell[0] . '_id NOT IN (SELECT TOP ' . $first . ' ' . $same_qry . '))';
      $sql_where = empty($sql_where) ? $sql_notin : $sql_notin . ' AND ';
    }
  }
  $sql_query = 'SELECT ' . $sql_select . ' FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  if (!empty($sql_where)) {
    $sql_query .= ' WHERE ' . $sql_where;
  }
  if (!empty($sql_order)) {
    $sql_query .= ' ORDER BY ' . $sql_order;
  }

  $sql_query = str_replace('{pre}', $cs_db['prefix'], $sql_query);
  
  if (!$sql_data = sqlsrv_query($cs_db['con'], $sql_query)) {
    cs_error_sql($cs_file, 'cs_sql_select', cs_sql_error());
    return false;
  }
  if ($max == 1) {
    $new_result = sqlsrv_fetch_array($sql_data, SQLSRV_FETCH_ASSOC);
  } else {
    while ($sql_result = sqlsrv_fetch_array($sql_data, SQLSRV_FETCH_ASSOC)) {
      $new_result[$run] = $sql_result;
      $run++;
    }
  }
  sqlsrv_free_stmt($sql_data);
  cs_log_sql($cs_file, $sql_query);
  
  if (!empty($new_result)) {
    
    if (!empty($cache))
      cs_cache_save($cache, $new_result);
    
    return $new_result;
  }
}

function cs_sql_update($cs_file, $sql_table, $sql_cells, $sql_content, $sql_id, $sql_where = 0) {

  global $cs_db;
  settype($sql_id, 'integer');
  $max = count($sql_cells);
  $set = ' SET ';
  for ($run = 0; $run < $max; $run++) {
    $set .= $sql_cells[$run] . "='" . str_replace("'","''",$sql_content[$run]);
    if ($run != $max - 1) {
      $set .= "', ";
    }
  }
  $set .= "' ";
  
  $sql_update = 'UPDATE ' . $cs_db['prefix'] . '_' . $sql_table . $set . ' WHERE ';
  if (empty($sql_where)) { 
    $sql_update .= $sql_table . '_id = ' . $sql_id;
  }
  else {
    $sql_update .= $sql_where;
  }
  sqlsrv_query($cs_db['con'], $sql_update) or cs_error_sql($cs_file, 'cs_sql_update', cs_sql_error());
  
  $action = 1;
  if ($sql_cells[0] == 'users_laston' or $sql_table == 'count') {
    $action = 0;
  }
  cs_log_sql($cs_file, $sql_update, $action);
}

function cs_sql_version($cs_file) {

  global $cs_db;
  $sql_infos = array('data_free' => 0, 'data_size' => 0, 'index_size' => 0, 'tables' => 0, 'names' => array());
  $client = sqlsrv_client_info($cs_db['con']);
  $server = sqlsrv_server_info($cs_db['con']);

  $sql_infos['encoding'] = 'default';
  $sql_infos['type'] = 'Microsoft SQL Server (sqlsrv)';
  $sql_infos['client'] = $client['DriverVer'] . ' - ODBC ' . $client['DriverODBCVer'];
  $sql_infos['host'] = $server['SQLServerName'];
  $sql_infos['server'] = $server['SQLServerVersion'];
  return $sql_infos;
}

function cs_sql_error() {
  
  global $cs_db;
  $return = '';
  $errors_array = sqlsrv_errors();
  if(is_array($errors_array)) {
    foreach($errors_array AS $num => $err) {
      foreach($err AS $key => $value)
        if(!is_integer($key)) $return .= "\n[" . $num . '][' . $key . '] => ' . $value;
    }
  }
  return $return;
}