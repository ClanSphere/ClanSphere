<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_error($file, $message, $log_only = 0) {

  global $cs_logs;
  $remote_ip = cs_getip();
  if(!empty($cs_logs['save_errors'])) {
    $log = $file . "\n" . $message . "\n";
    $log .= isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] . "\n" : "unknown\n";
    $log .= isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] . "\n" : "unknown\n";
    $log .= !empty($remote_ip) ? $remote_ip . "\n" : "unknown\n";
    $log .= isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] . "\n" : "unknown\n";
    cs_log('errors',$log);
  }
  if(empty($log_only))
    $cs_logs['errors'] .= 'Error: ' . $file . ' -> ' . $message . "\n";
}

function cs_error_internal($error = 0, $report = 0) {

  global $account, $com_lang, $cs_db, $cs_main, $cs_micro;

  $cs_main['error_internal'] = $error;
  $cs_main['error_reported'] = $report;

  $cs_main['def_title'] = 'ClanSphere';
  $cs_main['def_tpl'] = 'install';
  $cs_main['mod'] = 'errors';
  $cs_main['action'] = '500';
  $cs_main['show'] = 'mods/errors/500.php';
  $cs_main['public'] = 1;
  $cs_main['def_width'] = '100%';
  $cs_main['ajax'] = 0;

  if(!empty($cs_main['init_mod'])) {
    chdir('../../');
    $cs_main['php_self']['dirname'] .= '../../';
  }

  require_once 'system/cache/' . $cs_main['cache_mode'] . '.php';

  if(empty($account['users_lang']))
    $account = array('users_id' => 0, 'access_clansphere' => 0, 'access_errors' => 0, 'users_lang' => $cs_main['def_lang']);
  
  echo cs_template($cs_micro, 'error.htm');
}

function cs_error_sql($cs_file,$part,$message,$stop = 0) {

  global $cs_db;
  if(empty($message)) {
    $message = 'Database connection error';
  }
  $cs_db['last_error'] = $part . ' - ' . $message;
  cs_error($cs_file,$cs_db['last_error']);

  if(!empty($stop)) {
    die(cs_error_internal('sql', $message));
  }
}

function cs_content_prepare($cs_main) {

  if(!empty($_GET['mod'])) {
    $cs_main['mod'] = $_GET['mod'];
    $cs_main['action'] = empty($_GET['action']) ? 'list' : $_GET['action'];  
  }
  else {
    $cs_main['mod'] = $cs_main['def_mod'];
    $cs_main['action'] = $cs_main['def_action'];

    $parameters_split = empty($cs_main['def_parameters']) ? array() : explode('&', $cs_main['def_parameters']);

    foreach($parameters_split AS $parameter) {
      if(empty($parameter))
        break;
      $par_array = explode('=',$parameter);
      $_GET[$par_array[0]] = empty($_GET[$par_array[0]]) ? $par_array[1] : $_GET[$par_array[0]];
    }
  }

  if(!preg_match("=^[_a-z0-9-]+$=i",$cs_main['mod']) OR !preg_match("=^[_a-z0-9-]+$=i",$cs_main['action'])) {
    $cs_main['mod'] = 'errors';
    $cs_main['action'] = '404';
  }

  $cs_main['show'] = 'mods/' . $cs_main['mod'] . '/' . $cs_main['action'] . '.php';

  return $cs_main;
}

function cs_content_check ($cs_main) {

  global $account;
  $get_axx = 'mods/' . $cs_main['mod'] . '/access.php';
  if (!file_exists($cs_main['show'])) {
    if (!empty($cs_main['notfound_info']))
      cs_error($cs_main['show'], 'cs_content_check - File not found');
    $cs_main['show'] = 'mods/errors/404.php';
  }
  elseif (!file_exists($get_axx)) {
    cs_error($get_axx, 'cs_content_check - Access file not found');
    $cs_main['show'] = 'mods/errors/403.php';
  }
  else {
    $axx_file = array();
    include($get_axx);
    if (!isset($axx_file[$cs_main['action']])) {
      cs_error($cs_main['show'], 'cs_content_check - No access defined for target file');
      $cs_main['show'] = 'mods/errors/403.php';
    }
    elseif (!isset($account['access_' . $cs_main['mod']])) {
      cs_error($cs_main['show'], 'cs_content_check - No module access defined in database');
      $cs_main['show'] = 'mods/errors/403.php';
    }
    elseif ($account['access_' . $cs_main['mod']] < $axx_file[$cs_main['action']]) {
      $cs_main['show'] = empty($account['users_id']) ? 'mods/users/login.php' : 'mods/errors/403.php';
    }
  }

  return $cs_main;
}

function cs_content_append ($content) {

  global $account, $cs_main;
  if(!empty($cs_main['sec_remote']) AND $account['access_clansphere'] > 4 AND
    ($cs_main['sec_news'] > $cs_main['sec_last'] OR (cs_time() - $cs_main['sec_time']) > 9000)) {
    require_once 'mods/clansphere/sec_func.php';
    $content = cs_cspnews() . $content;
  }
  
  if(($cs_main['action'] == 'manage' OR $cs_main['action'] == 'create' OR $cs_main['action'] == 'options') AND 
    isset($account['access_' . $cs_main['mod']]) AND $account['access_' . $cs_main['mod']] >= 3) {
    require_once 'mods/clansphere/admin_menu.php';
    $content = cs_admin_menu() . $content;
  }

  if($account['access_clansphere'] > 3 AND file_exists('install.php') AND !file_exists('.git'))
    $content = cs_subtemplate(__FILE__, array(), 'clansphere', 'del_install') . $content;

  return $content;
}

function cs_content_lang () {

  global $account, $com_lang, $cs_main;

  $lang = empty($account['users_id']) ? $cs_main['def_lang'] : $account['users_lang'];

  if(empty($account['users_id']) AND !empty($_COOKIE['cs_lang']))
  {
    $lang_new = $_COOKIE['cs_lang'];
  }
  if(!empty($_REQUEST['lang']))
  {
    $lang_new = $_REQUEST['lang'];
  }

  if(!empty($lang_new)) {
    $allow = 0;
    $languages = cs_checkdirs('lang');

    foreach($languages as $mod)
      if($mod['dir'] == $lang_new)
        $allow++;

    $lang = empty($allow) ? $cs_main['def_lang'] : $lang_new;

    # update language changes
    if(empty($account['users_id'])) {
      setcookie('cs_lang', $lang, $cs_main['cookie']['lifetime'], $cs_main['cookie']['path'], $cs_main['cookie']['domain']);
    }
    elseif($account['users_lang'] != $lang) {
      $users_cells = array('users_lang');
      $users_save = array($lang);
      cs_sql_update(__FILE__,'users',$users_cells,$users_save,$account['users_id'], 0, 0);
    }
  }

  require_once 'lang/' . $lang . '/system/comlang.php';
  return $lang;
}

function cs_init($predefined) {

  @error_reporting(E_ALL | E_STRICT);
  @set_error_handler("php_error");

  @ini_set('short_open_tag','off');
  @ini_set('arg_separator.output','&amp;');
  @ini_set('session.use_trans_sid','0');
  @ini_set('session.use_cookies','1');
  @ini_set('session.use_only_cookies','1');
  @ini_set('display_errors','on');

  $phpversion = phpversion();
  if(version_compare($phpversion, '5.1', '>='))
    @date_default_timezone_set('Europe/Berlin');

  global $account, $com_lang, $cs_db, $cs_logs, $cs_main, $cs_micro, $cs_template;

  $cs_micro = explode(' ', microtime()); # starting parsetime
  $cs_logs = array('php_errors' => '', 'errors' => '', 'sql' => '', 'queries' => 0, 'warnings' => 1, 'dir' => 'uploads/logs');
  $cs_main['cellspacing'] = 1;
  $cs_main['def_lang'] = empty($cs_main['def_lang']) ? 'English' : $cs_main['def_lang'];
  $cs_main['def_theme'] = 'base';
  $cs_main['xsrf_protection'] = true;
  $cs_main['zlib'] = true;
  
  require_once 'system/core/servervars.php';

  $cs_main['ajaxrequest'] = isset($_REQUEST['xhr']) ? true : false;

  require_once 'system/core/tools.php';
  require_once 'system/core/abcode.php';
  require_once 'system/core/templates.php';
  require_once 'system/core/gd.php';

  require_once 'system/core/cachegen.php';
  $cs_main['cache_mode'] = 'file';

  if(version_compare($phpversion, '5.0', '<'))
    require_once 'mods/clansphere/fallback.php';

  if($cs_main['php_self']['basename'] == 'install.php')
    $account = array('users_id' => 0, 'access_clansphere' => 0, 'access_errors' => 2, 'access_install' => 5);
  else
    file_exists('setup.php') ? require_once 'setup.php' : die(cs_error_internal('setup', '<a href="' . $cs_main['php_self']['dirname'] . 'install.php">Installation</a>'));

  if(!in_array($cs_main['cache_mode'], array('file', 'none')) AND !extension_loaded($cs_main['cache_mode']))
    $cs_main['cache_mode'] = 'file';
  require_once 'system/cache/' . $cs_main['cache_mode'] . '.php';

    if(empty($cs_main['charset'])) {
    $cs_main['charset'] = 'UTF-8';
    die(cs_error_internal(0,'No charset information found in setup.php'));
  }

  # backfall if json extension is not available
  if(!extension_loaded('json'))
    require_once 'system/output/json.php';

  require_once 'system/output/xhtml_10.php';
  # add old xhtml functions if needed
  if(!empty($cs_main['xhtml_old']))
    require_once 'system/output/xhtml_10_old.php';
  
  if(!empty($predefined['init_sql'])) {

    require_once 'system/database/' . $cs_db['type'] . '.php';

    $cs_db['con'] = cs_sql_connect($cs_db);
    unset($cs_db['pwd'], $cs_db['user']);

    $cs_options = cs_sql_option(__FILE__,'clansphere');
    
    $cs_options['unicode'] = extension_loaded('unicode') ? 1 : 0;
    if(!isset($cs_options['cache_unicode']) OR $cs_options['cache_unicode'] != $cs_options['unicode'])
      cs_cache_clear();
  }
  else
    $cs_options = array();

  $cs_main = array_merge($cs_main, $cs_options, $predefined);

  if(empty($cs_main['def_path']))
    $cs_main['def_path'] = getcwd();

  # process mod and action data
  $cs_main = cs_content_prepare($cs_main);

  if(!empty($predefined['init_sql'])) {
    require_once 'system/core/account.php';
    $cs_main['def_theme'] = empty($account['users_theme']) ? $cs_main['def_theme'] : $account['users_theme']; 
  }
  
  # determine users language
  $account['users_lang'] = cs_content_lang();

  if(!empty($predefined['init_sql'])) {
    # check for deprecated runstartup behavior
    if(!empty($cs_main['runstartup']))
      cs_tasks('system/runstartup');

    # fetch startup files
    $startup = cs_cache_load('startup');
    # fallback to create startup files overview
    if($startup == false) {
      $startup = cs_cache_dirs('mods', $account['users_lang'], 1);
    }
    # execute startup files
    if(is_array($startup)) {
      foreach($startup AS $mod) {
        $file = $cs_main['def_path'] . '/mods/' . $mod . '/startup.php';
        file_exists($file) ? include_once $file : cs_error($file, 'cs_init - Startup file not found');
      }
    }
  }

  # search for possible mod and action errors
  $cs_main = cs_content_check($cs_main);

  $cs_main['template'] = empty($cs_main['def_tpl']) ? 'clansphere' : $cs_main['def_tpl'];
  $cs_template = cs_template_info($cs_main['template']);
  if(!empty($_GET['template']) AND preg_match("=^[_a-z0-9-]+$=i",$_GET['template']))
    $cs_main['template'] = $_GET['template'];

  if(!empty($predefined['init_tpl'])) {
    if ($cs_main['ajaxrequest'] === true) {
      echo cs_ajaxwrap();
    }
    else
      echo cs_template($cs_micro, $cs_main['tpl_file']);
  }
}

function cs_title() {

  # Provides the page title with as many information as possible
  global $cs_main;
  $title = htmlentities($cs_main['def_title'], ENT_QUOTES, $cs_main['charset']);

  if($cs_main['mod'] != 'static' OR $cs_main['action'] != 'view') {
    $cs_act_lang = substr($cs_main['show'],0,11) == 'mods/errors' ? cs_translate('errors') : cs_translate($cs_main['mod']);
    $title .= ' - ' . $cs_act_lang['mod_name'];

    if(empty($cs_main['page_title']) AND isset($cs_act_lang['' . $cs_main['action'] . '']))
    $title .= ' - ' . $cs_act_lang['' . $cs_main['action'] . ''];
  }

  if(!empty($cs_main['page_title']))
    $title .= ' - ' . htmlentities($cs_main['page_title'], ENT_QUOTES, $cs_main['charset']);

  return $title;
}

function cs_ajaxwrap() {

  global $cs_main, $account;
  $json = array();

  header('Content-Type:application/json');

  if (empty($cs_main['public']) and $account['access_clansphere'] < $cs_main['maintenance_access'])
  {
    return json_encode(array('location' => '', 'reload' => 1));
  }
  if(!isset($_REQUEST['xhr_nocontent'])) {

    $content = cs_contentload($cs_main['show']);

    $json['title'] = html_entity_decode(cs_title(), ENT_NOQUOTES, $cs_main['charset']);

    $pathPrefix = str_replace('\\','/',$cs_main['php_self']['dirname'] . $cs_main['php_self']['filename']) . '/';

    $uri = preg_replace('/^(.*?)\.php\??(.*?)$/s','\\2',$_SERVER['REQUEST_URI']) ;  
    $uri = preg_replace('/[&\?\/]?(xhr_navlists[=\/])[^&\/]*/s','', $uri);
    $uri = str_replace(array('&xhr=1', '/xhr/1', '&xhr_nocontent=1', 'params=/', '/params//',$pathPrefix),'', $uri);
    $uri = preg_replace('/' . str_replace('/','\/', $cs_main['php_self']['dirname']) . '/s', '',$uri, 0);    

    $json['location'] = $uri;

    if(isset($cs_main['ajax_js'])) {
      $json['scripts'] = $cs_main['ajax_js'];
    }
    $json['content'] = $content;
  }

  if(isset($_REQUEST['xhr_navlists'])) {
    $navs = explode(',', $_REQUEST['xhr_navlists']);
    $navlists = array();
    foreach($navs AS $nav) {
      $navlist = explode('-',$nav);
      if($navlist[1]!='func') {
        $navlists[$nav] = cs_templatefile($navlist);
      }      
    }
    $json['navlists'] = $navlists;
  }

  if (!empty($cs_main['debug'])) {
    global $cs_logs;
    $cs_logs['php_errors'] = nl2br($cs_logs['php_errors']);
    $cs_logs['errors'] = nl2br($cs_logs['errors']);

    $data = array('data');
    $data['data']['log_sql'] = cs_log_format('sql');
    $data['data']['php_errors'] = $cs_logs['php_errors'];
    $data['data']['csp_errors'] = $cs_logs['errors'];
    $json['debug'] = cs_subtemplate(__FILE__, $data, 'clansphere', 'debug');
  }

  return json_encode($json);
}


function cs_contentload($file) {

  global $account, $cs_main;
  if(empty($cs_main['public']) and $account['access_clansphere'] < $cs_main['maintenance_access'])
    $file = 'mods/users/login.php';

  $content = str_replace(array('{', '}'), array('&#123;', '&#125;'), cs_filecontent($file));
  $content = preg_replace_callback('/<script([^>]*?)>(.*?)<\/script>/is', 'cs_revert_script_braces', $content);

  return cs_content_append($content);
}

function cs_log($target,$content) {

  global $cs_logs, $cs_main;
  $full_path = $cs_logs['dir'] . '/' . $target;
  if(is_writeable($full_path . '/')) {
    $log = "-------- \n" . date('H:i:s') . "\n" . $content;
    $log_file = $full_path . '/' . date('Y-m-d') . '.log';
    $save_error = fopen($log_file,'a');
    # set stream encoding if possible to avoid converting issues
    if(function_exists('stream_encoding'))
      stream_encoding($save_error, $cs_main['charset']);
    fwrite($save_error,$log);
    fclose($save_error);
    chmod($log_file, 0755);
  }
  else {
    $msg = 'cs_log - Unable to write into directory -> ' . $full_path;
    $cs_logs['errors'] .= $msg . "\n";
  }
}

function cs_log_sql($file, $sql, $action = 0) {

  global $cs_logs, $account;
  $cs_logs['queries']++;
  $new = $cs_logs['queries'] . ') ' . $sql . "\n";
  $cs_logs['sql'][$file] = isset($cs_logs['sql'][$file]) ? $cs_logs['sql'][$file] . $new : $new;

  if(!empty($action) AND !empty($cs_logs['save_actions'])) {
    $log = 'USERS_ID ' . $account['users_id'] . "\n" . $sql . "\n";
    cs_log('actions',$log);
  }
}

function cs_log_format($part, $addslashes = 0) {

  global $cs_logs, $cs_main;
  $log = '';
  if(is_array($cs_logs[$part])) {
    foreach($cs_logs[$part] AS $file => $content) {
      if(!empty($addslashes))
        $file = str_replace('\\', '\\\\', $file);
      $log .= cs_html_big(1) . $file . cs_html_big(0) . cs_html_br(1);
      $log .= nl2br(htmlentities($content, ENT_QUOTES, $cs_main['charset']));
    }
    return $log;
  }
  else
    return '';
}

function cs_warning($message) {

  global $cs_logs;
  static $last_warning = array();
  if(!empty($cs_logs['warnings']) AND !isset($last_warning[$message])) {
    $cs_logs['errors'] .= 'Warning: ' . $message . "\n";
    $last_warning[$message] = 1;
  }
}

function cs_parsetime($micro, $precision = 3) {

  $new_time = explode(' ', microtime());
  $getparse = $new_time[1] + $new_time[0] - $micro[0] - $micro[1];
  $getparse = round($getparse,$precision) * 1000;
  return $getparse;
}

function cs_tasks($dir) {

  global $cs_main;
  if($goal = opendir($cs_main['def_path'] . '/' . $dir . '/')) {
    while(false !== ($filename = readdir($goal))) {
      if($filename != '.' AND $filename != '..' AND $filename != '.git')
        include_once $dir . '/' . $filename;
    }
    closedir($goal);
  }
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
    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 0;

  // check for multiple ip's in case of multiple x-forwarders
  $pos = stripos($ip, ',');
  if ($pos !== false)
    $ip = trim(substr($ip, 0, $pos));
  // possible extra flags: FILTER_FLAG_NO_PRIV_RANGE, FILTER_FLAG_NO_RES_RANGE
  if (function_exists('filter_var') AND filter_var($ip, FILTER_VALIDATE_IP) === false)
    $ip = 0;

  return $ip;
}

function php_error($errno, $errmsg, $filename, $linenum) {

  global $cs_logs, $cs_main;

  $silent = (error_reporting() === 0) ? 1 : 0;

  $errortype = Array(
    E_ERROR           => 'Error',
    E_WARNING         => 'Warning',
    E_PARSE           => 'Parsing Error',
    E_NOTICE          => 'Notice',
    E_CORE_ERROR      => 'Core Error',
    E_CORE_WARNING    => 'Core Warning',
    E_COMPILE_ERROR   => 'Compile Error',
    E_COMPILE_WARNING => 'Compile Warning',
    E_USER_ERROR      => 'User Error',
    E_USER_WARNING    => 'User Warning',
    E_USER_NOTICE     => 'User Notice',
  );

  // Added E_Strict for PHP 5 Version
    $errortype['2048'] = 'Strict Notice/Error';

  // Added E_RECOVERABLE_ERROR for PHP 5.2.0 Version
  if (substr(phpversion(), 0, 3) >= '5.2')
    $errortype['4096'] = 'Recoverable Error';

  // Added E_DEPRECATED & E_USER_DEPRECATED for PHP 5.3.0 Version
  if (substr(phpversion(), 0, 3) >= '5.3') {
    $errortype['8192'] = 'Deprecate Notice';
    $errortype['16384'] = 'User Deprecated Warning';
  }

  $error = empty($silent) ? '' : '(@) ';
  $error .= $errortype[$errno] . ": " . $errmsg . " in " . $filename . " on line " . $linenum . "\r\n";
  $cs_logs['php_errors'] = empty($cs_logs['php_errors']) ? '' : $cs_logs['php_errors'];
  $cs_logs['php_errors'] .= '<strong>PHP-Warning:</strong> ' . $error . "<br />";
  if(empty($silent))
    cs_error($filename, 'PHP ' . $errortype[$errno] . ' on line ' . $linenum . ' -> ' . trim($errmsg), 1);
}