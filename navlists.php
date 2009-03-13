<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$
/*
# Overwrite global settings by using the following array
$cs_main = array('init_sql' => false, 'init_tpl' => false);

require_once 'system/core/functions.php';

cs_init($cs_main);


global $cs_logs, $cs_main, $account;

$cs_main['show'] = '';
*/
if (empty($account['access_ajax'])) die('No access on AJAX');

if (isset($_GET['debug'])) {
  if (substr($cs_main['ajax_navlists'],-1) != ',') $cs_main['ajax_navlists'] .= ',';
	$cs_main['ajax_navlists'] .= 'func_sql,func_errors,';
}
$ajaxes = explode(',',$cs_main['ajax_navlists']);
array_pop($ajaxes);
$string = str_replace(',','',$cs_main['ajax_navlists']);

if (!empty($string)) {
  $temp = '';
  $specials = array('func_parse' => 'cs_parsetime($cs_micro)', 'func_queries' => $cs_logs['queries'], 'func_sql' => 'nl2br(htmlspecialchars($cs_logs[\'sql\']));',
    'func_errors' => 'nl2br($cs_logs["php_errors"] . $cs_logs["errors"])');
  $special_names = array('func_sql' => 'sql', 'func_errors' => 'errors');
  
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