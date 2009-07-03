<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

$data = array();

global $login;

if(empty($login['mode'])) {

  if(empty($login['nick']))
    $login['nick'] = 'Nick';
  if(empty($login['password']))
    $login['password'] = 'Pass';

  $data['form']['navlogin'] = cs_url('users','login');
  $data['login']['nick'] = cs_secure($login['nick']);
  $data['login']['password'] = cs_secure($login['password']);
  $data['link']['uri'] = str_replace('&','&amp;',$uri);

  echo cs_subtemplate(__FILE__,$data,'users','navlogin_form_icons');
}
else {

  $where_msg = 'users_id_to = ' . (int) $account['users_id'] . ' AND messages_show_receiver = 1 AND messages_view = 0';
  $messages_count_new = cs_sql_count(__FILE__,'messages',$where_msg);
  $data['messages']['new'] = $messages_count_new;

  if($cs_main['def_admin'] != 'separated' AND $account['access_contact'] >= 3) {
    $mail_count_new = cs_sql_count(__FILE__,'mail','mail_answered = 0');
    $data['contact']['new'] = $mail_count_new;
  }

  if($cs_main['def_admin'] == 'separated' AND $account['access_clansphere'] >= 3) {
    if(empty($cs_main['mod_rewrite']))
      $data['link']['panel'] = 'admin.php';
    else {
      $shorten  = $cs_main['php_self']['filename'];
      $shorten .= empty($_REQUEST['params']) ? '' : $_REQUEST['params'];
      $data['link']['panel'] = str_replace($shorten, '', $uri) . 'admin';
    }
  }

  $data['if']['panel'] = $cs_main['def_admin'] == 'separated' ? 1 : 0;
  $data['if']['contact'] = (empty($data['if']['panel']) AND $account['access_contact'] >= 3) ? 1 : 0;
  $data['if']['admin'] = (empty($data['if']['panel']) AND $account['access_clansphere'] >= 3) ? 1 : 0;
  $data['if']['system'] = (empty($data['if']['panel']) AND $account['access_clansphere'] >= 4) ? 1 : 0;
  $data['if']['more'] = (empty($data['if']['contact']) AND empty($data['if']['admin']) AND empty($data['if']['panel'])) ? 0 : 1;

  echo cs_subtemplate(__FILE__,$data,'users','navlogin_view_icons');
}