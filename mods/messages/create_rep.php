<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');

$messages_form = 1;
$messages_to = '';
$messages_subject = '';
$messages_show_receiver = '1';
$messages_show_sender = '0';
$messages_text = '';
$time = cs_time();
$users_id = $account['users_id'];
$messages_error = '';
$errormsg = '';

if (!empty($_POST['messages_to'])) 
{
  $users_nick_to = $_POST['messages_to'];
  $from = 'users';
  $select = 'users_id';
  $where = "users_nick = '" . cs_sql_escape($users_nick_to) . "'"; 
  $cs_messages = cs_sql_select(__FILE__,$from,$select,$where);
  $users_id_to = $cs_messages['users_id'];
}
else
{
  $messages_error++;
  $errormsg .= $cs_lang['error_to'] . cs_html_br(1);
}
if (!empty($_POST['messages_subject'])) 
{
  $messages_subject = $_POST['messages_subject'];
}
else
{
  $messages_error++;
  $errormsg .= $cs_lang['error_subject'] . cs_html_br(1);
}
if (!empty($_POST['messages_id'])) 
{
  $messages_id = $_POST['messages_id'];
}
else
{
  $messages_error++;
  $errormsg .= $cs_lang['error_id'] . cs_html_br(1);
}
if (!empty($_POST['messages_text'])) 
{
  $messages_text = $_POST['messages_text'];
}
else
{
  $messages_error++;
  $errormsg .= $cs_lang['error_text'] . cs_html_br(1);
}
if(!empty($_POST['messages_show_sender'])) 
{
  $messages_show_sender = $_POST['messages_show_sender'];
}
else
{
  $messages_show_sender = '0';
}

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_create'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo nl2br($cs_lang['body_create']);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

  if (isset($_POST['submit'])) 
  {
    if (empty($messages_error)) 
    {
      $messages_form = 0;

      $messages_cells = array('users_id','messages_time','messages_subject','messages_text','users_id_to','messages_show_receiver','messages_show_sender');
      $messages_save = array($users_id,$time,$messages_subject,$messages_text,$users_id_to,$messages_show_receiver,$messages_show_sender);
      cs_sql_insert(__FILE__,'messages',$messages_cells,$messages_save);
      
      $messages_view = '2';
      $messages_cells = array('messages_view');
      $messages_content = array($messages_view);
      cs_sql_update(__FILE__,'messages',$messages_cells,$messages_content,$messages_id);


      cs_redirect($cs_lang['msg_create_done'],'messages','center');
    }
    else 
    {
      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'leftc');
      echo cs_icon('important');
      echo $cs_lang['error_occured'];
      echo cs_html_br('1');
      echo $errormsg;
      echo cs_html_roco(0);
      echo cs_html_table(0);
      echo cs_html_br(1);
    }
  }
  
  if (isset($_POST['preview'])) 
  {
    if (empty($messages_error)) 
    {
      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'headb',0,3);
      echo $cs_lang['mod'] . ' - ' . cs_secure($_POST['messages_subject']);
      echo cs_html_roco(0);
      echo cs_html_roco(1,'leftb');
      echo $cs_lang['subject'];
      echo cs_html_roco(2,'leftb');
      echo cs_secure($_POST['messages_subject']);
      echo cs_html_roco(0);
      
      echo cs_html_roco(1,'leftb');
      echo $cs_lang['date'];
      echo cs_html_roco(2,'leftb');
      echo cs_date('unix',$time,1);
      echo cs_html_roco(0);
      
      echo cs_html_roco(1,'leftb');
      echo $cs_lang['to'];
      echo cs_html_roco(2,'leftb');
      echo cs_secure($_POST['messages_to']);
      echo cs_html_roco(0);
      
      echo cs_html_roco(1,'leftb');
      echo $cs_lang['options'];
      echo cs_html_roco(2,'leftb');
      
      echo cs_icon('back',16,$cs_lang['back']);
      echo cs_icon('mail_replay',16,$cs_lang['replay']);
      echo cs_icon('mail_delete',16,$cs_lang['remove']);
      echo cs_html_roco(0);
      echo cs_html_table(0);
      
      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'headb',0,3);
      echo $cs_lang['mod'] . ' - ' . $cs_lang['text'];
      echo cs_html_roco(0);
      echo cs_html_roco(1,'leftb');
      echo cs_secure($_POST['messages_text'],1,1);
      echo cs_html_roco(0);
      echo cs_html_table(0);
      echo cs_html_br(1);
    }
    else
    {
      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'leftc');
      echo cs_icon('important');
      echo $cs_lang['error'];
      echo cs_html_br('1');
      echo $errormsg;
      echo cs_html_roco(0);
      echo cs_html_table(0);
      echo cs_html_br(1);
    }
  }

  if (!empty($messages_form)) 
  {
    if(!empty($_REQUEST['id']))
    {
      $messages_id = $_REQUEST['id'];
      settype($messages_id,'integer');
    }
    $from = 'messages msg INNER JOIN {pre}_users usr ON msg.users_id = usr.users_id';
    $select = ' msg.messages_subject AS messages_subject, msg.users_id AS users_id, usr.users_nick AS users_nick, 
    msg.messages_text AS messages_text';
    $where = "messages_id = '" . $messages_id . "'"; 
    $cs_messages = cs_sql_select(__FILE__,$from,$select,$where);
    $messages_to = $cs_messages['users_nick'];
    $messages_subject = $cs_messages['messages_subject'];
        
    $ms = substr($messages_subject, 0, 3);
    if($ms !== 'Re:')
    {
      $messages_subject = 'Re: ' . $messages_subject;
    }    
    $wrote = $cs_lang['wrote'];

    if (!empty($_POST['messages_text'])) 
    {
      $messages_text = $_POST['messages_text'];
    }
    else
    {
      $temp = explode("[quote]", $cs_messages['messages_text']);
      $messages_text = '[quote][b]----------' . $messages_to . $wrote .  '----------[/b]' . "\n" . $temp['0'] . '[/quote]';
      if(count($temp) >= 2)
      {
        for($run=1; $run < 2; $run++)
        {
          $messages_text .= "\n" . '[quote]' . $temp[$run];
        }
      }
      $count_temp = count($temp);
      for($run=2; $run < $count_temp; $run++)
      {
        $messages_text .= '[quote]' . $temp[$run];
      }
      $aa = strstr($messages_text,'[clip=' . $cs_lang['clip_more'] . ']');
      $ab = strlen($aa);
      $ac = strlen('[clip=' . $cs_lang['clip_more'] . ']');
      $a = strlen($messages_text);
      $ad = substr($aa,$ac);
      $ae = substr($messages_text,'0',$a - $ab);
      $a = substr($messages_text,$a - 7);
      if($a !== '[/clip]')
      {
        $messages_text = "\n\n\n\n\n" . '[clip=' . $cs_lang['clip_more'] . ']' . $ae . $ad . '[/clip]';
      }
      else
      {
        $messages_text = "\n\n\n\n\n" . '[clip=' . $cs_lang['clip_more'] . ']' . $ae . $ad;
      }
    }
    echo cs_html_form (1,'create_rep','messages','create_rep');
    echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'leftc');
    echo cs_icon('personal') . $cs_lang['to'] . ' *';
    echo cs_html_roco(2,'leftb');
    echo $messages_to;
    echo cs_html_input('messages_to',$messages_to,'hidden');
    echo cs_html_roco(0);
    
    echo cs_html_roco(1,'leftc');
    echo cs_icon('kedit') . $cs_lang['subject'] . ' *';
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('messages_subject',$messages_subject,'text',200,50);
    echo cs_html_roco(0);
  
    echo cs_html_roco(1,'leftc');
    echo cs_icon('kate') . $cs_lang['text'] . ' *';
    echo cs_html_br(2);
    echo cs_abcode_smileys('messages_text');
    echo cs_html_roco(2,'leftb');
    echo cs_abcode_features('messages_text');
    echo cs_html_textarea('messages_text',$messages_text,'50','15');
    echo cs_html_roco(0);
    
    echo cs_html_roco(1,'leftc');
    echo cs_icon('configure') . $cs_lang['more'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_vote('messages_show_sender','1','checkbox',$messages_show_sender);
    echo $cs_lang['messages_show_sender'];
  
    echo cs_html_roco(1,'leftc');
    echo cs_icon('ksysguard') . $cs_lang['options'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('messages_id',$messages_id,'hidden');
    echo cs_html_vote('submit',$cs_lang['send'],'submit');
    echo cs_html_vote('preview',$cs_lang['preview'],'submit');
    echo cs_html_vote('reset',$cs_lang['reset'],'reset');
    echo cs_html_roco(0);
    echo cs_html_table(0);
    echo cs_html_form (0);
  }
?>