<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => false, 'init_tpl' => false);

require_once 'system/core/functions.php';

cs_init($cs_main);


global $cs_logs, $cs_main, $account;

if(file_exists('setup.php')) {
    
  require 'setup.php';
  require 'system/database/' . $cs_db['type'] . '.php';
  $cs_db['con'] = cs_sql_connect($cs_db);
  unset($cs_db['pwd']);
  unset($cs_db['user']);
}
else {
  $cs_logs['save_actions'] = 0;
  $cs_logs['save_errors'] = 0;
}

$cs_main = array( 'def_action'      => 'list',
                  'def_lang'        => 'English',
                  'def_mod'         => 'install',
                  'def_title'       => 'ClanSphere 2008.3_svn Installation',
                  'def_tpl'         => 'install',
                  'def_theme'       => 'base',
                  'def_parameters'  => '',
                  'def_width'       => '100%',
                  'public'          => 1,
                  'version_name'    => '2008.3_svn',
                  'version_date'    => '2008-09-20');

require 'system/core/content.php';

if(!empty($_REQUEST['lang'])) {
  $languages = cs_checkdirs('lang');
  foreach($languages as $mod) {
    if($mod['dir'] == $_REQUEST['lang']) { $lang = $_REQUEST['lang']; break; }
  }
}

$lang = empty($lang) ? 'English' : $lang;

$account = array('users_id' => 0, 'access_clansphere' => 0, 'access_install' => 5, 'users_lang' => $lang);
require 'lang/' . $account['users_lang'] . '/system/comlang.php';

$cs_lang_main = cs_translate();

echo cs_template($cs_micro,$cs_main,$account);

?>