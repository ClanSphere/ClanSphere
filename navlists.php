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

require 'system/core/functions.php';
@set_error_handler("php_error");

require 'system/core/servervars.php';
require 'system/core/content.php';
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

  require 'system/core/account.php';

  cs_tasks('system/extensions', 1); # load extensions
  cs_tasks('system/runstartup'); # load startup files

  $cs_main['debug'] = false;

  echo cs_template($cs_micro,$cs_main,$account);

  $cs_main['show'] = '';
  
  if (empty($account['access_ajax'])) die('No access on AJAX');
  
  $where = "users_id_to = '" . $account['users_id'] . "' AND messages_show_receiver = '1' AND messages_view = '0'";
  $messages_count = cs_sql_count(__FILE__,'messages',$where);
  
  if (isset($_GET['debug'])) {
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
      $name = !empty($special_names[$ajax]) ? $special_names[$ajax] : 'cs_' . $ajax;
      if (empty($specials[$ajax]))
        echo $temp .= '!33/' . $name . '!33/' . cs_filecontent('mods/' . str_replace('_','/',$ajax) . '.php');
      else {
        eval('$var = ' . $specials[$ajax] . ';');
        $temp .= '!33/' . $name . '!33/' . $var;
      }
    }
    echo $temp;
  }
}
else
  cs_error_internal('setup');

?>