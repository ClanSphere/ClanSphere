<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$  

@error_reporting(E_ALL);

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

chdir('mods/messages/');

$_GET['name'] = !empty($_GET['name']) ? cs_sql_escape($_GET['name']) : '';

$current = end(explode(';',$_GET['name']));
$old = substr($_GET['name'],0,strlen($_GET['name']) - strlen($current));

if(!empty($current)) {
  $where = "users_nick LIKE '" . cs_sql_escape($current) . "%'";
  $result = cs_sql_select(__FILE__,'users','users_nick',$where,0,0,10);  
  if(!empty($result)) {
    $out = '';
    foreach($result AS $value) {
      //$out .= cs_html_anchor(0, $value['users_nick'],'onclick="abc_set(\''. $old . $value['users_nick'] . '\', \'name\')"').',';
      $out .= '<a href="javascript:abc_set(\''. $old . $value['users_nick'] . '\', \'name\')">'. $value['users_nick'] . '</a>, ';
    }
    echo substr($out,0,-3);
  } 
}

?>