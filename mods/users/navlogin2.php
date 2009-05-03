<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$data = array();

global $login;

if(empty($login['mode'])) {
  
  $data['link']['login'] = cs_url('users','login');
  $data['link']['register'] = cs_url('users','register');
  $data['link']['sendpw'] = cs_url('users','sendpw');
  
  echo cs_subtemplate(__FILE__,$data,'users','navlogin2_1');
}
else {

  $where = "users_id_to = '" . $account['users_id'] . "' AND messages_show_receiver = '1' AND messages_view = '0'";
  $messages_count = cs_sql_count(__FILE__,'messages',$where);

  $data['link']['home'] = cs_url('users','home');
  $data['link']['messages'] = cs_url('messages','center');
  $data['messages']['count_new'] = $messages_count;
  $data['link']['settings'] = cs_url('users','settings');

  $data['link']['admin'] = '';
  $data['login']['admin'] = '';
  $data['link']['system'] = '';
  $data['login']['system'] = '';
  
  $data['link']['panel'] = '';
  $data['login']['panel'] = '';

  $data['link']['logout'] = cs_url('users','logout');
  
  if($cs_main['def_admin'] != 'separated') {
    if($account['access_clansphere'] >= 3) {
      $data['link']['admin'] .= cs_link($cs_lang['admin'],'clansphere','admin') . ' - ';
      $data['login']['admin'] .= '-';
    }
    if($account['access_clansphere'] >= 4) {
      $data['link']['system'] .= cs_link($cs_lang['system'],'clansphere','system') . ' - ';
      $data['login']['system'] .= '-';
    }
  }
  elseif($account['access_clansphere'] >= 3) {
      if(empty($cs_main['mod_rewrite']))
        $data['link']['panel'] .= cs_html_link('admin.php',$cs_lang['panel']) . ' - ';
      else {
        $shorten  = $cs_main['php_self']['filename'];
        $shorten .= empty($_REQUEST['params']) ? '' : $_REQUEST['params'];
        $panel_url = str_replace($shorten, '', $_SERVER['REQUEST_URI']);
        $data['link']['panel'] .= cs_html_link($panel_url . 'admin',$cs_lang['panel']) . ' - ';
      }
      $data['login']['panel'] .= '-';
  }
  
  echo cs_subtemplate(__FILE__,$data,'users','navlogin2_2');
}