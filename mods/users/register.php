<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$op_users = cs_sql_option(__FILE__,'users');
$cs_contact = cs_sql_option(__FILE__, 'contact');

require_once('mods/users/functions.php');

$data = array();

if(empty($op_users['register'])) {
  echo cs_subtemplate(__FILE__,$data,'users','register_disabled');
} else {
  $captcha = extension_loaded('gd') ? 1 : 0;
  $languages = cs_checkdirs('lang');
  $error = 0;
  $errormsg = '';

  if(isset($_POST['submit'])) {
    $register['lang'] = empty($_POST['lang']) ? '' : $_POST['lang'];
    $register['nick'] = empty($_POST['nick']) ? '' : $_POST['nick'];
    $register['password'] = empty($_POST['password']) ? '' : $_POST['password'];
    $register['email'] = empty($_POST['email']) ? '' : $_POST['email'];
    $register['newsletter'] = empty($_POST['newsletter']) ? 0 : 1;

    $userlang = $register['lang'];
    $register['lang'] = isset($languages[$userlang]) ? $register['lang'] : $cs_main['def_lang'];

    $nick2 = str_replace(' ','',$register['nick']);
    $nickchars = strlen($nick2);
    if($nickchars < $op_users['min_letters']) {
      $error++;
      $errormsg .= sprintf($cs_lang['short_nick'],$op_users['min_letters']) . cs_html_br(1);
    }

    $search_nick = cs_sql_count(__FILE__,'users',"users_nick = '" . cs_sql_escape($register['nick']) . "'");
    if(!empty($search_nick)) {
      $error++;
      $errormsg .= $cs_lang['nick_exists'] . cs_html_br(1);
    }

    $search_nick = strpos($register['nick'], '&#9829;');
    if(!empty($search_nick)) {
      $error++;
      $errormsg .= $cs_lang['chars_in_nick'] . cs_html_br(1);
    }

    $pwd2 = str_replace(' ','',$register['password']);
    $pwdchars = strlen($pwd2);
    if($pwdchars<4) {
      $error++;
      $errormsg .= $cs_lang['short_pwd'] . cs_html_br(1);
    }

    $search_email = cs_sql_count(__FILE__,'users',"users_email = '" . cs_sql_escape($register['email']) . "'");
    if(!empty($search_email)) {
      $error++;
      $errormsg .= $cs_lang['email_exists'] . cs_html_br(1);
    }

    $pattern = "=^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([0-9a-z](-?[0-9a-z])*\.)+[a-z]{2}([zmuvtg]|fo|me)?$=i";
    if(!preg_match($pattern,$register['email'])) {
      $error++;
      $errormsg .= $cs_lang['email_false'] . cs_html_br(1);
    }

    include_once 'mods/contact/trashmail.php';
    if(cs_trashmail($register['email'])) {
      $error++;
      $errormsg .= $cs_lang['email_false'] . cs_html_br(1);
    }

  $flood = cs_sql_select(__FILE__,'users','users_register',0,'users_register DESC');
  $maxtime = $flood['users_register'] + $cs_main['def_flood'];
  if($maxtime > cs_time()) {
    $error++;
    $diff = $maxtime - cs_time();
    $errormsg .= sprintf($cs_lang['flood_on'], $diff) . cs_html_br(1);
  }

  if(empty($op_users['def_register']) OR $op_users['def_register'] == '2') {
      if(!cs_captchacheck($_POST['captcha'])) {
        $error++;
        $errormsg .= $cs_lang['captcha_false'] . cs_html_br(1);
      }
    }

    isset($_POST['send_mail']) ? $rgsm = $_POST['send_mail'] : $rgsm = 0;
    $register['send_mail'] = $rgsm;

  } else {

    $register['lang'] = $cs_main['def_lang'];
    $register['nick'] = '';
    $register['password'] = '';
    $register['email'] = '';
    $register['send_mail'] = 0;
    $register['newsletter'] = '';
  }

  if(!isset($_POST['submit'])) {
    $data['head']['body_text'] = $cs_lang['register_info'];
  } elseif(!empty($error)) {
    $data['head']['body_text'] = $errormsg;
  } else {
    $data['head']['body_text'] = $cs_lang['reg_done'];
  }

  if(!empty($error) OR !isset($_POST['submit'])) {

  $data['head']['action'] = $cs_lang['register'];
  echo cs_subtemplate(__FILE__,$data,'users','head');

  $data = array();
  $data['form']['register'] = cs_url('users','register');
  $data['register']['nick'] = $register['nick'];
  $data['register']['password'] = $register['password'];
  $data['register']['email'] = $register['email'];
  $data['register']['send_mail'] = $register['send_mail'];
  $data['register']['languages'] = '';
  $data['checked']['newsletter'] = empty($register['newsletter']) ? '' : 'checked';
  $data['checked']['email'] = empty($register['send_mail']) ? '' : 'checked';

  foreach($languages as $lang) {
    $lang['name'] == $register['lang'] ? $sel = 1 : $sel = 0;
  $data['register']['languages'] .= cs_html_option($lang['name'],$lang['name'],$sel);
  }

  $data['if']['captcha'] = 0;

  if(empty($op_users['def_register']) OR $op_users['def_register'] == '2') {
    if(!empty($captcha)) {
      $data['if']['captcha'] = 1;
      $data['captcha']['img'] = cs_html_img('mods/captcha/generate.php?time=' . cs_time());
    }
  }
  if(empty($op_users['def_register']) OR $op_users['def_register'] == '2') {
    if($op_users['def_register'] != '2') {
      $data['if']['reg_mail'] = 1;
    }
    else {
      $data['if']['reg_mail'] = 0;
    }
      echo cs_subtemplate(__FILE__,$data,'users','register_code');
    }
    else {
      echo cs_subtemplate(__FILE__,$data,'users','register_mail');
    }
  }
  else {
    $code_id = generate_code(30); // 30 Zeichen lang
    $register['users_key'] = $code_id;
    $active = empty($op_users['def_register']) ? $register['users_active'] = 1 : $register['users_active'] = 0;
    $def_timezone = empty($cs_main['def_timezone']) ? 0 : $cs_main['def_timezone'];
    $def_dstime = empty($cs_main['def_dstime']) ? 0 : $cs_main['def_dstime'];
    create_user(2,$register['nick'],$register['password'],$register['lang'],$register['email'],'fam',$def_timezone,$def_dstime,$register['newsletter'],$active,20,$register['users_key']);

    $ip = cs_getip();
    if(!empty($register['send_mail']) OR !empty($op_users['def_register']) OR $op_users['def_register'] == '2') {
      $content = $cs_lang['mail_reg_start'] . $cs_lang['mail_reg_nick'] . $register['nick'];
      $content .= $cs_lang['mail_reg_password'] . $register['password'];
      $content .= $cs_lang['mail_reg_ip'] . $ip;
      if(!empty($op_users['def_register'])) {
        $content .= "\n" . $cs_lang['mail_key'] . ': ';
        $content .= $cs_main['php_self']['website'] . str_replace('&amp;', '&', cs_url('users', 'activate', 'key=' . $register['users_key'] . '&email=' . $register['email']));
      }
      $content .= $cs_lang['mail_reg_ask'] . $cs_contact['def_mail'] . $cs_lang['mail_reg_end'];
      cs_mail($register['email'],$cs_lang['mail_reg_head'],$content);
    }

    $data['lang']['head'] = $cs_lang['register'];
    $data['link']['continue'] = cs_url('users','login');

    $data['lang']['success'] = !empty($op_users['def_register']) ? $cs_lang['done2'] : $cs_lang['done'];
    echo cs_subtemplate(__FILE__,$data,'users','done');
  }
}