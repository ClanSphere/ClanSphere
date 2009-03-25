<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => true, 'init_tpl' => false, 'init_mod' => true);

chdir('../../');

require_once 'system/core/functions.php';

cs_init($cs_main);

chdir('mods/messages/');

$_GET['name'] = !empty($_GET['name']) ? cs_sql_escape($_GET['name']) : '';

$current = end(explode(';',$_GET['name']));
$old = substr($_GET['name'],0,strlen($_GET['name']) - strlen($current));
$old = htmlspecialchars($old);

if(!empty($current)) {
  $where = "users_nick LIKE '" . cs_sql_escape($current) . "%' AND users_active = \"1\" AND users_delete = \"0\"";
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

?>