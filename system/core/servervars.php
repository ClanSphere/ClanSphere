<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

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

if(!empty($_GET['params']{1})) {
  
  $params = explode('/', $_GET['params']);
  $_GET['mod'] = $params[1];
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
  if($_GET['mod'] == 'explorer') {
    $_GET['dir'] = substr(stristr($_GET['params'],'dir/'),4);
  }
}

function cs_servervars($mode, $integers = 0, $unharmed = 0) {
  
  $return = array();
  if (empty($unharmed)) $unharmed = array();
  $mode = strtolower($mode);
  $vars = $mode == 'post' ? $_POST : $_GET;
  if (is_string($integers)) $integers = explode(',',$integers);
  
  foreach ($vars AS $key => $value) {
    if (in_array($key, $unharmed)) { $return[$key] = $value; continue; }
    $return[$key] = in_array($key, $integers) ? (int) $value : cs_sql_escape($value);
  }
  //if ($mode == 'post') unset($_POST); else unset($_GET);
  
  return $return;
}

function cs_get($integers = 0, $unharmed = 0) { return cs_servervars('get',$integers,$unharmed); }
function cs_post($integers = 0, $unharmed = 0) { return cs_servervars('post',$integers,$unharmed); }

settype($_GET['id'],'integer');
settype($_REQUEST['id'],'integer');
settype($_REQUEST['fid'],'integer');
settype($_GET['cat_id'], 'integer');

/* Part that can be enabled after
 * including this function in the whole script
 *
$cs_post_hidden = $_POST;
$cs_get_hidden = $_GET;
 *
unset($_POST);
unset($_GET);
unset($_REQUEST);
 *
 *
*/

$_SERVER['PHP_SELF'] = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES);

$cs_main['def_path'] = getcwd();

$cs_main['php_self'] = pathinfo($_SERVER['PHP_SELF']);
$cs_main['php_self']['dirname'] = $cs_main['php_self']['dirname'] == '/' ? '/' : $cs_main['php_self']['dirname'] . '/';

// if (stristr(PHP_OS, 'WIN')) {
//   $cs_main['php_self']['dirname'] = str_replace($cs_main['php_self']['dirname'], '\\' , '');
//   $cs_main['php_self']['dirname'] = str_replace($cs_main['php_self']['dirname'], '\/\/' , '/');
// }

?>