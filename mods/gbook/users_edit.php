<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gbook');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod_name'] . ' - ' . $cs_lang['head_edit'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_edit'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$gbook_id = $_REQUEST['id'];
settype($gbook_id,'integer');
$where = "gbook_id = '" . $gbook_id . "'";
$user_check = cs_sql_select(__FILE__,'gbook','gbook_users_id',$where);
if($user_check['gbook_users_id'] == $account['users_id'])
{
  $gbook_error = 3;
  $gbook_form = 1;
  $gbook_newtime = 0;
  $gbook_edit = cs_sql_select(__FILE__,'gbook','*',"gbook_id = '" . $gbook_id . "'");
  $gbook_nick = $gbook_edit['gbook_nick'];
  $gbook_email = $gbook_edit['gbook_email'];
  $gbook_icq = $gbook_edit['gbook_icq'];
  $gbook_msn = $gbook_edit['gbook_msn'];
  $gbook_skype = $gbook_edit['gbook_skype'];
  $gbook_url = $gbook_edit['gbook_url'];
  $gbook_town = $gbook_edit['gbook_town'];
  $gbook_text = $gbook_edit['gbook_text'];
  $time = $gbook_edit['gbook_time'];
  $errormsg = '';

  if (!empty($_POST['gbook_newtime']))
  {
    $gbook_newtime = $_POST['gbook_newtime'];
    $time = cs_time();
  }

  if (!empty($_POST['gbook_nick']))
  {
    $gbook_nick = $_POST['gbook_nick'];
    $gbook_error--;
  }
  if (!empty($_POST['gbook_skpye']))
  {
    $gbook_skype = $_POST['gbook_skype'];
  }
  if (isset($_POST['gbook_email']) || !empty($_POST['gbook_email']))
  {
    $gbook_email = $_POST['gbook_email'];
    $pattern = "=[_a-z0-9-]@[a-z0-9].[a-z0-9]=i";
    if (preg_match($pattern,$gbook_email))
    {
        $gbook_error--;
    }
    else
    {
      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'leftc');
      echo cs_icon('important');
      echo $cs_lang['error_email'];
      echo cs_html_roco(0);
      echo cs_html_table(0);
      echo cs_html_br(1);
    }
  }

  if (!empty($_POST['gbook_msn']))
  {
    $gbook_msn = $_POST['gbook_msn'];
    $pattern = "=[_a-z0-9-]@[a-z0-9].[a-z0-9]=i";
     if(!preg_match($pattern,$gbook_msn))
    {
      $gbook_error++;
      $errormsg .= $cs_lang['error_msn'] . cs_html_br(1);
    }
  }

  if (!empty($_POST['gbook_icq']))
  {
    $icqnummern = "=[0-9]=si";
    $gbook_icq = $_POST['gbook_icq'];
    if (!preg_match($icqnummern,$gbook_icq))
    {
      $gbook_error++;
      $errormsg .= $cs_lang['error_icq'] . cs_html_br(1);
    }
  }

    if (!empty($_POST['gbook_url']))
    {
      $www = "=.[a-z0-9].[a-z0-9]=si";
      $gbook_url = $_POST['gbook_url'];
      if(!preg_match($www,$gbook_url))
      {
        $gbook_error++;
        $errormsg .= $cs_lang['error_url'] . cs_html_br(1);
      }
    }

  if (!empty($_POST['gbook_town']))
  {
    $gbook_town = $_POST['gbook_town'];
  }

  if (!empty($_POST['gbook_text']))
  {
    $gbook_text = $_POST['gbook_text'];
    $gbook_error--;
  }

  if (isset($_POST['submit']))
  {
    if (empty($gbook_error))
    {
      $gbook_form = 0;
      $cells = array('gbook_nick','gbook_email','gbook_icq','gbook_msn','gbook_skype','gbook_url','gbook_town','gbook_text','gbook_time');
      $content = array($gbook_nick,$gbook_email,$gbook_icq,$gbook_msn,$gbook_skype,$gbook_url,$gbook_town,$gbook_text,$time);
      cs_sql_update(__FILE__,'gbook',$cells,$content,$gbook_id);

      cs_redirect($cs_lang['changes_done'],'gbook','manage');
    }
    else
    {
      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'leftc');
      echo cs_icon('important');
      echo $gbook_error;
      if($gbook_error == '1')
      {
        echo $cs_lang['error_occurred_1'];
      }
      else
      {
        echo $cs_lang['error_occurred'];
      }
      echo cs_html_roco(0);
      echo cs_html_roco(2,'leftc');
      echo $errormsg;
      echo cs_html_roco(0);

      echo cs_html_table(0);
      echo cs_html_br(1);
    }
  }

  if (isset($_POST['preview']))
  {
    if (empty($gbook_error))
    {
        echo cs_html_table(1,'forum',1);
        echo cs_html_roco(1,'bottom',0,0,'160px');
        $nick = $_POST['gbook_nick'];
        echo "$nick";
        echo cs_html_br(2);
        if (!empty($gbook_town))
        {
          echo cs_icon('gohome');
          echo cs_secure($gbook_town);
        }
        echo cs_html_br(2);
        echo cs_html_link("mailto:$gbook_email",cs_icon('mail_generic'));
        if (!empty($gbook_icq))
        {
          echo cs_html_link("http://www.icq.com/$gbook_icq",cs_icon('licq'));
        }
        if (!empty($gbook_msn))
        {
          echo cs_html_link("http://members.msn.com/$gbook_msn",cs_icon('msn_protocol'));
        }
        if (!empty($gbook_skype))
        {
          $url = 'http://mystatus.skype.com/smallicon/' . $gbook_skype;
          $alt ='';
          echo cs_html_link("skype:$gbook_skype?userinfo",cs_html_img($url,'16','16','0',$alt),'0');
        }
        if (!empty($gbook_url))
        {
          echo cs_html_link("http://" . $gbook_url,cs_icon('gohome'));
        }
        echo cs_html_roco(2,'leftb');
        echo cs_secure($_POST['gbook_text'],1,1);
        echo cs_html_roco(0);
        echo cs_html_roco(1,'bottom');
        echo cs_date('unix',$time,1);
        echo cs_html_roco(2,'leftb');
        echo cs_html_roco(0);
        echo cs_html_table(0);
        echo cs_html_br(1);
      }
      else
      {
        echo cs_html_table(1,'forum',1);
        echo cs_html_roco(1,'leftc');
        echo cs_icon('important');
        echo $gbook_error;
        if($gbook_error == '1')
        {
          echo $cs_lang['error_occurred_1'];
        }
        else
        {
          echo $cs_lang['error_occurred'];
        }
        echo cs_html_roco(0);
        echo cs_html_roco(2,'leftc');
        echo $errormsg;
        echo cs_html_roco(0);
        echo cs_html_table(0);
        echo cs_html_br(1);
    }
  }

  if (!empty($gbook_form))
  {
    echo cs_html_form (1,'gbook_edit','gbook','edit');
    echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'leftc');
    echo cs_icon('personal') . $cs_lang['nick'] . ' *';
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('gbook_nick',$gbook_nick,'text',200,50);
    echo cs_html_roco(0);

    echo cs_html_roco(1,'leftc');
    echo cs_icon('mail_generic') . $cs_lang['email'] . ' *';
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('gbook_email',$gbook_email,'text',200,50);
    echo cs_html_roco(0);

    echo cs_html_roco(1,'leftc');
    echo cs_icon('licq') . $cs_lang['icq'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('gbook_icq',$gbook_icq,'text',12,50);
    echo cs_html_roco(0);

    echo cs_html_roco(1,'leftc');
    echo cs_icon('msn_protocol') . $cs_lang['msn'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('gbook_msn',$gbook_msn,'text',200,50);
    echo cs_html_roco(0);

    echo cs_html_roco(1,'leftc');
    echo cs_icon('skype') . $cs_lang['skype'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('gbook_skype',$gbook_skype,'text',200,50);
    echo cs_html_roco(0);

    echo cs_html_roco(1,'leftc');
    echo cs_icon('gohome') . $cs_lang['town'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('gbook_town',$gbook_town,'text',200,50);
    echo cs_html_roco(0);

    echo cs_html_roco(1,'leftc');
    echo cs_icon('gohome') . $cs_lang['url'];
    echo cs_html_roco(2,'leftb');
    echo 'http://';
    echo cs_html_input('gbook_url',$gbook_url,'text',200,42);
    echo cs_html_roco(0);

    echo cs_html_roco(1,'leftc');
    echo cs_icon('kate') . $cs_lang['text'] . ' *';
     echo cs_html_br(2);
     echo cs_abcode_smileys('gbook_text');
    echo cs_html_roco(2,'leftb');
    echo cs_abcode_features('gbook_text');
    echo cs_html_textarea('gbook_text',$gbook_text,'50','15');
    echo cs_html_roco(0);

    echo cs_html_roco(1,'leftc');
    echo cs_icon('configure') . $cs_lang['more'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_vote('gbook_newtime','1','checkbox',$gbook_newtime);
    echo $cs_lang['new_date'];
    echo cs_html_roco(0);

    echo cs_html_roco(1,'leftc');
    echo cs_icon('ksysguard') . $cs_lang['options'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_vote('id',$gbook_id,'hidden');
    echo cs_html_vote('submit',$cs_lang['edit'],'submit');
    echo cs_html_vote('preview',$cs_lang['preview'],'submit');
    echo cs_html_vote('reset',$cs_lang['reset'],'reset');
    echo cs_html_roco(0);
    echo cs_html_table(0);
    echo cs_html_form (0);
  }
}
else
{
  cs_redirect($cs_lang['no_access'],'gbook','center');
}
?>