<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$clan_id = 1;

$cs_lang = cs_translate('members');
$op_members = cs_sql_option(__FILE__,'members');

$squads_order = 'squads_order, squads_name';
$cs_squads = cs_sql_select(__FILE__,'squads','*','squads_own = \'1\'',$squads_order,0,0);
$squads_loop = count($cs_squads);

$data['lang']['mod_name'] = $cs_lang[$op_members['label']];

$data['lang']['body'] = sprintf($cs_lang['body_list'], $squads_loop);

if(empty($squads_loop)) {
  $data['members'] = '';
}

for($sq_run=0; $sq_run<$squads_loop; $sq_run++) {
  $select = 'mem.members_admin AS members_admin, mem.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete';
  $from = 'members mem INNER JOIN {pre}_users usr ON mem.users_id = usr.users_id ';
  $where = "mem.squads_id = '" . $cs_squads[$sq_run]['squads_id'] . "'";
  $order = 'mem.members_order ASC, usr.users_nick ASC';
  
  $cs_members = cs_sql_select(__FILE__,$from,$select,$where,$order,0,0);
  $members_loop = count($cs_members);


  if(empty($cs_squads[$sq_run]['squads_picture'])) {
    $data['members'][$sq_run]['pic'] = $cs_lang['nopic'];
  }
  else {
    $place = 'uploads/squads/' . $cs_squads[$sq_run]['squads_picture'];
    $size = getimagesize($cs_main['def_path'] . '/' . $place);
    $data['members'][$sq_run]['pic'] = cs_html_img($place,$size[1],$size[0]);
  }
  
  $id = 'id=' . $cs_squads[$sq_run]['squads_id'];
  $squads_name = cs_secure($cs_squads[$sq_run]['squads_name']);
  $data['members'][$sq_run]['name'] = cs_link($squads_name,'squads','view',$id);

  if(!empty($cs_squads[$sq_run]['games_id'])) {    
    if(file_exists('uploads/games/' . $cs_squads[$sq_run]['games_id'] . '.gif')) {
      $data['members'][$sq_run]['icon'] = cs_html_img('uploads/games/' . $cs_squads[$sq_run]['games_id'] . '.gif');
    } else {
      $data['members'][$sq_run]['icon'] = '';
    }
    $where = "games_id = '" . $cs_squads[$sq_run]['games_id'] . "'";
    $cs_game = cs_sql_select(__FILE__,'games','games_name, games_id',$where);
    $id = 'id=' . $cs_game['games_id'];
    $data['members'][$sq_run]['game'] = ' ' . cs_link($cs_game['games_name'],'games','view',$id);
    $data['members'][$sq_run]['if']['game'] = TRUE;
  } else {
    $data['members'][$sq_run]['if']['game'] = FALSE;
    $data['members'][$sq_run]['game'] = ' - ';
    $data['members'][$sq_run]['icon'] = '';
  }

  if(empty($members_loop)) {
    $data['loop']['squad_members'] = '';
    $data['stop']['squad_members'] = '';
    $data['squad_members']['members'] = '';
    $data['squad_members']['dot'] = '';
  }

  
  for($run=0; $run<$members_loop; $run++) {
        
    $data['members'][$sq_run]['squad_members'][$run]['members'] =  cs_user($cs_members[$run]['users_id'], $cs_members[$run]['users_nick'], $cs_members[$run]['users_active'], $cs_members[$run]['users_delete']);  
    
    if($run == ($members_loop - 1)) {
      $data['members'][$sq_run]['squad_members'][$run]['dot'] =  '';
    } elseif(!empty($run)) {
      $data['members'][$sq_run]['squad_members'][$run]['dot'] =  ', ';
    } else {
      $data['members'][$sq_run]['squad_members'][$run]['dot'] =  ', ';
    }
  }  
}

echo cs_subtemplate(__FILE__,$data,'members','teams');
