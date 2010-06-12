<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

# This can be set to e.g. 'ISO-8859-15', but ClanSphere prefers unicode
$charset = 'UTF-8';

# Overwrite global settings by using the following array
$cs_main = array( 'charset'         => $charset,
                  'def_action'      => 'list',
                  'def_mod'         => 'install',
                  'def_title'       => 'ClanSphere Installation',
                  'def_tpl'         => 'install',
                  'def_parameters'  => '',
                  'def_width'       => '100%',
                  'init_sql'        => false,
                  'init_tpl'        => false,
                  'public'          => 1,
                  'img_path'        => 'crystal_project',
                  'img_ext'         => 'png',
                  'version_name'    => '2010.0_DEV',
                  'version_date'    => '2010-06-08');

require_once 'system/core/functions.php';

cs_init($cs_main);

if(file_exists('setup.php')) {
  require 'setup.php';
  require 'system/database/' . $cs_db['type'] . '.php';
  $cs_db['con'] = cs_sql_connect($cs_db);
  unset($cs_db['pwd'], $cs_db['user']);
}
else {
  global $cs_logs;
  $cs_logs['save_actions'] = 0;
  $cs_logs['save_errors'] = 1;
}

echo cs_template($cs_micro);