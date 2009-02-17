<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$
// cs_notify($email='', $title='title', $message='test', $users_id=1, $notification_name = 'notifications_pm');
$cs_lang = cs_translate('messages');
require_once('mods/messages/functions.php');
$messages_form = 1;
if(isset($_REQUEST['to'])){
  $messages_to = $_REQUEST['to'];
} else {
  $messages_to = '';
}
$messages_subject = '';
$messages_text = '';
$time = cs_time();
$users_id = $account['users_id'];
$messages_error = '';
$errormsg = '';
$messages_archiv = '0';
$messages_show_receiver = '1';
/*+-------------------------------------------------------------+*/
/*|  Pre Sample:  @                        |*/
/*|  Clan:test clan 1; test user 1; Squad:test clan 1 squad 1  |*/
/*+-------------------------------------------------------------+*/
if (!empty($_POST['messages_to'])) {
  $messages_to = $_POST['messages_to'];
  $temp = explode(';', $messages_to);
  $loop_temp = count($temp);
  $where = '';
  for($run=0; $run<$loop_temp; $run++) {
    $a = substr($temp[$run], 0, 6); //check is this a squad
    $b = substr($temp[$run], 0, 5); //check is this a clan
    if($a == 'Squad:') {
      if(!empty($where)) {
        $where = $where . ' OR ';
      }
      $z = substr($temp[$run], 6);
      $where .= "squ.squads_name = '" . cs_sql_escape($z) . "'";
    } elseif($b == 'Clan:') {
      if(!empty($where)) {
        $where = $where . ' OR ';
      }
      $z = substr($temp[$run], 5);
      $where .= "cla.clans_name = '" . cs_sql_escape($z) . "'";
    } else {
      if(!empty($where)) {
        $where .= ' OR ';
      }
      $where .= "usr.users_nick = '" . cs_sql_escape($temp[$run]) . "'";
      $z = $temp[$run];
    }
  }
  /*$from = 'clans cla INNER JOIN {pre}_squads squ ON cla.clans_id = squ.clans_id ';
  $from .= 'INNER JOIN {pre}_members mem ON squ.squads_id = mem.squads_id ';
  $from .= 'RIGHT OUTER JOIN {pre}_users usr ON mem.users_id = usr.users_id';*/
  $from = 'users usr LEFT JOIN {pre}_members mem ON usr.users_id = mem.users_id ';
  $from .= 'LEFT JOIN {pre}_squads squ ON mem.squads_id = squ.squads_id ';
  $from .= 'LEFT JOIN {pre}_clans cla ON squ.clans_id = cla.clans_id';
  $select = 'usr.users_id AS users_id, usr.users_nick AS users_nick, usr.users_email AS users_email';
  $order = '';
  $cs_messages = cs_sql_select(__FILE__,$from,$select,$where,0,0,0);
  $cs_messages_loop = count($cs_messages);

  if(empty($cs_messages_loop) OR empty($where)) {
    $messages_error++;
    $errormsg .= $cs_lang['error_to'] . cs_html_br(1);
    $error_to = '1';
  } else {
    $cs_messages = remove_dups($cs_messages,'users_nick');
    $cs_messages_loop = count($cs_messages);
  }

  if(empty($cs_messages_loop) AND empty($error_to)) {
    $messages_error++;
    $errormsg .= $cs_lang['error_to'] . cs_html_br(1);
  }
} else {
  $messages_error++;
  $errormsg .= $cs_lang['error_to'] . cs_html_br(1);
}
if (!empty($_POST['messages_subject'])) {
  $messages_subject = $_POST['messages_subject'];
} else {
  $messages_error++;
  $errormsg .= $cs_lang['error_subject'] . cs_html_br(1);
}
if (!empty($_POST['messages_text'])) {
  $messages_text = $_POST['messages_text'];
} else {
  $messages_error++;
  $errormsg .= $cs_lang['error_text'] . cs_html_br(1);
}
if (!empty($_POST['messages_show_sender'])) {
  $messages_show_sender = $_POST['messages_show_sender'];
} else {
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

if (isset($_POST['submit'])) {
  if (empty($messages_error)) {
    $messages_form = 0;
    for($run=0; $run<$cs_messages_loop; $run++) {
      $users_id_to = $cs_messages[$run]['users_id'];
      $messages_cells = array('users_id','messages_time','messages_subject','messages_text',
        'users_id_to','messages_show_receiver','messages_show_sender');
      $messages_save = array($users_id,$time,$messages_subject,$messages_text,$users_id_to,
        $messages_show_receiver,$messages_show_sender);
      cs_sql_insert(__FILE__,'messages',$messages_cells,$messages_save);

      $where = "users_id = '" . $users_id_to . "'";
      $select = 'users_id,autoresponder_subject,autoresponder_text,autoresponder_close,autoresponder_mail';
      $autoresponder = cs_sql_select(__FILE__,'autoresponder',$select,$where);
      $auto_subject = $autoresponder['autoresponder_subject'];
      $auto_text = $autoresponder['autoresponder_text'];
      $auto_mail = $autoresponder['autoresponder_mail'];

      if(!empty($autoresponder['autoresponder_close'])) {
        $messages_cells = array('users_id','messages_time','messages_subject','messages_text','users_id_to','messages_show_receiver');
        $messages_save = array($users_id_to,$time,$auto_subject,$auto_text,$users_id,'1');
        cs_sql_insert(__FILE__,'messages',$messages_cells,$messages_save);
      }
      if(!empty($autoresponder['autoresponder_mail']))
      {
        echo $cs_messages[$run]['users_email'];
        if(!empty($cs_messages[$run]['users_email']))
        {
          $email = $cs_messages[$run]['users_email'];
          $title = $cs_lang['mail_titel'];
          $message = $cs_lang['mail_text'] . $cs_messages[$run]['users_nick'];
          $message .= $cs_lang['mail_text_2'] . $cs_main['def_title'] . $cs_lang['mail_text_3'];
          $message .= $cs_main['def_org'] . $cs_lang['mail_text_4'];
          cs_mail($email,$title,$message);
        }
      }
    }

    cs_redirect($cs_lang['msg_create_done'],'messages','center');
  }
  else
  {
    echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'leftc');
    echo cs_icon('important');
    echo $cs_lang['error_occured'];
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftb');
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
    echo cs_html_roco(1,'headb',0,2);
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
    for($run=0; $run<$cs_messages_loop; $run++)
    {
      echo $cs_messages[$run]['users_nick'] . '; ';
    }
    echo cs_html_roco(0);

    echo cs_html_roco(1,'leftb');
    echo $cs_lang['options'];
    echo cs_html_roco(2,'leftb');

    echo cs_icon('back',16,$cs_lang['back']);
    echo cs_icon('mail_replay',16,$cs_lang['replay']);
    echo cs_icon('mail_delete',16,$cs_lang['remove']);
    echo cs_html_roco(0);

    echo cs_html_roco(1,'headb',0,2);
    echo $cs_lang['mod'] . ' - ' . $cs_lang['text'];
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftb',0,2);
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
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftb');
    echo $errormsg;
    echo cs_html_roco(0);
    echo cs_html_table(0);
    echo cs_html_br(1);
  }
}

if (!empty($messages_form))
{
  echo cs_html_form (1,'create','messages','create');
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftc');
  echo cs_icon('personal') . $cs_lang['to'] . ' *';
  echo cs_html_roco(2,'leftb');

  $more  = 'onkeyup="cs_ajax_getcontent(\'' . $cs_main['php_self']['dirname'] . 'mods/messages/getusers.php';
  $more .= '?name=\' + document.getElementById(\'name\').value,\'output\')"';
  $more .= ' id="name"';

  echo cs_html_input('messages_to',$messages_to, 'text', 200, 50,$more);
  echo cs_html_br(1);
  echo cs_html_span(1,0,'id="output"') . cs_html_span(0);

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
  echo cs_html_vote('submit',$cs_lang['send'],'submit');
  echo cs_html_vote('preview',$cs_lang['preview'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form (0);
}
?>