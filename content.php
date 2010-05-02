<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => true, 'init_tpl' => false, 'ajax_js' => '');

if (isset($_GET['debug'])) $cs_main['themebar'] = true;

require_once 'system/core/functions.php';

cs_init($cs_main);

header("Content-Type: text/html; charset=UTF-8");

global $cs_main, $account;

if (empty($cs_main['public']) and $account['access_clansphere'] < 3)
    $cs_main['show'] = 'mods/users/login.php';

if ($cs_main['mod'] == 'users' && $cs_main['action'] == 'logout') die(ajax_js('window.location.href=""'));
if (empty($account['access_ajax'])) die('No access on AJAX');

$temp = cs_filecontent($cs_main['show']);
$temp = cs_content_append($temp);
$temp = str_replace('action="#','action="index.php?',$temp);

$location = cs_url($cs_main['mod'],$cs_main['action']);
$cs_act_lang = cs_translate($cs_main['mod']); 
$temp .= '<a style="display:none" id="ajax_location" href="' . $location . '"></a>';
$temp .= '<div style="display:none" id="ajax_title">' . $cs_main['def_title'] . ' - ' . ucfirst($cs_act_lang['mod_name']) . '</div>';
$temp .= "\n" . '<div style="display: none;" id="ajax_scripts">' . (isset($cs_main['scripts']) ? $cs_main['scripts'] : '') . '</div>';

echo $temp;

function ajax_js($js) { return '<script type="text/javascript">' . $js . '</script>'; }

if (!empty($cs_main['ajax_js'])) echo ajax_js($cs_main['ajax_js']);

if (!isset($_GET['first'])) {
  echo '<div style="display:none" id="contenttemp">';
  
  include 'navlists.php';
  
  echo '</div>';
}