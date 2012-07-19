<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

if (isset($_POST['submit'])) {

  $save = array();
  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];
  $save['show_wars'] = empty($_POST['show_wars']) ? 0 : 1;
  $save['req_fullname'] = empty($_POST['req_fullname']) ? 0 : 1;
  $save['req_fulladress'] = empty($_POST['req_fulladress']) ? 0 : 1;
  $save['req_phone'] = empty($_POST['req_phone']) ? 0 : 1;
  $save['req_mobile'] = empty($_POST['req_mobile']) ? 0 : 1;
  $save['max_navbirthday'] = $_POST['max_navbirthday'];
  $save['max_navnext'] = $_POST['max_navnext'];
  
  require_once 'mods/clansphere/func_options.php';
  
  cs_optionsave('events', $save);
  
  cs_redirect($cs_lang['changes_done'], 'options', 'roots');
  
} else {

  $data = array();

  $data['op'] = cs_sql_option(__FILE__,'events');

  $data['lang']['getmsg'] = cs_getmsg();

  $checked = ' checked="checked"';
  $data['checked']['show_wars'] = !empty($data['op']['show_wars']) ? $checked : '';
  $data['checked']['req_fullname'] = !empty($data['op']['req_fullname']) ? $checked : '';
  $data['checked']['req_fulladress'] = !empty($data['op']['req_fulladress']) ? $checked : '';
  $data['checked']['req_phone'] = !empty($data['op']['req_phone']) ? $checked : '';
  $data['checked']['req_mobile'] = !empty($data['op']['req_mobile']) ? $checked : '';
  
  
  echo cs_subtemplate(__FILE__,$data,'events','options');
}