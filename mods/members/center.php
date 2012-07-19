<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('members');

$op_members = cs_sql_option(__FILE__,'members');
$op_squads = cs_sql_option(__FILE__,'squads');

$squads_id = empty($_REQUEST['where']) ? $_REQUEST['id'] : $_REQUEST['where'];
settype($squads_id,'integer');

$cs_sort[1] = 'usr.users_nick DESC';
$cs_sort[2] = 'usr.users_nick ASC';
$cs_sort[3] = 'mem.members_task DESC';
$cs_sort[4] = 'mem.members_task ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

if(!empty($_GET['del_id'])) {
  $del_id = $_GET['del_id'];
  settype($del_id,'integer');
  $target = cs_sql_select(__FILE__,'members','squads_id',"members_id = '" . $del_id . "'");
  $squads_id = $target['squads_id'];
  $is_admin = "members_admin > 0 AND squads_id ='" . $squads_id . "' AND users_id ='" . $account['users_id'] . "'";
  $allow = cs_sql_count(__FILE__,'members',$is_admin);

  if(empty($allow)) {
    $msg = $cs_lang['del_failed'];
  }
  else {
    cs_sql_delete(__FILE__,'members',$del_id);
    $msg = $cs_lang['del_done'];
  }
}

$data['lang']['mod_name'] = $cs_lang[$op_members['label']];
$data['url']['form'] = cs_url('members','center');
$data['lang']['team'] = $cs_lang[$op_squads['label']];

$where = "mem.users_id = '" . $account['users_id'] . "' AND mem.members_admin > 0";
$select = 'sqd.squads_name AS squads_name, sqd.squads_id AS squads_id';
$from = 'members mem INNER JOIN {pre}_squads sqd ON mem.squads_id = sqd.squads_id';
$sqd_data = cs_sql_select(__FILE__,$from,$select,$where,'sqd.squads_name',0,0);
$sqd_loop = count($sqd_data);

for($run=0; $run<$sqd_loop; $run++) {
  $data['squad'][$run]['selected'] = $sqd_data[$run]['squads_id'] == $squads_id ? ' selected="selected"' : '';
  $data['squad'][$run]['id'] = $sqd_data[$run]['squads_id'];
  $data['squad'][$run]['name'] = cs_secure($sqd_data[$run]['squads_name']);
}

if (empty($sqd_loop)) $data['squad'] = array();
$data['lang']['msg'] = !empty($msg) ? $msg : '';

$select = 'mem.members_admin AS members_admin, mem.members_order AS members_order, mem.users_id AS users_id, usr.users_nick AS users_nick, usr.users_delete AS users_delete, usr.users_active AS users_active, mem.members_task, mem.members_id AS members_id';
$from = 'members mem INNER JOIN {pre}_users usr ON mem.users_id = usr.users_id';
$where = "mem.squads_id = '" . $squads_id . "'";
$cs_members = cs_sql_select(__FILE__,$from,$select,$where,$order,0,0);
$members_loop = count($cs_members);

$data['sort']['user'] = cs_sort('members','center',0,$squads_id,1,$sort);
$data['sort']['task'] = cs_sort('members','center',0,$squads_id,3,$sort);

$img_edit = cs_icon('edit',16,$cs_lang['edit']);
$img_del = cs_icon('editdelete',16,$cs_lang['remove']);

if (empty($members_loop))
  $data['members'] = '';

for($run=0; $run<$members_loop; $run++) {

  $users_nick = cs_user($cs_members[$run]['users_id'], $cs_members[$run]['users_nick'], $cs_members[$run]['users_active'], $cs_members[$run]['users_delete']);
  $data['members'][$run]['user'] = empty($cs_members[$run]['members_admin']) ? $users_nick : cs_html_big(1) . $users_nick . cs_html_big(0);
  $data['members'][$run]['task'] = cs_secure($cs_members[$run]['members_task']);
  $data['members'][$run]['order'] = $cs_members[$run]['members_order'];
  $data['members'][$run]['edit'] = cs_link($img_edit,'members','change','id=' . $cs_members[$run]['members_id'],0,$cs_lang['edit']);
  $data['members'][$run]['remove'] = cs_link($img_del,'members','center','del_id=' . $cs_members[$run]['members_id'],0,$cs_lang['remove']);
}

echo cs_subtemplate(__FILE__,$data,'members','center');