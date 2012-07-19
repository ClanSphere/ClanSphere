<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('members');

$data = array();

$cells  = 'mm.members_task AS members_task, mm.members_since AS members_since, ';
$cells .= 'usr.users_picture AS users_picture, usr.users_country AS users_country, usr.users_hidden AS users_hidden, usr.users_id AS users_id, ';
$cells .= 'usr.users_nick AS users_nick, usr.users_name AS users_name, usr.users_surname AS users_surname';
$tables = 'members mm INNER JOIN {pre}_users usr ON mm.users_id = usr.users_id INNER JOIN {pre}_squads sq ON mm.squads_id = sq.squads_id';

$data['members'] = cs_sql_select(__FILE__,$tables,$cells,'sq.squads_own = 1','{random}',0,1);
$found = count($data['members']);

if(!empty($found)) {
  $data['members']['picture'] = empty($data['members']['users_picture']) ? $cs_lang['nopic'] :
    cs_html_img('uploads/users/' . $data['members']['users_picture']);
  $data['members']['since'] = empty($data['members']['members_since']) ? '-' :
    cs_date('date',$data['members']['members_since']);

  $data['members']['flag'] = cs_html_img('symbols/countries/' . $data['members']['users_country'] . '.png',11,16);

  $hidden = explode(',',$data['members']['users_hidden']);

  $users_id = $data['members']['users_id'];
  $allow = $users_id == $account['users_id'] OR $account['access_users'] > 4 ? 0 : 1;

  $content = $data['members']['users_name'];
  $content2 = $data['members']['users_surname'];

  if(in_array('users_surname',$hidden)) {
    $content2 = empty($allow) ? '' : $content2;
  }

  if(in_array('users_name',$hidden)) {
    $content = empty($allow) ? $cs_lang['noname'] : $content;
    $content2 = empty($allow) ? '' : $content2;
  }

  $data['members']['users_name'] = empty($data['members']['users_name']) ? $cs_lang['noname'] : $content;
  $data['members']['users_surname'] = empty($data['members']['users_surname']) ? '' : $content2;

  echo cs_subtemplate(__FILE__,$data,'members','navrand');
}
else
  echo $cs_lang['no_data'];