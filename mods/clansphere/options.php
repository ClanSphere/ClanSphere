<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$data = array();
$data['if']['done'] = false;
$data['options'] = cs_sql_option(__FILE__, 'clansphere');

if($account['access_wizard'] == 5) {
  
  $wizard = cs_sql_count(__FILE__,'options',"options_name = 'done_opts' AND options_value = 1");
  if(empty($wizard)) {
    $data['if']['done'] = true;
    $data['lang']['link_2'] = cs_link($cs_lang['show'],'wizard','roots') . ' - ' . cs_link($cs_lang['task_done'],'wizard','roots','handler=opts&amp;done=1');
  }
}

if(isset($_POST['submit'])) {

  $modules = cs_checkdirs('mods');
  $allow = 0;

  foreach($modules as $mod) {
    if($mod['dir'] == $_POST['def_mod']) {
      $allow++;
    }
  }

  $save = array();
  $save['mod_rewrite'] = (int) $_POST['mod_rewrite'];
  $save['def_width'] = $_POST['def_width'];
  $save['cellspacing'] = (int) $_POST['cellspacing'];
  $save['def_title'] = $_POST['def_title'];
  $save['def_mod'] = empty($allow) ? $data['options']['def_mod'] : $_POST['def_mod'];
  $save['def_action'] = empty($_POST['def_action']) ? 'list' : $_POST['def_action'];
  $save['def_parameters'] = $_POST['def_parameters'];
  $save['def_path'] = $_POST['def_path_mode'] == 'automatic' ? '' : $_POST['def_path'];
  $save['public'] = (int) $_POST['public'];
  $save['maintenance_access'] = (int) $_POST['maintenance_access'];
  $save['def_timezone'] = (int) $_POST['def_timezone'];
  $save['def_dstime'] = $_POST['def_dstime'];
  $save['def_flood'] = $_POST['def_flood'];
  $save['img_path'] = $_POST['img_path'];
  $save['img_ext'] = $_POST['img_ext'];
  $save['def_admin'] = $_POST['def_admin'];
  $save['developer'] = (int) $_POST['developer'];
  $save['notfound_info'] = (int) $_POST['notfound_info'];
  $save['data_limit'] = (int) $_POST['data_limit'];
  $save['sec_remote'] = (int) $_POST['sec_remote'];

  require_once 'mods/clansphere/func_options.php';

  cs_optionsave('clansphere', $save);

  # clear cache to not run into trouble on mod_rewrite changes
  cs_cache_clear();

  if(!empty($_POST['dstime_all'])) {
    $query = 'UPDATE {pre}_users SET users_dstime = \''.$_POST['def_dstime'].'\'';
    cs_sql_query(__FILE__,$query);
  }

  if(!empty($_POST['data_limit_all'])) {
    $query = 'UPDATE {pre}_users SET users_limit = \'' . (int) $_POST['data_limit'] . '\'';
    cs_sql_query(__FILE__,$query);
  }

  global $cs_main;

  $cs_main['mod_rewrite'] = $save['mod_rewrite'];

  cs_redirect($cs_lang['success'], 'options','roots');
} 
else {

  $data['options'] = cs_sql_option(__FILE__, 'clansphere');

  # Supported webservers: Apache, Microsoft IIS, Lighttpd, Nginx
  $data['if']['mod_rewrite'] = false;
  if(file_exists($cs_main['def_path'] . '/.htaccess')
  OR file_exists($cs_main['def_path'] . '/web.config')
  OR file_exists($cs_main['def_path'] . '/ligttpd.conf')
  OR file_exists($cs_main['def_path'] . '/nginx.conf')) {
    $data['if']['mod_rewrite'] = true;
  }

  if (empty($data['options']['mod_rewrite'])) {
    $data['options']['mod_rewrite_on'] = '';
    $data['options']['mod_rewrite_off'] = ' selected="selected"';
  } else {
    $data['options']['mod_rewrite_on'] = ' selected="selected"';
    $data['options']['mod_rewrite_off'] = '';
  }

  if(empty($data['options']['developer'])) {
    $data['options']['developer_on'] = '';
    $data['options']['developer_off'] = ' selected="selected"';
  } else {
    $data['options']['developer_on'] = ' selected="selected"';
    $data['options']['developer_off'] = '';
  }

  if(empty($data['options']['notfound_info'])) {
    $data['options']['notfound_on'] = '';
    $data['options']['notfound_off'] = ' selected="selected"';
  } else {
    $data['options']['notfound_on'] = ' selected="selected"';
    $data['options']['notfound_off'] = '';
  }

  $modules = cs_checkdirs('mods');
  $run = 0;

  foreach($modules as $mods) {
    $sel = $mods['dir'] == $data['options']['def_mod'] ? 1 : 0;
    $data['sel'][$run]['options'] = cs_html_option($mods['name'],$mods['dir'],$sel);
    $run++;
  }

  $data['options']['automatic'] = $data['options']['def_path'] == '1' ? 'selected="selected"' : '';
  $data['options']['manual'] = $data['options']['def_path'] == '0' ? 'selected="selected"' : '';
  $data['options']['def_path'] = $cs_main['def_path'];

  $data['options']['public_1'] = $data['options']['public'] == '1' ? 'checked="checked"' : '';
  $data['options']['public_2'] = $data['options']['public'] == '0' ? 'checked="checked"' : '';
  $data['options']['admin_1'] = $data['options']['def_admin'] == 'integrated' || empty($data['options']['def_admin']) ? 'checked="checked"' : '';
  $data['options']['admin_2'] = $data['options']['def_admin'] == 'separated' ? 'checked="checked"' : '';
  $data['options']['sec_remote_1'] = !empty($data['options']['sec_remote']) ? 'checked="checked"' : '';
  $data['options']['sec_remote_2'] = empty($data['options']['sec_remote']) ? 'checked="checked"' : '';

  $data['options']['timezone_select'] = cs_html_select(1,'def_timezone');
  $timezone = -10;

  while($timezone <= 12) {
    $zonename = $timezone >= 0 ? 'UTC +' . $timezone: 'UTC ' . $timezone;
    $offset = $timezone * 3600;
    $sel = $offset == $data['options']['def_timezone'] ? 1 : 0;
    $data['options']['timezone_select'] .= cs_html_option($zonename,$offset,$sel);
    $timezone = $timezone + 0.5;
  }

  $data['options']['timezone_select'] .= cs_html_select(0);

  $data['options']['time_1'] = $data['options']['def_dstime'] == 'on' ? 'selected="selected"' : '';
  $data['options']['time_0'] = $data['options']['def_dstime'] == 'off' ? 'selected="selected"' : '';

  $data['options']['time_auto'] = $data['options']['def_dstime'] == '0' ? 'selected="selected"' : '';

  $data['options']['ajax_reload'] = empty($data['options']['ajax_reload']) ? 10 : $data['options']['ajax_reload'];

  $data['options']['main_acc3_checked'] = $data['options']['maintenance_access'] == 3 ? 'selected="selected"' : '';
  $data['options']['main_acc4_checked'] = $data['options']['maintenance_access'] == 4 ? 'selected="selected"' : '';
  $data['options']['main_acc5_checked'] = $data['options']['maintenance_access'] == 5 ? 'selected="selected"' : '';

  echo cs_subtemplate(__FILE__,$data,'clansphere','options');
}
