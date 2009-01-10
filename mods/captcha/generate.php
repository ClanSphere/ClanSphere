<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

@error_reporting(E_ALL);

$cs_logs = array('errors' => '', 'sql' => '', 'queries' => 0, 'warnings' => 0, 'dir' => 'logs');

chdir('../../');
require_once('system/core/functions.php');
require_once('system/extensions/gd.php');

if(file_exists('setup.php')) {
	require_once('setup.php');
	require_once('system/database/' . $cs_db['type'] . '.php');
	$cs_db['con'] = cs_sql_connect($cs_db);
	$cs_main = cs_sql_option(__FILE__,'clansphere');
}
else
{
	die('<a href="install.php">Installation required</a> or missing setup.php');
}

chdir('mods/captcha/');

$hash = '';
$pattern = '1234567890abcdefghijklmnpqrstuvwxyz';
$max = isset($_GET['mini']) ? 3 : 6;
for($i=0;$i<$max;$i++) {
  $hash .= $pattern{rand(0,34)};
}
#$ip = cs_sql_escape($_SERVER['REMOTE_ADDR']);
$ip = cs_getip();
$timeout = cs_time() - 900;
$save_hash = isset($_GET['mini']) ? 'mini_' . $hash : $hash;

$where = "captcha_ip = '" . $ip . "' AND captcha_time < '" . $timeout . "'";
$old = cs_sql_select(__FILE__,'captcha','captcha_id',$where,'captcha_time DESC');

if(empty($old['captcha_id'])) {
  $captcha_cells = array('captcha_time','captcha_string','captcha_ip');
  $captcha_save = array(cs_time(),$save_hash,$ip);
  cs_sql_insert(__FILE__,'captcha',$captcha_cells,$captcha_save);
}
else {
  $captcha_cells = array('captcha_time','captcha_string');
  $captcha_save = array(cs_time(),$save_hash);
  cs_sql_update(__FILE__,'captcha',$captcha_cells,$captcha_save,$old['captcha_id']);
}
cs_sql_query(__FILE__,"DELETE FROM {pre}_captcha WHERE captcha_time < '" . $timeout . "'");
cs_captcha($hash);
?>