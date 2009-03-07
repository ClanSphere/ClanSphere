<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

function cs_sql_connect($cs_db) {

  if (!extension_loaded('mssql')) {
    cs_error_sql(__FILE__, 'cs_sql_connect', 'mssql extension must be activated!', 1);
  }
  $connect = @mssql_connect($cs_db['place'], $cs_db['user'], $cs_db['pwd']) or cs_error_sql(__FILE__, 'mssql_connect', mssql_get_last_message(), 1);

  mssql_select_db($cs_db['name']) or cs_error_sql(__FILE__, 'mssql_select_db', mssql_get_last_message(), 1);
  return $connect;
}

function cs_sql_count($cs_file,$sql_table,$sql_where = 0, $distinct = 0) {

  global $cs_db;
  $row = empty($distinct) ? '*' : 'DISTINCT ' . $distinct;
  $sql_where = str_replace('"', '\'', $sql_where);
  
  $sql_query = 'SELECT COUNT('.$row.') FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  $sql_query .= empty($sql_where) ? '' : ' WHERE ' . $sql_where;
  
  $sql_query = str_replace('{pre}',$cs_db['prefix'],$sql_query);
  if(!$sql_data = mssql_query($sql_query, $cs_db['con'])) {
    cs_error_sql($cs_file, 'cs_sql_count', mssql_get_last_message());
    return FALSE;
  }
  $sql_result = mssql_fetch_row($sql_data);
  mssql_free_result($sql_data);
  cs_log_sql($sql_query);
  return $sql_result[0];
}

function cs_sql_delete($cs_file,$sql_table,$sql_id,$sql_field = 0) {

  global $cs_db;
  settype($sql_id,'integer');
  if(empty($sql_field)) {
    $sql_field = $sql_table . '_id';
  }
  $sql_delete = 'DELETE FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  $sql_delete .= ' WHERE ' . $sql_field . ' = ' . $sql_id;
  mssql_query($sql_delete, $cs_db['con']) OR 
    cs_error_sql($cs_file, 'cs_sql_delete', mssql_get_last_message());
  cs_log_sql($sql_delete,1);
}

function cs_sql_escape($string) {

  return str_replace("'","''",$string);
}

function cs_sql_insert($cs_file,$sql_table,$sql_cells,$sql_content) {

  global $cs_db;
  $max = count($sql_cells);
  $set = " (";
  for($run=0; $run<$max; $run++) {
    $set .= $sql_cells[$run];
    if($run != $max - 1) { $set .= ","; }
  }
  $set .= ") VALUES ('";
  for($run=0; $run<$max; $run++) {
    $set .= str_replace("'","''",$sql_content[$run]);
    if($run != $max - 1) { $set .= "','"; }
  }
  $set .= "')";
  
  $sql_insert = 'INSERT INTO ' . $cs_db['prefix'] . '_' . $sql_table . $set;
  mssql_query($sql_insert, $cs_db['con']) OR 
    cs_error_sql($cs_file, 'cs_sql_insert', mssql_get_last_message());
  cs_log_sql($sql_insert);
}

function cs_sql_insertid($cs_file) {

  global $cs_db;
  $sql_query = 'SELECT @@IDENTITY';
  $sql_data = mssql_query($sql_query, $cs_db['con']) OR 
    cs_error_sql($cs_file, 'cs_sql_insertid', mssql_get_last_message());
  $new_result = mssql_fetch_row($sql_data);
  mssql_free_result($sql_data);
  cs_log_sql($sql_query);
  return $new_result[0];
}

function cs_sql_option($cs_file,$mod) {

  static $options = array();
  if(!isset($options[$mod])) {
    global $cs_db;
    $sql_query = 'SELECT options_name, options_value FROM  ' . $cs_db['prefix'] . '_' . 'options';
    $sql_query .= " WHERE options_mod='" . $mod . "'";
    $sql_data = mssql_query($sql_query, $cs_db['con']) OR 
      cs_error_sql($cs_file, 'cs_sql_option', mssql_get_last_message(), 1);
    while($sql_result = mssql_fetch_assoc($sql_data)) {
      $name = $sql_result['options_name'];
      $new_result[$name] = $sql_result['options_value'];
    }
    mssql_free_result($sql_data);
    cs_log_sql($sql_query);
    $options[$mod] = isset($new_result) ? $new_result : 0;
  }
  if(!empty($options[$mod])) {
    return $options[$mod];
  }
}

function cs_sql_query($cs_file,$sql_query) {

  global $cs_db;
  $sql_query = str_replace('{pre}',$cs_db['prefix'],$sql_query);
  if(mssql_query($sql_query, $cs_db['con'])) {
    $result = array('affected_rows' => mssql_rows_affected($cs_db['con']));
  }
  else { 
    cs_error_sql($cs_file, 'cs_sql_query', mssql_get_last_message());
    $result = 0;
  }
  cs_log_sql($sql_query);
  return $result;
}

function cs_sql_select($cs_file,$sql_table,$sql_select,$sql_where = 0,$sql_order = 0,$first = 0,$max = 1) {

  global $cs_db;
  settype($first,'integer');
  settype($max,'integer');
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
  if(!empty($sql_where)) {
    $sql_query .= ' WHERE ' . $sql_where;
  }
  if(!empty($sql_order)) {
    $sql_query .= ' ORDER BY ' . $sql_order;
  }
  $sql_query = str_replace('{pre}',$cs_db['prefix'],$sql_query);
  
  if (!$sql_data = mssql_query($sql_query, $cs_db['con'])) {
    cs_error_sql($cs_file, 'cs_sql_select', mssql_get_last_message());
    return FALSE;
  }
  if($max == 1) {
    $new_result = mssql_fetch_assoc($sql_data);
  }
  else {
    while($sql_result = mssql_fetch_assoc($sql_data)) {
      $new_result[$run] = $sql_result;
      $run++;
    }
  }
  mssql_free_result($sql_data);
  cs_log_sql($sql_query);
  if(!empty($new_result)) {
    return $new_result;
  }
}

function cs_sql_update($cs_file,$sql_table,$sql_cells,$sql_content,$sql_id,$sql_where = 0) {

  global $cs_db;
  settype($sql_id,'integer');
  $max = count($sql_cells);
  $set = ' SET ';
  for($run=0; $run<$max; $run++) {
    $set .= $sql_cells[$run] . "='" . str_replace("'","''",$sql_content[$run]);
    if($run != $max - 1) { $set .= "', "; }
  }
  $set .= "' ";
  
  $sql_update = 'UPDATE ' . $cs_db['prefix'] . '_' . $sql_table . $set . ' WHERE ';
  if(empty($sql_where)) { 
    $sql_update .= $sql_table . "_id='" . $sql_id . "'";
  }
  else {
    $sql_update .= $sql_where;
  }
  mssql_query($sql_update, $cs_db['con']) OR 
    cs_error_sql($cs_file, 'cs_sql_update', mssql_get_last_message());
    
  $action = 1;
  if($sql_cells[0] == 'users_laston' OR $sql_table == 'count') {
    $action = 0;
  }
  cs_log_sql($sql_update,$action);
}

function cs_sql_version($cs_file) {

  global $cs_db;
  $sql_infos = array('data_size' => 0, 'index_size' => 0, 'tables' => 0, 'names' => array());
  $sql_infos['type'] = 'Microsoft SQL Server (mssql)';
  $sql_infos['host'] = $cs_db['place'];
  $sql_infos['client'] = '-';

  $sql_infos['encoding'] = ini_get('mssql.charset') . ' (php.ini)';
  $sql_query = 'SELECT @@VERSION';
  $sql_data = mssql_query($sql_query, $cs_db['con']) OR 
    cs_error_sql($cs_file, 'cs_sql_version', mssql_get_last_message());
  $sql_result = mssql_fetch_row($sql_data);
  mssql_free_result($sql_data);
  preg_match('=\d+\.\d+\.\d+.\d+=',$sql_result[0],$matches,PREG_OFFSET_CAPTURE);
  $sql_infos['server'] = isset($matches[0][0]) ? $matches[0][0] : '--';
  cs_log_sql($sql_query);
  return $sql_infos;
}

function cs_sql_error() {
  
  return mssql_get_last_message();
  
}

?>