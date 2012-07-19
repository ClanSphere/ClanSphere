<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

//-----------------------------------------------------------------// 
// Zufallszeichenketten erzeugen 
//-----------------------------------------------------------------// 
function generate_code($anz = 0) {

  $pass = '';
  mt_srand((double)microtime() * 1000000);
  if($anz < 1) {
    $anz = mt_rand(16,32);
  }
  $a = 'abcdefghijklmnopqrstuvwxyz1029384756';
  $l = strlen($a) - 1;
  for($i = 0; $i < $anz; $i++) {
    $pass .= substr($a, mt_rand(0, $l), 1);
  }
  return $pass;
}

//-----------------------------------------------------------------// 
// Create user
//-----------------------------------------------------------------// 
function create_user($access,$nick,$pwd,$lang,$email,$country,$timezone,$dst,$newsletter = 0,$active = 1,$empty = 0,$regkey = '') {

  global $cs_db, $cs_main;
  if($cs_db['hash'] == 'md5') { 
    $sec_pwd = md5($pwd); 
  } elseif($cs_db['hash'] == 'sha1') { 
    $sec_pwd = sha1($pwd);
  }

  $op_users = cs_sql_option(__FILE__,'users');
  $picture = empty($op_users['def_picture']) ? '' : 'nopicture.jpg';
  $time = cs_time();
  $limit = empty($cs_main['data_limit']) ? 20 : $cs_main['data_limit'];

  $users_cells = array('access_id', 'users_nick', 'users_pwd', 'users_lang', 'users_email', 'users_emailregister', 'users_country', 'users_register', 'users_laston', 'users_timezone', 'users_dstime', 'users_newsletter', 'users_active', 'users_limit', 'users_regkey', 'users_picture', 'users_hidden');
  $users_save = array($access, $nick, $sec_pwd, $lang,$email, $email, $country, $time, $time, $timezone, $dst, $newsletter,
  $active, $limit, $regkey, $picture, 'users_email');
  cs_sql_insert(__FILE__,'users',$users_cells,$users_save);
  
  return cs_sql_insertid(__FILE__);
}

function change_nick($users_id, $users_nick) {
  $save_cont = array('users_id','users_nick','users_changetime');
  $save_cells = array($users_id,$users_nick,cs_time());
  cs_sql_insert(__FILE__,'usernicks',$save_cont,$save_cells);
}