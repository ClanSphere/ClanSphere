<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => true, 'init_tpl' => false);

require_once 'system/core/functions.php';

cs_init($cs_main);


global $cs_logs, $com_lang, $cs_main, $account;
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