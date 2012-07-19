<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('notifymods');

empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start']; 
$cs_sort[1] = 'users_nick DESC';
$cs_sort[2] = 'users_nick ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$notifymods_count = cs_sql_count(__FILE__,'notifymods');

$data['head']['count'] = $notifymods_count;
$data['head']['pages'] = cs_pages('notifymods','manage',$notifymods_count,$start,0,$sort);

$data['head']['getmsg'] = cs_getmsg();

$data['sort']['users_nick'] = cs_sort('notifymods','manage',$start,0,1,$sort);

$from = 'notifymods ntm INNER JOIN {pre}_users usr ON ntm.notifymods_user = usr.users_id';
$select = 'ntm.notifymods_id, usr.users_id, usr.users_nick, usr.users_active, usr.users_delete, ntm.notifymods_gbook, ntm.notifymods_joinus, ntm.notifymods_fightus, ntm.notifymods_files, ntm.notifymods_board';
$data['nm'] = cs_sql_select(__FILE__,$from,$select,0,$order,$start,$account['users_limit']);
$notifymods_loop = count($data['nm']);

for($run=0; $run<$notifymods_loop; $run++) {

  $data['nm'][$run]['notifymods_user'] = cs_user($data['nm'][$run]['users_id'],$data['nm'][$run]['users_nick'],$data['nm'][$run]['users_active'], $data['nm'][$run]['users_delete']);
  $data['nm'][$run]['notifymods_gbook'] = empty($data['nm'][$run]['notifymods_gbook']) ? $cs_lang['no'] : $cs_lang['yes'];
  $data['nm'][$run]['notifymods_joinus'] = empty($data['nm'][$run]['notifymods_joinus']) ? $cs_lang['no'] : $cs_lang['yes'];
  $data['nm'][$run]['notifymods_fightus'] = empty($data['nm'][$run]['notifymods_fightus']) ? $cs_lang['no'] : $cs_lang['yes'];
  $data['nm'][$run]['notifymods_files'] = empty($data['nm'][$run]['notifymods_files']) ? $cs_lang['no'] : $cs_lang['yes'];
  $data['nm'][$run]['notifymods_board'] = empty($data['nm'][$run]['notifymods_board']) ? $cs_lang['no'] : $cs_lang['yes'];
  
  $data['nm'][$run]['url_edit'] = cs_url('notifymods','edit','id=' . $data['nm'][$run]['notifymods_id'],0,$cs_lang['edit']);
  $data['nm'][$run]['url_remove'] = cs_url('notifymods','remove','id=' . $data['nm'][$run]['notifymods_id'],0,$cs_lang['remove']);
}

echo cs_subtemplate(__FILE__,$data,'notifymods','manage');