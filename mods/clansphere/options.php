<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$cs_options = cs_sql_option(__FILE__, 'clansphere');

$data['if']['done'] = false;

if($account['access_wizard'] == 5) {
  $wizard = cs_sql_count(__FILE__,'options',"options_name = 'done_opts' AND options_value = '1'");
  if(empty($wizard)) {
    $data['if']['done'] = true;
  $data['lang']['link_2'] = cs_link($cs_lang['show'],'wizard','roots') . ' - ' . cs_link($cs_lang['task_done'],'wizard','roots','handler=opts&amp;done=1');
    }
  }
  
  $data['lang']['wizard'] = $cs_lang['wizard'];
  $data['lang']['getmsg'] = cs_getmsg(); 

if(isset($_POST['submit'])) {
  $modules = cs_checkdirs('mods');
  $allow = 0;

  foreach($modules as $mod) {
    if($mod['dir'] == $_POST['def_mod']) {
    $allow++;
  }
  }
  
  $_POST['def_mod'] = empty($allow) ? $cs_main['def_mod'] : $_POST['def_mod'];

  $def_path = $_POST['def_path_mode'] == 'automatic' ? '' : $_POST['def_path'];

  settype($_POST['mod_rewrite'],'integer');
  settype($_POST['def_timezone'],'integer');
  settype($_POST['public'],'integer');
  settype($_POST['cellspacing'],'integer');

  $opt_where = "options_mod = 'clansphere' AND options_name = ";
  $def_cell = array('options_value');
  $def_cont = array($_POST['mod_rewrite']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'mod_rewrite'");
  $def_cont = array($_POST['def_width']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_width'");
  $def_cont = array($_POST['cellspacing']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'cellspacing'");
  $def_cont = array($_POST['def_title']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_title'");
  $def_cont = array($_POST['def_mod']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_mod'");
  $def_cont = empty($_POST['def_action']) ? array('list') : array($_POST['def_action']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_action'");
  $def_cont = array($_POST['def_parameters']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_parameters'");
  $def_cont = array($def_path);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_path'");
  $def_cont = array($_POST['public']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'public'");  
  $def_cont = array($_POST['def_timezone']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_timezone'");
  $def_cont = array($_POST['def_dstime']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_dstime'");
  $def_cont = array($_POST['def_flood']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_flood'");
  $def_cont = array($_POST['def_org']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_org'");
  $def_cont = array($_POST['def_mail']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_mail'");
  $def_cont = array($_POST['img_path']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'img_path'");
  $def_cont = array($_POST['img_ext']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'img_ext'");
  $def_cont = array($_POST['def_admin']);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'def_admin'"); 

  if(!empty($_POST['dstime_all'])) {
    $query = 'UPDATE {pre}_users SET users_dstime = \''.$_POST['def_dstime'].'\'';
    cs_sql_query(__FILE__,$query);
  }
  if (!empty($cs_main['ajax']) && (empty($_POST['mod_rewrite']) && !empty($cs_main['mod_rewrite'])) | (!empty($_POST['mod_rewrite']) && empty($cs_main['mod_rewrite'])))
    die(ajax_js("window.location.hash='#'; window.location.href=window.location.href.substr(window.location.href.lastIndexOf('/')); window.location.reload();"));
  cs_redirect($cs_lang['success'], 'clansphere','options');

}
else {
  $data['action']['form'] = cs_url('clansphere','options');
  
  $selected = ' selected="selected"';
  
  if (empty($cs_main['mod_rewrite'])) {
    $data['options']['mod_rewrite_on'] = '';
    $data['options']['mod_rewrite_off'] = $selected;
  } else {
    $data['options']['mod_rewrite_on'] = $selected;
    $data['options']['mod_rewrite_off'] = '';
  }
  
  $data['options']['def_width'] = $cs_main['def_width'];
  $data['options']['def_title'] = $cs_main['def_title'];

  $modules = cs_checkdirs('mods');
  $run = 0;
  
  foreach($modules as $mods) {
    $sel = $mods['dir'] == $cs_main['def_mod'] ? 1 : 0;
    $data['sel'][$run]['options'] = cs_html_option($mods['name'],$mods['dir'],$sel);
  $run++;
  }

  $data['options']['action'] = $cs_main['def_action'];
  $data['options']['parameters'] = $cs_main['def_parameters'];

  if($cs_main['def_path'] == '1') {
    $data['options']['automatic'] = 'selected="selected"';
  }
  else {
    $data['options']['automatic'] = '';
  }
  
  if($cs_main['def_path'] == '0') {
    $data['options']['manual'] = 'selected="selected"';
  }
  else {
    $data['options']['manual'] = '';
  }
  
  $data['options']['def_path'] = $cs_main['def_path'];

  if($cs_main['public'] == '1') {
    $data['options']['public_1'] = 'checked="checked"';
  }
  else {
    $data['options']['public_1'] = '';
  }
  
  if($cs_main['public'] == '0') {
    $data['options']['public_2'] = 'checked="checked"';
  }
  else {
    $data['options']['public_2'] = '';
  }
  
  if($cs_main['def_admin'] == 'integrated' OR empty($cs_main['def_admin'])) {
    $data['options']['admin_1'] = 'checked="checked"';
  }
  else {
    $data['options']['admin_1'] = '';
  }
  
  if($cs_main['def_admin'] == 'separated') {
    $data['options']['admin_2'] = 'checked="checked"';
  }
  else {
    $data['options']['admin_2'] = '';
  }

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
  
  if($cs_main['def_dstime'] == 'on') {
    $data['options']['time_1'] = 'selected="selected"';
  }
  else {
    $data['options']['time_1'] = '';
  }
  
  if($cs_main['def_dstime'] == 'off') {
    $data['options']['time_0'] = 'selected="selected"';
  }
  else {
    $data['options']['time_0'] = '';
  }
  
  $data['options']['time_auto'] = $cs_main['def_dstime'] == '0' ? 'selected="selected"' : '';

  $data['options']['def_flood'] = $cs_main['def_flood'];
  $data['options']['def_org'] = $cs_main['def_org'];
  $data['options']['def_mail'] = $cs_main['def_mail'];
  $data['options']['img_path'] = $cs_main['img_path'];
  $data['options']['img_ext'] = $cs_main['img_ext'];
  $data['options']['cellspacing'] = $cs_main['cellspacing'];
  $data['options']['ajax_reload'] = empty($cs_main['ajax_reload']) ? 10 : $cs_main['ajax_reload'];
}

echo cs_subtemplate(__FILE__,$data,'clansphere','options');
?>