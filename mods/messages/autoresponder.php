<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');

$data = array();

$cs_messages = array();
$cs_messages['users_id'] = $account['users_id'];
$cs_messages['autoresponder_time'] = cs_time();

if(isset($_POST['submit']) OR isset($_POST['preview'])) {

  $update = $_POST['update'];
  $cs_messages['autoresponder_subject'] = $_POST['autoresponder_subject'];
  $cs_messages['autoresponder_text'] = $_POST['autoresponder_text'];
  $cs_messages['autoresponder_close'] = isset($_POST['autoresponder_close']) ? $_POST['autoresponder_close'] : 0;
  $cs_messages['autoresponder_id'] = $_POST['autoresponder_id'];

  settype($cs_messages['autoresponder_id'], 'integer');
  settype($cs_messages['autoresponder_close'], 'integer');
  
  $error = '';
  
  if(empty($cs_messages['autoresponder_subject']))
    $error .= $cs_lang['error_subject'] . cs_html_br(1);
  if(empty($cs_messages['autoresponder_text']))
    $error .= $cs_lang['no_text'] . cs_html_br(1);

}
else {
  $cells = 'autoresponder_id, autoresponder_text, autoresponder_subject, autoresponder_close';
  $cs_messages = cs_sql_select(__FILE__,'autoresponder',$cells,"users_id = '" . $account['users_id'] . "'",0,0,1);
  $update = count($cs_messages);
}

if(!isset($_POST['submit']) AND !isset($_POST['preview'])) 
  $data['head']['body'] = $cs_lang['body_edit'];
elseif(isset($_POST['preview'])) 
  $data['head']['body'] = $cs_lang['preview'];
elseif(!empty($error))
  $data['head']['body'] = $error;


$data['if']['preview'] = FALSE;

if(isset($_POST['preview'])) {

  $data['if']['preview'] = TRUE;
  $data['autoresponder']['subject'] = cs_secure($cs_messages['autoresponder_subject']);
  $data['autoresponder']['time'] = cs_date('unix',$cs_messages['autoresponder_time'],1);
  $data['autoresponder']['text'] = cs_secure($cs_messages['autoresponder_text'],1,1);
}

if(!empty($error) OR isset($_POST['preview']) OR !isset($_POST['submit'])) {

  $data['autoresponder2']['subject'] = cs_secure($cs_messages['autoresponder_subject']);
  $data['autoresponder2']['text'] = cs_secure($cs_messages['autoresponder_text']);

  $data['abcode']['smileys'] = cs_abcode_smileys('autoresponder_text');
  $data['abcode']['features'] = cs_abcode_features('autoresponder_text');

  $data['check']['close'] = empty($cs_messages['autoresponder_close']) ? '' : 'checked="checked"';

  $data['autoresponder']['id'] = $cs_messages['autoresponder_id'];
  $data['autoresponder']['update'] = $update;

 echo cs_subtemplate(__FILE__,$data,'messages','autoresponder');
}
else {

  $messages_cells = array_keys($cs_messages);
  $messages_save = array_values($cs_messages);

  if(empty($update)) {
     cs_sql_insert(__FILE__,'autoresponder',$messages_cells,$messages_save);
    $msg = $cs_lang['create_done'];
  } else {
    cs_sql_update(__FILE__,'autoresponder',$messages_cells,$messages_save,$cs_messages['autoresponder_id']);
    $msg = $cs_lang['changes_done'];
  }
  cs_redirect($msg,'messages','center');
} 