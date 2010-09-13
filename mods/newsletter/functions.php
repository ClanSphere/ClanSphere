<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_newsletter_to($select) {

  $cs_lang = cs_translate('newsletter');
  # TODO: Make $select work and insert clan and squad translation naming switch

  $dp = cs_html_option('----','0',1);
  $dp .= cs_html_option($cs_lang['all_users'],'1');
  $dp .= cs_html_option('&raquo;' .$cs_lang['ac_group'],'');
  $usergroups = cs_sql_select(__FILE__,'access','access_id,access_name','access_id != 1',0,0,0);
  foreach($usergroups AS $value) {
    $dp .= cs_html_option('&nbsp;&nbsp;&nbsp;' . cs_secure($value['access_name']),'2?' .$value['access_id']);
  }

  $dp .= cs_html_option(' &raquo;' .$cs_lang['squad'],'');
  $squads = cs_sql_select(__FILE__,'squads','squads_id, squads_name',0,'squads_name',0,0);
  $squads = empty($squads) ? array() : $squads;
  foreach($squads AS $squad) {
    $dp .= cs_html_option('&nbsp;&nbsp;&nbsp;' . cs_secure($squad['squads_name']),'3?' .$squad['squads_id']);
  }   
  $dp .= cs_html_option('&raquo;' .$cs_lang['clan'],'');

  $clans = cs_sql_select(__FILE__,'clans','clans_id, clans_name',0,'clans_name',0,0);
  $clans = empty($clans) ? array() : $clans;
  foreach($clans AS $clan) {
    $dp .= cs_html_option('&nbsp;&nbsp;&nbsp;' . cs_secure($clan['clans_name']),'4?' .$clan['clans_id']);
  }
  $data['nl']['to_dropdown'] = $dp;

  return $dp;
}

function cs_newsletter_emails($select) {

  $check_to = explode('?', $select); 
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

  return cs_sql_select(__FILE__,$from,$select,$where,0,0,0);
}