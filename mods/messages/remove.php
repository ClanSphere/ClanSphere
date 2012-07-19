<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');
$cs_post = cs_post('id');
$cs_get = cs_get('id');

$messages_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $messages_id = $cs_post['id'];

$select = 'users_id, users_id_to, messages_show_sender, messages_show_receiver, ';
$select .= 'messages_archiv_sender, messages_archiv_receiver, messages_subject';
$where = "messages_id = '" . $messages_id . "'";
$cs_messages = cs_sql_select(__FILE__,'messages',$select,$where);

if(isset($_POST['agree'])) {
 
  $users_id = $account['users_id'];
  if($cs_messages['users_id'] == $users_id)
  {
    $messages_show_sender = '0';
    $messages_archiv_sender = '0';
    $messages_cells = array('messages_show_sender','messages_archiv_sender');
    $messages_content = array($messages_show_sender,$messages_archiv_sender);
    cs_sql_update(__FILE__,'messages',$messages_cells,$messages_content,$messages_id);
  }
  if($cs_messages['users_id_to'] == $users_id)
  {
    $messages_show_receiver = '0';
    $messages_archiv_receiver = '0';
    $messages_cells = array('messages_show_receiver','messages_archiv_receiver');
    $messages_content = array($messages_show_receiver,$messages_archiv_receiver);
    cs_sql_update(__FILE__,'messages',$messages_cells,$messages_content,$messages_id);
  }
  if($cs_messages['messages_show_sender'] == 0 AND $cs_messages['messages_archiv_sender'] == 0 AND $cs_messages['users_id_to'] == $users_id OR $cs_messages['messages_show_receiver'] == 0 AND $cs_messages['messages_archiv_receiver'] == 0 AND $cs_messages['users_id'] == $users_id)
  {
    cs_sql_delete(__FILE__,'messages',$messages_id);
  }

 cs_redirect($cs_lang['del_true'], 'messages','center');
}

if(isset($_POST['cancel']))
  cs_redirect($cs_lang['del_false'], 'messages','center');

elseif($cs_messages['users_id'] == $account['users_id'] OR $cs_messages['users_id_to'] == $account['users_id']) {

  $data['head']['body'] = sprintf($cs_lang['msg_rly_rmv'], cs_html_big(1) . cs_secure($cs_messages['messages_subject']) . cs_html_big(0));
  $data['messages']['id'] = $messages_id;

  echo cs_subtemplate(__FILE__,$data,'messages','remove');
}