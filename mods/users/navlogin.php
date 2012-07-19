<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$data = array();
$data['options'] = cs_sql_option(__FILE__,'users');

$styles_array = array('horizontal', 'icons', 'picture');
$style = '';
if(!empty($_GET['style']))
if(in_array($_GET['style'], $styles_array)) {
  $style = '_' . $_GET['style'];
}
else {
  cs_error($_GET['style'], 'The given navlogin style cannot be found');
}

global $login;

if(empty($login['mode'])) {

  if(empty($login['nick'])) {
    $login['nick'] = 'Nick';
    if($data['options']['login'] == 'email') {
      $login['nick'] = 'E-Mail';
    }
  }

  if(empty($login['password'])) {
    $login['password'] = 'Pass';
  }

  $data['form']['navlogin'] = cs_url('users','login');
  $data['login']['nick'] = cs_secure($login['nick']);
  $data['login']['password'] = cs_secure($login['password']);
  $data['link']['uri'] = cs_url_self();

  echo cs_subtemplate(__FILE__,$data,'users','navlogin_form' . $style);
}
else {

  if($style == '_picture') {
    $cells = 'users_picture, users_country';
    $user = cs_sql_select(__FILE__, 'users', $cells, 'users_id = ' . (int) $account['users_id']);
    $data['users']['country_icon'] = cs_html_img('symbols/countries/' . cs_secure($user['users_country']) . '.png');
    if(empty($user['users_picture']))
    $data['users']['pic'] = cs_html_img('uploads/users/nopic.jpg');
    else
    $data['users']['pic'] = cs_html_img('uploads/users/' . $user['users_picture']);
  }

  $data['users']['link'] = cs_user($account['users_id'], $account['users_nick']);

  $data['if']['panel'] = ($cs_main['def_admin'] == 'separated' AND $cs_main['tpl_file'] != 'admin.htm') ? 1 : 0;
  $data['if']['messages'] = $account['access_messages'] >= 2 ? 1 : 0;
  $data['if']['contact'] = (empty($data['if']['panel']) AND $account['access_contact'] >= 3) ? 1 : 0;
  $data['if']['joinus'] = (empty($data['if']['panel']) AND $account['access_joinus'] >= 3) ? 1 : 0;
  $data['if']['fightus'] = (empty($data['if']['panel']) AND $account['access_fightus'] >= 3) ? 1 : 0;
  $data['if']['admin'] = (empty($data['if']['panel']) AND $account['access_clansphere'] >= 3) ? 1 : 0;
  $data['if']['system'] = (empty($data['if']['panel']) AND $account['access_clansphere'] >= 4) ? 1 : 0;
  $data['if']['more'] = (empty($data['if']['contact']) AND empty($data['if']['admin']) AND empty($data['if']['panel'])) ? 0 : 1;

  if($account['access_messages'] >= 2) {
    $where_msg = 'users_id_to = ' . (int) $account['users_id'] . ' AND messages_show_receiver = 1 AND messages_view = 0';
    $messages_count_new = cs_sql_count(__FILE__,'messages',$where_msg);
    $data['messages']['new'] = $messages_count_new;
  }

  if(empty($data['if']['panel']) AND $account['access_contact'] >= 3) {
    $data['contact']['new'] = cs_cache_load('count_mail_unread');
    if($data['contact']['new'] === false)
      $data['contact']['new'] = cs_cache_save('count_mail_unread', (int) cs_sql_count(__FILE__,'mail','mail_answered = 0'));
  }

  if(empty($data['if']['panel']) AND $account['access_joinus'] >= 3) {
    $data['joinus']['joinus_count'] = cs_cache_load('count_joinus');
    if($data['joinus']['joinus_count'] === false)
      $data['joinus']['joinus_count'] = cs_cache_save('count_joinus', (int) cs_sql_count(__FILE__,'joinus'));
  }

  if(empty($data['if']['panel']) AND $account['access_fightus'] >= 3) {
    $data['fightus']['fightus_count'] = cs_cache_load('count_fightus');
    if($data['fightus']['fightus_count'] === false)
      $data['fightus']['fightus_count'] = cs_cache_save('count_fightus', (int) cs_sql_count(__FILE__,'fightus'));
  }

  if(!empty($data['if']['panel']) AND $account['access_clansphere'] >= 3) {
    $data['link']['panel'] = cs_url('clansphere', 'admin', '', 'admin');
  }

  echo cs_subtemplate(__FILE__,$data,'users','navlogin_view' . $style);
}