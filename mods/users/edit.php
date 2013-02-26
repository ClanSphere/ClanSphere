<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

include_once 'lang/' . $account['users_lang'] . '/countries.php';
include_once 'mods/users/functions.php';

$data = array();

$users_id = (int) $_REQUEST['id'];

# check for access rights of target user
$from = 'users usr INNER JOIN {pre}_access acc ON usr.access_id = acc.access_id';
$select = 'acc.access_clansphere AS access_clansphere, acc.access_access AS access_access, acc.access_users AS access_users';
$target_user = cs_sql_select(__FILE__, $from, $select, 'users_id = ' . (int) $users_id);

$data['if']['allowed'] = false;
if($account['access_clansphere'] >= $target_user['access_clansphere'] AND 
   $account['access_access'] >= $target_user['access_access'] AND 
   $account['access_users'] >= $target_user['access_users'])
  $data['if']['allowed'] = true;

# if target user is granted more than the current user deny access
if(empty($data['if']['allowed'])) {
  $data['users']['body'] = $cs_lang['access_denied'];
  echo cs_subtemplate(__FILE__,$data,'users','edit');
}
else {
  if(isset($_POST['sendpw'])) {

    global $cs_db;
    $sPass = generate_code(8);
    if($cs_db['hash'] == 'md5') { 
      $aPass['users_pwd'] = md5($sPass); 
    } elseif($cs_db['hash'] == 'sha1') { 
      $aPass['users_pwd'] = sha1($sPass);
    }

    // DB update
    $users_cells = array_keys($aPass);
    $users_save = array_values($aPass);
    cs_sql_update(__FILE__,'users', $users_cells, $users_save, $users_id);

    // Send Mail
    $content = $cs_lang['mail_admin_sendpw_start'] . $_POST['data']['users_nick'];
    $content .= $cs_lang['mail_admin_sendpw_content'];
    $content .= $cs_lang['mail_admin_sendpw_pass'] . $sPass;
    $url = $cs_main['php_self']['website'] . $cs_main['php_self']['dirname'];
    $content .= sprintf($cs_lang['mail_admin_sendpw_url'], $url);
    $content .= $cs_lang['mail_admin_sendpw_end'] . $cs_main['def_title'];
    cs_mail($_POST['data']['users_email'],$cs_main['def_title'] . ' ' . $cs_lang['pwd_new'],$content);

    cs_redirect($cs_lang['mail_admin_sendpw_ok'], 'users');
  }

  if (isset($_POST['submit'])) {

    // Data rework after submit OR search submission
    $op_users = cs_sql_option(__FILE__, 'users');

    // Grep the data from the submitted array & single data
    $cs_user = $_POST['data'];
    $cs_user['users_id'] = $users_id;
    $data['users'] = $cs_user;

    // Get old user to prevent 'same nick' and 'same mail' error
    $old_user = cs_sql_select(__FILE__, 'users', 'users_email, users_nick', 'users_id = ' . $users_id);

    // Rework the hidden fields
    $hidden = array();
    $hidden_count = isset($_POST['hidden']) ? count($_POST['hidden']) : 0;

    $canhid = array(  'users_name',
                      'users_surname',
                      'users_age',
                      'users_height',
                      'users_adress',
                      'users_place',
                      'users_icq',
                      'users_jabber',
                      'users_skype',
                      'users_email',
                      'users_url',
                      'users_phone',
                      'users_mobile' );

    for($hc = 0; $hc < $hidden_count; $hc++) {
      if(in_array($_POST['hidden'][$hc],$canhid)) {
        $hidden[] = $_POST['hidden'][$hc];
      }
    }

    // More data polish
    $cs_user['users_country'] = isset($cs_country[$cs_user['users_country']]) ? $cs_user['users_country'] : 'fam';
    $cs_user['users_age'] = cs_datepost('age','date');
    $cs_user['access_id'] = (int)$_POST['access_id'];
    $cs_user['users_icq'] = str_replace('-','',$cs_user['users_icq']);

    // Error handling
    $error = 0;
    $errormsg = '';

    $nick2 = str_replace(' ', '', $cs_user['users_nick']);
    $nickchars = strlen($nick2);
    if ($nickchars < $op_users['min_letters']) {
      $error++;
      $errormsg .= sprintf($cs_lang['short_nick'], $op_users['min_letters']) . cs_html_br(1);
    }

    $where = "users_nick = '" . cs_sql_escape($cs_user['users_nick']) . "' AND users_id != ";
    $search_nick = cs_sql_count(__FILE__, 'users', $where . $users_id);
    if (!empty($search_nick) AND $old_user['users_nick'] != $cs_user['users_nick']) {
      $error++;
      $errormsg .= $cs_lang['nick_exists'] . cs_html_br(1);
    }

    $whr_acc = "access_id = " . cs_sql_escape($cs_user['access_id']);
    $get_acc = cs_sql_select(__FILE__, 'access', '*', $whr_acc);
    if ($get_acc['access_clansphere'] > $account['access_clansphere'] OR 
        $get_acc['access_access'] > $account['access_access'] OR 
        $get_acc['access_users'] > $account['access_users']) {
      $error++;
      $errormsg .= $cs_lang['access_denied'] . cs_html_br(1);
    }

    $where = "users_email = '" . cs_sql_escape($cs_user['users_email']) . "' AND users_id != ";
    $search_email = cs_sql_count(__FILE__, 'users', $where . $users_id);
    if (!empty($search_email) AND $old_user['users_email'] != $cs_user['users_email']) {
      $error++;
      $errormsg .= $cs_lang['email_exists'] . cs_html_br(1);
    }

    $pattern = "=^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([0-9a-z](-?[0-9a-z])*\.)+[a-z]{2}([zmuvtg]|fo|me)?$=i";
    if (!preg_match($pattern, $cs_user['users_email'])) {
      $error++;
      $errormsg .= $cs_lang['email_false'] . cs_html_br(1);
    }

    if (empty($cs_user['access_id'])) {
      $error++;
      $errormsg .= $cs_lang['no_access'] . cs_html_br(1);
    }
    
    if ((int) $_POST['age_year'].$_POST['age_month'].$_POST['age_day'] > (int) cs_datereal('Ymd')) {
      $error++;
      $errormsg .= $cs_lang['age_false'] . cs_html_br(1);
    }

  } else {

    // Get user from DB
    $cells = 'access_id, users_lang, users_nick, users_email, users_active, users_name, users_surname, users_sex, '
           . 'users_age, users_height, users_id, users_adress, users_postalcode, users_place, users_url, users_icq, '
           . 'users_jabber, users_skype, users_phone, users_mobile, users_info, users_signature, users_hidden, users_country, '
           . 'users_emailregister';

    $cs_user = cs_sql_select(__FILE__, 'users', $cells, 'users_id = ' . $users_id);
    $data['users'] = $cs_user;
  }

  if (!isset($_POST['submit'])) {
    $data['users']['body'] = $cs_lang['errors_here'];
  } elseif (!empty($error)) {
    $data['users']['body'] = $errormsg;
  }

  if (!empty($error) or !isset($_POST['submit'])) {

    // Set empty data when user is not found
    if(empty($cs_user['users_id'])) {
      $cs_user = array('access_id' => 0, 'users_active' => '', 'users_age' => '', 'users_country' => '',
                       'users_info' => '', 'users_lang' => '', 'users_sex' => '', 'users_signature' => '');
      $data['users'] = $cs_user;
    }

    // Edit addditional user information
    $hidden = empty($cs_user['users_hidden']) ? array() : explode(',',$cs_user['users_hidden']);
    $hidden = array_flip($hidden);
    if(empty($cs_user['users_height'])) { $cs_user['users_height'] = ''; }
    if(empty($cs_user['users_icq'])) { $cs_user['users_icq'] = ''; }

    $sel = 'selected="selected"';
    $checked = 'checked="checked"';

    $data['form']['action'] = cs_url('users','edit');
    $data['users']['users_age'] = cs_dateselect('age','date',$cs_user['users_age']);
    $data['users']['male_check'] = $cs_user['users_sex'] == 'male' ? $sel : '';
    $data['users']['female_check'] = $cs_user['users_sex'] == 'female' ? $sel : '';
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

    $data['users']['users_info'] = cs_secure($data['users']['users_info']);
    $data['abcode']['features'] = cs_abcode_features('users_info');
    $data['abcode']['smileys'] = cs_abcode_smileys('users_info');

    $data['users']['users_signature'] = cs_secure($data['users']['users_signature']);
    $data['abcode2']['features'] = cs_abcode_features('users_signature');
    $data['abcode2']['smileys'] = cs_abcode_smileys('users_signature');

    $data['country'] = array();

    $run = 0;
    foreach ($cs_country AS $short => $full) {
      $data['country'][$run]['short'] = $short;
      $data['country'][$run]['selection'] = $short == $cs_user['users_country'] ? ' selected="selected"' : '';
      $data['country'][$run]['full'] = $full;
      $run++;
    }
    
    $old_nicks = cs_sql_select(__FILE__,'usernicks','users_nick','users_id = ' . $users_id,'users_changetime DESC',0,0);
    $data['if']['old_nicks'] = false;
    if(!empty($old_nicks)) {
      $data['if']['old_nicks'] = true;
      for($a=0; $a<count($old_nicks); $a++) {
        $data['old'][$a]['nicks'] = $old_nicks[$a]['users_nick'];
      }
    }

    // State selections
    $data['users']['state_activated'] = $cs_user['users_active'] == 1 ? $sel : '';
    $data['users']['state_deactivated'] = $cs_user['users_active'] == 0 ? $sel : '';

    // Access
    $where = "access_clansphere <= '" . $account['access_clansphere'] . "'";
    $access_data = cs_sql_select(__FILE__, 'access', 'access_name, access_id, access_clansphere', $where, 'access_name', 0, 0);
    $data['users']['access_dropdown'] = cs_dropdown('access_id', 'access_name', $access_data, $cs_user['access_id']);

    // Languages
    $languages = cs_checkdirs('lang');
    foreach ($languages as $lang)
    $fixed_lang[]['data[users_lang]'] = $lang['name'];

    $data['users']['language_dropdown'] = cs_dropdown('data[users_lang]', 'data[users_lang]', $fixed_lang, $cs_user['users_lang']);

    // Output
    echo cs_subtemplate(__FILE__,$data,'users','edit');

  } else {

    $cs_user['users_hidden'] = implode(',',$hidden);

    $old_nick = cs_sql_select(__FILE__,'users','users_nick','users_id = ' . $users_id,0,0,1);
    if($old_nick['users_nick'] != $cs_user['users_nick']) {
      change_nick($users_id, $old_nick['users_nick']);
    }
    
    // DB update
    $users_cells = array_keys($cs_user);
    $users_save = array_values($cs_user);
    cs_sql_update(__FILE__, 'users', $users_cells, $users_save, $users_id);

    cs_cache_delete('navbirth');
    cs_cache_delete('nextbirth');

    cs_redirect($cs_lang['changes_done'], 'users');
  }
}