<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

# check for and remove magic quotes
$mq_gpc = ini_get('magic_quotes_gpc');
if(!empty($mq_gpc)) {
  function cs_stripslashes($content) {
    $result = is_array($content) ? array_map('cs_stripslashes', $content) : stripslashes($content);
    return $result;
  }
  $_GET = cs_stripslashes($_GET);
  $_POST = cs_stripslashes($_POST);
  $_COOKIE = cs_stripslashes($_COOKIE);
  $_REQUEST = cs_stripslashes($_REQUEST);
}

# get and secure path environment information
$_SERVER['PHP_SELF'] = htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES);
$cs_main['def_path'] = getcwd();
$cs_main['php_self'] = pathinfo($_SERVER['SCRIPT_NAME']);
if($cs_main['php_self']['dirname']{0} == '\\')
  $cs_main['php_self']['dirname']{0} = '/';
$cs_main['php_self']['dirname'] = $cs_main['php_self']['dirname'] == '/' ? '/' : $cs_main['php_self']['dirname'] . '/';
  // workaround since filename is available as of php 5.2.0
if(!isset($cs_main['php_self']['filename']))
  $cs_main['php_self']['filename'] = substr($cs_main['php_self']['basename'], 0, strrpos($cs_main['php_self']['basename'], '.'));
$domain = htmlspecialchars($_SERVER['HTTP_HOST'], ENT_QUOTES);
$cs_main['php_self']['website'] = 'http://' . $domain;

# handle mod_rewrite params and split them for default usage
if(empty($_GET['mod']) AND empty($_GET['action'])) {
  if(empty($_GET['params']))
    $cs_main['php_self']['params'] = isset($_SERVER['REQUEST_URI']) ? substr($_SERVER['REQUEST_URI'], strlen($cs_main['php_self']['dirname'] . $cs_main['php_self']['filename'])) : '';
  else
    $cs_main['php_self']['params'] = $_GET['params'];
}
if(!empty($cs_main['php_self']['params']{1})) {

  $params = explode('/', $cs_main['php_self']['params']);
  $_GET['mod'] =  empty($params[1]) ? '' : $params[1];
  $_GET['action'] = empty($params[2]) ? 'list' : $params[2];
  $pm_cnt = count($params);

  for($i=3;$i<$pm_cnt;$i++) {
    if(!empty($params[$i]) AND !empty($params[($i+1)]) OR !isset($params[($i+1)])) {
      $value = isset($params[($i+1)]) ? $params[($i+1)] : 1;
      $_GET['' . $params[$i] . ''] = $value;
      $_REQUEST['' . $params[$i] . ''] = $value;
      $i++;
    }
  }
}

# define basic settings for cookies
$domain = (strpos($domain, '.') !== FALSE) ? $domain : '';
$port = strpos($domain, ':'); 
if ($port !== FALSE)
  $domain = substr($domain, 0, $port);
$cs_main['cookie'] = array('lifetime' => (cs_time() + 2592000), 'path' => $cs_main['php_self']['dirname'], 'domain' => $domain);

# set some request and get data to integer for backwards compatibility with old modules
settype($_GET['id'],'integer');
settype($_REQUEST['id'],'integer');
settype($_GET['sort'],'integer');
settype($_REQUEST['sort'],'integer');
# preserved for navlogin functionality
unset($_GET['style']);

# the following code is a perfect example for training wheel programming practices
# please try to avoid the usage of these functions
function cs_servervars($mode, $integers = 0, $unharmed = 0) {

  $return = array();
  if (empty($unharmed))
    $unharmed = array();
  $mode = strtolower($mode);
  $vars = $mode == 'post' ? $_POST : $_GET;
  if (is_string($integers))
    $integers = explode(',',$integers);
  if (!is_array($integers))
    $integers = array($integers);

  foreach ($vars AS $key => $value) {
    if (in_array($key, $unharmed)) { $return[$key] = $value; continue; }
    $return[$key] = in_array($key, $integers) ? (int) $value : cs_sql_escape($value);
  }
  //if ($mode == 'post') unset($_POST); else unset($_GET);

  return $return;
}

function cs_get($integers = 0, $unharmed = 0) {

  return cs_servervars('get',$integers,$unharmed);
}
function cs_post($integers = 0, $unharmed = 0) {

  return cs_servervars('post',$integers,$unharmed);
}