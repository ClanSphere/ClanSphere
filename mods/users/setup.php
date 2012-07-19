<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$languages = cs_checkdirs('lang');

$data = array();

$data['head']['mod'] = $cs_lang['mod_name'];
$data['head']['action'] = $cs_lang['setup'];

if(isset($_POST['submit'])) {

  $cs_user['users_lang'] = $_POST['users_lang'];
  $cs_user['users_timezone'] = $_POST['users_timezone'];
  $cs_user['users_dstime'] = $_POST['users_dstime'];
  $cs_user['users_limit'] = $_POST['users_limit'];
  $cs_user['users_view'] = $_POST['users_view'];
  $cs_user['users_readtime'] = $_POST['users_readtime'];
  $cs_user['users_homelimit'] = $_POST['users_homelimit'];
  $cs_user['users_invisible'] = $_POST['users_invisible'];
  $cs_user['users_abomail'] = (int)$_POST['users_abomail'];
  $cs_user['users_ajax'] = isset($_POST['users_ajax']) ? $_POST['users_ajax'] : 0;

  settype($cs_user['users_limit'],'integer');
  settype($cs_user['users_homelimit'],'integer');
  settype($cs_user['users_readtime'],'integer');

  $error = 0;
  $errormsg = '';

  $allow = 0;
  foreach($languages as $mod) {
    if($mod['dir'] == $cs_user['users_lang']) { 
      $allow++; 
    }
  }
  $cs_user['users_lang'] = empty($allow) ? $cs_main['def_lang'] : $cs_user['users_lang'];

  if(empty($cs_user['users_limit'])) {
    $error++;
    $errormsg .= $cs_lang['no_limit'] . cs_html_br(1);
  }
  if($cs_user['users_limit'] > 50) {
    $cs_user['users_limit'] = 50;
  }
  
  if(empty($cs_user['users_readtime'])) {
    $error++;
    $errormsg .= $cs_lang['no_readtime'] . cs_html_br(1);
  }
  if($cs_user['users_readtime'] > 50) {
    $cs_user['users_readtime'] = 50;
  }
  $cs_user['users_view'] = in_array($cs_user['users_view'], array('list','float')) ? $cs_user['users_view'] : '';
  settype($cs_user['users_timezone'],'integer');
}
else {
  $cells = 'users_lang, users_timezone, users_limit, users_view, users_dstime, users_homelimit, users_readtime, users_invisible, users_abomail, users_ajax';
  $cs_user = cs_sql_select(__FILE__,'users',$cells,"users_id = '" . $account['users_id'] . "'");
  $cs_user['users_readtime'] = $cs_user['users_readtime'] / 86400;
}
if(!isset($_POST['submit'])) {
  $data['head']['body_text'] =  $cs_lang['errors_here'];
}
elseif(!empty($error)) {
  $data['head']['body_text'] =  $errormsg;
}
else {
  $data['head']['body_text'] =  $cs_lang['success'];
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['data'] = $cs_user;
  
  $data['if']['done'] = false;

  if($account['access_wizard'] == 5) {
    $wizard = cs_sql_count(__FILE__,'options',"options_name = 'done_setp' AND options_value = '1'");
    if(empty($wizard)) {
      $data['if']['done'] = true;
      $data['link']['wizard'] = cs_link($cs_lang['show'],'wizard','roots') . ' - ' . cs_link($cs_lang['task_done'],'wizard','roots','handler=setp&amp;done=1');
    }
  }  

  $data['lang']['datasheet_per_page'] = $cs_lang['limit'];

  $data['setup']['languages'] = '';
  $data['setup']['timezone'] = '';
  $data['setup']['view_std'] = '';
  $data['setup']['view_list'] = '';
  
  foreach($languages as $lang) {
      $lang['name'] == $cs_user['users_lang'] ? $sel = 1 : $sel = 0;
      $data['setup']['languages'] .= cs_html_option($lang['name'],$lang['name'],$sel);
    }
  
  $timezone = -10;
  while($timezone <= 12) {
    $zonename = $timezone >= 0 ? 'UTC +' . $timezone: 'UTC ' . $timezone;
    $offset = $timezone * 3600;
    $sel = $offset == $cs_user['users_timezone'] ? 1 : 0;
    $data['setup']['timezone'] .= cs_html_option($zonename,$offset,$sel);
    $timezone = $timezone + 0.5;
  }
    
  $sel = empty($cs_user['users_dstime']) ? 1 : 0;
  $data['setup']['option_automatic'] = cs_html_option($cs_lang['automatic'],0,$sel);
  $sel = $cs_user['users_dstime'] == 'on' ? 1 : 0;
  $data['setup']['option_on'] =  cs_html_option($cs_lang['on'],'on',$sel);
  $sel = $cs_user['users_dstime'] == 'off' ? 1 : 0;
  $data['setup']['option_off'] = cs_html_option($cs_lang['off'],'off',$sel);

  $data['setup']['users_limit'] = $cs_user['users_limit'];

  $views[0]['users_view'] = '';
  $views[0]['name'] = $cs_lang['default'];
  $views[1]['users_view'] = 'list';
  $views[1]['name'] = $cs_lang['list'];
  $views[2]['users_view'] = 'float';
  $views[2]['name'] = $cs_lang['compatible'];
  $data['setup']['view_type'] = cs_dropdown('users_view','name',$views,$cs_user['users_view'],0,1);
  
  $mode[0]['users_invisible'] = 0;
  $mode[0]['name'] = $cs_lang['off'];
  $mode[1]['users_invisible'] = 1;
  $mode[1]['name'] = $cs_lang['on'];
  $data['setup']['users_invisible'] = cs_dropdown('users_invisible','name',$mode,$cs_user['users_invisible'],0,1);
  
  $mode[0]['users_abomail'] = 0;
  $mode[0]['name'] = $cs_lang['off'];
  $mode[1]['users_abomail'] = 1;
  $mode[1]['name'] = $cs_lang['on'];
  $data['setup']['users_abomail'] = cs_dropdown('users_abomail','name',$mode,$cs_user['users_abomail'],0,1);
  
  $mode[0]['users_ajax'] = 0;
  $mode[0]['name'] = $cs_lang['off'];
  $mode[1]['users_ajax'] = 1;
  $mode[1]['name'] = $cs_lang['on'];
  $data['setup']['users_ajax'] = cs_dropdown('users_ajax','name',$mode,$cs_user['users_ajax']);
  
  $data['if']['ajax_allowed'] = $cs_main['ajax'] == 1 ? 1 : 0;
  
  echo cs_subtemplate(__FILE__,$data,'users','setup');
}
else {
  $cs_user['users_readtime'] = $cs_user['users_readtime'] * 86400;

  $users_cells = array_keys($cs_user);
  $users_save = array_values($cs_user);
  cs_sql_update(__FILE__,'users',$users_cells,$users_save,$account['users_id']);

  if (!empty($cs_main['mod_rewrite'])) {
    header('Location: ../../' . $cs_main['php_self']['basename']);
  } else {
    $account['users_ajax'] = empty($cs_main['ajax']) ? 0 : $cs_user['users_ajax'];

    cs_redirect($cs_lang['success'],'users','settings', 'lang=' . $cs_user['users_lang']);
  }
}