<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_sql_connect($cs_db, $test = 0) {

  $error = '';
  if(!extension_loaded('pgsql')) {
    $error = 'PHP extension pgsql must be activated!';
  }
  else {
    $pg_con = empty($cs_db['place']) ? '' : 'host=' . $cs_db['place'] . ' ';
    $pg_con .= 'dbname=' . $cs_db['name'] . ' user=' . $cs_db['user'] . ' password=' . $cs_db['pwd'];

    @ini_set('track_errors', 1);
    $connect = pg_connect($pg_con) OR $error = empty($php_errormsg) ? 'Connection failed' : $php_errormsg;
  }

  global $cs_main;
  $sql_charset = strtolower($cs_main['charset']);
  if(empty($error) AND $sql_charset == 'utf-8')
  pg_set_client_encoding('UNICODE');

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

  $sql_query = 'SELECT COUNT('.$row.') FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  $sql_query .= empty($sql_where) ? '' : ' WHERE ' . $sql_where;

  $sql_query = str_replace('{pre}',$cs_db['prefix'],$sql_query);
  if(!$sql_data = pg_query($cs_db['con'], $sql_query)) {
    cs_error_sql($cs_file, 'cs_sql_count', cs_sql_error(0, $sql_query));
    return NULL;
  }
  $sql_result = pg_fetch_row($sql_data);
  pg_free_result($sql_data);
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
  pg_query($cs_db['con'], $sql_delete) OR
  cs_error_sql($cs_file, 'cs_sql_delete', cs_sql_error(0, $sql_delete));
  cs_log_sql($cs_file, $sql_delete,1);
}

function cs_sql_escape($string) {

  return pg_escape_string((string) $string);
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
    $set .= pg_escape_string((string) $sql_content[$run]);
    if($run != $max - 1) { $set .= "','"; }
  }
  $set .= "')";

  $sql_insert = 'INSERT INTO ' . $cs_db['prefix'] . '_' . $sql_table . $set;
  pg_query($cs_db['con'], $sql_insert) OR
  cs_error_sql($cs_file, 'cs_sql_insert', cs_sql_error(0, $sql_insert));
  cs_log_sql($cs_file, $sql_insert);
}

function cs_sql_insertid($cs_file) {

  $found = cs_sql_query($cs_file, 'SELECT LASTVAL()', 1);
  $lastval = isset($found['more'][0]['lastval']) ? $found['more'][0]['lastval'] : NULL;
  return $lastval;
}

function cs_sql_option($cs_file,$mod) {

  global $cs_db, $cs_template;
  static $options = array();

  if (empty($options[$mod])) {

    if (!$options[$mod] = cs_cache_load('op_' . $mod)) {

      $sql_query = 'SELECT options_name, options_value FROM  ' . $cs_db['prefix'] . '_' . 'options';
      $sql_query .= " WHERE options_mod='" . $mod . "'";
      $sql_data = pg_query($cs_db['con'], $sql_query) OR
      cs_error_sql($cs_file, 'cs_sql_option', cs_sql_error(0, $sql_query), 1);
      while($sql_result = pg_fetch_assoc($sql_data)) {
        $name = $sql_result['options_name'];
        $new_result[$name] = $sql_result['options_value'];
      }
      pg_free_result($sql_data);
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
  if($sql_data = pg_query($cs_db['con'], $sql_query)) {
    $result = array('affected_rows' => pg_affected_rows($sql_data));
    if(!empty($more)) {
      while($sql_result = pg_fetch_assoc($sql_data)) {
        $result['more'][] = $sql_result;
      }
      pg_free_result($sql_data);
    }
  }
  else {
    cs_error_sql($cs_file, 'cs_sql_query', cs_sql_error(0, $sql_query));
    $result = 0;
  }
  cs_log_sql($cs_file, $sql_query);
  return $result;
}

function cs_sql_replace($replace) {

  $replace = str_replace('{optimize}','VACUUM',$replace);
  $replace = str_replace('{serial}','serial NOT NULL',$replace);
  $replace = str_replace('{engine}','',$replace);
  return preg_replace("=int\((.*?)\)=si",'integer',$replace);
}

function cs_sql_select($cs_file,$sql_table,$sql_select,$sql_where = 0,$sql_order = 0,$first = 0,$max = 1, $cache = 0) {

  if (!empty($cache) && $return = cs_cache_load($cache)) {
    return $return;
  }

  global $cs_db;
  $first = ($first < 0) ? 0 : (int) $first;
  $max = ($max < 0) ? 20 : (int) $max;
  $run = 0;

  $sql_query = 'SELECT ' . $sql_select . ' FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  if(!empty($sql_where)) {
    $sql_query .= ' WHERE ' . $sql_where;
  }
  if(!empty($sql_order)) {
    $sql_query .= ' ORDER BY ' . str_replace('{random}', 'RANDOM()', $sql_order);
  }
  if(!empty($max)) {
    $sql_query .= ' LIMIT ' . $max . ' OFFSET ' . $first;
  }
  $sql_query = str_replace('{pre}',$cs_db['prefix'],$sql_query);
  $sql_data = pg_query($cs_db['con'], $sql_query) OR
  cs_error_sql($cs_file, 'cs_sql_select', cs_sql_error(0, $sql_query));
  if($max == 1) {
    $new_result = pg_fetch_assoc($sql_data);
  }
  else {
    while($sql_result = pg_fetch_assoc($sql_data)) {
      $new_result[$run] = $sql_result;
      $run++;
    }
  }
  pg_free_result($sql_data);
  cs_log_sql($cs_file, $sql_query);

  if(!empty($new_result)) {
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
    $set .= $sql_cells[$run] . "='" . pg_escape_string((string) $sql_content[$run]);
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
  pg_query($cs_db['con'], $sql_update) OR
  cs_error_sql($cs_file, 'cs_sql_update', cs_sql_error(0, $sql_update));

  cs_log_sql($cs_file, $sql_update, $sql_log);
}

function cs_sql_version($cs_file) {

  global $cs_db;
  $sql_infos = array('data_free' => 0, 'data_size' => 0, 'index_size' => 0, 'tables' => 0, 'names' => array());
  $sql_infos['type'] = 'PostgreSQL (pgsql)';
  $sql_infos['host'] = pg_host($cs_db['con']) OR
  cs_error_sql($cs_file, 'cs_sql_version', cs_sql_error());
  if(function_exists('pg_version')) {
    $pg_infos = pg_version($cs_db['con']) OR
    cs_error_sql($cs_file, 'cs_sql_version', cs_sql_error());
  }

  $sql_infos['encoding'] = pg_client_encoding($cs_db['con']);
  $sql_infos['client'] = isset($pg_infos['client']) ? $pg_infos['client'] : '-';
  $sql_infos['server'] = isset($pg_infos['server_version']) ? $pg_infos['server_version'] : '-';
  if($sql_infos['server'] == '-') {
    $found = cs_sql_query($cs_file, 'SELECT VERSION()', 1);
    preg_match('=[\d|.]+=',$found['more'][0]['version'],$matches,PREG_OFFSET_CAPTURE);
    $sql_infos['server'] = isset($matches[0][0]) ? $matches[0][0] : $found['more'][0]['version'];
  }
  return $sql_infos;
}

function cs_sql_error($object = 0, $query = 0) {

  global $cs_db;
  $error_string = pg_last_error($cs_db['con']);
  if(!empty($query))
    $error_string .= ' --Query: ' . $query;
  return $error_string;
}