<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$data = array();
$data['if']['done'] = false;

if($account['access_wizard'] == 5) {
	
  $wizard = cs_sql_count(__FILE__,'options',"options_name = 'done_opts' AND options_value = \"1\"");
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
  $save['def_mod'] = empty($allow) ? $cs_main['def_mod'] : $_POST['def_mod'];
  $save['def_action'] = empty($_POST['def_action']) ? 'list' : $_POST['def_action'];
  $save['def_parameters'] = $_POST['def_parameters'];
  $save['def_path'] = $_POST['def_path_mode'] == 'automatic' ? '' : $_POST['def_path'];
  $save['public'] = (int) $_POST['public'];
  $save['def_timezone'] = (int) $_POST['def_timezone'];
  $save['def_dstime'] = $_POST['def_dstime'];
  $save['def_flood'] = $_POST['def_flood'];
  $save['def_org'] = $_POST['def_org'];
  $save['def_mail'] = $_POST['def_mail'];
  $save['img_path'] = $_POST['img_path'];
  $save['img_ext'] = $_POST['img_ext'];
  $save['def_admin'] = $_POST['def_admin'];
  $save['developer'] = (int) $_POST['developer'];  

  require_once 'mods/clansphere/func_options.php';
  
  cs_optionsave('clansphere', $save);

  if(!empty($_POST['dstime_all'])) {
    $query = 'UPDATE {pre}_users SET users_dstime = \''.$_POST['def_dstime'].'\'';
    cs_sql_query(__FILE__,$query);
  }
  if (!empty($cs_main['ajax']) && !empty($account['users_ajax']) && (empty($_POST['mod_rewrite']) && !empty($cs_main['mod_rewrite'])) | 
    (!empty($_POST['mod_rewrite']) && empty($cs_main['mod_rewrite'])))
    die(ajax_js("window.location.hash='#'; window.location.href=window.location.href.substr(window.location.href.lastIndexOf('/')); window.location.reload();"));
  
  cs_redirect($cs_lang['success'], 'options','roots');

} 
else {

	$data['options'] = cs_sql_option(__FILE__, 'clansphere');

  if (empty($cs_main['mod_rewrite'])) {
    $data['options']['mod_rewrite_on'] = '';
    $data['options']['mod_rewrite_off'] = ' selected="selected"';
  } else {
    $data['options']['mod_rewrite_on'] = ' selected="selected"';
    $data['options']['mod_rewrite_off'] = '';
  }

  if(empty($cs_main['developer'])) {
    $data['options']['developer_on'] = '';
    $data['options']['developer_off'] = ' selected="selected"';
  } else {
    $data['options']['developer_on'] = ' selected="selected"';
    $data['options']['developer_off'] = '';
  }

  $modules = cs_checkdirs('mods');
  $run = 0;

  foreach($modules as $mods) {
    $sel = $mods['dir'] == $cs_main['def_mod'] ? 1 : 0;
    $data['sel'][$run]['options'] = cs_html_option($mods['name'],$mods['dir'],$sel);
    $run++;
  }

  $data['options']['action'] = $cs_main['def_action'];
  $data['options']['parameters'] = $cs_main['def_parameters'];
  $data['options']['automatic'] = $cs_main['def_path'] == '1' ? 'selected="selected"' : '';
  $data['options']['manual'] = $cs_main['def_path'] == '0' ? 'selected="selected"' : '';
  $data['options']['def_path'] = $cs_main['def_path'];
  $data['options']['public_1'] = $cs_main['public'] == '1' ? 'checked="checked"' : '';
  $data['options']['public_2'] = $cs_main['public'] == '0' ? 'checked="checked"' : '';
  $data['options']['admin_1'] = $cs_main['def_admin'] == 'integrated' || empty($cs_main['def_admin']) ? 'checked="checked"' : '';
  $data['options']['admin_2'] = $cs_main['def_admin'] == 'separated' ? 'checked="checked"' : '';

  $data['options']['def_timezone'] = cs_html_select(1,'def_timezone');
  $timezone = -10;

  while($timezone <= 12) {
    $zonename = $timezone >= 0 ? 'UTC +' . $timezone: 'UTC ' . $timezone;
    $offset = $timezone * 3600;
    $sel = $offset == $cs_main['def_timezone'] ? 1 : 0;
    $data['options']['def_timezone'] .= cs_html_option($zonename,$offset,$sel);
    $timezone = $timezone + 0.5;
  }

  $data['options']['def_timezone'] .= cs_html_select(0);

  $data['options']['time_1'] = $cs_main['def_dstime'] == 'on' ? 'selected="selected"' : '';
  $data['options']['time_0'] = $cs_main['def_dstime'] == 'off' ? 'selected="selected"' : '';

  $data['options']['time_auto'] = $cs_main['def_dstime'] == '0' ? 'selected="selected"' : '';

  $data['options']['def_flood'] = $cs_main['def_flood'];
  $data['options']['def_org'] = $cs_main['def_org'];
  $data['options']['def_mail'] = $cs_main['def_mail'];
  $data['options']['img_path'] = $cs_main['img_path'];
  $data['options']['img_ext'] = $cs_main['img_ext'];
  $data['options']['cellspacing'] = $cs_main['cellspacing'];
  $data['options']['ajax_reload'] = empty($cs_main['ajax_reload']) ? 10 : $cs_main['ajax_reload'];

  echo cs_subtemplate(__FILE__,$data,'clansphere','options');
}

?>