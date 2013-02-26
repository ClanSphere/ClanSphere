<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('joinus');

include_once('lang/' . $account['users_lang'] . '/countries.php');

$data = array();
$data['op'] = cs_sql_option(__FILE__,'joinus');
$data['head']['getmsg'] = cs_getmsg();
$data['if']['form'] = empty($data['head']['getmsg']) ? TRUE : FALSE;

$captcha = 0;
if(empty($account['users_id']) AND extension_loaded('gd')) {
  $captcha = 1;
}

foreach($data['op'] AS $key => $value) {
  if(!empty($value)) {
    $data['if'][$key] = true;
  }
  else {
    $data['if'][$key] = false;
  }
}

$data['if']['pass'] = 0;
$data['if']['nopass'] = 1;
$data['if']['captcha'] = 0;

if(isset($_POST['submit'])) {

  $data['join']['games_id'] = $_POST['games_id'];
  $data['join']['squads_id'] = $_POST['squads_id'];
  $data['join']['joinus_nick'] = $_POST['joinus_nick'];
  $data['join']['joinus_name'] = $_POST['joinus_name'];
  $data['join']['joinus_surname'] = $_POST['joinus_surname'];
  $data['join']['joinus_age'] = cs_datepost('age','date');
  $data['join']['joinus_country'] = $_POST['joinus_country'];
  $data['join']['joinus_place'] = $_POST['joinus_place'];
  $data['join']['joinus_icq'] = empty($_POST['joinus_icq']) ? 0 : str_replace('-','',$_POST['joinus_icq']);
  $data['join']['joinus_jabber'] = $_POST['joinus_jabber'];
  $data['join']['joinus_email'] = $_POST['joinus_email'];
  $data['join']['joinus_lanact'] = $_POST['joinus_lanact'];
  $data['join']['joinus_webcon'] = $_POST['joinus_webcon'];
  $data['join']['joinus_date'] = cs_datepost('join','date');
  $data['join']['joinus_more'] = $_POST['joinus_more'];
  $data2['join']['joinus_rules'] = empty($_POST['joinus_rules']) ? 0 : 1;

  if(empty($account['users_id'])) {
    $data['join']['users_pwd'] = $_POST['users_pwd'];
  } else {
    $data['if']['pass'] = 1;
    $data['if']['nopass'] = 0;
  }

  $error = 0;
  $errormsg = '';

  $nick2 = str_replace(' ','',$data['join']['joinus_nick']);
  $nickchars = strlen($nick2);

  $op_users = cs_sql_option(__FILE__,'users');

  if($nickchars < $op_users['min_letters']) {
    $error++;
    $errormsg .= sprintf($cs_lang['short_nick'], $op_users['min_letters']) . cs_html_br(1);
  }
  if(empty($account['users_id'])) {
    $pwd2 = str_replace(' ','',$data['join']['users_pwd']);
    $pwdchars = strlen($pwd2);
    if($pwdchars<4) {
      $error++;
      $errormsg .= $cs_lang['short_pwd'] . cs_html_br(1);
    }
  }
  if(!empty($data['if']['vorname'])) {
    if(empty($data['join']['joinus_name'])) {
      $error++;
      $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
    }
  }
  if(!empty($data['if']['surname'])) {
    if(empty($data['join']['joinus_surname'])) {
      $error++;
      $errormsg .= $cs_lang['no_surname'] . cs_html_br(1);
    }
  }
  if(!empty($data['if']['place'])) {
    if(empty($data['join']['joinus_place'])) {
      $error++;
      $errormsg .= $cs_lang['no_place'] . cs_html_br(1);
    }
  }
  if(!empty($data['if']['country'])) {
    if(empty($data['join']['joinus_country'])) {
      $error++;
      $errormsg .= $cs_lang['no_country'] . cs_html_br(1);
    }
  }
  if(!empty($data['if']['icq'])) {
    if(empty($data['join']['joinus_icq'])) {
      $error++;
      $errormsg .= $cs_lang['no_icq'] . cs_html_br(1);
    }
  }
  if(!empty($data['if']['jabber'])) {
    if(empty($data['join']['joinus_jabber'])) {
      $error++;
      $errormsg .= $cs_lang['no_jabber'] . cs_html_br(1);
    }
  }
  if(!empty($data['if']['game'])) {
    if(empty($data['join']['games_id'])) {
      $error++;
      $errormsg .= $cs_lang['no_game'] . cs_html_br(1);
    }
  }
  if(!empty($data['if']['squad'])) {
    if(empty($data['join']['squads_id'])) {
      $error++;
      $errormsg .= $cs_lang['no_squad'] . cs_html_br(1);
    }
  }
  if(!empty($data['if']['webcon'])) {
    if(empty($data['join']['joinus_webcon'])) {
      $error++;
      $errormsg .= $cs_lang['no_webcon'] . cs_html_br(1);
    }
  }
  if(!empty($data['if']['lanact'])) {
    if(empty($data['join']['joinus_lanact'])) {
      $error++;
      $errormsg .= $cs_lang['no_lanact'] . cs_html_br(1);
    }
  }
  if(!empty($data['if']['more'])) {
    if(empty($data['join']['joinus_more'])) {
      $error++;
      $errormsg .= $cs_lang['no_info'] . cs_html_br(1);
    }
  }
  if(empty($data['join']['joinus_age'])) {
    $error++;
    $errormsg .= $cs_lang['no_age'] . cs_html_br(1);
  }
  if(empty($data['join']['joinus_date'])) {
    $error++;
    $errormsg .= $cs_lang['no_date'] . cs_html_br(1);
  }
  if(empty($data2['join']['joinus_rules'])) {
    $error++;
    $errormsg .= $cs_lang['no_rules'] . cs_html_br(1);
  }

  $pattern = "=^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([0-9a-z](-?[0-9a-z])*\.)+[a-z]{2}([zmuvtg]|fo|me)?$=i";
  if(!preg_match($pattern,$data['join']['joinus_email'])) {
    $error++;
    $errormsg .= $cs_lang['email_false'] . cs_html_br(1);
  }

  include_once 'mods/contact/trashmail.php';
  if(cs_trashmail($data['join']['joinus_email'])) {
    $error++;
    $errormsg .= $cs_lang['email_false'] . cs_html_br(1);
  }

  $flood = cs_sql_select(__FILE__,'joinus','joinus_since',0,'joinus_since DESC');
  $maxtime = $flood['joinus_since'] + $cs_main['def_flood'];
  if($maxtime > cs_time()) {
    $error++;
    $diff = $maxtime - cs_time();
    $errormsg .= sprintf($cs_lang['flood_on'], $diff);
  }
  if(empty($account['users_id'])) {
    if (!cs_captchacheck($_POST['captcha'])) {
      $error++;
      $errormsg .= $cs_lang['captcha_false'] . cs_html_br(1);
    }
  }

  $and = ' AND users_id != ' . $account['users_id'];
  $search_email = cs_sql_count(__FILE__,'users',"users_email = '" . cs_sql_escape($data['join']['joinus_email']) . "'" . $and);
  if(!empty($search_email)) {
    $error++;
    $errormsg .= $cs_lang['email_exists'] . cs_html_br(1);
  }

  $search_nick = cs_sql_count(__FILE__,'users',"users_nick = '" . cs_sql_escape($data['join']['joinus_nick']) . "'" . $and);
  if(!empty($search_nick)) {
    $error++;
    $errormsg .= $cs_lang['nick_exists'] . cs_html_br(1);
  }

  if ((int) $_POST['age_year'].$_POST['age_month'].$_POST['age_day'] > (int) cs_datereal('Ymd')) {
    $error++;
    $errormsg .= $cs_lang['age_false'] . cs_html_br(1);
  }
}
else {
  $data['join']['games_id'] = '';
  $data['join']['squads_id'] = '';
  $data['join']['joinus_nick'] = '';
  $data['join']['joinus_name'] = '';
  $data['join']['joinus_surname'] = '';
  $data['join']['joinus_age'] = 0;
  $data['join']['joinus_country'] = 'fam';
  $data['join']['joinus_place'] = '';
  $data['join']['joinus_icq'] = '';
  $data['join']['joinus_jabber'] = '';
  $data['join']['joinus_email'] = '';
  $data['join']['joinus_lanact'] = '';
  $data['join']['joinus_webcon'] = '';
  $data['join']['joinus_date'] = cs_datereal('Y-m-d');
  $data['join']['joinus_more'] = '';
  $data['join']['users_pwd'] = '';
  $data2['join']['joinus_rules'] = 0;

  if(!empty($account['users_id'])) {
    $fetch = 'users_nick, users_name, users_surname, users_age, users_country, users_place, users_icq, users_jabber, users_email';
    $cs_user = cs_sql_select(__FILE__,'users',$fetch,"users_id = '" . $account['users_id'] . "'");
    $data['join']['joinus_nick'] = $cs_user['users_nick'];
    $data['join']['joinus_name'] = $cs_user['users_name'];
    $data['join']['joinus_surname'] = $cs_user['users_surname'];
    $data['join']['joinus_age'] = $cs_user['users_age'];
    $data['join']['joinus_country'] = $cs_user['users_country'];
    $data['join']['joinus_place'] = $cs_user['users_place'];
    $data['join']['joinus_icq'] = empty($cs_user['users_icq']) ? '' : $cs_user['users_icq'];
    $data['join']['joinus_jabber'] = $cs_user['users_jabber'];
    $data['join']['joinus_email'] = $cs_user['users_email'];
    $data['if']['pass'] = 1;
    $data['if']['nopass'] = 0;
  }
}

if (!empty($data['head']['getmsg'])) {
  $data['lang']['body'] = $cs_lang['new_join'];
}
elseif(!isset($_POST['submit'])) {
  $data['lang']['body'] = $cs_lang['body_new'];
}
elseif(!empty($error)) {
  $data['lang']['body'] = $errormsg;
}

if(!empty($data['if']['form']) AND (!empty($error) OR !isset($_POST['submit']))) {

  foreach($data['join'] AS $key => $value)
  $data['join'][$key] = cs_secure($value);

  $data['join']['date'] = cs_dateselect('age','date',$data['join']['joinus_age']);
  $data['join']['country_url'] = cs_html_img('/symbols/countries/' . $data['join']['joinus_country'] . '.png',0,0,'id="country_1"');
  $data['country'] = array();
  $run = 0;
  foreach ($cs_country AS $short => $full) {
    $data['country'][$run]['short'] = $short;
    $data['country'][$run]['selection'] = $short == $data['join']['joinus_country'] ? ' selected="selected"' : '';
    $data['country'][$run]['full'] = $full;
    $run++;
  }
  $data['join']['games_url'] = cs_html_img('uploads/games/0.gif',0,0,'id="game"');
  $data['games'] = array();
  $cs_games = cs_sql_select(__FILE__,'games','games_name,games_id',0,'games_name',0,0);
  for($run = 0; $run < count($cs_games); $run++) {
    $data['games'][$run]['short'] = $cs_games[$run]['games_id'];
    $data['games'][$run]['selection'] = $cs_games[$run]['games_id'] == $data['join']['games_id'] ? ' selected="selected"' : '';
    $data['games'][$run]['name'] = $cs_games[$run]['games_name'];
  }
  $cid = "squads_own = '1' AND squads_joinus = '0'";
  $squads_data = cs_sql_select(__FILE__,'squads','squads_name, squads_id, squads_own, squads_joinus',$cid,'squads_name',0,0);
  $data['squad']['list'] = cs_dropdown('squads_id','squads_name',$squads_data,$data['join']['squads_id']);
  $data['date']['join'] = cs_dateselect('join','date',$data['join']['joinus_date'],2000);
  $data['abcode']['smileys'] = cs_abcode_smileys('joinus_more');
  $data['abcode']['features'] = cs_abcode_features('joinus_more');

  $data['rules']['link'] = cs_html_link(cs_url('rules','list'),$cs_lang['rules']);
  $data['joinus']['rules_selected'] = !empty($data2['join']['joinus_rules']) ? 'checked="checked"' : '';
  if(!empty($captcha)) {
          $data['join']['captcha_img'] = cs_html_img('mods/captcha/generate.php?time=' . cs_time());
          $data['if']['captcha'] = 1;
  }

}
elseif(!empty($data['if']['form'])) {

  if(empty($account['users_id'])) {
    global $cs_db;
    if($cs_db['hash'] == 'md5') { $data['join']['users_pwd'] = md5($data['join']['users_pwd']);
    } elseif($cs_db['hash'] == 'sha1') { $data['join']['users_pwd'] = sha1($data['join']['users_pwd']); }
  }

  settype($data['join']['joinus_icq'],'integer');
  $data['join']['joinus_since'] = cs_time();
  $joinus_cells = array_keys($data['join']);
  $joinus_save = array_values($data['join']);
  cs_sql_insert(__FILE__,'joinus',$joinus_cells,$joinus_save);

  $joinus_id = cs_sql_insertid(__FILE__);

  cs_cache_delete('count_joinus');

  require_once('mods/notifymods/functions.php');
  notifymods_mail('joinus', $account['users_id']);

  $tables = "joinus ju INNER JOIN {pre}_members mem ON ju.squads_id = mem.squads_id AND mem.members_admin = '1' ";
  $tables .= 'INNER JOIN {pre}_squads sq ON ju.squads_id = sq.squads_id';
  $cells = 'ju.squads_id AS squads_id, mem.users_id AS users_id, sq.squads_name AS squads_name';
  $select = cs_sql_select(__FILE__,$tables,$cells,"ju.joinus_id = '" . $joinus_id . "'",0,0,0);
  $select_count = count($select);

  for ($run = 0; $run < $select_count; $run++) {
    $user = cs_sql_select(__FILE__,'users','users_id',"users_id = '" . $select[$run]['users_id'] . "'");
    $message['users_id'] = '1';
    $message['users_id_to'] = $user['users_id'];
    $message['messages_time'] = cs_time();
    $message['messages_subject'] = $cs_lang['new_joinus'] . $select[$run]['squads_name'];
    $message['messages_text'] = $cs_lang['new_joinus_text'] . $select[$run]['squads_name'] . $cs_lang['new_joinus_text2'];
    //  $message['messages_text'] .= $cs_lang['since'] . ': ' . $cs_joinus['joinus_date'];
    //  $message['messages_text'] .= $cs_lang['nick'] . ': ' . $cs_joinus['joinus_nick'];
    //  $message['messages_text'] .= $cs_lang['vorname'] . ': ' . $cs_joinus['joinus_name'];
    //  $message['messages_text'] .= $cs_lang['surname'] . ': ' . $cs_joinus['joinus_surname'];
    //  $message['messages_text'] .= $cs_lang['birthday'] . ': ' . $cs_joinus['joinus_age'];
    $message['messages_text'] .= ' ' . $cs_lang['new_joinus_text3'];
    $message['messages_show_receiver'] = '1';
    $messages_cells = array_keys($message);
    $messages_save = array_values($message);
    cs_sql_insert(__FILE__,'messages',$messages_cells,$messages_save);
  }
  cs_redirect($cs_lang['new_done'],'joinus','new');
}

echo cs_subtemplate(__FILE__,$data,'joinus','new');