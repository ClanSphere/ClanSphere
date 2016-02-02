<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

# Overwrite global settings by using the following array
$cs_main = array('init_sql' => true, 'init_tpl' => false, 'init_mod' => true);

chdir('../../');

require_once 'system/core/functions.php';

cs_init($cs_main);

chdir('mods/captcha/');
  
$hash = '';
$pattern = '1234567890abcdefghijklmnpqrstuvwxyz';
$max = isset($_GET['mini']) ? 3 : 6;
for($i=0;$i<$max;$i++) {
  $hash .= $pattern{rand(0,34)};
}

$ip = cs_getip();
$timeout = cs_time() - 900;
$save_hash = isset($_GET['mini']) ? 'mini_' . $hash : $hash;

$where = "captcha_ip = '" . cs_sql_escape($ip) . "' AND captcha_time < '" . $timeout . "'";
$old = cs_sql_select(__FILE__,'captcha','captcha_id',$where,'captcha_time DESC');

if(empty($old['captcha_id'])) {
  $captcha_cells = array('captcha_time','captcha_string','captcha_ip');
  $captcha_save = array(cs_time(),$save_hash,$ip);
  cs_sql_insert(__FILE__,'captcha',$captcha_cells,$captcha_save);
}
else {
  $captcha_cells = array('captcha_time','captcha_string');
  $captcha_save = array(cs_time(),$save_hash);
  cs_sql_update(__FILE__,'captcha',$captcha_cells,$captcha_save,$old['captcha_id']);
}
cs_sql_query(__FILE__,"DELETE FROM {pre}_captcha WHERE captcha_time < '" . $timeout . "'");
cs_captcha($hash);