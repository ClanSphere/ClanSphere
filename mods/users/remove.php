<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');
$cs_get = cs_get('id');

$data = array();

$users_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
$nick_temp = cs_sql_select(__FILE__, 'users', 'users_nick', 'users_id = ' . $users_id);

if(isset($_GET['agree'])) {

  $nick = $nick_temp['users_nick']; 

  $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
  $chars_count = strlen($chars)-1;
  $mail = '';
  $given = 1;

  while (!empty($given)) {
    for ($i = 0; $i < 40; $i++) {
      $rand = rand(0,$chars_count);
      $mail .= $chars{$rand};
    }
    $given = cs_sql_count(__FILE__, 'users', "users_email = '" . $mail . "'");
  }

  $array_data = array('access_id'=>0,
                      'users_nick'=>$nick,
                      'users_pwd'=>'',
                      'users_name'=>'',
                      'users_surname'=>'',
                      'users_sex'=>'',
                      'users_age'=>'',
                      'users_height'=>0,
                      'users_lang'=>'',
                      'users_country'=>"fam",
                      'users_postalcode'=>'',
                      'users_place'=>'',
                      'users_adress'=>'',
                      'users_icq'=>0,
                      'users_jabber'=>'',
                      'users_skype'=>'',
                      'users_email'=>$mail,
                      'users_url'=>'',
                      'users_phone'=>'',
                      'users_mobile'=>'',
                      'users_laston'=>0,
                      'users_picture'=>'',
                      'users_avatar'=>'',
                      'users_signature'=>'',
                      'users_info'=>'',
                      'users_regkey'=>'',
                      'users_register'=>0,
                      'users_delete'=>1);

  $array_keys = array_keys($array_data);
  $array_values = array_values($array_data);
  cs_sql_update(__FILE__, 'users', $array_keys, $array_values, $users_id);
  cs_sql_delete(__FILE__, 'members', $users_id, 'users_id');
  cs_cache_clear();
  cs_redirect($cs_lang['del_true'], 'users');
}

if(isset($_GET['cancel']))
  cs_redirect($cs_lang['del_false'], 'users');

else {
  
  $data['head']['body'] = sprintf($cs_lang['rly_rmv_user'],$nick_temp['users_nick']);
  $data['url']['agree'] = cs_url('users','remove','id=' . $users_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('users','remove','id=' . $users_id . '&amp;cancel');

  echo cs_subtemplate(__FILE__,$data,'users','remove');
}