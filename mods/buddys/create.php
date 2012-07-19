<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('buddys');

$cs_get = cs_get('id');
$data = array();

$users_add_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$error = '';
$time = cs_time();
$buddys_id = 0;
$buddys_notice = '';
$users_id = $account['users_id'];

if(!empty($users_add_id)) {
  $users_data = cs_sql_select(__FILE__,'users','users_id, users_nick',"users_id = '" . $users_add_id . "'");
  $buddys_nick = $users_data['users_nick'];
}
else {
  $buddys_nick = '';
}

if(isset($_POST['submit'])) {

  if(!empty($_POST['buddys_nick'])) {
    $buddys_nick = $_POST['buddys_nick'];
    $buddys_notice = $_POST['buddys_notice'];
    $users_data = cs_sql_select(__FILE__,'users','users_id, users_nick',"users_nick = '" . cs_sql_escape($buddys_nick) . "'");
  
    if(!empty($users_data)) {
      $buddys_id = $users_data['users_id'];
      if($buddys_id == $account['users_id']) {
        $error .= $cs_lang['error_user_self'];
      }
      $where = "users_id = '" . $users_id . "' AND buddys_user = '" . $buddys_id . "'";
      $buddys_check = cs_sql_count(__FILE__,'buddys',$where);
      if(!empty($buddys_check)) {
        $error = $cs_lang['error_available'];
      }  
    }
    else {
      $error = $cs_lang['error_user_noavailable'];
    }
  }
  else {
    $error = $cs_lang['error_id'];
  }
}

if(!isset($_POST['submit']))
  $data['head']['body'] = $cs_lang['body_create'];
elseif(!empty($error))
  $data['head']['body'] = $error;

if(!empty($error) OR !isset($_POST['submit'])) {
  
  $data['buddys']['nick'] = $buddys_nick;
    
  if(empty($users_add_id)) {
    $more  = 'onkeyup="Clansphere.ajax.user_autocomplete(\'buddys_nick\', \'output\', \''
           . $cs_main['php_self']['dirname'] . '\')" id="buddys_nick"';

    $data['if']['empty_users_id'] = TRUE;
    $data['if']['users_id'] = FALSE;
    $data['input']['more'] = $more;
  }
  else {
    $data['if']['empty_users_id'] = FALSE;
    $data['if']['users_id'] = TRUE;
    $data['buddys']['nick_sec'] = cs_secure($buddys_nick);
  }
  $data['abcode']['smileys']   = cs_abcode_smileys('buddys_notice');
  $data['abcode']['features']  = cs_abcode_features('buddys_notice');
  $data['create']['buddys_notice'] = $buddys_notice;

 echo cs_subtemplate(__FILE__,$data,'buddys','create');
}
else {
  
  $buddys_cells = array('users_id','buddys_user','buddys_time','buddys_notice');
  $buddys_save = array($users_id,$buddys_id,$time,$buddys_notice);
 cs_sql_insert(__FILE__,'buddys',$buddys_cells,$buddys_save);
 
 cs_redirect($cs_lang['create_done'],'buddys','center');
}