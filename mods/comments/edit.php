<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('comments');

$com_id = $_REQUEST['id'];
settype($com_id,'integer');

$guestnick = '';
$cells = 'users_id, comments_text, comments_time, comments_fid, comments_edit, comments_mod, comments_guestnick';
$cs_com = cs_sql_select(__FILE__,'comments',$cells,"comments_id = '" . $com_id . "'");
$com_fid = $cs_com['comments_fid'];

$data['if']['preview'] = FALSE;
$data['if']['guest'] = FALSE;

if(isset($_POST['submit']) OR isset($_POST['preview'])) {

  $cs_com['comments_text'] = $_POST['comments_text'];

  $error = '';
  
  if(empty($cs_com['users_id'])) {
    $guestnick = $_POST['comments_guestnick'];
  
    if(empty($guestnick) AND empty($cs_com['users_id'])) {
      $error .= $cs_lang['no_guestnick'] . cs_html_br(1);
    } else {
      $nick2 = str_replace(' ','',$guestnick);
      $nickchars = strlen($nick2);
      if($nickchars < $op_users['min_letters']) {
        $error .= sprintf($cs_lang['short_nick'],$op_users['min_letters']) . cs_html_br(1);
      }
      $search_nick = cs_sql_count(__FILE__,'users',"users_nick = '" . cs_sql_escape($guestnick) . "'");
      if(!empty($search_nick)) {
        $error .= $cs_lang['nick_exists'] . cs_html_br(1);
      }
    }
  }

  if(empty($cs_com['comments_text'])) {
    $error .= $cs_lang['no_text'] . cs_html_br(1);
  }
}

if(!isset($_POST['submit']) AND !isset($_POST['preview'])) {
  $data['head']['body'] = $cs_lang['body_com_edit'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $error;
}
elseif(isset($_POST['preview'])) {
  $data['head']['body'] = $cs_lang['preview'];
}

if(isset($_POST['preview']) AND empty($error)) {

  $data['if']['preview'] = true;
  $userid = $cs_com['users_id'];
  
  if(!empty($cs_com['users_id'])) {
    $data['if']['guest_prev'] = FALSE;
    $data['if']['user_prev'] = TRUE;
  
    $select = 'users_nick, users_laston, users_place, users_country, users_active, users_invisible';
    $cs_user = cs_sql_select(__FILE__,'users',$select,"users_id = '" . $userid . "'");

    $user = cs_secure($cs_user['users_nick']);
    $url = 'symbols/countries/' . $cs_user['users_country'] . '.png';
    $data['prev']['flag'] = cs_html_img($url,11,16);
    $data['prev']['user'] = cs_user($userid,$cs_user['users_nick'], $cs_user['users_active']);

    $data['prev']['status'] = cs_userstatus($cs_user['users_laston'],$cs_user['users_invisible']);
    $data['prev']['laston'] = empty($cs_user['users_invisible']) ? '--' : cs_date('unix',$cs_user['users_laston']);

    $place = empty($cs_user['users_place']) ? '-' : $cs_user['users_place'];
    $data['prev']['place'] = cs_secure($place);

    $who = "users_id = '" . $userid . "'";
    $count_com[$userid] = cs_sql_count(__FILE__,'comments',$who);
    $data['prev']['posts'] = $count_com[$userid];
    
  } else {
    $data['if']['guest_prev'] = TRUE;
    $data['if']['user_prev'] = FALSE;
    $data['prev']['guestnick'] = cs_secure($guestnick);
  }

  $opt = "comments_mod = '".$cs_com['comments_mod']."' AND comments_fid = '" . $com_fid . "'";
  $count_com = cs_sql_count(__FILE__,'comments',$opt);
  $data['prev']['count_com'] = ($count_com + 1);
  $data['prev']['date'] = cs_date('unix',cs_time(),1);
  $data['prev']['text'] = cs_secure($cs_com['comments_text'],1,1);
}

if(!empty($error) OR isset($_POST['preview']) OR !isset($_POST['submit'])) {

  $data['com']['smileys'] = cs_abcode_smileys('comments_text');
  $data['com']['abcode'] = cs_abcode_features('comments_text');
  
  if(empty($cs_com['users_id'])) {
    $data['if']['guest'] = TRUE;
    $data['com']['guestnick'] = $guestnick;
  }
  
  $data['com']['text'] = $cs_com['comments_text'];
  $data['com']['id'] = $com_id;

  echo cs_subtemplate(__FILE__,$data,'comments','edit');
}
else {
  
  if(!empty($cs_com['comments_edit'])) {
    $edits = explode('/',$cs_com['comments_edit']);
    $edits_count = $edits[3] + 1;
  }
  else {
    $edits_count = 1;
  }
  $com_edits = $account['users_id'].'/'.$account['users_nick'].'/'.cs_time().'/'.$edits_count;  

  $com_cells = array('comments_text','comments_edit');
  $com_save = array($cs_com['comments_text'],$com_edits,$guestnick);
  cs_sql_update(__FILE__,'comments',$com_cells,$com_save,$com_id);
  
  cs_redirect($cs_lang['changes_done'],'comments','manage','where=' . $cs_com['comments_mod']);
}