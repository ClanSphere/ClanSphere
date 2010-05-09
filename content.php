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

$content = cs_filecontent($cs_main['show']);

$cs_act_lang = cs_translate($cs_main['mod']); 

$json = array();
$json['title'] = $cs_main['def_title'] . ' - ' . ucfirst($cs_act_lang['mod_name']);
$json['location'] = str_replace('&debug','', preg_replace('/(.*?)content\.php\?(.*?)/s','\\2',$_SERVER['REQUEST_URI']) );
$json['scripts'] = isset($cs_main['ajax_js']) ? $cs_main['ajax_js'] : '';
$json['content'] = $content;

if (!isset($_GET['first'])) {
  
  require_once 'navlists.php';
  
  $json['navlists'] = $navlists;
  
}

echo json_encode($json);