<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');
$data = array();

$users_id = $account['users_id'];
$time = cs_time();

$cells = 'autoresponder_id,autoresponder_mail';
$cs_messages = cs_sql_select(__FILE__,'autoresponder',$cells,"users_id = '" . $users_id . "'");
$update = count($cs_messages);


if(isset($_POST['submit'])) {
  $update = (int) $_POST['update'];
  $cs_messages['autoresponder_id'] = (int) $_POST['autoresponder_id'];
  $cs_messages['autoresponder_mail'] = isset($_POST['autoresponder_mail']) ? $_POST['autoresponder_mail'] : 0;
  $cs_messages['users_id'] = $users_id;

  if(empty($update)) {
    $messages_cells = array_keys($cs_messages);
    $messages_save = array_values($cs_messages);
   cs_sql_insert(__FILE__,'autoresponder',$messages_cells,$messages_save);
  }
  else {
    $messages_cells = array_keys($cs_messages);
    $messages_save = array_values($cs_messages);
   cs_sql_update(__FILE__,'autoresponder',$messages_cells,$messages_save,$cs_messages['autoresponder_id']);
  }
  
 cs_redirect($cs_lang['changes_done'],'messages','center');

}
else {

  $data['check']['responder'] = empty($cs_messages['autoresponder_mail']) ? '' : 'checked="checked"';
  
  $data['hidden']['id'] = $cs_messages['autoresponder_id'];
  $data['hidden']['update'] = $update;

 echo cs_subtemplate(__FILE__,$data,'messages','mail');
}