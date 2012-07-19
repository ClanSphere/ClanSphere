<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('newsletter');
$cs_get = cs_get('id');
$data = array();

$newsletter_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$from = 'newsletter nwl INNER JOIN {pre}_users usr ON nwl.users_id = usr.users_id ';
$select = 'nwl.newsletter_id AS newsletter_id, nwl.newsletter_subject AS newsletter_subject, nwl.newsletter_time AS newsletter_time, nwl.newsletter_text AS newsletter_text, nwl.newsletter_to AS newsletter_to, nwl.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active'; 

$data['newsletter'] = cs_sql_select(__FILE__,$from,$select,"newsletter_id = '" . $newsletter_id . "'");
    

$data['newsletter']['subject'] = cs_secure($data['newsletter']['newsletter_subject']);
$data['newsletter']['date'] = cs_date('unix',$data['newsletter']['newsletter_time'],1);
$data['newsletter']['user'] = cs_user($data['newsletter']['users_id'],$data['newsletter']['users_nick'],$data['newsletter']['users_active']);
$check_to = explode('?',$data['newsletter']['newsletter_to']); 
switch ($check_to[0])
{
  case 1:
  {
    $newsletter_to = $cs_lang['all_users'];
    break;
  }
  case 2:
  {
    $group = cs_sql_select(__FILE__,'access','access_name',"access_id = '" . $check_to[1] . "'");
    $newsletter_to = $cs_lang['ac_group'] . ' ' . $group['access_name'];
    break;
  }
  case 3:
  {
    $group = cs_sql_select(__FILE__,'squads','squads_name',"squads_id = '" . $check_to[1] . "'");
    $newsletter_to = $cs_lang['squad'] . ' ' . $group['squads_name'];
    break;
  }
  case 4:
  {
    $group = cs_sql_select(__FILE__,'clans','clans_name',"clans_id = '" . $check_to[1] . "'");
    $newsletter_to = $cs_lang['clan'] . ' ' . $group['clans_name'];
    break;
  }                                                                                               
}

$data['newsletter']['to'] = cs_secure($newsletter_to);
$data['newsletter']['text'] = cs_secure($data['newsletter']['newsletter_text'],1,1);

echo cs_subtemplate(__FILE__,$data,'newsletter','view');