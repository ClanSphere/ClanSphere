<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

function cs_sql_connect($cs_db, $test = 0)
{
  $error = '';
  if(!extension_loaded('sqlite')) {
    $error = 'PHP extension sqlite must be activated!';
  }
  else {
    $connect = sqlite_open($cs_db['name'], 0666, $error);
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

  $row = '*'; // Not supported: $row = empty($distinct) ? '*' : 'DISTINCT ' . $distinct;
  $sql_where = str_replace('"', '\'', $sql_where);
  
  $sql_query = 'SELECT COUNT(*) FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  $sql_query .= empty($sql_where) ? '' : ' WHERE ' . $sql_where;

  $sql_query = str_replace('{pre}',$cs_db['prefix'],$sql_query);
  if(!$sql_data = sqlite_query($cs_db['con'], $sql_query)) {
    cs_error_sql($cs_file, 'cs_sql_count', cs_sql_error());
    return FALSE;
  }
  $sql_result = sqlite_fetch_array($sql_data,SQLITE_NUM);
  cs_log_sql($cs_file, $sql_query);
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
  sqlite_query($cs_db['con'], $sql_delete) OR 
    cs_error_sql($cs_file, 'cs_sql_delete', cs_sql_error($cs_db['con']));
  cs_log_sql($cs_file, $sql_delete,1);
}

function cs_sql_escape($string) {

  return sqlite_escape_string($string);
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
    $set .= sqlite_escape_string($sql_content[$run]);
    if($run != $max - 1) { $set .= "','"; }
  }
  $set .= "')";
  
  $sql_insert = 'INSERT INTO ' . $cs_db['prefix'] . '_' . $sql_table . $set;
  sqlite_query($cs_db['con'], $sql_insert) OR 
    cs_error_sql($cs_file, 'cs_sql_insert', cs_sql_error($cs_db['con']));
  cs_log_sql($cs_file, $sql_insert);
}

function cs_sql_insertid($cs_file) {

  global $cs_db;
  $result = sqlite_last_insert_rowid($cs_db['con']) OR 
    cs_error_sql($cs_file, 'cs_sql_insertid', cs_sql_error($cs_db['con']));
  return $result;
}

function cs_sql_option($cs_file,$mod) {

  global $cs_db;
  static $options = array();

  if (empty($options[$mod])) {

    if (!$options[$mod] = cs_cache_load('op_' . $mod)) {

      $sql_query = 'SELECT options_name, options_value FROM  ' . $cs_db['prefix'] . '_' . 'options';
      $sql_query .= " WHERE options_mod='" . $mod . "'";
      $sql_data = sqlite_query($cs_db['con'], $sql_query) OR 
        cs_error_sql($cs_file, 'cs_sql_option', cs_sql_error($cs_db['con']), 1);
      while($sql_result = sqlite_fetch_array($sql_data,SQLITE_ASSOC)) {
        $name = $sql_result['options_name'];
        $new_result[$name] = $sql_result['options_value'];
      }
      cs_log_sql($cs_file, $sql_query);
      $options[$mod] = isset($new_result) ? $new_result : 0;

      cs_cache_save('op_' . $mod, $options[$mod]);
    }
  }
  
  return $options[$mod];
}

function cs_sql_query($cs_file,$sql_query, $more = 0) {

  global $cs_db;
  $sql_query = str_replace('{pre}',$cs_db['prefix'],$sql_query);
  if($sql_data = sqlite_query($cs_db['con'], $sql_query)) {
    $result = array('affected_rows' => sqlite_changes($cs_db['con']));
    if(!empty($more)) {
      while($sql_result = sqlite_fetch_array($sql_data,SQLITE_ASSOC)) {
        $result['more'][] = $sql_result;
      }
    }
  }
  else { 
    cs_error_sql($cs_file, 'cs_sql_query', cs_sql_error($cs_db['con']));
    $result = 0;
  }
  cs_log_sql($cs_file, $sql_query);
  return $result;
}

function cs_sql_select($cs_file,$sql_table,$sql_select,$sql_where = 0,$sql_order = 0,$first = 0,$max = 1, $cache = 0) {

  if (!empty($cache) && $return = cs_cache_load($cache)) {
    return $return;
  }
  
  global $cs_db;
  settype($first,'integer');
  settype($max,'integer');
  $run = 0;
  $sql_where = str_replace('"', "'", $sql_where);
  
  $sql_query = 'SELECT ' . $sql_select . ' FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  if(!empty($sql_where)) {
    $sql_query .= ' WHERE ' . $sql_where;
  }
  if(!empty($sql_order)) {
    $sql_query .= ' ORDER BY ' . $sql_order;
  }
  if(!empty($max)) {
    $sql_query .= ' LIMIT ' . $first . ',' . $max;
  }
  $sql_query = str_replace('{pre}',$cs_db['prefix'],$sql_query);
  if (!$sql_data = sqlite_query($cs_db['con'], $sql_query)) {
    cs_error_sql($cs_file, 'cs_sql_select', cs_sql_error($cs_db['con']));
    return FALSE;
  }
  if($max == 1) {
    $new_result = sqlite_fetch_array($sql_data,SQLITE_ASSOC);
  }
  else {
    while($sql_result = sqlite_fetch_array($sql_data,SQLITE_ASSOC)) {
      $new_result[$run] = $sql_result;
      $run++;
    }
  }
  cs_log_sql($cs_file, $sql_query);
  
  if(!empty($new_result)) {
    
    if (!empty($cache))
      cs_cache_save($cache, $new_result);
    
    return $new_result;
  }
}

function cs_sql_update($cs_file,$sql_table,$sql_cells,$sql_content,$sql_id,$sql_where = 0) {

  global $cs_db;
  settype($sql_id,'integer');
  $max = count($sql_cells);
  $set = ' SET ';
  for($run=0; $run<$max; $run++) {
    $set .= $sql_cells[$run] . "='" . sqlite_escape_string($sql_content[$run]);
    if($run != $max - 1) { $set .= "', "; }
  }
  $set .= "' ";
  
  $sql_update = 'UPDATE ' . $cs_db['prefix'] . '_' . $sql_table . $set . ' WHERE ';
  if(empty($sql_where)) { 
    $sql_update .= $sql_table . '_id = ' . $sql_id;
  }
  else {
    $sql_update .= $sql_where;
  }
  sqlite_query($cs_db['con'], $sql_update) OR 
    cs_error_sql($cs_file, 'cs_sql_update', cs_sql_error($cs_db['con']));
  
  $action = 1;
  if($sql_cells[0] == 'users_laston' OR $sql_table == 'count') {
    $action = 0;
  }
  cs_log_sql($cs_file, $sql_update,$action);
}

function cs_sql_version($cs_file) {

  global $cs_db;
  $sql_infos = array('data_free' => 0, 'data_size' => 0, 'index_size' => 0, 'tables' => 0, 'names' => array());
  $sql_infos['type'] = 'SQLite 2 (sqlite)';
  $sql_infos['host'] = 'localhost';
  $sql_infos['client'] = sqlite_libversion();
  $sql_infos['server'] = sqlite_libversion();
  $sql_infos['encoding'] = sqlite_libencoding();

    $sql_query = 'SELECT COUNT(*) FROM sqlite_master WHERE type = \'table\' AND name LIKE \'' . $cs_db['prefix'] . '_%\'';
    $sql_query = str_replace('{pre}',$cs_db['prefix'],$sql_query);
    if(!$sql_data = sqlite_query($cs_db['con'], $sql_query)) {
        cs_error_sql($cs_file, 'cs_sql_count', cs_sql_error($cs_db['con']));
    }
    else {
        $sql_result = sqlite_fetch_array($sql_data,SQLITE_NUM);
        $sql_infos['tables'] = $sql_result[0];
        $sql_infos['data_size'] = filesize($cs_db['name']);
    }
    cs_log_sql($cs_file, $sql_query);
  return $sql_infos;
}

function cs_sql_error() {

  global $cs_db;
  
  $error_code = sqlite_last_error($cs_db['con']);
  $error_string = sqlite_error_string($error_code);
  
  return $error_string == 'not an error' ? false : $error_string;
}