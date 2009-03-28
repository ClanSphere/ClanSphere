<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

//-----------------------------------------------------------------// 
// Zufallszeichenketten erzeugen 
//-----------------------------------------------------------------// 
function generate_code($anz = 0) {

  $pass = 0;
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
function create_user($access,$nick,$pwd,$lang,$email,$country,$timezone,$dst,$newsletter = 0,$active = 1,$limit = 20,$regkey = '') {

  global $cs_db, $op_users;

  $time = cs_time();

  if($cs_db['hash'] == 'md5') { 
    $sec_pwd = md5($pwd); 
  } elseif($cs_db['hash'] == 'sha1') { 
    $sec_pwd = sha1($pwd);
  }

  $picture = empty($op_users['def_picture']) ? '' : 'nopicture.jpg';

  $users_cells = array('access_id', 'users_nick', 'users_pwd', 'users_lang', 'users_email', 'users_country', 'users_register', 'users_laston', 'users_timezone', 'users_dstime', 'users_newsletter', 'users_active', 'users_limit', 'users_regkey', 'users_picture');
  $users_save = array($access,$nick,$sec_pwd,$lang,$email,$country,$time,$time,$timezone,$dst,$newsletter,$active,$limit,$regkey,$picture);
  cs_sql_insert(__FILE__,'users',$users_cells,$users_save);
}
 
?>