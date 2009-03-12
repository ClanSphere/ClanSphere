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

$where = "users_id_to = '" . $account['users_id'] . "' AND messages_show_receiver = '1' AND messages_view = '0'";
$messages_count = cs_sql_count(__FILE__,'messages',$where);

if (isset($_GET['debug'])) {
  if (substr($cs_main['ajax_navlists'],-1) != ',') $cs_main['ajax_navlists'] .= ',';
	$cs_main['ajax_navlists'] .= 'func_sql,func_errors,';
}
echo $cs_main['ajax_navlists'];
$ajaxes = explode(',',$cs_main['ajax_navlists']);
array_pop($ajaxes);
$string = str_replace(',','',$cs_main['ajax_navlists']);

if (!empty($string)) {
  $temp = '';
  $specials = array('func_parse' => 'cs_parsetime($cs_micro)', 'func_queries' => $cs_logs['queries'], 'func_sql' => 'nl2br(htmlspecialchars($cs_logs[\'sql\']));',
    'func_errors' => 'nl2br($cs_logs["php_errors"] . $cs_logs["errors"])');
  $special_names = array('func_sql' => 'sql', 'func_errors' => 'errors');
  
  foreach ($ajaxes as $ajax) {
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