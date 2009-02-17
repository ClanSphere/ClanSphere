<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('newsletter');
$data = array();

$cs_nl['newsletter_subject'] = '';
$cs_nl['newsletter_to'] = '';
$cs_nl['newsletter_text'] = '';
$cs_nl['newsletter_time'] = cs_time();
$cs_nl['users_id'] = $account['users_id'];

if(isset($_POST['submit'])) {

  $cs_nl['newsletter_subject'] = $_POST['newsletter_subject'];
  $cs_nl['newsletter_to'] = $_POST['newsletter_to'];
  $cs_nl['newsletter_text'] = $_POST['newsletter_text'];
  
  $error = '';
  
  if(empty($cs_nl['newsletter_subject']))
    $error .= $cs_lang['no_subject'] . cs_html_br(1);
  if(empty($cs_nl['newsletter_to']))
    $error .= $cs_lang['no_to'] . cs_html_br(1);
  if(empty($cs_nl['newsletter_text']))
    $error .= $cs_lang['no_text'] . cs_html_br(1);
}

if(!isset($_POST['submit'])) {
  $data['head']['body'] = $cs_lang['require'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['nl'] = $cs_nl;
  
  $data['nl']['to_dropdown'] = cs_html_option('----','0',1);
  $data['nl']['to_dropdown'] .= cs_html_option($cs_lang['all_users'],'1');
  $data['nl']['to_dropdown'] .= cs_html_option('&raquo;' .$cs_lang['ac_group'],'');
  $usergroups = cs_sql_select(__FILE__,'access','access_id,access_name','access_id != 1',0,0,0);
  foreach($usergroups as $value) {
    $data['nl']['to_dropdown'] .= cs_html_option('&nbsp;&nbsp;&nbsp;' .$value['access_name'],'2?' .$value['access_id']);
  }
  $data['nl']['to_dropdown'] .= cs_html_option(' &raquo;' .$cs_lang['squad'],'');
  $usergroups = cs_sql_select(__FILE__,'squads','squads_id,squads_name',0,0,0,0);
  foreach($usergroups as $value) {
    $data['nl']['to_dropdown'] .= cs_html_option('&nbsp;&nbsp;&nbsp;' .$value['squads_name'],'3?' .$value['squads_id']);
  }   
  $data['nl']['to_dropdown'] .= cs_html_option('&raquo;' .$cs_lang['clan'],'');
  $usergroups = cs_sql_select(__FILE__,'clans','clans_id,clans_name',0,0,0,0);
  foreach($usergroups as $value) {
    $data['nl']['to_dropdown'] .= cs_html_option('&nbsp;&nbsp;&nbsp;' .$value['clans_name'],'4?' .$value['clans_id']);
  }

 echo cs_subtemplate(__FILE__,$data,'newsletter','create');

}
else {

  $check_to = explode('?',$cs_nl['newsletter_to']); 
  switch ($check_to[0]) 
  {
    case 1:
       {
         $from  = 'users';
      $where = "users_active = '1' AND users_newsletter = '1'";
      $select = 'users_email';
         break;
       }
       break;
           case 2:
       {
         $from  = 'access acs INNER JOIN {pre}_users usr ON usr.access_id = acs.access_id ';
      $where = "acs.access_id = '" . $check_to[1] . "' AND usr.users_newsletter = '1'";
      $select = 'usr.users_email';
         break;
       }
       break;
    case 3:
    {
         $from  = 'squads squ INNER JOIN {pre}_members meb ON meb.squads_id = squ.squads_id ';
      $from .= 'INNER JOIN {pre}_users usr ON meb.users_id = usr.users_id';
      $where = "squ.squads_id = '" . $check_to[1] . "' AND usr.users_newsletter = '1'";
      $select = 'usr.users_email';
         break;
       } 
       case 4:
       {
         $from  = 'clans cln INNER JOIN {pre}_squads squ ON squ.clans_id = cln.clans_id ';
         $from .= 'INNER JOIN {pre}_members meb ON meb.squads_id = squ.squads_id ';
      $from .= 'INNER JOIN {pre}_users usr ON meb.users_id = usr.users_id';
      $where = "cln.clans_id = '" . $check_to[1] . "' AND usr.users_newsletter = '1'";
      $select = 'usr.users_email';
         break;
       }
       break;
  }

  $mail_addys = cs_sql_select(__FILE__,$from,$select,$where,0,0,0);
  $count_mails = 0; 
  foreach($mail_addys as $value)
  {       
    cs_mail($value['users_email'],$cs_nl['newsletter_subject'],$cs_nl['newsletter_text']);
    $count_mails++; 
  }
  $cells = array_keys($cs_nl);
  $values = array_values($cs_nl);
  cs_sql_insert(__FILE__,'newsletter',$cells,$values);
  
  cs_redirect(sprintf($cs_lang['successfull'],$count_mails),'newsletter');
}

?>