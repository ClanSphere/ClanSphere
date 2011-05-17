<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_sql_connect($cs_db, $test = 0) {

  $error = '';
  if(!extension_loaded('mysql')) {
    $error = 'PHP extension mysql must be activated!';
  }
  else {
    $connect = mysql_connect($cs_db['place'], $cs_db['user'], $cs_db['pwd']) OR $error = mysql_error();
  }
  if(empty($error)) {
    mysql_select_db($cs_db['name']) OR $error = mysql_error($connect);
  }

  global $cs_main;
  $sql_charset = strtolower($cs_main['charset']);
  if(empty($error) AND $sql_charset == 'utf-8') {
    # since php 5.2.3 - depends on mysql libs, too
    if(function_exists('mysql_set_charset'))
    mysql_set_charset('utf8', $connect);
    else
    mysql_unbuffered_query("SET NAMES 'utf8'", $connect) OR $error = mysql_error();
  }

  if(empty($test) AND empty($error))
  return $connect;
  elseif(empty($test))
  cs_error_sql(__FILE__, 'cs_sql_connect', $error, 1);
  else
  return $error;
}

function cs_sql_count($cs_file, $sql_table, $sql_where = 0, $distinct = 0) {

  global $cs_db;
  $row = empty($distinct) ? '*' : 'DISTINCT ' . $distinct;

  $sql_query = 'SELECT COUNT(' . $row . ') FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  $sql_query .= empty($sql_where) ? '' : ' WHERE ' . $sql_where;

  $sql_query = str_replace('{pre}', $cs_db['prefix'], $sql_query);
  if (!$sql_data = mysql_query($sql_query, $cs_db['con'])) {
    cs_error_sql($cs_file, 'cs_sql_count', cs_sql_error(0, $sql_query));
    return NULL;
  }
  $sql_result = mysql_fetch_row($sql_data);
  mysql_free_result($sql_data);
  cs_log_sql($cs_file, $sql_query);
  return $sql_result[0];
}

function cs_sql_delete($cs_file, $sql_table, $sql_id, $sql_field = 0) {

  global $cs_db;
  settype($sql_id, 'integer');
  if (empty($sql_field)) {
    $sql_field = $sql_table . '_id';
  }
  $sql_delete = 'DELETE FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  $sql_delete .= ' WHERE ' . $sql_field . ' = ' . $sql_id;
  mysql_query($sql_delete, $cs_db['con']) or cs_error_sql($cs_file, 'cs_sql_delete', $cs_sql_error(0, $sql_delete));
  cs_log_sql($cs_file, $sql_delete, 1);
}

function cs_sql_escape($string) {

  global $cs_db;
  return mysql_real_escape_string((string) $string, $cs_db['con']);
}

function cs_sql_insert($cs_file, $sql_table, $sql_cells, $sql_content) {

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
    $set .= mysql_real_escape_string((string) $sql_content[$run], $cs_db['con']);
    if ($run != $max - 1) {
      $set .= "','";
    }
  }
  $set .= "')";

  $sql_insert = 'INSERT INTO ' . $cs_db['prefix'] . '_' . $sql_table . $set;
  mysql_query($sql_insert, $cs_db['con']) or cs_error_sql($cs_file, 'cs_sql_insert', cs_sql_error(0, $sql_insert));
  cs_log_sql($cs_file, $sql_insert);
}

function cs_sql_insertid($cs_file) {

  global $cs_db;
  $result = mysql_insert_id($cs_db['con']) or cs_error_sql($cs_file, 'cs_sql_insertid', cs_sql_error());
  return $result;
}

function cs_sql_option($cs_file, $mod) {

  global $cs_db;
  global $cs_template;
  static $options = array();

  if (empty($options[$mod])) {

    if (!$options[$mod] = cs_cache_load('op_' . $mod)) {

      $sql_query = 'SELECT options_name, options_value FROM  ' . $cs_db['prefix'] . '_' . 'options';
      $sql_query .= " WHERE options_mod = '" . $mod . "'";
      $sql_data = mysql_query($sql_query, $cs_db['con']) or cs_error_sql($cs_file, 'cs_sql_option', cs_sql_error(0, $sql_query), 1);

      while ($sql_result = mysql_fetch_assoc($sql_data)) {
        $name = $sql_result['options_name'];
        $new_result[$name] = $sql_result['options_value'];
      }
      mysql_free_result($sql_data);
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
  $sql_query = str_replace('{pre}', $cs_db['prefix'], $sql_query);
  if ($sql_data = mysql_query($sql_query, $cs_db['con'])) {
    $result = array('affected_rows' => mysql_affected_rows($cs_db['con']));
    if(!empty($more)) {
      while ($sql_result = mysql_fetch_assoc($sql_data)) {
        $result['more'][] = $sql_result;
      }
      mysql_free_result($sql_data);
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

  global $cs_db;
  $subtype = empty($cs_db['subtype']) ? 'myisam' : $cs_db['subtype'];
  #engine since 4.0.18, but collation works since 4.1.8
  $version = mysql_get_server_info($cs_db['con']) or cs_error_sql(__FILE__, 'cs_sql_replace', cs_sql_error(0, $sql_insert));
  $myv = explode('.', $version);
  settype($myv[2], 'integer');
  if($myv[0] > 4 OR $myv[0] == 4 AND $myv[1] > 1 OR $myv[0] == 4 AND $myv[1] == 1 AND $myv[2] > 7)
  $engine = ' ENGINE=' . $subtype . ' DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';
  else
  $engine = ' TYPE=' . $subtype . ' CHARACTER SET utf8';

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
  $first = ($first < 0) ? 0 : (int) $first;
  $max = ($max < 0) ? 20 : (int) $max;
  $run = 0;

  $sql_query = 'SELECT ' . $sql_select . ' FROM ' . $cs_db['prefix'] . '_' . $sql_table;
  if (!empty($sql_where)) {
    $sql_query .= ' WHERE ' . $sql_where;
  }
  if (!empty($sql_order)) {
    $sql_query .= ' ORDER BY ' . str_replace('{random}', 'RAND()', $sql_order);
  }
  if (!empty($max)) {
    $sql_query .= ' LIMIT ' . $first . ',' . $max;
  }
  $sql_query = str_replace('{pre}', $cs_db['prefix'], $sql_query);

  if (!$sql_data = mysql_query($sql_query, $cs_db['con'])) {
    cs_error_sql($cs_file, 'cs_sql_select', cs_sql_error(0, $sql_query));
    return NULL;
  }
  if ($max == 1) {
    $new_result = mysql_fetch_assoc($sql_data);
  } else {
    while ($sql_result = mysql_fetch_assoc($sql_data)) {
      $new_result[$run] = $sql_result;
      $run++;
    }
  }
  mysql_free_result($sql_data);
  cs_log_sql($cs_file, $sql_query);

  if (!empty($new_result)) {
    if (!empty($cache))
    cs_cache_save($cache, $new_result);

    return $new_result;
  }
  return NULL;
}

function cs_sql_update($cs_file, $sql_table, $sql_cells, $sql_content, $sql_id, $sql_where = 0, $sql_log = 1) {

  global $cs_db;
  settype($sql_id, 'integer');
  $max = count($sql_cells);
  $set = ' SET ';
  for ($run = 0; $run < $max; $run++) {
    $set .= $sql_cells[$run] . "='" . mysql_real_escape_string((string) $sql_content[$run], $cs_db['con']);
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
  mysql_query($sql_update, $cs_db['con']) or cs_error_sql($cs_file, 'cs_sql_update', cs_sql_error(0, $sql_update));

  cs_log_sql($cs_file, $sql_update, $sql_log);
}

function cs_sql_version($cs_file) {

  global $cs_db;
  $subtype = empty($cs_db['subtype']) ? 'myisam' : strtolower($cs_db['subtype']);
  $sql_infos = array('data_free' => 0, 'data_size' => 0, 'index_size' => 0, 'tables' => 0, 'names' => array());
  $sql_query = "SHOW TABLE STATUS LIKE '" . cs_sql_escape($cs_db['prefix'] . '_') . "%'";
  $sql_data = mysql_query($sql_query, $cs_db['con']) or cs_error_sql($cs_file, 'cs_sql_version', cs_sql_error(0, $sql_query));
  while($row = mysql_fetch_assoc($sql_data)) {
    $sql_infos['data_size'] += $row['Data_length'];
    $sql_infos['index_size'] += $row['Index_length'];
    $sql_infos['data_free'] += ($subtype == 'innodb') ? 0 : $row['Data_free'];
    $sql_infos['tables']++;
    $sql_infos['names'][] .= $row['Name'];
  }
  mysql_free_result($sql_data);
  cs_log_sql($cs_file, $sql_query);

  $sql_infos['encoding'] = mysql_client_encoding();
  $sql_infos['type'] = 'MySQL (mysql)';
  $sql_infos['subtype'] = empty($cs_db['subtype']) ? 'myisam' : $cs_db['subtype'];
  $sql_infos['client'] = mysql_get_client_info();
  $sql_infos['host'] = mysql_get_host_info($cs_db['con']) or cs_error_sql($cs_file, 'cs_sql_version', cs_sql_error());
  $sql_infos['server'] = mysql_get_server_info($cs_db['con']) or cs_error_sql($cs_file, 'cs_sql_version', cs_sql_error());
  return $sql_infos;
}

function cs_sql_error($object = 0, $query = 0) {

  global $cs_db;
  $error_string = mysql_error($cs_db['con']);
  if(!empty($query))
    $error_string .= ' --Query: ' . $query;
  return $error_string;
}