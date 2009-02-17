<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

function cs_error($file,$message) {

  global $cs_logs;
  if(!empty($cs_logs['save_errors'])) {
    $log = $file . "\n" . $message . "\n";
    $log .= $_SERVER['QUERY_STRING'] . "\n";
    $log .= $_SERVER['SERVER_SOFTWARE'] . "\n";
    $log .= $_SERVER['REMOTE_ADDR'] . "\n";
    $log .= $_SERVER['HTTP_USER_AGENT'] . "\n";
    cs_log('errors',$log);
  }
  $cs_logs['errors'] .= 'Error: ' . $file . ' -> ' . $message . "\n";
}

function cs_error_sql($file,$part,$message,$stop = 0) {

  global $cs_db;
  if(empty($message)) {
    $message = 'Database connection error';
  }
  $cs_db['last_error'] = $part . ' - ' . $message;
  cs_error($file,$cs_db['last_error']);

  if(!empty($stop)) {
    die($message);
  }
}

// Array walking with refereced altering
function cs_int_walk(&$item, $key) {
    $item = (int)$item;
}
  
function cs_log($target,$content) {

  global $cs_logs;
  $full_path = $cs_logs['dir'] . '/' . $target;
  if(is_writeable($full_path . '/')) {
    $log = "-------- \n" . date('H:i:s') . "\n" . $content;
    $log_file = $full_path . '/' . date('Y-m-d') . '.log';
    $save_error = fopen($log_file,'a');
    fwrite($save_error,$log);
    fclose($save_error);
    chmod($log_file,0644);
  }
  else {
    $msg = 'cs_log - Unable to write into directory -> ' . $full_path;
    $cs_logs['errors'] .= $msg . "\n";
  }
}

function cs_log_sql($sql,$action = 0) {

  global $cs_logs, $account;
  $cs_logs['queries']++;
  $cs_logs['sql'] .= $sql . "\n";

  if(!empty($action) AND !empty($cs_logs['save_actions'])) {
    $log = 'USERS_ID ' . $account['users_id'] . "\n" . $sql . "\n";
    cs_log('actions',$log);
  }
}

function cs_warning($message) {

  global $cs_logs;
  static $last_warning = array();
  if(!empty($cs_logs['warnings']) AND !isset($last_warning[$message])) {
    $cs_logs['errors'] .= 'Warning: ' . $message . "\n";
    $last_warning[$message] = 1;
  }
}

function cs_parsetime($micro) {

  $new_time = explode(' ', microtime());
  $getparse = $new_time[1] + $new_time[0] - $micro[0] - $micro[1];
  $getparse = round($getparse,3) * 1000;
  return $getparse;
}

function cs_tasks($dir, $check = 0) {

  $goal = opendir($dir . '/');
  while(false !== ($filename = readdir($goal))) {
    if($filename != '.' AND $filename != '..' AND $filename != '.svn') {
      if(empty($check) OR 
      extension_loaded(substr($filename, 0, strpos($filename, '.php')))) {
        include_once($dir . '/' . $filename);
      }
    }
  }
  closedir($goal);
}

function cs_time() {

  $time = time() - date('Z');
  return $time;
}

function cs_getip () {

  if (getenv('HTTP_CLIENT_IP'))
    $ip = getenv('HTTP_CLIENT_IP');
  elseif (getenv('HTTP_X_FORWARDED_FOR'))
    $ip = getenv('HTTP_X_FORWARDED_FOR');
  elseif (getenv('HTTP_X_FORWARDED'))
    $ip = getenv('HTTP_X_FORWARDED');
  elseif (getenv('HTTP_FORWARDED_FOR'))
    $ip = getenv('HTTP_FORWARDED_FOR');
  elseif (getenv('HTTP_FORWARDED'))
    $ip = getenv('HTTP_FORWARDED');
  else
    $ip = $_SERVER['REMOTE_ADDR'];
  return $ip;
}

// Log_error
function php_error($errno, $errmsg, $filename, $linenum) {
 
  global $cs_main;
   global $cs_logs;
 
  $errortype = Array(
      E_ERROR    => 'Error',
    E_WARNING   => 'Warning',
    E_PARSE    => 'Parsing Error',
    E_NOTICE   => 'Notice',
    E_CORE_ERROR  => 'Core Error',
    E_CORE_WARNING  => 'Core Warning',
    E_COMPILE_ERROR  => 'Compile Error',
    E_COMPILE_WARNING => 'Compile Warning',
    E_USER_ERROR  => 'User Error',
    E_USER_WARNING  => 'User Warning',
    E_USER_NOTICE  => 'User Notice',
    );
    // Added E_Strict for PHP 5 Version
    if (substr(phpversion(), 0, 3) >= '5.0') {
      $errortype['2048'] = 'Strict Notice/Error';
  }
  $error = $errortype[$errno] . ": " . $errmsg . " in " . $filename . " on line " . $linenum . "\r\n";
  $cs_logs['php_errors'] .= '<strong>PHP-Warning:</strong> ' . $error . "<br />";
}

?>