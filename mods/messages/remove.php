<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');

$messages_id = $_REQUEST['id'];
settype($messages_id,'integer');
$messages_form = 1;
$cancel = 0;

$from = 'messages';
$select = 'users_id,users_id_to,messages_show_sender,messages_show_receiver,messages_archiv_sender,messages_archiv_receiver,messages_subject';
$where = "messages_id = '" . $messages_id . "'";
$cs_messages = cs_sql_select(__FILE__,$from,$select,$where);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['remove'];
echo cs_html_roco(0);

if(isset($_POST['agree']))
{
  $cancel = 1;
  $messages_form = 0;
  $users_id = $account['users_id'];
  if($cs_messages['users_id'] == $users_id)
  {
    $messages_show_sender = '0';
    $messages_archiv_sender = '0';
    $messages_cells = array('messages_show_sender','messages_archiv_sender');
    $messages_content = array($messages_show_sender,$messages_archiv_sender);
    cs_sql_update(__FILE__,'messages',$messages_cells,$messages_content,$messages_id);
    $cancel = 0;
  }
  if($cs_messages['users_id_to'] == $users_id)
  {
    $messages_show_receiver = '0';
    $messages_archiv_receiver = '0';
    $messages_cells = array('messages_show_receiver','messages_archiv_receiver');
    $messages_content = array($messages_show_receiver,$messages_archiv_receiver);
    cs_sql_update(__FILE__,'messages',$messages_cells,$messages_content,$messages_id);
    $cancel = 0;
  }
  if($cs_messages['messages_show_sender'] == 0 AND $cs_messages['messages_archiv_sender'] == 0 AND $cs_messages['users_id_to'] == $users_id OR $cs_messages['messages_show_receiver'] == 0 AND $cs_messages['messages_archiv_receiver'] == 0 AND $cs_messages['users_id'] == $users_id)
  {
    cs_sql_delete(__FILE__,'messages',$messages_id);
    $cancel = 0;
  }
  if($cancel == 0)
  {
    cs_redirect($cs_lang['del_true'], 'messages','center');
  }
}

if(isset($_POST['cancel']) OR $cancel == 1)
  cs_redirect($cs_lang['del_false'], 'messages','center');

if(!empty($messages_form))
{
  echo cs_html_roco(1,'leftb');
  echo sprintf($cs_lang['del_rly'],cs_html_big(1) . $cs_messages['messages_subject'] . cs_html_big(0));
  echo cs_html_roco(0);

  echo cs_html_roco(1,'centerc');
  echo cs_html_form(1,'messages_remove','messages','remove');
  echo cs_html_vote('id',$messages_id,'hidden');
  echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
  echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
  echo cs_html_form (0);
  echo cs_html_roco(0);
  echo cs_html_table(0);
}
?>