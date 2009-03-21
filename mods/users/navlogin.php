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

  echo cs_subtemplate(__FILE__,$data,'users','navlogin_1');
}
else {

  $where_msg = "users_id_to = '" . $account['users_id'] . "' AND messages_show_receiver = 1 AND messages_view = 0";
  $messages_count_new = cs_sql_count(__FILE__,'messages',$where_msg);

  $data['lang']['home'] = $cs_lang['home'];
  $data['link']['home'] = cs_url('users','home');
  $data['lang']['messages'] = $cs_lang['messages'];
  $data['link']['messages'] = cs_url('messages','center');

  $data['messages']['new'] = $messages_count_new;

  $data['lang']['settings'] = $cs_lang['settings'];
  $data['link']['settings'] = cs_url('users','settings');

  $data['link']['contact'] = '';
  $data['link']['admin'] = '';
  $data['link']['system'] = '';
  $data['link']['panel'] = '';

  $data['lang']['logout'] = $cs_lang['logout'];
  $data['link']['logout'] = cs_url('users','logout');

  if($cs_main['def_admin'] != 'separated') {

    if($account['access_contact'] >= 3) {

      $where_mail = "mail_answered = 0";
      $mail_count_new = cs_sql_count(__FILE__,'mail',$where_mail);

      $data['link']['contact'] .= cs_link($cs_lang['contact'],'contact','manage');
      $data['link']['contact'] .= ' (' . $mail_count_new . ')' . cs_html_br(1);
    }
    if($account['access_clansphere'] >= 3) {

      $data['link']['admin'] .= cs_link($cs_lang['admin'],'clansphere','admin');
      $data['link']['admin'] .= cs_html_br(1);
    }
    if($account['access_clansphere'] >= 4) {

      $data['link']['system'] .= cs_link($cs_lang['system'],'clansphere','system');
      $data['link']['system'] .= cs_html_br(2);
    }
  }
  elseif($account['access_clansphere'] >= 3) {

      $data['link']['panel'] .= cs_html_link('admin.php',$cs_lang['panel']);
      $data['link']['panel'] .= cs_html_br(2);
  }

  echo cs_subtemplate(__FILE__,$data,'users','navlogin_2');
}

?>