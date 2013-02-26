<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('fightus');

$op_users = cs_sql_option(__FILE__,'users');

include_once('lang/' . $account['users_lang'] . '/countries.php');

$data = array();
$data['head']['getmsg'] = cs_getmsg();
$data['if']['form'] = empty($data['head']['getmsg']) ? TRUE : FALSE;

$data['if']['captcha'] = FALSE;
$captcha = 0;
if(empty($account['users_id']) AND extension_loaded('gd')) {
  $captcha = 1;
}

if(isset($_POST['submit'])) {

  $cs_fightus['games_id'] = empty($_POST['games_id']) ? 0 : $_POST['games_id'];
  $cs_fightus['squads_id'] = $_POST['squads_id'];
  $cs_fightus['fightus_nick'] = $_POST['fightus_nick'];
  $cs_fightus['fightus_clan'] = $_POST['fightus_clan'];
  $cs_fightus['fightus_short'] = $_POST['fightus_short'];
  $cs_fightus['fightus_url'] = $_POST['fightus_url'];
  $cs_fightus['fightus_country'] = $_POST['fightus_country'];
  $cs_fightus['fightus_icq'] = empty($_POST['fightus_icq']) ? 0 : str_replace('-','',$_POST['fightus_icq']);
  $cs_fightus['fightus_jabber'] = $_POST['fightus_jabber'];
  $cs_fightus['fightus_email'] = $_POST['fightus_email'];
  $cs_fightus['fightus_date'] = cs_datepost('fight','unix');
  $cs_fightus['fightus_more'] = $_POST['fightus_more'];

  $error = '';

  $nick2 = str_replace(' ','',$cs_fightus['fightus_nick']);
  $nickchars = strlen($nick2);
  
  if(empty($cs_fightus['fightus_nick'])) {
    $error .= $cs_lang['no_nick'] . cs_html_br(1);
  } elseif($nickchars < $op_users['min_letters']) {
    $error .= sprintf($cs_lang['short_nick'], $op_users['min_letters']) . cs_html_br(1);
  }
  if(empty($cs_fightus['fightus_clan'])) {
    $error .= $cs_lang['no_clan'] . cs_html_br(1);
  }
  if(empty($cs_fightus['fightus_short'])) {
    $error .= $cs_lang['no_short'] . cs_html_br(1);
  }
  if(empty($cs_fightus['fightus_date'])) {
    $error .= $cs_lang['no_date'] . cs_html_br(1);
  }

  $pattern = "=^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([0-9a-z](-?[0-9a-z])*\.)+[a-z]{2}([zmuvtg]|fo|me)?$=i";
  if(!preg_match($pattern,$cs_fightus['fightus_email'])) {
    $error .= $cs_lang['email_false'] . cs_html_br(1);
  }

  include_once 'mods/contact/trashmail.php';
  if(cs_trashmail($cs_fightus['fightus_email'])) {
    $error .= $cs_lang['email_false'] . cs_html_br(1);
  }

  $flood = cs_sql_select(__FILE__,'fightus','fightus_since',0,'fightus_since DESC');
  $maxtime = $flood['fightus_since'] + $cs_main['def_flood'];
  if($maxtime > cs_time()) {
    $error++;
    $diff = $maxtime - cs_time();
    $error .= sprintf($cs_lang['flood_on'], $diff);
  }
  if(empty($account['users_id'])) {
    if (!cs_captchacheck($_POST['captcha'])) {
        $error .= $cs_lang['captcha_false'] . cs_html_br(1);
    }
  }    
}
else {

  $cs_fightus['games_id'] = 0;
  $cs_fightus['squads_id'] = '';
  $cs_fightus['fightus_nick'] = '';
  $cs_fightus['fightus_clan'] = '';
  $cs_fightus['fightus_short'] = '';
  $cs_fightus['fightus_url'] = '';
  $cs_fightus['fightus_country'] = 'fam';
  $cs_fightus['fightus_icq'] = '';
  $cs_fightus['fightus_jabber'] = '';
  $cs_fightus['fightus_email'] = '';
  $cs_fightus['fightus_date'] = cs_time();
  $cs_fightus['fightus_more'] = '';

  if(!empty($account['users_id'])) {
    $fetch = 'users_nick, users_country, users_icq, users_jabber, users_email';
    $cs_user = cs_sql_select(__FILE__,'users',$fetch,"users_id = '" . $account['users_id'] . "'");
    $cs_fightus['fightus_nick'] = $cs_user['users_nick'];
    $cs_fightus['fightus_country'] = $cs_user['users_country'];
    $cs_fightus['fightus_icq'] = empty($cs_user['users_icq']) ? '' : $cs_user['users_icq'];
    $cs_fightus['fightus_jabber'] = $cs_user['users_jabber'];
    $cs_fightus['fightus_email'] = $cs_user['users_email'];
  }
}

if(!isset($_POST['submit'])) {
  $data['head']['body'] = $cs_lang['body_new'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $error;
}

if(!empty($data['if']['form']) AND (!empty($error) OR !isset($_POST['submit']))) {
  
  foreach($cs_fightus AS $key => $value)
    $data['fightus'][$key] = cs_secure($value);

  $data['games'] = cs_sql_select(__FILE__,'games','games_name,games_id',0,'games_name',0,0);
  $games_count = count($data['games']);
  for ($i = 0; $i < $games_count; $i++)
    $data['games'][$i]['games_name'] = cs_secure($data['games'][$i]['games_name']);
  
  $url = 'uploads/games/' . $cs_fightus['games_id'] . '.gif';
  $data['fightus']['games_img'] = cs_html_img($url,0,0,'id="game_1"');

  $cid = "squads_own = '1' AND squads_fightus = '0'";
  $cs_squads = cs_sql_select(__FILE__,'squads','squads_name, squads_id, squads_own, squads_fightus',$cid,'squads_name',0,0);
  $data['fightus']['squad_sel'] = cs_dropdown('squads_id','squads_name',$cs_squads,$cs_fightus['squads_id']);

  $el_id = 'country_1';
  $onc = "document.getElementById('" . $el_id . "').src='" . $cs_main['php_self']['dirname'] . "symbols/countries/' + this.form.";
  $onc .= "fightus_country.options[this.form.fightus_country.selectedIndex].value + '.png'";
  $data['fightus']['country_sel'] = cs_html_select(1,'fightus_country',"onchange=\"" . $onc . "\"");
  foreach ($cs_country AS $short => $full) {
    $short == $cs_fightus['fightus_country'] ? $sel = 1 : $sel = 0;
    $data['fightus']['country_sel'] .= cs_html_option($full,$short,$sel);
  }
  $data['fightus']['country_sel'] .= cs_html_select(0) . ' ';
  $url = 'symbols/countries/' . $cs_fightus['fightus_country'] . '.png';
  $data['fightus']['country_img'] = cs_html_img($url,11,16,'id="' . $el_id . '"');

  $data['fightus']['date_sel'] = cs_dateselect('fight','unix',$cs_fightus['fightus_date'],2000);

  $data['fightus']['abcode_smileys'] = cs_abcode_smileys('fightus_more');
  $data['fightus']['abcode_features'] = cs_abcode_features('fightus_more');

  if(!empty($captcha)) {
    $data['if']['captcha'] = TRUE;
    $data['fightus']['captcha_img'] = cs_html_img('mods/captcha/generate.php?time=' . cs_time());
  }
}
elseif(!empty($data['if']['form'])) {

  settype($cs_fightus['fightus_icq'],'integer');
  $cs_fightus['fightus_since'] = cs_time();
  $fightus_cells = array_keys($cs_fightus);
  $fightus_save = array_values($cs_fightus);
  cs_sql_insert(__FILE__,'fightus',$fightus_cells,$fightus_save);

  cs_cache_delete('count_fightus');

  require_once('mods/notifymods/functions.php');
  notifymods_mail('fightus', $account['users_id']);
  
  cs_redirect($cs_lang['success'],'fightus','new');
}

echo cs_subtemplate(__FILE__,$data,'fightus','new');