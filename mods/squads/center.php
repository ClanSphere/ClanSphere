<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('squads');
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();

$op_squads = cs_sql_option(__FILE__,'squads');

$data['if']['squad_to_leave'] = FALSE;

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 2 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$cs_sort[1] = 'sqd.squads_name DESC';
$cs_sort[2] = 'sqd.squads_name ASC';
$cs_sort[3] = 'mem.members_task DESC';
$cs_sort[4] = 'mem.members_task ASC';
$order = $cs_sort[$sort];
$own = "users_id = '" . $account['users_id'] . "'";
$squads_count = cs_sql_count(__FILE__,'members',$own);


$data['head']['mod'] = $cs_lang[$op_squads['label'].'s'];
$data['lang']['new_label'] = $cs_lang['new_'.$op_squads['label']];
$data['head']['count'] = $squads_count;
$data['head']['pages'] = cs_pages('squads','center',$squads_count,$start,0,$sort);
$data['head']['getmsg'] = cs_getmsg();

$data['lang']['join_label'] = $cs_lang['join_'.$op_squads['label']];
if(!empty($squads_count)) {
  $data['if']['squad_to_leave'] = TRUE;
  $data['lang']['leave_label'] = $cs_lang['leave_'.$op_squads['label']];
}

$data['sort']['squad_name'] = cs_sort('squads','center',$start,0,1,$sort);
$data['lang']['label'] = $cs_lang[$op_squads['label']];
$data['sort']['members_task'] = cs_sort('squads','center',$start,0,3,$sort);

$select = 'sqd.squads_name AS squads_name, sqd.squads_id AS squads_id, mem.members_task AS members_task, mem.members_admin AS members_admin';
$from = 'members mem INNER JOIN {pre}_squads sqd ON mem.squads_id = sqd.squads_id';
$where = "mem.users_id = '" . $account['users_id'] . "'";
$data['squads'] = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$squads_loop = count($data['squads']);


for($run=0; $run<$squads_loop; $run++) {

  $data['squads'][$run]['id'] = $data['squads'][$run]['squads_id'];
   $data['squads'][$run]['name'] = cs_secure($data['squads'][$run]['squads_name']);
  $data['squads'][$run]['members_task'] = cs_secure($data['squads'][$run]['members_task']);

  if(!empty($data['squads'][$run]['members_admin'])) {
    $data['squads'][$run]['if']['squad_admin'] = TRUE;
    $data['squads'][$run]['if']['no_squad_admin'] = FALSE;
  } else {
    $data['squads'][$run]['if']['squad_admin'] = FALSE;
    $data['squads'][$run]['if']['no_squad_admin'] = TRUE;
  }
}

echo cs_subtemplate(__FILE__,$data,'squads','center');
