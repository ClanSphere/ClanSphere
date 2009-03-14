<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

if (strpos($_SERVER['PHP_SELF'], 'content.php') === false) {
  $cs_main = array('init_sql' => true, 'init_tpl' => false);
  require_once 'system/core/functions.php';

  cs_init($cs_main);
}

if (empty($account['access_ajax'])) die('No access on AJAX');

if (isset($_GET['debug'])) {
  if (substr($cs_main['ajax_navlists'],-1) != ',') $cs_main['ajax_navlists'] .= ',';
	$cs_main['ajax_navlists'] .= 'func_sql,func_errors,';
}

$ajaxes = explode(',',$cs_main['ajax_navlists']);
array_pop($ajaxes);
$string = str_replace(',','',$cs_main['ajax_navlists']);

$logsql = '';
if (!empty($cs_main['developer']) OR $account['access_clansphere'] > 4) {
  $cs_logs['php_errors'] = str_replace('\'','\\\'',nl2br($cs_logs['php_errors']));
  $cs_logs['errors'] = str_replace('\'','\\\'',nl2br($cs_logs['errors']));
  foreach($cs_logs['sql'] AS $sql_file => $sql_queries) {
    $logsql .= cs_html_big(1) . $sql_file . cs_html_big(0) . cs_html_br(1);
    $logsql .= nl2br(cs_secure($sql_queries));
  }
} else {
  $cs_logs['php_errors'] = '';
  $cs_logs['errors'] = 'Developer mode is turned off';
}

if (!empty($string)) {
  $temp = '';
  $specials = array('func_parse' => 'cs_parsetime($cs_micro)', 'func_queries' => '2', 'func_sql' => '\'' . $logsql . '\'',
    'func_errors' => '\'' . $cs_logs["php_errors"] . $cs_logs["errors"] . '\'');
  $special_names = array('func_errors' => 'errors', 'func_sql' => 'sql');
  
  foreach ($ajaxes as $ajax) {
    if (empty($ajax)) continue;
  	$name = !empty($special_names[$ajax]) ? $special_names[$ajax] : 'cs_' . $ajax;
    if (empty($specials[$ajax])) {
      $temp .= '!33/' . $name . '!33/' . cs_filecontent('mods/' . str_replace('_','/',$ajax) . '.php');
    } else {
      eval('$var = ' . $specials[$ajax] . ';');
      $temp .= '!33/' . $name . '!33/' . $var;
    }
  }
  echo $temp;
}

?>