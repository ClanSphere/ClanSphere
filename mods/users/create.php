<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$op_users = cs_sql_option(__FILE__,'users');
$cs_contact = cs_sql_option(__FILE__, 'contact');

require_once('mods/users/functions.php');

$conv_joinus = 0;

if(isset($_POST['submit'])) {

  $create['access_id'] = $_POST['access_id'];
  $create['users_lang'] = $_POST['lang'];
  $create['users_nick'] = $_POST['nick'];
  $create_['password'] = $_POST['password'];
  $create['users_email'] = $_POST['email'];
  $create['users_country'] = $_POST['country'];

  if(!empty($_POST['conv_joinus'])) {
    $create['users_name'] = $_POST['users_name'];
    $create['users_surname'] = $_POST['users_surname'];
    $create['users_age'] = $_POST['users_age'];
    $create['users_place'] = $_POST['users_place'];
    $create['users_icq'] = $_POST['users_icq'];
    $create['users_jabber'] = $_POST['users_jabber'];
    $create['users_pwd'] = $_POST['users_pwd'];
    $conv_joinus = 1;
  }

  $error = '';

  $nick2 = str_replace(' ','',$create['users_nick']);
  $nickchars = strlen($nick2);
  if($nickchars < $op_users['min_letters']) {
    $error .= sprintf($cs_lang['short_nick'],$op_users['min_letters']) . cs_html_br(1);
  }

  $search_nick = cs_sql_count(__FILE__,'users',"users_nick = '" . cs_sql_escape($create['users_nick']) . "'");
  if(!empty($search_nick)) {
    $error .= $cs_lang['nick_exists'] . cs_html_br(1);
  }

  $whr_acc = "access_id = '" . cs_sql_escape($create['access_id']) . "'";
  $get_acc = cs_sql_select(__FILE__,'access','*',$whr_acc);
  if($get_acc['access_clansphere'] > $account['access_clansphere'] OR $get_acc['access_access'] > $account['access_access'] OR $get_acc['access_users'] > $account['access_users']) {
    $error .= $cs_lang['access_denied'] . cs_html_br(1);
  }
  if(empty($_POST['conv_joinus'])) {
    $pwd2 = str_replace(' ','',$create_['password']);
    $pwdchars = strlen($pwd2);
    if($pwdchars<4) {
      $error .= $cs_lang['short_pwd'] . cs_html_br(1);
    }
  }

  $search_email = cs_sql_count(__FILE__,'users',"users_email = '" . cs_sql_escape($create['users_email']) . "'");
  if(!empty($search_email)) {
    $error .= $cs_lang['email_exists'] . cs_html_br(1);
  }

  $pattern = "=^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([0-9a-z](-?[0-9a-z])*\.)+[a-z]{2}([zmuvtg]|fo|me)?$=i";
  if(!preg_match($pattern,$create['users_email'])) {
    $error .= $cs_lang['email_false'] . cs_html_br(1);
  }

  $flood = cs_sql_select(__FILE__,'users','users_register',0,'users_register DESC');
  $maxtime = $flood['users_register'] + $cs_main['def_flood'];
  if($maxtime > cs_time()) {
    $diff = $maxtime - cs_time();
    $error .= sprintf($cs_lang['flood_on'], $diff);
  }

  if(empty($create['access_id'])) {
    $error .= $cs_lang['no_access'] . cs_html_br(1);
  }

  isset($_POST['send_mail']) ? $rgsm = $_POST['send_mail'] : $rgsm = 0;
  $create_['send_mail'] = $rgsm;
}
else {

  $create['users_lang'] = $cs_main['def_lang'];
  $create['users_country'] = 'fam';
  $create['users_nick'] = '';
  $create_['password'] = '';
  $create['users_email'] = '';
  $create_['send_mail'] = 0;
  $create['access_id'] = 0;

  if(!empty($_GET['joinus'])) {
    $joinus_where = "joinus_id = '" . cs_sql_escape($_GET['joinus']) . "'";
    $cs_joinus = cs_sql_select(__FILE__,'joinus','*',$joinus_where);
    if(!empty($cs_joinus)) {
      $create['users_nick'] = $cs_joinus['joinus_nick'];
      $create['users_email'] = $cs_joinus['joinus_email'];
      $create['users_country'] = $cs_joinus['joinus_country'];
      $create['users_name'] = $cs_joinus['joinus_name'];
      $create['users_surname'] = $cs_joinus['joinus_surname'];
      $create['users_age'] = $cs_joinus['joinus_age'];
      $create['users_place'] = $cs_joinus['joinus_place'];
      $create['users_icq'] = $cs_joinus['joinus_icq'];
        $create['users_jabber'] = $cs_joinus['joinus_jabber'];
      $create['users_pwd'] = $cs_joinus['users_pwd'];
      $create['access_id'] = '3';
      $conv_joinus = 1;
    }
  }
}

if(!isset($_POST['submit']))
  $data['head']['body'] = $cs_lang['create_users'];
elseif(!empty($error))
  $data['head']['body'] = $error;

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['data'] = $create;

  $data['lang']['opts'] = '';
  $languages = cs_checkdirs('lang');
  foreach($languages as $lang) {
    $lang['name'] == $create['users_lang'] ? $sel = 1 : $sel = 0;
    $data['lang']['opts'] .= cs_html_option($lang['name'],$lang['name'],$sel);
  }

  $where = "access_clansphere <= '" . $account['access_clansphere'] . "'";
  $access_data = cs_sql_select(__FILE__,'access','access_name, access_id, access_clansphere',$where,'access_name',0,0);
  $data['access']['dropdown'] = cs_dropdown('access_id','access_name',$access_data,$create['access_id']);

  if(empty($conv_joinus)) {
    $data['if']['simple'] = TRUE;
    $data['if']['convert'] = FALSE;

    $matches[1] = $cs_lang['secure_stages'];
    $matches[2] = $cs_lang['stage_1'] . $cs_lang['stage_1_text'] . cs_html_br(1);
    $matches[2] .= $cs_lang['stage_2'] . $cs_lang['stage_2_text'] . cs_html_br(1);
    $matches[2] .= $cs_lang['stage_3'] . $cs_lang['stage_3_text'] . cs_html_br(1);
    $matches[2] .= $cs_lang['stage_4'] . $cs_lang['stage_4_text'];
    $data['clip']['pw_sec'] = cs_abcode_clip($matches);

  } else {
    $data['if']['simple'] = FALSE;
    $data['if']['convert'] = TRUE;

    $code_id = generate_code(8);
    $data['hidden']['password'] = $code_id;
    $data['hidden']['conv'] = $conv_joinus;
  }

  $data['check']['send_mail'] = empty($create_['send_mail']) ? '' : 'checked="checked"';
  $data['hidden']['flag'] = $create['users_country'];

 echo cs_subtemplate(__FILE__,$data,'users','create');
}
else {

  $create['users_timezone']   = empty($cs_main['def_timezone']) ? 0 : $cs_main['def_timezone'];
  $create['users_dstime']     = empty($cs_main['def_dstime']) ? 0 : $cs_main['def_dstime'];
  $users_id = create_user($create['access_id'],$create['users_nick'],$create_['password'],$create['users_lang'],$create['users_email'],$create['users_country'],$create['users_timezone'],$create['users_dstime']);

  if(!empty($conv_joinus) AND !empty($users_id)) {
    $array_keys = array('users_name', 'users_surname', 'users_age', 'users_place', 'users_icq', 'users_jabber', 'users_pwd');
    $array_values = array($create['users_name'], $create['users_surname'], $create['users_age'], $create['users_place'], $create['users_icq'], $create['users_jabber'], $create['users_pwd']);
    cs_sql_update(__FILE__, 'users', $array_keys, $array_values, $users_id);
  }

  if(!empty($create_['send_mail'])) {
    $content = $cs_lang['mail_reg_start'] . $cs_lang['mail_reg_nick'] . $create['users_nick'];
    if(empty($_POST['conv_joinus'])) {
      $content .= $cs_lang['mail_reg_password'] . $create_['password'];
    } else {
      $content .= $cs_lang['mail_reg_password'] . $cs_lang['mail_reg_password2'];
    }
    $ip = cs_getip();
    $content .= $cs_lang['mail_reg_ip'] . $ip;
    $content .= $cs_lang['mail_reg_ask'] . $cs_contact['def_mail'] . $cs_lang['mail_reg_end'];

    cs_mail($create['users_email'],$cs_lang['mail_reg_head'],$content);
  }

  cs_redirect($cs_lang['create_done'],'users');
}