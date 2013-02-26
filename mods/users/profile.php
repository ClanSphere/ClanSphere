<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

include_once('lang/' . $account['users_lang'] . '/countries.php');
include_once('mods/users/functions.php');

$data = array();

if(isset($_POST['submit'])) {
  
  $op_users = cs_sql_option(__FILE__,'users');
  
  $cs_user['users_nick'] = $_POST['users_nick'];
  $cs_user['users_name'] = $_POST['users_name'];
  $cs_user['users_surname'] = $_POST['users_surname'];
  $cs_user['users_sex'] = $_POST['users_sex'];
  $cs_user['users_age'] = cs_datepost('age','date');
  $cs_user['users_height'] = $_POST['users_height'];
  $cs_user['users_country'] = $_POST['users_country'];
  $cs_user['users_postalcode'] = $_POST['users_postalcode'];
  $cs_user['users_place'] = $_POST['users_place'];
  $cs_user['users_adress'] = $_POST['users_adress'];
  $cs_user['users_icq'] = str_replace('-','',$_POST['users_icq']);
  $cs_user['users_jabber'] = $_POST['users_jabber'];
  $cs_user['users_skype'] = $_POST['users_skype'];
  $cs_user['users_email'] = $_POST['users_email'];
  $cs_user['users_url'] = $_POST['users_url'];
  $cs_user['users_phone'] = $_POST['users_phone'];
  $cs_user['users_mobile'] = $_POST['users_mobile'];
  $cs_user['users_info'] = $_POST['users_info'];

  $hidden = array();
  $hidden_count = isset($_POST['hidden']) ? count($_POST['hidden']) : 0;

  $canhid = array('users_name','users_surname','users_age','users_height','users_adress','users_place','users_icq','users_jabber','users_skype','users_email','users_url','users_phone','users_mobile');
  for($hc = 0; $hc < $hidden_count; $hc++) {
    if(in_array($_POST['hidden'][$hc],$canhid)) {
      $hidden[] = $_POST['hidden'][$hc];
    }
  }

  $error = 0;
  $errormsg = '';

  $nick2 = str_replace(' ','',$cs_user['users_nick']);
  $nickchars = strlen($nick2);
  if($nickchars < $op_users['min_letters']) {
    $error++;
    $errormsg .= sprintf($cs_lang['short_nick'],$op_users['min_letters']) . cs_html_br(1);
  }

  $where = "users_nick = '" . cs_sql_escape($cs_user['users_nick']) . "' AND users_id != ";
  $search_nick = cs_sql_count(__FILE__,'users',$where . $account['users_id']);
  if(!empty($search_nick)) {
    $error++;
    $errormsg .= $cs_lang['nick_exists'] . cs_html_br(1);
  }

  $where = "users_email = '" . cs_sql_escape($cs_user['users_email']) . "' AND users_id != ";
  $search_email = cs_sql_count(__FILE__,'users',$where . $account['users_id']);
  if(!empty($search_email)) {
    $error++;
    $errormsg .= $cs_lang['email_exists'] . cs_html_br(1);
  }
  
  $pattern = "=^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([0-9a-z](-?[0-9a-z])*\.)+[a-z]{2}([zmuvtg]|fo|me)?$=i";
  if(!preg_match($pattern,$cs_user['users_email'])) {
    $error++;
    $errormsg .= $cs_lang['email_false'] . cs_html_br(1);
  }

  include_once 'mods/contact/trashmail.php';
  if(cs_trashmail($cs_user['users_email'])) {
    $error++;
    $errormsg .= $cs_lang['email_false'] . cs_html_br(1);
  }

  if(!empty($cs_user['users_sex'])) {
    $cs_user['users_sex'] = $cs_user['users_sex'] == 'male' ? 'male' : 'female';
  }
  $country = $cs_user['users_country'];
  $cs_user['users_country'] = isset($cs_country[$country]) ? $cs_user['users_country'] : 'fam';
  
  if ((int) $_POST['age_year'].$_POST['age_month'].$_POST['age_day'] > (int) cs_datereal('Ymd')) {
    $error++;
    $errormsg .= $cs_lang['age_false'] . cs_html_br(1);
  }
}
else {
  $cells = 'users_nick, users_name, users_surname, users_sex, users_age, users_height, users_country, users_postalcode, users_place, users_adress, users_icq, users_jabber, users_skype, users_email, users_url, users_phone, users_mobile, users_info, users_hidden';
  $cs_user = cs_sql_select(__FILE__,'users',$cells,"users_id = '" . $account['users_id'] . "'");
  $hidden = explode(',',$cs_user['users_hidden']);
}
if(!isset($_POST['submit'])) {
 $data['users']['body'] = $cs_lang['errors_here'];
}
elseif(!empty($error)) {
  $data['users']['body'] = $errormsg;
}
else {
  $data['users']['body'] =  $cs_lang['changes_done'];
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $hidden = array_flip($hidden);
  if(empty($cs_user['users_height'])) { $cs_user['users_height'] = ''; }
  if(empty($cs_user['users_icq'])) { $cs_user['users_icq'] = ''; }

  $sel = 'selected="selected"';
  $checked = 'checked="checked"';

  $data['form']['action'] = cs_url('users','profile');
  $data['users']['users_nick'] = cs_secure($cs_user['users_nick']);
  $data['users']['users_name'] = cs_secure($cs_user['users_name']);
  $data['users']['users_surname'] = cs_secure($cs_user['users_surname']);
  $data['users']['users_age'] = cs_dateselect('age','date',$cs_user['users_age']);
  $data['users']['male_check'] = $cs_user['users_sex'] == 'male' ? $sel : '';
  $data['users']['female_check'] = $cs_user['users_sex'] == 'female' ? $sel : '';
  $data['users']['users_height'] = cs_secure($cs_user['users_height']);
  $data['users']['users_postalcode'] = cs_secure($cs_user['users_postalcode']);
  $data['users']['users_place'] = cs_secure($cs_user['users_place']);
  $data['users']['users_adress'] = cs_secure($cs_user['users_adress']);
  $data['users']['users_icq'] = cs_secure($cs_user['users_icq']);
  $data['users']['users_jabber'] = cs_secure($cs_user['users_jabber']);
  $data['users']['users_skype'] = cs_secure($cs_user['users_skype']);
  $data['users']['users_email'] = cs_secure($cs_user['users_email']);
  $data['users']['users_url'] = cs_secure($cs_user['users_url']);
  $data['users']['users_phone'] = cs_secure($cs_user['users_phone']);
  $data['users']['users_mobile'] = cs_secure($cs_user['users_mobile']);
  $data['users']['users_info'] = cs_secure($cs_user['users_info']);
  $data['users']['country_url'] = cs_html_img('symbols/countries/' . $cs_user['users_country'] . '.png',0,0,'id="country_1"');

  $data['hidden']['users_name'] = isset($hidden['users_name']) ? $checked : '';
  $data['hidden']['users_surname'] = isset($hidden['users_surname']) ? $checked : '';
  $data['hidden']['users_age'] = isset($hidden['users_age']) ? $checked : '';
  $data['hidden']['users_height'] = isset($hidden['users_height']) ? $checked : '';
  $data['hidden']['users_postalcode'] = isset($hidden['users_postalcode']) ? $checked : '';
  $data['hidden']['users_place'] = isset($hidden['users_place']) ? $checked : '';
  $data['hidden']['users_adress'] = isset($hidden['users_adress']) ? $checked : '';
  $data['hidden']['users_icq'] = isset($hidden['users_icq']) ? $checked : '';
  $data['hidden']['users_jabber'] = isset($hidden['users_jabber']) ? $checked : '';
  $data['hidden']['users_skype'] = isset($hidden['users_skype']) ? $checked : '';
  $data['hidden']['users_email'] = isset($hidden['users_email']) ? $checked : '';
  $data['hidden']['users_url'] = isset($hidden['users_url']) ? $checked : '';
  $data['hidden']['users_phone'] = isset($hidden['users_phone']) ? $checked : '';
  $data['hidden']['users_mobile'] = isset($hidden['users_mobile']) ? $checked : '';

  $data['abcode']['features'] =cs_abcode_features('users_info');
  $data['abcode']['smileys'] = cs_abcode_smileys('users_info');

  $data['country'] = array();

  $run = 0;
  foreach ($cs_country AS $short => $full) {
    $data['country'][$run]['short'] = $short;
    $data['country'][$run]['selection'] = $short == $cs_user['users_country'] ? ' selected="selected"' : '';
    $data['country'][$run]['full'] = $full;
    $run++;
  }

  echo cs_subtemplate(__FILE__,$data,'users','profile');
}
else {
  settype($cs_user['users_height'],'integer');
  settype($cs_user['users_icq'],'integer');
  $cs_user['users_hidden'] = implode(',',$hidden);
  
  if($cs_user['users_nick'] != $account['users_nick']) {
    change_nick($account['users_id'], $account['users_nick']);
  }

  $users_cells = array_keys($cs_user);
  $users_save = array_values($cs_user);
  cs_sql_update(__FILE__,'users',$users_cells,$users_save,$account['users_id']);

  cs_cache_delete('navbirth');
  cs_cache_delete('nextbirth');

  $data['link']['continue'] = cs_url('users','home');
  $data['lang']['head'] = $cs_lang['profile'];

  echo cs_subtemplate(__FILE__,$data,'users','done');

  if($account['access_wizard'] == 5) {
    $wizard = cs_sql_count(__FILE__,'options',"options_name = 'done_prfl' AND options_value = '1'");
    if(empty($wizard)) {
      $data['wizard']['show'] = cs_link($cs_lang['show'],'wizard','roots');
      $data['wizard']['task_done'] = cs_link($cs_lang['task_done'],'wizard','roots','handler=prfl&amp;done=1');
    echo cs_subtemplate(__FILE__,$data,'users','wizard');
    }
  }
} 