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

  chdir('mods/messages/');
  
  $_GET['name'] = !empty($_GET['name']) ? cs_sql_escape($_GET['name']) : '';
  
  $current = end(explode(';',$_GET['name']));
  $old = substr($_GET['name'],0,strlen($_GET['name']) - strlen($current));
  $old = htmlspecialchars($old);
  
  if(!empty($current)) {
    $where = "users_nick LIKE '" . cs_sql_escape($current) . "%'";
    $result = cs_sql_select(__FILE__,'users','users_nick',$where,0,0,10);  
    if(!empty($result)) {
      $out = '';
      foreach($result AS $value) {
        //$out .= cs_html_anchor(0, $value['users_nick'],'onclick="abc_set(\''. $old . $value['users_nick'] . '\', \'name\')"').',';
        $out .= '<a href="javascript:abc_set(\''. $old . $value['users_nick'] . '\', \'name\')">'. $value['users_nick'] . '</a>, ';
      }
      echo substr($out,0,-2);
    } 
  }
}
else
  cs_error_internal('setup');

?>