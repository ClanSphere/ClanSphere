<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

# PHP 4 has no multibyte support in some functions, so it should use a charset like iso
$charset = version_compare(phpversion(), '5.0', '>=') ? 'UTF-8' : 'ISO-8859-15';

# Overwrite global settings by using the following array
$cs_main = array( 'cellspacing'     => 1,
                  'charset'         => $charset,
                  'def_action'      => 'list',
                  'def_mod'         => 'install',
                  'def_title'       => 'ClanSphere Installation',
                  'def_tpl'         => 'install',
                  'def_theme'       => 'base',
                  'def_parameters'  => '',
                  'def_width'       => '100%',
                  'init_sql'        => false,
                  'init_tpl'        => false,
                  'public'          => 1,
                  'img_path'        => 'crystal_project',
                  'img_ext'         => 'png',
                  'version_name'    => '2010.0_SVN',
                  'version_date'    => '2010-05-05');

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