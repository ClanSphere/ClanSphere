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

require('system/core/functions.php');

if (!file_exists('setup.php')) die('<a href="install.php">Installation required</a> or missing setup.php');

require('setup.php');
require('system/database/' . $cs_db['type'] . '.php');
$cs_db['con'] = cs_sql_connect($cs_db);

$cs_main = @cs_sql_option(__FILE__,'clansphere') OR die('<a href="install.php">Installation required</a> or database error');

require('system/core/servervars.php');
require('system/output/xhtml_10_old.php');
require('system/core/templates.php');
require('system/core/content.php');
require('system/core/tools.php');
require('system/core/account.php');
require('system/core/abcode.php');

cs_tasks('system/extensions', 1); # load extensions
cs_tasks('system/runstartup'); # load startup files

global $cs_logs, $com_lang, $cs_main;
$wp = $cs_main['php_self']['dirname'];
$mod = $cs_main['mod'];
$action = $cs_main['action'];
$get_axx = 'mods/' . $mod . '/access.php';

if (!file_exists($cs_main['show'])) {
  $message = 'cs_template - File not found';
  cs_error($cs_main['show'], $message);
  $cs_main['show'] = 'mods/errors/404.php';
} elseif (!file_exists($get_axx)) {
  $message = 'cs_template - Access file not found';
  cs_error($get_axx, $message);
  $cs_main['show'] = 'mods/errors/403.php';
} else {
  $axx_file = array();
  include($get_axx);
  if (!isset($axx_file[$action]))
  {
      $message = 'cs_template - No access defined for target file';
      cs_error($cs_main['show'], $message);
      $cs_main['show'] = 'mods/errors/403.php';
  } elseif (!isset($account['access_' . $mod])) {
      $message = 'cs_template - No module access defined in database';
      cs_error($cs_main['show'], $message);
      $cs_main['show'] = 'mods/errors/403.php';
  } elseif ($account['access_' . $mod] < $axx_file[$action]) {
      $cs_main['show'] = empty($account['users_id']) ? 'mods/users/login.php' : 'mods/errors/403.php';
  }
}

if (empty($cs_main['public']) and $account['access_clansphere'] < 3)
    $cs_main['show'] = 'mods/users/login.php';

if ($cs_main['mod'] == 'users' && $cs_main['action'] == 'logout') die('<div style="display:none" id="ajax_js">window.location.href=""</div>');
if (empty($account['access_ajax'])) die('No access on AJAX');

$cs_main['ajax_js'] = '';
$temp = cs_filecontent($cs_main['show']);
$temp = str_replace('action="#','action="index.php?',$temp);

$location = cs_url($cs_main['mod'],$cs_main['action']);
$temp .= '<a style="display:none" id="ajax_location" href="' . $location . '"></a>';
$temp .= '<div style="display:none" id="ajax_title">' . $cs_main['def_title'] . ' - ' . ucfirst($cs_main['mod']) . '</div>';

echo $temp;

function ajax_js($js) { return '<div style="display:none" id="ajax_js">' . $js . '</div>'; }

if (!empty($cs_main['ajax_js'])) echo ajax_js($cs_main['ajax_js']);

if (!isset($_GET['first'])) {
  echo '<div style="display:none" id="contenttemp">';
  
  include 'navlists.php';
  
  echo '</div>';
}

?>