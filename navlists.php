<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

@error_reporting(E_ALL);

@ini_set('arg_separator.output','&amp;');
@ini_set('session.use_trans_sid','0');
@ini_set('session.use_cookies','1');
@ini_set('session.use_only_cookies','1');
@ini_set('display_errors','on');
@ini_set('magic_quotes_runtime','off');
if (substr(phpversion(), 0, 3) >= '5.1') {
  @date_default_timezone_set('Europe/Berlin');
}

$cs_micro = explode(' ', microtime()); # starting parsetime
$cs_logs = array('php_errors' => '', 'errors' => '', 'sql' => '', 'queries' => 0, 'warnings' => 0, 'dir' => 'logs');

require_once('system/core/functions.php');

$install_link = '<a href="install.php">Installation required</a>';
if(file_exists('setup.php')) {
	require_once('setup.php');
	require_once('system/database/' . $cs_db['type'] . '.php');
	$cs_db['con'] = cs_sql_connect($cs_db);

	if (empty($cs_main)) $cs_main = @cs_sql_option(__FILE__,'clansphere') OR die($install_link . ' or database error');

	require_once('system/core/servervars.php');
	require_once('system/output/xhtml_10_old.php');
	require_once('system/core/templates.php');
	require_once('system/core/content.php');
	require_once('system/core/tools.php');
	require_once('system/core/account.php');
	require_once('system/core/abcode.php');

	cs_tasks('system/extensions', 1); # load extensions
	cs_tasks('system/runstartup'); # load startup files
  
  $cs_main['show'] = '';
  
  if (empty($account['access_ajax'])) die('No access on AJAX');
  
  $where = "users_id_to = '" . $account['users_id'] . "' AND messages_show_receiver = '1' AND messages_view = '0'";
  $messages_count = cs_sql_count(__FILE__,'messages',$where);
  
  $ajaxes = explode(',',$cs_main['ajax_navlists']);
  array_pop($ajaxes);
  $string = str_replace(',','',$cs_main['ajax_navlists']);
  
  if (!empty($string)) {
    $temp = '';
    foreach ($ajaxes as $ajax)
    	$temp .= '!33/' . 'cs_' . $ajax . '!33/' . cs_filecontent('mods/' . str_replace('_','/',$ajax) . '.php');
    echo $temp;
  }
} else {
	echo $install_link . ' or missing setup.php';
}

?>