<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gbook');
$cs_options = cs_sql_option(__FILE__,'gbook');
$id = empty($_REQUEST['id']) ? 0 : $_REQUEST['id'];
settype($id,'integer');

$data['head']['mod'] = $cs_lang['mod_name'];
$data['head']['action'] = $cs_lang['submit'];
$data['body']['create'] = $cs_lang['body_create'];
$data['error']['icon'] = '';
$data['error']['error'] = '';
$data['error']['message'] = '';
$data['tpl']['preview'] = '';
$data['tpl']['extension'] = '';
$data['tpl']['captcha'] = '';

$gbook_error = '';
$gbook_form = 1;
$errormsg = '';
$error = '';
$users_id = $account['users_id'];
if($_REQUEST['id'] != 0) {
  $users_check = cs_sql_count(__FILE__,'users',"users_id = '" . $id . "'");
  if(empty($users_check)) {
    $gbook_form = 0;
    
    cs_redirect($cs_lang['error'],'gbook','list');
  }
  if($users_id == 0) {
    $error++;
    $errormsg .= $cs_lang['error_login'] . cs_html_br(1);
  }
}
$cs_gbook_users = cs_sql_select(__FILE__,'users','users_nick, users_email, users_icq, users_msn, users_skype, users_place, users_url',"users_id = '" . $users_id . "'");

$gbook['gbook_time'] = cs_time();
$gbook['gbook_nick'] = cs_secure($cs_gbook_users['users_nick']);
$gbook['gbook_email'] = cs_secure($cs_gbook_users['users_email']);
$gbook['gbook_icq'] = cs_secure($cs_gbook_users['users_icq']);

$gbook['gbook_msn'] = cs_secure($cs_gbook_users['users_msn']);
$gbook['gbook_skype'] = cs_secure($cs_gbook_users['users_skype']);
$gbook['gbook_url'] = cs_secure($cs_gbook_users['users_url']);
$gbook['gbook_town'] = cs_secure($cs_gbook_users['users_place']);
$gbook['gbook_text'] = '';
$gbook['gbook_ip'] = $_SERVER['REMOTE_ADDR'];

$last_entry = cs_sql_select(__FILE__,'gbook','gbook_ip',"gbook_users_id = '" . $id . "'",'gbook_id DESC');
$lastip = $last_entry['gbook_ip'];

$flood = cs_sql_select(__FILE__,'gbook','gbook_time',"users_id = '" . $users_id . "'",'gbook_time DESC');
$maxtime = $flood['gbook_time'] + $cs_main['def_flood'];
if ($maxtime > cs_time()) {
  $error++;
  $diff = $maxtime - cs_time();
  $errormsg .= sprintf($cs_lang['flood_on'], $diff) . cs_html_br(1);
}

if ($lastip == $gbook['gbook_ip']) {
  $error++;
  $errormsg .= $cs_lang['last_own'];
}

if($users_id == 0)
{
  $captcha = extension_loaded('gd') ? 1 : 0;
}

if (!empty($error)) {
  if(empty($id)) {
    cs_redirect($errormsg,'gbook','list');
  } else {
    cs_redirect($errormsg,'gbook','users','id=' . $id);
  }

} else {
  if (!empty($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
  }
  
  if (!empty($_POST['gbook_nick'])) {
    if(empty($account['users_id'])) {
          $exists_user = cs_sql_select(__FILE__,'users','users_nick',"users_nick = '" . $_POST['gbook_nick'] . "'");
    
        if(empty($exists_user)) {
        $gbook['gbook_nick'] = $_POST['gbook_nick'];
        }
        else {
        $gbook_error++;
        $errormsg .= $cs_lang['error_exist_nick'] . cs_html_br(1);
        }
      }
  } else {
    $gbook_error++;
    $errormsg .= $cs_lang['error_nick'] . cs_html_br(1);
  }

  if (isset($_POST['gbook_email']) || !empty($_POST['gbook_email'])) {
    if(empty($account['users_id'])) {
      $exists_user = cs_sql_select(__FILE__,'users','users_email',"users_email = '" . $_POST['gbook_email'] . "'");
    
      if(!empty($exists_user)) {
        $gbook_error++;
        $errormsg .= $cs_lang['error_exist_email'] . cs_html_br(1);
      }
    }
    else {
      $gbook['gbook_email'] = $_POST['gbook_email'];
    }
    
    $pattern = "/^[0-9a-zA-Z._\\-]+@[0-9a-zA-Z._\\-]{2,}\\.[a-zA-Z]{2,4}\$/";
     if(!preg_match($pattern,$gbook['gbook_email'])) {
          $gbook_error++;
      $errormsg .= $cs_lang['error_email'] . cs_html_br(1);
    }
    
  }

  if (!empty($_POST['gbook_msn'])) {
    $gbook['gbook_msn'] = $_POST['gbook_msn'];
    $pattern = "/^[0-9a-zA-Z._\\-]+@[0-9a-zA-Z._\\-]{2,}\\.[a-zA-Z]{2,4}\$/";
     if(!preg_match($pattern,$gbook['gbook_msn'])) {
      $gbook_error++;
      $errormsg .= $cs_lang['error_msn'] . cs_html_br(1);
    }
  }
  $gbook['gbook_skype'] = !empty($_POST['gbook_skype']) ? $_POST['gbook_skype'] : '';

  if (!empty($_POST['gbook_icq'])) {
    $pattern = '#^[\d-]*$#';
    $gbook['gbook_icq'] = $_POST['gbook_icq'];
    if (!preg_match($pattern,$gbook['gbook_icq'])) {
      $gbook_error++;
      $errormsg .= $cs_lang['error_icq'] . cs_html_br(1);
    }
  }

  if (!empty($_POST['gbook_url'])) {
    $pattern = "=.[a-z0-9].[a-z0-9]=si";
    $gbook['gbook_url'] = $_POST['gbook_url'];
    if(!preg_match($pattern,$gbook['gbook_url'])) {
      $gbook_error++;
      $errormsg .= $cs_lang['error_url'] . cs_html_br(1);
    }
  }
  $gbook['gbook_town'] = !empty($_POST['gbook_place']) ? $_POST['gbook_place'] : '';

  if (!empty($_POST['gbook_text'])) {
    $gbook['gbook_text'] = $_POST['gbook_text'];
    if(strlen($gbook['gbook_text']) < 30) {
        $gbook_error++;
      $errormsg .= $cs_lang['error_to_short'] . cs_html_br(1);
    }
      $gbook['gbook_text'] = preg_replace_callback("=\[img\](.*?)\[/img\]=si","cs_abcode_resize",$gbook['gbook_text']);
      $gbook['gbook_text'] = preg_replace_callback("=\[img width\=(.*?) height\=(.*?)\](.*?)\[/img\]=si","cs_abcode_resize",$gbook['gbook_text']);
  } else {
    $gbook_error++;
    $errormsg .= $cs_lang['no_text'] . cs_html_br(1);
  }

  if (isset($_POST['submit'])) {
    if(empty($account['users_id'])) {
      $input = empty($_POST['captcha']) ? '' : $_POST['captcha'];
      if (!cs_captchacheck($input)) {
        $gbook_error++;
        $errormsg .= $cs_lang['captcha_false'] . cs_html_br(1);
      }
    }
    if (empty($gbook_error)) {
      $gbook_form = 0;
      if($users_id > 0) {
        $gbook['gbook_nick'] = '';
        $gbook['gbook_email'] = '';
        $gbook['gbook_icq'] = '';
        $gbook['gbook_msn'] = '';
        $gbook['gbook_skype'] = '';
        $gbook['gbook_url'] = '';
        $gbook['gbook_town'] = '';
      }
      $gbook['users_id'] = $account['users_id'];
      $gbook['gbook_users_id'] = $id;
      $gbook['gbook_lock'] = empty($cs_options['lock']) ? 1 : 0;
      $cells = array_keys($gbook);
      $save = array_values($gbook);
      cs_sql_insert(__FILE__,'gbook',$cells,$save);
      $data['lang']['done'] = !empty($cs_options['lock']) ? $cs_lang['create_done_lock'] : $cs_lang['create_done'];
      $data['lang']['continue'] = cs_link($cs_lang['continue'],'gbook','list','id=' . $id);
      
      cs_redirect($data['lang']['done'],'gbook','list','id=' . $id);
    } else {
      $data['body']['create'] = '';
      $data['error']['icon'] = cs_icon('important');
      $data['error']['error'] = $cs_lang['error'] . cs_html_br(1);
      $data['error']['message'] = $errormsg;
    }
  }

  if (isset($_POST['preview'])) {
    if (empty($gbook_error)) {
      $data['gbook']['entry_count'] = '1';
      $data['gbook']['users_nick'] = $gbook['gbook_nick'];
      $data['gbook']['icon_town'] = empty($gbook['gbook_town']) ? '' : cs_icon('gohome');
      $data['gbook']['town'] = empty($gbook['gbook_town']) ? '' : cs_secure($gbook['gbook_town']);
      $email = cs_html_link('mailto:' . $gbook['gbook_email'],cs_icon('mail_generic'));
      $data['gbook']['icon_mail'] = empty($gbook['gbook_email']) ? '' : $email;
      $icq = cs_html_link('http://www.icq.com/' . $gbook['gbook_icq'],cs_icon('licq'));
      $data['gbook']['icon_icq'] = empty($gbook['gbook_icq']) ? '' : $icq;
      $msn = cs_html_link('http://members.msn.com/' . $gbook['gbook_msn'],cs_icon('msn_protocol'));
      $data['gbook']['icon_msn'] = empty($gbook['gbook_msn']) ? '' : $msn;
      $url = 'http://mystatus.skype.com/smallicon/' . $gbook['gbook_skype'];
      $skype = cs_html_link('skype:' . $gbook['gbook_skype'] . '?userinfo',cs_html_img($url,'16','16','0','Skype'),'0');
      $data['gbook']['icon_skype'] = empty($gbook['gbook_skype']) ? '' : $skype;
      $url = cs_html_link('http://' . $gbook['gbook_url'],cs_icon('gohome'));
      $data['gbook']['icon_url'] = empty($gbook['gbook_url']) ? '' : $url;
      $data['gbook']['text'] = cs_secure($gbook['gbook_text'],1,1);
      $data['gbook']['time'] = cs_date('unix',$gbook['gbook_time'],1);
      $data['tpl']['preview'] =  cs_subtemplate(__FILE__,$data,'gbook','preview');
    } else {
      $data['body']['create'] = '';
      $data['error']['icon'] = cs_icon('important');
      $data['error']['error'] = $cs_lang['error'] . cs_html_br(1);
      $data['error']['message'] = $errormsg;
    }
  }

  if (!empty($gbook_form)) {
    if($users_id == 0) {
      $data['data']['nick'] = $gbook['gbook_nick'];
      $data['data']['email'] = $gbook['gbook_email'];
      $data['data']['icq'] = $gbook['gbook_icq'];
      $data['data']['msn'] = $gbook['gbook_msn'];
      $data['data']['skype'] = $gbook['gbook_skype'];

      $data['lang']['place'] = $cs_lang['town'];
      $data['data']['place'] = $gbook['gbook_town'];

      $data['data']['url'] = $gbook['gbook_url'];
      $data['tpl']['extension'] = cs_subtemplate(__FILE__,$data,'gbook','extension');
    } else {
      $data['data']['nick'] = $gbook['gbook_nick'];
      $data['data']['email'] = $gbook['gbook_email'];
    }
    $data['abcode']['smileys'] = cs_abcode_smileys('gbook_text');
    $data['abcode']['features'] = cs_abcode_features('gbook_text');
    $data['data']['gbook_text'] = $gbook['gbook_text'];

    if($users_id == 0) {
      if(!empty($captcha)) {
        $data['captcha']['img'] = cs_html_img('mods/captcha/generate.php');
        $data['tpl']['captcha'] = cs_subtemplate(__FILE__,$data,'gbook','captcha');
      }
    }
    $data['data']['id'] = $id;
    echo cs_subtemplate(__FILE__,$data,'gbook','entry');
  }
}
?>