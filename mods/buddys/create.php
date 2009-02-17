<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('buddys');

$data = array();

$buddys_error = '';
$buddys_form = 1;
$time = cs_time();
$buddys_id = 0;
$buddys_notice = '';
$users_id = $account['users_id'];

if(!isset($_POST['submit'])) {
  $data['lang']['head'] = $cs_lang['body_create'];
}
elseif(!empty($buddys_error)) {
  $data['lang']['head'] = cs_icon('important') . cs_html_br(1);
  $data['lang']['head'] .= $errormsg;
}
else {
  $data['lang']['head'] = $cs_lang['create_done'];
}

if(!empty($_GET['id'])) {
  $users_add_id = $_GET['id'];
  settype($users_add_id,'integer');
  $users_data = cs_sql_select(__FILE__,'users','users_id, users_nick',"users_id = '" . $users_add_id . "'");
  $buddys_nick = $users_data['users_nick'];
}
else {
  $buddys_nick = '';
}

if(!empty($_POST['buddys_nick'])) {
  $buddys_nick = $_POST['buddys_nick'];
  $buddys_notice = $_POST['buddys_notice'];
  $users_data = cs_sql_select(__FILE__,'users','users_id, users_nick',"users_nick = '" . cs_sql_escape($buddys_nick) . "'");
  
  if(!empty($users_data)) {
    $buddys_id = $users_data['users_id'];
    if($buddys_id == $account['users_id']) {
      $buddys_error++;
      $errormsg = $cs_lang['error_user_noavailable'];
    }
    $where = "users_id = '" . $users_id . "' AND buddys_user = '" . $buddys_id . "'";
    $buddys_check = cs_sql_count(__FILE__,'buddys',$where);
    if(!empty($buddys_check)) {
      $buddys_error++;
      $errormsg = $cs_lang['error_available'];
    }  
  }
  else {
    $buddys_error++;
    $errormsg = $cs_lang['error_user_noavailable'];
  }
}
else {
  $buddys_error++;
  $errormsg = $cs_lang['error_id'];
}

if(isset($_POST['submit'])) {
  
  if(empty($buddys_error)) {
    
    $data['if']['done'] = TRUE;
    $data['if']['form'] = FALSE;

    $buddys_form = 0;

    $buddys_cells = array('users_id','buddys_user','buddys_time','buddys_notice');
    $buddys_save = array($users_id,$buddys_id,$time,$buddys_notice);
    cs_sql_insert(__FILE__,'buddys',$buddys_cells,$buddys_save);
      cs_redirect($cs_lang['create_done'],'buddys','center');
  }
  else {
    
    $data['if']['done'] = FALSE;
    $data['if']['form'] = TRUE;
   }
}


if(!empty($buddys_form)) {
  
  $data['if']['done'] = FALSE;
  $data['if']['form'] = TRUE;
    
  if(empty($users_add_id)) {
    $more  = 'onkeyup="cs_ajax_getcontent(\'' . $cs_main['php_self']['dirname'] . 'mods/messages/getusers.php';
    $more .= '?name=\' + document.getElementById(\'name\').value,\'output\')"';
    $more .= ' id="name"';
    $data['create']['buddys_nick']    = cs_html_input('buddys_nick',$buddys_nick,'text',200,50,$more);
    $data['create']['buddys_nick']   .= cs_html_br(1);
    $data['create']['buddys_nick']   .= cs_html_span(1,0,'id="output"') . cs_html_span(0);
    #$data['create']['buddys_nick']   .= ' - ' . cs_link($cs_lang['search'],'search','list','where=users');
  }
  else {
    $data['create']['buddys_nick']    = cs_html_input('buddys_nick',$buddys_nick,'hidden',200,50);
    $data['create']['buddys_nick']   .= cs_secure($buddys_nick);
  }
  $data['create']['abcode_smilies']   = cs_abcode_smileys('buddys_notice');
  $data['create']['abcode_features']  = cs_abcode_features('buddys_notice');
  $data['create']['buddys_notice']    = $buddys_notice;
 
}

echo cs_subtemplate(__FILE__,$data,'buddys','create');

?>