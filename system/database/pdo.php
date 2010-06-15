<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_sql_count($cs_file,$sql_table,$sql_where = 0, $distinct = 0) {

  global $cs_db;
  $row = empty($distinct) ? '*' : 'DISTINCT ' . $distinct;
  $sql_where = str_replace('"', '\'', $sql_where);

  $sql_query = 'SELECT COUNT('.$row.') FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  $sql_query .= empty($sql_where) ? '' : ' WHERE ' . $sql_where;

  $sql_query = str_replace('{pre}',$cs_db['prefix'],$sql_query);
  if($sql_data = $cs_db['con']->query($sql_query, PDO::FETCH_NUM)) {
    $sql_result = $sql_data->fetch();
    $sql_data = NULL;
    $result = $sql_result[0];
  }
  else {
    $error = $cs_db['con']->errorInfo();
    cs_error_sql($cs_file, 'cs_sql_count', $error[2]);
    $result = 0;
  }
  cs_log_sql($cs_file, $sql_query);
  return $result;
}

function cs_sql_delete($cs_file,$sql_table,$sql_id,$sql_field = 0) {

  global $cs_db;
  settype($sql_id,'integer');
  if(empty($sql_field)) {
    $sql_field = $sql_table . '_id';
  }
  $sql_delete = 'DELETE FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  $sql_delete .= ' WHERE ' . $sql_field . ' = ' . $sql_id;
  if(!$cs_db['con']->query($sql_delete)) {
    $error = $cs_db['con']->errorInfo();
    cs_error_sql($cs_file, 'cs_sql_delete', $error[2]);
  }
  cs_log_sql($cs_file, $sql_delete,1);
}

function cs_sql_escape($string) {

  global $cs_db;
  $string = $cs_db['con']->quote($string);
  return substr($string,1,-1);
}

function cs_sql_insert($cs_file,$sql_table,$sql_cells,$sql_content) {

  global $cs_db;
  $max = count($sql_cells);
  $set = " (";
  for($run=0; $run<$max; $run++) {
    $set .= $sql_cells[$run];
    if($run != $max - 1) { $set .= ","; }
  }
  $set .= ") VALUES (";
  for($run=0; $run<$max; $run++) {
    $set .= $cs_db['con']->quote($sql_content[$run]);
    if($run != $max - 1) { $set .= ','; }
  }
  $set .= ')';

  $sql_insert = 'INSERT INTO ' . $cs_db['prefix'] . '_' . $sql_table . $set;
  if(!$cs_db['con']->query($sql_insert)) {
    $error = $cs_db['con']->errorInfo();
    cs_error_sql($cs_file, 'cs_sql_insert', $error[2]);
  }
  cs_log_sql($cs_file, $sql_insert,1);
}

function cs_sql_insertid($cs_file) {

  global $cs_db;
  if($cs_db['type'] == 'pdo_pgsql') {
    $found = cs_sql_query($cs_file, 'SELECT LASTVAL()', 1);
    $result = isset($found['more'][0]['lastval']) ? $found['more'][0]['lastval'] : NULL;
  }
  else {
    $result = $cs_db['con']->lastInsertId();
  }
  if($result > 0) {
    return $result;
  }
  else {
    $error = $cs_db['con']->errorInfo();
    $error[2] = empty($error[2]) ? 'Failed to receive ID of insert query' : $error[2];
    cs_error_sql($cs_file, 'cs_sql_insertid', $error[2]);
  }
}

function cs_sql_option($cs_file,$mod) {

  global $cs_db;
  static $options = array();

  if (empty($options[$mod])) {

    if (!$options[$mod] = cs_cache_load('op_' . $mod)) {

      $sql_query = 'SELECT options_name, options_value FROM  ' . $cs_db['prefix'] . '_' . 'options';
      $sql_query .= " WHERE options_mod='" . $mod . "'";
      if($sql_data = $cs_db['con']->query($sql_query, PDO::FETCH_ASSOC)) {
        while($sql_result = $sql_data->fetch()) {
          $name = $sql_result['options_name'];
          $new_result[$name] = $sql_result['options_value'];
        }
        $sql_data = NULL;
      }
      else {
        $error = $cs_db['con']->errorInfo();
        cs_error_sql($cs_file, 'cs_sql_option', $error[2], 1);
      }
      cs_log_sql($cs_file, $sql_query);
      $options[$mod] = isset($new_result) ? $new_result : 0;

      cs_cache_save('op_' . $mod, $options[$mod]);
    }
  }

  return $options[$mod];
}

function cs_sql_query($cs_file, $sql_query, $more = 0) {

  global $cs_db;
  $sql_query = str_replace('{pre}',$cs_db['prefix'],$sql_query);
  if($sql_data = $cs_db['con']->query($sql_query, PDO::FETCH_ASSOC)) {
    $result = array('affected_rows' => $sql_data->rowCount());
    if(!empty($more)) {
      while($sql_result = $sql_data->fetch()) {
        $result['more'][] = $sql_result;
      }
      $sql_data = NULL;
    }
  }
  else {
    $error = $cs_db['con']->errorInfo();
    cs_error_sql($cs_file, 'cs_sql_query', $error[2]);
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
  $new_result = 0;
  $run = 0;
  $sql_where = str_replace('"', "'", $sql_where);

  $sql_query = 'SELECT ' . $sql_select . ' FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  if (!empty($sql_where)) {
    $sql_query .= ' WHERE ' . $sql_where;
  }
  if (!empty($sql_order)) {
    if($cs_db['type'] == 'pdo_mysql')
      $random = 'RAND()';
    else
      $random = 'RANDOM()';

    $sql_query .= ' ORDER BY ' . str_replace('{random}', $random, $sql_order);
  }
  if (!empty($max)) {
    $limit = $cs_db['type'] == 'pdo_pgsql' ? $max . ' OFFSET ' . $first : $first . ',' . $max;
    $sql_query .= ' LIMIT ' . $limit;
  }
  $sql_query = str_replace('{pre}',$cs_db['prefix'],$sql_query);
  cs_log_sql($cs_file, $sql_query);
  if($sql_data = $cs_db['con']->query($sql_query)) {
    $new_result = $max == 1 ? $sql_data->fetch(PDO::FETCH_ASSOC) : $sql_data->fetchAll(PDO::FETCH_ASSOC);
    $sql_data = NULL;
  }
  else {
    $error = $cs_db['con']->errorInfo();
    cs_error_sql($cs_file, 'cs_sql_select', $error[2]);
  }

  if (!empty($new_result)) {
    if (!empty($cache))
      cs_cache_save($cache, $new_result);

    return $new_result;
  }
  return NULL;
}

function cs_sql_update($cs_file,$sql_table,$sql_cells,$sql_content,$sql_id,$sql_where = 0) {

  global $cs_db;
  settype($sql_id,'integer');
  $max = count($sql_cells);
  $set = ' SET ';
  for($run=0; $run<$max; $run++) {
    $set .= $sql_cells[$run] . '=' . $cs_db['con']->quote($sql_content[$run]);
    if($run != $max - 1) { $set .= ', '; }
  }

  $sql_update = 'UPDATE ' . $cs_db['prefix'] . '_' . $sql_table . $set . ' WHERE ';
  if(empty($sql_where)) { 
    $sql_update .= $sql_table . '_id = ' . $sql_id;
  }
  else {
    $sql_update .= $sql_where;
  }
  $action = $sql_cells[0] == 'users_laston' OR $sql_table == 'count' ? 0 : 1;
  if(!$cs_db['con']->query($sql_update)) {
    $error = $cs_db['con']->errorInfo();
    cs_error_sql($cs_file, 'cs_sql_update', $error[2]);
  }
  cs_log_sql($cs_file, $sql_update,$action);
}

function cs_sql_error() {

  global $cs_db;
  $error = $cs_db['con']->errorInfo();
  if(empty($error) OR $error = array(0 => '00000'))
    return FALSE;
  else
    return $error;
}