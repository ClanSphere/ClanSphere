<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$users_id = $_GET['id'];
settype($users_id,'integer');
$cs_user = cs_sql_select(__FILE__,'users','*',"users_id = '" . $users_id . "'");

if(empty($cs_user['users_active'])) {
  $data['head']['action'] = $cs_lang['profile'];
  $data['head']['body_text'] = $cs_lang['not_active_text'];

  echo cs_subtemplate(__FILE__,$data,'users','head');

  $data['lang']['not_active'] = $cs_lang['not_active'];
  echo cs_subtemplate(__FILE__,$data,'users','not_active');
}
elseif(!empty($cs_user['users_delete'])) {
  $data['head']['action'] = $cs_lang['profile'];
  $data['head']['body_text'] = $cs_lang['delete_text'];

  echo cs_subtemplate(__FILE__,$data,'users','head');

  $data['lang']['delete'] = $cs_lang['delete'];
  echo cs_subtemplate(__FILE__,$data,'users','delete');
}
else {
  $data['head']['action'] = $cs_lang['profile'];
  $data['head']['body_text'] = cs_addons('users','view',$users_id,'users');

  echo cs_subtemplate(__FILE__,$data,'users','head');
  
  $old_nick = cs_sql_select(__FILE__,'usernicks','users_nick','users_id = ' . $users_id,'users_changetime DESC',0,1);
  $data['if']['old_nick'] = false;
  if(!empty($old_nick)) {
    $data['if']['old_nick'] = true;
    $data['users']['old_nick'] = $old_nick['users_nick'];  
  }

  $data['users']['id'] = $cs_user['users_id'];

  $data['if']['buddies_active'] = (empty($account['access_buddys']) OR $account['access_buddys'] < 2) ? false : true;

  $hidden = explode(',',$cs_user['users_hidden']);
  #$allow = $users_id == $account['users_id'] OR $account['access_users'] > 4 ? 1 : 0;
  $allow = 0;
  if($users_id == $account['users_id'] OR $account['access_users'] > 4) {
    $allow = 1;
  }

  $data['if']['own_profile'] = $users_id == $account['users_id'] ? true : false;
  $data['url']['picture'] = cs_url('users','picture');
  $data['url']['profile'] = cs_url('users','profile');

  $data['users']['nick'] = cs_secure($cs_user['users_nick']);
  $data['url']['message_create'] = cs_url('messages','create','to_id=' . $cs_user['users_id']);
  if(empty($cs_user['users_picture'])) {
    $data['users']['picture'] = $cs_lang['nopic'];
  } else {
    $place = 'uploads/users/' . $cs_user['users_picture'];
    $size = getimagesize($cs_main['def_path'] . '/' . $place);
    $data['users']['picture'] = cs_html_img($place,$size[1],$size[0]);
  }  

  $content = cs_secure($cs_user['users_name']);
  if(in_array('users_name',$hidden)) {
    $content = empty($allow) ? '--' : cs_html_italic(1) . $content . cs_html_italic(0);
  }
  $data['users']['name'] =  empty($cs_user['users_name']) ? '--' : $content;

  $content = cs_secure($cs_user['users_surname']);
  if(in_array('users_surname',$hidden)) {
    $content = empty($allow) ? '--' : cs_html_italic(1) . $content . cs_html_italic(0);
  }
  $data['users']['surname'] = empty($cs_user['users_surname']) ? '--' : $content;

  $data['lang']['sex'] = $cs_lang['sex'];
  if(empty($cs_user['users_sex'])) { $data['users']['sex'] = '--'; }
  if($cs_user['users_sex'] == 'male') { $data['users']['sex'] = $cs_lang['male']; }
  if($cs_user['users_sex'] == 'female') { $data['users']['sex'] = $cs_lang['female']; }

  $data['lang']['birth_age'] = $cs_lang['birth_age'];
  if (!empty($cs_user['users_age'])) {
    $content = cs_date('date',$cs_user['users_age']);
    $birth = explode ('-', $cs_user['users_age']);
    $age = cs_datereal('Y') - $birth[0];
    if(cs_datereal('m')<=$birth[1]) { $age--; }
    if(cs_datereal('d')>=$birth[2] AND cs_datereal('m')==$birth[1]) { $age++; }
    $content .= ' (' . $age . ')';
  }
  if(in_array('users_age',$hidden)) {
    $content = empty($allow) ? '--' : cs_html_italic(1) . $content . cs_html_italic(0);
  }
  $data['users']['age'] = empty($cs_user['users_age']) ? '--' : $content;

  $content = empty($cs_user['users_height']) ? '--' : $cs_user['users_height'] . ' cm';
  if(in_array('users_height',$hidden)) {
    $content = empty($allow) ? '--' : cs_html_italic(1) . $content . cs_html_italic(0);
  }
  $data['users']['height'] = empty($cs_user['users_height']) ? '--' : $content;
  
  $content = cs_secure($cs_user['users_adress']);
  if(in_array('users_adress',$hidden)) {
    $content = empty($allow) ? '--' : cs_html_italic(1) . $content . cs_html_italic(0);
  }
  $data['users']['adress'] = empty($cs_user['users_adress']) ? '--' : $content;
  
  $data['lang']['postal_place'] = $cs_lang['postal_place'];
  if(empty($cs_user['users_postalcode']) AND empty($cs_user['users_place'])) {
    $data['users']['postal_place'] =  '--';
  }
  else {
    $content = cs_secure($cs_user['users_postalcode']) . ' - ' . cs_secure($cs_user['users_place']);
    if(in_array('users_place',$hidden)) {
      $content = empty($allow) ? '--' : cs_html_italic(1) . $content . cs_html_italic(0);
    }
    $data['users']['postal_place'] =   $content;
  }
  
  if(empty($cs_user['users_country'])) {
    $data['users']['country'] = '-';
  }
  else {
    $url = 'symbols/countries/' . $cs_user['users_country'] . '.png';
    $data['users']['country'] =  cs_html_img($url,11,16);
    include_once('lang/' . $account['users_lang'] . '/countries.php');
    $country = $cs_user['users_country'];
    $data['users']['country'] .=  ' ' . $cs_country[$country];
  }

  $data['users']['registered'] = cs_date('unix',$cs_user['users_register'],1);
  $data['users']['laston'] = !empty($cs_users['users_invisible']) ? '--' : cs_date('unix',$cs_user['users_laston'],1);

  $content = cs_html_mail($cs_user['users_email']);
  if(in_array('users_email',$hidden)) {
    $content = empty($allow) ? '--' : cs_html_italic(1) . $content . cs_html_italic(0);
  }
  $data['users']['email'] =  empty($cs_user['users_email']) ? '--' : $content;

  $cs_user['users_url'] = cs_secure($cs_user['users_url']);
  $content = cs_html_link('http://' . $cs_user['users_url'],$cs_user['users_url']);
  if(in_array('users_url',$hidden)) {
    $content = empty($allow) ? '--' : cs_html_italic(1) . $content . cs_html_italic(0);
  }
  $data['users']['url'] = empty($cs_user['users_url']) ? '--' : $content;

  $content = cs_html_link('http://www.icq.com/people/' . $cs_user['users_icq'],$cs_user['users_icq']);
  if(in_array('users_icq',$hidden)) {
    $content = empty($allow) ? '--' : cs_html_italic(1) . $content . cs_html_italic(0);
  }
  $data['users']['icq'] = empty($cs_user['users_icq']) ? '--' : $content;

  $cs_user['users_jabber'] = cs_secure($cs_user['users_jabber']);
  $content = cs_html_jabbermail($cs_user['users_jabber']);
  if(in_array('users_jabber',$hidden)) {
    $content = empty($allow) ? '--' : cs_html_italic(1) . $content . cs_html_italic(0);
  }
  $data['users']['jabber'] = empty($cs_user['users_jabber']) ? '--' : $content;

  $cs_user['users_skype'] = cs_secure($cs_user['users_skype']);
  $content = cs_html_link('skype:' . $cs_user['users_skype'] . '?userinfo', $cs_user['users_skype']);
  $skype_url = 'http://mystatus.skype.com/smallicon/' . $cs_user['users_skype'];
  $content .= ' ' . cs_html_img($skype_url,'16','16');
  if(in_array('users_skype',$hidden)) {
    $content = empty($allow) ? '--' : cs_html_italic(1) . $content . cs_html_italic(0);
  }
  $data['users']['skype'] = empty($cs_user['users_skype']) ? '--' : $content;

  $content = cs_secure($cs_user['users_phone']);
  if(in_array('users_phone',$hidden)) {
    $content = empty($allow) ? '--' : cs_html_italic(1) . $content . cs_html_italic(0);
  }
  $data['users']['phone'] = empty($cs_user['users_phone']) ? '--' : $content;

  $content = cs_secure($cs_user['users_mobile']);
  if(in_array('users_mobile',$hidden)) {
    $content = empty($allow) ? '--' : cs_html_italic(1) . $content . cs_html_italic(0);
  }
  $data['users']['mobile'] =  empty($cs_user['users_mobile']) ? '--' : $content;

  $data['users']['info'] = empty($cs_user['users_info']) ? '&nbsp;' : cs_secure($cs_user['users_info'],1,1);

  /* Users View Update */
/*  $users_view['users_view'] = $cs_user['users_view'] + 1;
  $users_cells = array_keys($users_view);
  $users_save = array_values($users_view);
  cs_sql_update(__FILE__,'users',$users_cells,$users_save,$cs_user['users_id']);
  $data['users']['view'] = $users_view['users_view'];*/

  echo cs_subtemplate(__FILE__,$data,'users','view');
}