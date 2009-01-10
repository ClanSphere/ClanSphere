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
@date_default_timezone_set('Europe/Berlin');

$cs_logs = array('errors' => '', 'sql' => '', 'queries' => 0, 'warnings' => 0, 'dir' => 'logs');

chdir('../../');
require_once('system/core/functions.php');

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

require('system/output/xhtml_10.php');
require('mods/categories/functions.php');

$mod = cs_sql_escape($_GET['mod']);

echo cs_categories_dropdown2($mod,0,0);

?>