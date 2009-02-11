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

settype($_GET['id'],'integer');
settype($_REQUEST['id'],'integer');
settype($_REQUEST['fid'],'integer');

if(empty($cs_main['def_path'])) {
	$cs_main['def_path'] = getcwd();
}

$cs_main['php_self'] = pathinfo($_SERVER['PHP_SELF']);
$cs_main['php_self']['dirname'] = $cs_main['php_self']['dirname'] == '/' ? '/' : $cs_main['php_self']['dirname'] . '/';

/*if (stristr(PHP_OS, 'WIN')) {
    $cs_main['php_self']['dirname'] = str_replace($cs_main['php_self']['dirname'], '\\' , '');
    $cs_main['php_self']['dirname'] = str_replace($cs_main['php_self']['dirname'], '\/\/' , '/');
}*/

$_SERVER['PHP_SELF'] = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES);

$cs_main['template'] = $cs_main['def_tpl'];
if(isset($_GET['template']) AND preg_match("=^[_a-z0-9-]+$=i",$_GET['template'])) {
  $cs_main['template'] = $_GET['template'];
}

if(!empty($_GET['mod'])) {
	$cs_main['mod'] = $_GET['mod'];
	$cs_main['action'] = empty($_GET['action']) ? 'list' : $_GET['action'];  
}
else {
  $cs_main['mod'] = $cs_main['def_mod'];
  $cs_main['action'] = $cs_main['def_action'];
  
  $parameters_split = explode('&',$cs_main['def_parameters']);
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

?>