<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$data = array();

global $login;

if(empty($login['mode'])) {

  if(empty($login['nick'])) {
    $login['nick'] = 'Nick';
  }
  if(empty($login['password'])) {
    $login['password'] = 'Pass';
  }

  $data['form']['navlogin'] = cs_url('users','login');
  $data['login']['nick'] = cs_secure($login['nick']);
  $data['login']['password'] = cs_secure($login['password']);
  $data['lang']['cookie'] = $cs_lang['cookie'];
  $data['lang']['submit'] = $cs_lang['submit'];
  $data['lang']['register'] = $cs_lang['register'];
  $data['lang']['sendpw'] = $cs_lang['sendpw'];
  $data['link']['register'] = cs_url('users','register');
  $data['link']['sendpw'] = cs_url('users','sendpw');
  $data['link']['uri'] = str_replace('&','&amp;',$_SERVER['REQUEST_URI']);

  echo cs_subtemplate(__FILE__,$data,'users','navlogin3_1');
}
else {

  $where_new = "users_id_to = '" . $account['users_id'] . "' AND messages_show_receiver = 1 AND messages_view = 0";
  $messages_count_new = cs_sql_count(__FILE__,'messages',$where_new);

  $data['lang']['home'] = $cs_lang['home'];
  $data['link']['home'] = cs_url('users','home');
  $data['lang']['messages'] = $cs_lang['messages'];
  $data['link']['messages'] = cs_url('messages','center');

  $data['messages']['new'] = $messages_count_new;
  $data['link']['messages'] = cs_url('messages','inbox');
  $data['lang']['settings'] = $cs_lang['settings'];
  $data['link']['settings'] = cs_url('users','settings');

  $data['lang']['admin'] = '';
  $data['link']['admin'] = '';
  $data['br']['admin'] = '';
  $data['lang']['system'] = '';
  $data['link']['system'] = '';
  $data['br']['system_panel'] = '';

  $data['lang']['panel'] = '';
  $data['link']['panel'] = '';

  $data['lang']['logout'] = $cs_lang['logout'];
  $data['link']['logout'] = cs_url('users','logout');

  if($cs_main['def_admin'] != 'separated') {
    if($account['access_clansphere'] >= 3) {
/*      $data['lang']['admin'] .= $cs_lang['admin'];
      $data['link']['admin'] .= cs_url('clansphere','admin');*/
      $adm_link = cs_icon('package_settings') . $cs_lang['admin'];
      $data['link']['admin'] .= cs_link($adm_link,'clansphere','admin');
      $data['link']['admin'] .= cs_html_br(1);
    }
    if($account['access_clansphere'] >= 4) {
      /*$data['lang']['system'] .= $cs_lang['system'];*/
      $sys_link = cs_icon('package_system') . $cs_lang['system'];
      $data['link']['system'] .= cs_link($sys_link,'clansphere','system');
      
      $data['link']['system'] .= cs_html_br(2);
    }
  }
  elseif($account['access_clansphere'] >= 3) {
      /*$data['lang']['panel'] .= $cs_lang['panel'];*/
      $pan_link = cs_icon('package_system') . $cs_lang['panel'];
      if(empty($cs_main['mod_rewrite']))
        $data['link']['panel'] .= cs_html_link('admin.php', $pan_link);
      else {
        $shorten  = $cs_main['php_self']['filename'];
        $shorten .= empty($_REQUEST['params']) ? '' : $_REQUEST['params'];
        $panel_url = str_replace($shorten, '', $_SERVER['REQUEST_URI']);
        $data['link']['panel'] .= cs_html_link($panel_url . 'admin', $pan_link);
      }
      $data['link']['panel'] .= cs_html_br(2);
  }

  echo cs_subtemplate(__FILE__,$data,'users','navlogin3_2');
}

?>