<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanpartys');

$where = empty($_REQUEST['where']) ? $_GET['id'] : $_REQUEST['where'];
settype($where,'integer');
$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'lanpartys_name DESC';
$cs_sort[2] = 'lanpartys_name ASC';
$cs_sort[3] = 'lanpartys_start DESC';
$cs_sort[4] = 'lanpartys_start ASC';
$cs_sort[5] = 'languests_status DESC';
$cs_sort[6] = 'languests_status ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$lanpartys_count = cs_sql_count(__FILE__,'lanpartys');

$cs_user = cs_sql_select(__FILE__,'users','users_nick, users_active, users_delete',"users_id = '" . $where . "'");
$user = cs_user($where,$cs_user['users_nick'], $cs_user['users_active'], $cs_user['users_delete']);

$data['lang']['addons'] = cs_addons('users','view',$where,'lanpartys');
$data['lang']['body'] = sprintf($cs_lang['body_users'], $user);
$data['pages']['list'] = cs_pages('lanpartys','users',$lanpartys_count,$start,$where,$sort);

$select = 'lpa.lanpartys_name AS lanpartys_name, lpa.lanpartys_id AS lanpartys_id, lpa.lanpartys_start AS lanpartys_start, lgu.languests_status AS languests_status, lrd.lanroomd_id AS lanroomd_id, lrd.lanroomd_number AS lanroomd_number';
$from = 'languests lgu INNER JOIN {pre}_lanpartys lpa ON lgu.lanpartys_id = lpa.lanpartys_id LEFT JOIN {pre}_lanroomd lrd ON lgu.lanroomd_id = lrd.lanroomd_id';
$where2 = "users_id = '" . $where . "'";
$cs_lanpartys = cs_sql_select(__FILE__,$from,$select,$where2,$order,$start,$account['users_limit']);
$lanpartys_loop = count($cs_lanpartys);

$data['sort']['name'] = cs_sort('lanpartys','center',$start,$where,1,$sort);
$data['sort']['start'] = cs_sort('lanpartys','center',$start,$where,3,$sort);
$data['sort']['status'] = cs_sort('lanpartys','center',$start,$where,5,$sort);

if(empty($lanpartys_loop)) {
  $data['lanpartys'] = '';
}

for($run=0; $run<$lanpartys_loop; $run++) {
  $data['lanpartys'][$run]['name'] = cs_link(cs_secure($cs_lanpartys[$run]['lanpartys_name']),'lanpartys','view','id=' . $cs_lanpartys[$run]['lanpartys_id']);
  $data['lanpartys'][$run]['start'] = cs_date('unix',$cs_lanpartys[$run]['lanpartys_start']);

  if(empty($cs_lanpartys[$run]['lanroomd_id'])) {
    $data['lanpartys'][$run]['status'] = $cs_lang['status_' . $cs_lanpartys[$run]['languests_status']];
  }
  else {
    $data['lanpartys'][$run]['status'] = cs_link($cs_lang['chair'] . ' ' . $cs_lanpartys[$run]['lanroomd_number'],'lanrooms','view','lanroomd_id=' . $cs_lanpartys[$run]['lanroomd_id']);
  }
}

echo cs_subtemplate(__FILE__,$data,'lanpartys','users');
?>