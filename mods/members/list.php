<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('members');

$op_members = cs_sql_option(__FILE__,'members');
$op_squads = cs_sql_option(__FILE__,'squads');

$tables = 'squads sq INNER JOIN {pre}_clans cln ON sq.clans_id = cln.clans_id';
$cells  = 'sq.squads_id AS squads_id, sq.games_id AS games_id, sq.squads_name AS squads_name, ';
$cells .= 'sq.clans_id AS clans_id, cln.clans_tagpos AS clans_tagpos, sq.squads_text AS squads_text, ';
$cells .= 'cln.clans_tag AS clans_tag, sq.squads_picture AS squads_picture';
$cs_squads = cs_sql_select(__FILE__,$tables,$cells,'squads_own = \'1\'','squads_order, squads_name',0,0);

$squads_loop = count($cs_squads);
$members_count = cs_sql_count(__FILE__,'members',0,'users_id');

$data['lang']['members'] = $cs_lang[$op_members['label']];
$data['lang']['list'] = $cs_lang['head_list'];
$data['count']['members'] = $members_count;
$data['pictured']['url'] = cs_url('members','pictured');
$data['pictured']['name'] = $cs_lang['pictured'];

$data['lang']['country'] = $cs_lang['country'];

if (empty($squads_loop)) {
  $data['squads'] = '';
}

for($sq_run = 0; $sq_run < $squads_loop; $sq_run++) {
  
  $select = 'mem.members_task AS members_task, mem.members_since AS members_since, mem.members_admin AS members_admin, mem.users_id AS users_id, usr.users_nick AS users_nick, usr.users_delete AS users_delete, usr.users_country AS users_country, usr.users_laston AS users_laston, usr.users_name AS users_name, usr.users_surname AS users_surname, usr.users_active AS users_active, usr.users_invisible AS users_invisible';
  $from = 'members mem INNER JOIN {pre}_users usr ON mem.users_id = usr.users_id ';
  $where = "mem.squads_id='" . $cs_squads[$sq_run]['squads_id'] . "'";
  $order = 'mem.members_order ASC, usr.users_nick ASC';
  
  $cs_members = cs_sql_select(__FILE__,$from,$select,$where,$order,0,0);
  $members_loop = count($cs_members);
  
  $data['squads'][$sq_run]['membercount'] = $members_loop . ' ' . $cs_lang['members'];
  $data['squads'][$sq_run]['gameicon'] = empty($cs_squads[$sq_run]['games_id']) ? '' : cs_html_img('uploads/games/'.$cs_squads[$sq_run]['games_id'].'.gif');
  
  if (empty($cs_squads[$sq_run]['squads_text']))
    $data['squads'][$sq_run]['if']['text'] = false;
  else {
    $data['squads'][$sq_run]['if']['text'] = 1;
    $data['squads'][$sq_run]['squads_text'] = cs_secure($cs_squads[$sq_run]['squads_text'],1,1);
  }
  
  $data['squads'][$sq_run]['name'] = cs_secure($cs_squads[$sq_run]['squads_name']);
  $data['squads'][$sq_run]['squads_picture'] = cs_html_img('uploads/squads/'.$cs_squads[$sq_run]['squads_picture']);
  
  $data['squads'][$sq_run]['members'] = !empty($cs_members) ? $cs_members : array();
  
  for($run = 0; $run < $members_loop; $run++) {
    $url = 'symbols/countries/' . $cs_members[$run]['users_country'] . '.png';
    $data['squads'][$sq_run]['members'][$run]['country'] = cs_html_img($url,11,16);    
    $data['squads'][$sq_run]['members'][$run]['nick']  = $cs_squads[$sq_run]['clans_tagpos'] == 1 ?
        $cs_squads[$sq_run]['clans_tag'] . ' ' : '';
    $data['squads'][$sq_run]['members'][$run]['nick'] .=
        cs_user($cs_members[$run]['users_id'],$cs_members[$run]['users_nick'], $cs_members[$run]['users_active'], $cs_members[$run]['users_delete']);
    $data['squads'][$sq_run]['members'][$run]['nick'] .= $cs_squads[$sq_run]['clans_tagpos'] == 2 ?
        ' ' . $cs_squads[$sq_run]['clans_tag'] : '';
    $data['squads'][$sq_run]['members'][$run]['task']  = cs_secure($cs_members[$run]['members_task']);
    $data['squads'][$sq_run]['members'][$run]['since'] = empty($cs_members[$run]['members_since']) ? '-'
      : cs_date('date',$cs_members[$run]['members_since']);
    $data['squads'][$sq_run]['members'][$run]['status'] = cs_userstatus($cs_members[$run]['users_laston'],$cs_members[$run]['users_invisible']);
    $data['squads'][$sq_run]['members'][$run]['users_name'] = 
      empty($data['squads'][$sq_run]['members'][$run]['users_name']) ? '' : 
      $data['squads'][$sq_run]['members'][$run]['users_name'];
    $data['squads'][$sq_run]['members'][$run]['users_surname'] = 
      empty($data['squads'][$sq_run]['members'][$run]['users_surname']) ? '' : 
      $data['squads'][$sq_run]['members'][$run]['users_surname'];
  }
}

echo cs_subtemplate(__FILE__,$data,'members','list');
