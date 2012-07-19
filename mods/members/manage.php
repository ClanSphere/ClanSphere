<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('members');

$op_members = cs_sql_option(__FILE__,'members');
$op_squads = cs_sql_option(__FILE__,'squads');

$letter = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'usr.users_nick DESC';
$cs_sort[2] = 'usr.users_nick ASC';
$cs_sort[3] = 'sqd.squads_name DESC';
$cs_sort[4] = 'sqd.squads_name ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$members_count = cs_sql_count(__FILE__,'members');


$data['lang']['mod_name'] = $cs_lang[$op_members['label']];
$data['member']['all'] = $members_count;
$data['pages']['list'] = cs_pages('members','manage',$members_count,$start,0,$sort);


$data['lang']['getmsg'] = cs_getmsg();

$select = 'mem.members_admin AS members_admin, mem.users_id AS users_id, mem.squads_id AS squads_id, mem.members_order AS members_order, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete, sqd.squads_name AS squads_name, mem.members_id AS members_id';
$from = 'members mem LEFT JOIN {pre}_users usr ON mem.users_id = usr.users_id LEFT JOIN {pre}_squads sqd ON mem.squads_id = sqd.squads_id ';
$where = empty($letter) ? "users_delete = '0'" : "users_delete = '0' AND users_nick LIKE '" . cs_sql_escape($letter) . "%'";
$cs_members = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$members_loop = count($cs_members);

$data['sort']['user'] = cs_sort('members','manage',$start,0,1,$sort);
$data['sort']['team'] = cs_sort('members','manage',$start,0,3,$sort);
$data['lang']['team'] = $cs_lang[$op_squads['label']];


$img_edit = cs_icon('edit',16,$cs_lang['edit']);
$img_del = cs_icon('editdelete',16,$cs_lang['remove']);

if (empty($members_loop)) {
  $data['members'] = '';
}

for($run=0; $run<$members_loop; $run++) {


  $users_nick = cs_user($cs_members[$run]['users_id'],$cs_members[$run]['users_nick'], $cs_members[$run]['users_active'], $cs_members[$run]['users_delete']);
  $data['members'][$run]['user'] = empty($cs_members[$run]['members_admin']) ? $users_nick : cs_html_big(1) . $users_nick . cs_html_big(0);

  $cs_squad_name = cs_secure($cs_members[$run]['squads_name']);
  $data['members'][$run]['team'] = cs_link($cs_squad_name,'squads','view','id=' . $cs_members[$run]['squads_id']);

  $data['members'][$run]['order'] = $cs_members[$run]['members_order'];

  $data['members'][$run]['edit'] = cs_link($img_edit,'members','edit','id=' . $cs_members[$run]['members_id'],0,$cs_lang['edit']);
  $data['members'][$run]['remove'] = cs_link($img_del,'members','remove','id=' . $cs_members[$run]['members_id'],0,$cs_lang['remove']);

}
echo cs_subtemplate(__FILE__,$data,'members','manage');
