<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

if((substr(phpversion(), 0, 3) >= '5.0') AND (substr(phpversion(), 0, 3) < '6.0'))
  @error_reporting(E_ALL | E_STRICT);
else
  @error_reporting(E_ALL);

@ini_set('arg_separator.output','&amp;');
@ini_set('session.use_trans_sid','0');
@ini_set('session.use_cookies','1');
@ini_set('session.use_only_cookies','1');
@ini_set('display_errors','on');
@ini_set('magic_quotes_runtime','off');

if(substr(phpversion(), 0, 3) >= '5.1')
  @date_default_timezone_set('Europe/Berlin');

$cs_micro = explode(' ', microtime()); # starting parsetime
$cs_logs = array('php_errors' => '', 'errors' => '', 'sql' => '', 'queries' => 0, 'warnings' => 0, 'dir' => 'logs');

chdir('../../');
require 'system/core/functions.php';
@set_error_handler("php_error");

require 'system/core/servervars.php';
require 'system/core/tools.php';
require 'system/core/abcode.php';
require 'system/core/templates.php';
require 'system/output/xhtml_10_old.php';

if(file_exists('setup.php')) {
    
  require 'setup.php';
  require 'system/database/' . $cs_db['type'] . '.php';
  $cs_db['con'] = cs_sql_connect($cs_db);
  unset($cs_db['pwd']);
  unset($cs_db['user']);

  $cs_main = cs_sql_option(__FILE__,'clansphere');

  require 'system/core/content.php';
  require 'system/core/account.php';

  cs_tasks('system/extensions', 1); # load extensions
  cs_tasks('system/runstartup'); # load startup files

  $cs_main['debug'] = false;

  require 'mods/categories/functions.php';

  $mod = cs_sql_escape($_GET['mod']);

  echo cs_categories_dropdown2($mod,0,0);
}
else
  cs_error_internal('setup');

?>