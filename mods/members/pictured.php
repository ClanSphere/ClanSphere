<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('members');
$data = array();

$op_members = cs_sql_option(__FILE__,'members');
$op_squads = cs_sql_option(__FILE__,'squads');

$tables = 'squads sq INNER JOIN {pre}_clans cln ON sq.clans_id = cln.clans_id';
$cells  = 'sq.squads_id AS squads_id, sq.games_id AS games_id, sq.squads_name AS squads_name, ';
$cells .= 'sq.clans_id AS clans_id, cln.clans_tagpos AS clans_tagpos, ';
$cells .= 'cln.clans_tag AS clans_tag';
$data['squads'] = cs_sql_select(__FILE__,$tables,$cells,'squads_own = \'1\'','squads_order, squads_name',0,0);
$squads_loop = count($data['squads']);

$data['head']['mod'] = $cs_lang[$op_members['label']];
$data['head']['body'] = sprintf($cs_lang['body_pictured'], $squads_loop);
$data['lang']['members'] = $cs_lang[$op_members['label']];

for($sq_run=0; $sq_run<$squads_loop; $sq_run++) {

  $select  = 'mem.members_admin AS members_admin, mem.members_task AS members_task, ';
  $select .= 'mem.members_since AS members_since, mem.users_id AS users_id, usr.users_nick AS users_nick, ';
  $select .= 'usr.users_name AS users_name, usr.users_surname AS users_surname, usr.users_sex AS users_sex, ';
  $select .= 'usr.users_age AS users_age, usr.users_place AS users_place, usr.users_country AS users_country, ';
  $select .= 'usr.users_picture AS users_picture, usr.users_active AS users_active, usr.users_hidden AS users_hidden, usr.users_delete AS users_delete';
  $from = 'members mem INNER JOIN {pre}_users usr ON mem.users_id = usr.users_id ';
  $where = "mem.squads_id = '" . $data['squads'][$sq_run]['squads_id'] . "'";
  $order = 'mem.members_order ASC, usr.users_nick ASC';

  $data['squads'][$sq_run]['members'] = cs_sql_select(__FILE__,$from,$select,$where,$order,0,0);
  $members_loop = count($data['squads'][$sq_run]['members']);

  $data['squads'][$sq_run]['games_img'] = '';
  if(!empty($data['squads'][$sq_run]['games_id'])) {
    $data['squads'][$sq_run]['games_img'] = cs_html_img('uploads/games/' . $data['squads'][$sq_run]['games_id'] . '.gif');
  }
  $data['squads'][$sq_run]['squad_name'] = cs_secure($data['squads'][$sq_run]['squads_name']);
  $data['squads'][$sq_run]['count_members'] = $members_loop;

  if(empty($members_loop)) {
  $data['squads'][$sq_run]['members'] = array();
  }

  $tr = 0;
  for($run=0; $run<$members_loop; $run++) {
  
  $members = $data['squads'][$sq_run]['members'];
  
    $hidden = explode(',',$members[$run]['users_hidden']);
    $allow = $members[$run]['users_id'] == $account['users_id']  OR $account['access_users'] > 4 ? 1 : 0;
    
  if(empty($members[$run]['users_picture'])) {
      $members[$run]['picture'] = $cs_lang['nopic'];
  } else {
      $place = 'uploads/users/' . $members[$run]['users_picture'];
      $size = getimagesize($cs_main['def_path'] . '/' . $place);
      $members[$run]['picture'] = cs_html_img($place,$size[1],$size[0]);
  }

  $url = 'symbols/countries/' . $members[$run]['users_country'] . '.png';
  $members[$run]['country'] = cs_html_img($url,11,16) . ' ';    
  
  $members[$run]['nick']  = $data['squads'][$sq_run]['clans_tagpos'] == 1 ? $data['squads'][$sq_run]['clans_tag'] . ' ' : '';
  $members[$run]['nick'] .=
    cs_user($members[$run]['users_id'],$members[$run]['users_nick'], $members[$run]['users_active'], $members[$run]['users_delete']);
  $members[$run]['nick'] .= $data['squads'][$sq_run]['clans_tagpos'] == 2 ? ' ' . $data['squads'][$sq_run]['clans_tag'] : '';

  $users_name = !in_array('users_name',$hidden) || !empty($allow) ? $members[$run]['users_name'] : '';
  $users_surname = !in_array('users_surname',$hidden) || !empty($allow) ? $members[$run]['users_surname'] : '';
  $members[$run]['surname'] = empty($users_name) && empty($users_surname) ? ' - ' : $users_name . ' ' . $users_surname;
    
  $members[$run]['task'] = cs_secure($members[$run]['members_task']);
  $since = empty($members[$run]['members_since']) ? '-' : cs_date('date',$members[$run]['members_since']);
  $members[$run]['since'] = $since;

  $tr++;
  $members[$run]['if']['td'] = FALSE;
  $members[$run]['if']['end_row'] = FALSE;
  
  if(($tr %2 != 0) && ($tr == $members_loop)) {
    $members[$run]['if']['td'] = TRUE;
  } elseif (($tr %2 == 0) && ($tr != $members_loop)) {
    $members[$run]['if']['end_row'] = TRUE;
  }

  $data['squads'][$sq_run]['members'] = $members;
  }

}

echo cs_subtemplate(__FILE__,$data,'members','pictured');
