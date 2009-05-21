<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

function cs_sql_connect($cs_db, $test = 0)
{
  $error = '';
  if(!extension_loaded('mysqli')) {
    $error = 'PHP extension mysqli must be activated!';
  }
  else {
    $connect = @mysqli_connect($cs_db['place'], $cs_db['user'], $cs_db['pwd'], $cs_db['name']) OR $error = mysqli_connect_error();
  }

  if(empty($test) AND empty($error)) {
    # mysqli_set_charset($connect, 'utf8'); // php 5.0.5+
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
  if (!$sql_data = mysqli_query($cs_db['con'], $sql_query)) {
    cs_error_sql($cs_file, 'cs_sql_count', mysqli_error($cs_db['con']));
    return false;
  }
  $sql_result = mysqli_fetch_row($sql_data);
  mysqli_free_result($sql_data);
  cs_log_sql($cs_file, $sql_query);
  return $sql_result[0];
}

function cs_sql_delete($cs_file,$sql_table,$sql_id,$sql_field = 0) {

  global $cs_db;
  settype($sql_id,'integer');
  if (empty($sql_field)) {
    $sql_field = $sql_table . '_id';
  }
  $sql_delete = 'DELETE FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  $sql_delete .= ' WHERE ' . $sql_field . ' = ' . $sql_id;
  mysqli_query($cs_db['con'], $sql_delete) or cs_error_sql($cs_file, 'cs_sql_delete', mysqli_error($cs_db['con']));
  cs_log_sql($cs_file, $sql_delete,1);
}

function cs_sql_escape($string) {

  global $cs_db;
  return mysqli_real_escape_string($cs_db['con'],$string);
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
    $set .= mysqli_real_escape_string($cs_db['con'],$sql_content[$run]);
    if ($run != $max - 1) {
      $set .= "','";
    }
  }
  $set .= "')";
  
  $sql_insert = 'INSERT INTO ' . $cs_db['prefix'] . '_' . $sql_table . $set;
  mysqli_query($cs_db['con'], $sql_insert) or cs_error_sql($cs_file, 'cs_sql_insert', mysqli_error($cs_db['con']));
  cs_log_sql($cs_file, $sql_insert);
}

function cs_sql_insertid($cs_file) {

  global $cs_db;
  $result = mysqli_insert_id($cs_db['con']) or cs_error_sql($cs_file, 'cs_sql_insertid', mysqli_error($cs_db['con']));
  return $result;
}

function cs_sql_option($cs_file, $mod)
{
  global $cs_db;
  static $options = array();

  if (empty($options[$mod])) {

    if (!$options[$mod] = cs_cache_load('op_' . $mod)) {

      $sql_query = 'SELECT options_name, options_value FROM  ' . $cs_db['prefix'] . '_' . 'options';
      $sql_query .= " WHERE options_mod = '" . $mod . "'";
      $sql_data = mysqli_query($cs_db['con'], $sql_query) or cs_error_sql($cs_file, 'cs_sql_option', mysqli_error($cs_db['con']), 1);

      while ($sql_result = mysqli_fetch_assoc($sql_data)) {
        $name = $sql_result['options_name'];
        $new_result[$name] = $sql_result['options_value'];
      }
      mysqli_free_result($sql_data);
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
  if ($sql_data = mysqli_query($cs_db['con'], $sql_query)) {
    $result = array('affected_rows' => mysqli_affected_rows($cs_db['con']));
    if(!empty($more)) {
      while ($sql_result = mysqli_fetch_assoc($sql_data)) {
        $result['more'][] = $sql_result;
      }
      mysqli_free_result($sql_data);
    }
  } else { 
    cs_error_sql($cs_file, 'cs_sql_query', mysqli_error($cs_db['con']));
    $result = 0;
  }
  cs_log_sql($cs_file, $sql_query);
  return $result;
}

function cs_sql_replace($replace) {

  global $cs_db;
  #engine since 4.0.18, but collation works since 4.1.8
  $version = mysqli_get_server_info($cs_db['con']) or cs_error_sql($cs_file, 'cs_sql_replace', mysqli_error($cs_db['con']));
  $myv = explode('.', $version);
  settype($myv[2], 'integer');
  if($myv[0] > 4 OR $myv[0] == 4 AND $myv[1] > 1 OR $myv[0] == 4 AND $myv[1] == 1 AND $myv[2] > 7)
    $engine = ' ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';
  else
    $engine = ' TYPE=MyISAM CHARACTER SET utf8';

  $replace = str_replace('{optimize}','OPTIMIZE TABLE',$replace);
  $replace = str_replace('{serial}','int(8) unsigned NOT NULL auto_increment',$replace);
  $replace = str_replace('{engine}',$engine,$replace);
  return preg_replace("=create index (\S+) on (\S+) (\S+)=si",'ALTER TABLE $2 ADD KEY $1 $3',$replace);
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
  
  $sql_query = 'SELECT ' . $sql_select . ' FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  if (!empty($sql_where)) {
    $sql_query .= ' WHERE ' . $sql_where;
  }
  if (!empty($sql_order)) {
    $sql_query .= ' ORDER BY ' . $sql_order;
  }
  if (!empty($max)) {
    $sql_query .= ' LIMIT ' . $first . ',' . $max;
  }
  $sql_query = str_replace('{pre}', $cs_db['prefix'], $sql_query);
  
  if (!$sql_data = mysqli_query($cs_db['con'], $sql_query)) {
    cs_error_sql($cs_file, 'cs_sql_select', mysqli_error($cs_db['con']));
    return false;
  }
  if ($max == 1) {
    $new_result = mysqli_fetch_assoc($sql_data);
  } else {
    while ($sql_result = mysqli_fetch_assoc($sql_data)) {
      $new_result[$run] = $sql_result;
      $run++;
    }
  }
  mysqli_free_result($sql_data);
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
    $set .= $sql_cells[$run] . "='" . mysqli_real_escape_string($cs_db['con'], $sql_content[$run]);
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
  mysqli_query($cs_db['con'], $sql_update) or cs_error_sql($cs_file, 'cs_sql_update', mysqli_error($cs_db['con']));
  
  $action = 1;
  if ($sql_cells[0] == 'users_laston' or $sql_table == 'count') {
    $action = 0;
  }
  cs_log_sql($cs_file, $sql_update, $action);
}

function cs_sql_version($cs_file) {

  global $cs_db;
  $sql_infos = array('data_free' => 0, 'data_size' => 0, 'index_size' => 0, 'tables' => 0, 'names' => array());
  $sql_query = "SHOW TABLE STATUS LIKE '" . cs_sql_escape($cs_db['prefix'] . '_') . "%'";
  $sql_data = mysqli_query($cs_db['con'], $sql_query) or cs_error_sql($cs_file, 'cs_sql_version', mysqli_error($cs_db['con']));
  while($row = mysqli_fetch_assoc($sql_data)) {
    $sql_infos['data_size'] += $row['Data_length'];
    $sql_infos['index_size'] += $row['Index_length'];
    $sql_infos['data_free'] += $row['Data_free'];
    $sql_infos['tables']++;
    $sql_infos['names'][] .= $row['Name'];
  }
  mysqli_free_result($sql_data);
  cs_log_sql($cs_file, $sql_query);

  $sql_infos['encoding'] = mysqli_character_set_name($cs_db['con']);
  $sql_infos['type'] = 'MySQL (mysqli)';
  $sql_infos['client'] = mysqli_get_client_info();
  $sql_infos['host'] = mysqli_get_host_info($cs_db['con']) or cs_error_sql($cs_file, 'cs_sql_version', mysqli_error($cs_db['con']));
  $sql_infos['server'] = mysqli_get_server_info($cs_db['con']) or cs_error_sql($cs_file, 'cs_sql_version', mysqli_error($cs_db['con']));
  return $sql_infos;
}

function cs_sql_error() {

  global $cs_db;

  return mysqli_error($cs_db['con']);
}