<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gbook');

$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

$data['tpl']['preview'] = '';
$data['tpl']['extension'] = '';

$gbook_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $gbook_id = $cs_post['id'];

$from = 'manage';
if (isset($_POST['from'])) $from = $_POST['from'];
elseif (isset($_GET['from'])) $from = $_GET['from'];
$from = cs_secure($from, 0, 0, 0, 0, 0);
$select = 'users_id, gbook_nick, gbook_email, gbook_icq, gbook_jabber, gbook_skype, gbook_url, gbook_town, gbook_text, gbook_time';
$cs_gbook = cs_sql_select(__FILE__,'gbook',$select,"gbook_id = '" . (int) $gbook_id . "'");

if(!empty($cs_gbook['users_id'])) {
  $select = 'users_nick, users_email, users_place, users_icq, users_jabber, users_skype, users_url';
  $cs_user = cs_sql_select(__FILE__,'users',$select,"users_id = '" . (int) $cs_gbook['users_id'] . "'");
}

if(isset($_POST['submit']) OR isset($_POST['preview'])) {

  $error = '';

  if(empty($cs_gbook['users_id'])) {
    $cs_gbook['gbook_nick'] = $_POST['gbook_nick'];
    $cs_gbook['gbook_email'] = $_POST['gbook_email'];
    $cs_gbook['gbook_icq'] = $_POST['gbook_icq'];
    $cs_gbook['gbook_jabber'] = $_POST['gbook_jabber'];
    $cs_gbook['gbook_skype'] = $_POST['gbook_skype'];
    $cs_gbook['gbook_town'] = $_POST['gbook_town'];
    $cs_gbook['gbook_url'] = $_POST['gbook_url'];

    //check nick if exists or empty
    if (!empty($cs_gbook['gbook_nick'])) {
      $exists_user = cs_sql_select(__FILE__,'users','users_nick',"users_nick = '" . cs_sql_escape($cs_gbook['gbook_nick']) . "'");
      
      if(!empty($exists_user)) {
        $error .= $cs_lang['error_exist_nick'] . cs_html_br(1);
      }
    } else {
      $error .= $cs_lang['error_nick'] . cs_html_br(1);
    }
    
    //check email if exists, chars or empty
    if (!empty($cs_gbook['gbook_email'])) {
      $exists_user = cs_sql_select(__FILE__,'users','users_email',"users_email = '" . cs_sql_escape($_POST['gbook_email']) . "'");
    
      if(!empty($exists_user)) {
        $error .= $cs_lang['error_exist_email'] . cs_html_br(1);
      }
      $pattern = "/^[0-9a-zA-Z._\\-]+@[0-9a-zA-Z._\\-]{2,}\\.[a-zA-Z]{2,4}\$/";
      if(!preg_match($pattern,$cs_gbook['gbook_email'])) {
        $error .= $cs_lang['error_email'] . cs_html_br(1);
      }
    } else {
      $error .= $cs_lang['error_email'] . cs_html_br(1);
    }
    
    //check jabber
    if (!empty($cs_gbook['gbook_jabber'])) {
      $pattern = "/^[0-9a-zA-Z._\\-]+@[0-9a-zA-Z._\\-]{2,}\\.[a-zA-Z]{2,4}\$/";
      if(!preg_match($pattern,$cs_gbook['gbook_jabber'])) {
        $error .= $cs_lang['error_jabber'] . cs_html_br(1);
      }
    }
    
    //check icq
    if (!empty($cs_gbook['gbook_icq'])) {
      $pattern = '#^[\d-]*$#';
      if (!preg_match($pattern,$cs_gbook['gbook_icq'])) {
        $error .= $cs_lang['error_icq'] . cs_html_br(1);
      }
    }

    //check url
    if (!empty($cs_gbook['gbook_url'])) {
      $pattern = "=.[a-z0-9].[a-z0-9]=si";
      if(!preg_match($pattern,$cs_gbook['gbook_url'])) {
        $error .= $cs_lang['error_url'] . cs_html_br(1);
      }
    }
  }

  if (!empty($_POST['gbook_newtime'])) {
    $cs_gbook['gbook_time'] = cs_time();
  }

  $cs_gbook['gbook_text'] = $_POST['gbook_text'];

  if(empty($cs_gbook['gbook_text']))
    $error .= $cs_lang['no_text'] . cs_html_br(1);
}

if(!isset($_POST['submit']))
  $data['head']['body'] = $cs_lang['body_create'];
elseif(!empty($error))
  $data['head']['body'] = $error;

//preview
if (isset($_POST['preview']) AND empty($error)) {
  
  $where_user = !empty($id) ? "gbook_users_id = '" . $id . "'" : 0;
  $count_entry = cs_sql_count(__FILE__,'gbook',$where_user);

  $data['gbook']['entry_count'] = $count_entry + 1;
  $data['gbook']['users_nick'] = $cs_gbook['gbook_nick'];
  $data['gbook']['icon_town'] = empty($cs_gbook['gbook_town']) ? '' : cs_icon('gohome');
  $data['gbook']['town'] = empty($cs_gbook['gbook_town']) ? '' : cs_secure($cs_gbook['gbook_town']);
  $data['gbook']['icon_mail'] = cs_html_link('mailto:' . $cs_gbook['gbook_email'],cs_icon('mail_generic'));
   $icq = cs_html_link('http://www.icq.com/people/' . $cs_gbook['gbook_icq'],cs_icon('licq'));
  $data['gbook']['icon_icq'] = empty($cs_gbook['gbook_icq']) ? '' : $icq;
   $jabber = cs_html_jabbermail($cs_gbook['gbook_jabber'],cs_icon('jabber_protocol'));
  $data['gbook']['icon_jabber'] = empty($cs_gbook['gbook_jabber']) ? '' : $jabber;
   $url = 'http://mystatus.skype.com/smallicon/' . $cs_gbook['gbook_skype'];
   $skype = cs_html_link('skype:' . $cs_gbook['gbook_skype'] . '?userinfo',cs_html_img($url,'16','16','0','Skype'),'0');
  $data['gbook']['icon_skype'] = empty($cs_gbook['gbook_skype']) ? '' : $skype;
   $url = cs_html_link('http://' . $cs_gbook['gbook_url'],cs_icon('gohome'));
  $data['gbook']['icon_url'] = empty($cs_gbook['gbook_url']) ? '' : $url;
  $data['gbook']['text'] = cs_secure($cs_gbook['gbook_text'],1,1);
  $data['gbook']['time'] = cs_date('unix',$cs_gbook['gbook_time'],1);
  
  $data['tpl']['preview'] = cs_subtemplate(__FILE__,$data,'gbook','preview');
}

if (!empty($error) OR !isset($_POST['submit']) OR isset($_POST['preview'])) {

  foreach($cs_gbook AS $key => $value)
    $data['gbook'][$key] = cs_secure($value);

  if($cs_gbook['users_id'] == 0) {
    $data['tpl']['extension'] = cs_subtemplate(__FILE__,$data,'gbook','extension');
  }
  $data['abcode']['smileys'] = cs_abcode_smileys('gbook_text');
  $data['abcode']['features'] = cs_abcode_features('gbook_text');
  $data['check']['newtime'] = !empty($_POST['gbook_newtime']) ? 'checked="checked"' : '';
  $data['gbook']['id'] = $gbook_id;
  $data['gbook']['from'] = cs_secure($from);
  
  echo cs_subtemplate(__FILE__,$data,'gbook','edit');
}
else {

  $cells = array_keys($cs_gbook);
  $save = array_values($cs_gbook);
  cs_sql_update(__FILE__,'gbook',$cells,$save,$gbook_id);
  
  if($from == 'users') {
    $selid = cs_sql_select(__FILE__,'gbook','gbook_users_id',"gbook_id = '" . $gbook_id . "'",0,0);
    $action = 'users';
    $more = 'id=' . $selid['gbook_users_id'];
  }else{
    $action = $from;
    $more = '';
  }
    
  cs_redirect($cs_lang['changes_done'],'gbook',$action,$more) ;
}