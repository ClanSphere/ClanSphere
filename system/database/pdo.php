<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_sql_count($cs_file,$sql_table,$sql_where = 0, $distinct = 0) {

  global $cs_db;
  $row = empty($distinct) ? '*' : 'DISTINCT ' . $distinct;

  $sql_query = 'SELECT COUNT('.$row.') FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  $sql_query .= empty($sql_where) ? '' : ' WHERE ' . $sql_where;

  $sql_query = str_replace('{pre}',$cs_db['prefix'],$sql_query);
  if($sql_data = $cs_db['con']->query($sql_query, PDO::FETCH_NUM)) {
    $sql_result = $sql_data->fetch();
    $sql_data = NULL;
    $result = $sql_result[0];
  }
  else {
    cs_error_sql($cs_file, 'cs_sql_count', cs_sql_error(0, $sql_query));
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
    cs_error_sql($cs_file, 'cs_sql_delete', cs_sql_error(0, $sql_delete));
  }
  cs_log_sql($cs_file, $sql_delete,1);
}

function cs_sql_escape($string) {

  global $cs_db;
  if($cs_db['type'] == 'pdo_sqlsrv')
    return str_replace("'","''",(string) $string);

  $string = $cs_db['con']->quote((string) $string);
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
    $set .= $cs_db['con']->quote((string) $sql_content[$run]);
    if($run != $max - 1) { $set .= ','; }
  }
  $set .= ')';

  $sql_insert = 'INSERT INTO ' . $cs_db['prefix'] . '_' . $sql_table . $set;
  if(!$cs_db['con']->query($sql_insert)) {
    cs_error_sql($cs_file, 'cs_sql_insert', cs_sql_error(0, $sql_insert));
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
    cs_error_sql($cs_file, 'cs_sql_insertid', cs_sql_error());
  }
}

function cs_sql_option($cs_file,$mod) {

  global $cs_db;
  global $cs_template;
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
        cs_error_sql($cs_file, 'cs_sql_option', cs_sql_error(0, $sql_query), 1);
      }
      cs_log_sql($cs_file, $sql_query);
      if(count($cs_template)) {
        foreach($cs_template AS $navlist => $value) {
          if($navlist == $mod) {
          $new_result = array_merge($new_result,$value);
          }
        }
      }
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
    cs_error_sql($cs_file, 'cs_sql_query',cs_sql_error(0, $sql_query));
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
  $first = ($first < 0) ? 0 : (int) $first;
  $max = ($max < 0) ? 20 : (int) $max;
  $new_result = 0;
  $run = 0;

  if($cs_db['type'] == 'pdo_sqlsrv' AND (!empty($max) OR $sql_order === '{random}')) {
    $sql_select = ' TOP ' . $max . ' ' . $sql_select;
    if(!empty($first)) {
      $cell = explode(' ',$sql_table);
      $same_qry = ' ' . $cell[0] . '_id FROM ' . $cs_db['prefix'] . '_' . $sql_table;
      $same_qry .= empty($sql_where) ? '' : ' WHERE ' . $sql_where;
      $same_qry .= empty($sql_order) ? '' : ' ORDER BY ' . $sql_order;
      $sql_notin = '(' . $cell[0] . '_id NOT IN (SELECT TOP ' . $first . ' ' . $same_qry . '))';
      $sql_where = empty($sql_where) ? $sql_notin : $sql_notin . ' AND ' . $sql_where;
    }
  }

  $sql_query = 'SELECT ' . $sql_select . ' FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  if (!empty($sql_where)) {
    $sql_query .= ' WHERE ' . $sql_where;
  }
  if (!empty($sql_order)) {
    if($cs_db['type'] == 'pdo_mysql')
      $random = 'RAND()';
    elseif($cs_db['type'] == 'pdo_sqlsrv')
      $random = 'NEWID()';
    else
      $random = 'RANDOM()';

    $sql_query .= ' ORDER BY ' . str_replace('{random}', $random, $sql_order);
  }
  if ($cs_db['type'] != 'pdo_sqlsrv' AND !empty($max)) {
    $limit = $cs_db['type'] == 'pdo_pgsql' ? $max . ' OFFSET ' . $first : $first . ',' . $max;
    $sql_query .= ' LIMIT ' . $limit;
  }
  $sql_query = str_replace('{pre}',$cs_db['prefix'],$sql_query);
  cs_log_sql($cs_file, $sql_query);
  try {
    $sql_data = $cs_db['con']->query($sql_query);
  }
  catch(PDOException $err) {
    cs_error_sql($cs_file, 'cs_sql_select', cs_sql_error($err, $sql_query));
  }
  if(empty($error)) {
    $new_result = $max == 1 ? $sql_data->fetch(PDO::FETCH_ASSOC) : $sql_data->fetchAll(PDO::FETCH_ASSOC);
    $sql_data = NULL;
  }

  if (!empty($new_result)) {
    if (!empty($cache))
      cs_cache_save($cache, $new_result);

    return $new_result;
  }
  return NULL;
}

function cs_sql_update($cs_file,$sql_table,$sql_cells,$sql_content,$sql_id,$sql_where = 0, $sql_log = 1) {

  global $cs_db;
  settype($sql_id,'integer');
  $max = count($sql_cells);
  $set = ' SET ';
  for($run=0; $run<$max; $run++) {
    $set .= $sql_cells[$run] . '=' . $cs_db['con']->quote((string) $sql_content[$run]);
    if($run != $max - 1) { $set .= ', '; }
  }

  $sql_update = 'UPDATE ' . $cs_db['prefix'] . '_' . $sql_table . $set . ' WHERE ';
  if(empty($sql_where)) { 
    $sql_update .= $sql_table . '_id = ' . $sql_id;
  }
  else {
    $sql_update .= $sql_where;
  }

  if(!$cs_db['con']->query($sql_update)) {
    cs_error_sql($cs_file, 'cs_sql_update', cs_sql_error(0, $sql_update));
  }

  cs_log_sql($cs_file, $sql_update, $sql_log);
}

function cs_sql_error($object = 0, $query = 0) {

  global $cs_db;
  $error_string = is_object($object) ? $object->getMessage() : '';
  if(empty($error_string)) {
    $error = $cs_db['con']->errorInfo();
    if(isset($error[2]))
      $error_string = $error[2];
    elseif(empty($error) OR $error_string = array(0 => '00000'))
      $error_string = 'Unknown SQL Error';
    else
      $error_string = (string) $error;
  }

  if(!empty($query))
    $error_string .= ' --Query: ' . $query;
  elseif($error_string == 'Unknown SQL Error')
    return FALSE;

  return $error_string;
}