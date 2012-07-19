<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clans');

$op_clans = cs_sql_option(__FILE__,'clans');
$op_squads = cs_sql_option(__FILE__,'squads');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$where = empty($_REQUEST['where']) ? $_GET['id'] : $_REQUEST['where'];
settype($where,'integer');
$cs_sort[1] = 'clans_name DESC';
$cs_sort[2] = 'clans_name ASC';
$cs_sort[3] = 'squads_name DESC';
$cs_sort[4] = 'squads_name ASC';
$cs_sort[5] = 'members_since DESC';
$cs_sort[6] = 'members_since ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$cru = "users_id = '" . $where . "'";
$clans_count = cs_sql_count(__FILE__,'members',$cru);

$data['lang']['mod_name'] = $cs_lang[$op_clans['label']];
$data['lang']['addons'] = cs_addons('users','view',$where,'clans');
$data['pages']['list'] = cs_pages('clans','users',$clans_count,$start,$where,$sort);

$select = 'mem.members_task AS members_task, mem.members_since AS members_since, ';
$select .= 'sqd.squads_id AS squads_id, sqd.squads_name AS squads_name, ';
$select .= 'cln.clans_id AS clans_id, cln.clans_name AS clans_name';
$from = 'members mem INNER JOIN {pre}_squads sqd ON mem.squads_id = sqd.squads_id ';
$from .= 'INNER JOIN {pre}_clans cln ON sqd.clans_id = cln.clans_id';
$where2 = "mem.users_id ='" . $where . "'";

$cs_clans = cs_sql_select(__FILE__,$from,$select,$where2,$order,$start,$account['users_limit']);
$clans_loop = count($cs_clans);

$data['sort']['clans'] = cs_sort('clans','users',$start,$where,1,$sort);
$data['lang']['clans'] = $cs_lang[$op_clans['label']];
$data['sort']['squads'] = cs_sort('clans','users',$start,$where,3,$sort);
$data['lang']['squads'] = $cs_lang[$op_squads['label']];
$data['sort']['joined'] = cs_sort('clans','users',$start,$where,5,$sort);

if(empty($clans_loop)) {
  $data['clans'] = '';
}

for($run=0; $run<$clans_loop; $run++) {
  $data['clans'][$run]['name'] = cs_link(cs_secure($cs_clans[$run]['clans_name']),'clans','view','id=' . $cs_clans[$run]['clans_id']);
  $data['clans'][$run]['short'] = cs_link(cs_secure($cs_clans[$run]['squads_name']),'squads','view','id=' . $cs_clans[$run]['squads_id']);
  $data['clans'][$run]['task'] = cs_secure($cs_clans[$run]['members_task']);
  $data['clans'][$run]['since'] = empty($cs_clans[$run]['members_since']) ? '-' : cs_date('date',$cs_clans[$run]['members_since']);
}

echo cs_subtemplate(__FILE__,$data,'clans','users');
