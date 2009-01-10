<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('languests');

$lanpartys_id = empty($_REQUEST['id']) ? 0 : $_REQUEST['id'];
$lanpartys_id = empty($_REQUEST['where']) ? $lanpartys_id : $_REQUEST['where'];
settype($lanpartys_id,'integer');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'users_nick DESC';
$cs_sort[2] = 'users_nick ASC';
$cs_sort[3] = 'languests_team DESC';
$cs_sort[4] = 'languests_team ASC';
$cs_sort[5] = 'languests_status DESC, users_nick ASC';
$cs_sort[6] = 'languests_status ASC, users_nick DESC';
$sort = empty($_REQUEST['sort']) ? 5 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$where = "lanpartys_id = '" . $lanpartys_id . "'";
$languests_count = cs_sql_count(__FILE__,'languests',$where);

$data['lang']['addons'] = cs_addons('lanpartys','view',$lanpartys_id,'languests');
$data['count']['all'] = $languests_count;
$data['pages']['list'] = cs_pages('languests','lanpartys',$languests_count,$start,$lanpartys_id,$sort);

$cs_lanpartys = cs_sql_select(__FILE__,'lanpartys','lanpartys_maxguests',$where);
$status = '';
$bar_count = array(1 => 0, 3 => 0, 4 => 0, 5 => 0);
$cs_languests = cs_sql_select(__FILE__,'languests','languests_status',$where,0,0,0);
$lgu_loop = count($cs_languests);

for($run=0; $run<$lgu_loop; $run++) {
  $status = $cs_languests[$run]['languests_status'];
  $bar_count[$status]++;
}

$lan['payed'] = $bar_count[3] + $bar_count[4];
$lan['signd'] = $bar_count[1] + $lan['payed'];
$lan['maxgt'] = empty($cs_lanpartys['lanpartys_maxguests']) ? 0 : $cs_lanpartys['lanpartys_maxguests'];

$data['lang']['body'] = sprintf($cs_lang['stats'],$lan['signd'],$lan['maxgt'],$lan['payed']);

$from = 'languests lgu INNER JOIN {pre}_users usr ON lgu.users_id = usr.users_id LEFT JOIN {pre}_lanroomd lrd ON lgu.lanroomd_id = lrd.lanroomd_id';
$select = 'lgu.languests_team AS languests_team, lgu.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, lgu.languests_status AS languests_status, lgu.languests_id AS languests_id, lrd.lanroomd_id AS lanroomd_id, lrd.lanroomd_number AS lanroomd_number';
$cs_languests = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$languests_loop = count($cs_languests);

$data['sort']['nick'] = cs_sort('languests','lanpartys',$start,$lanpartys_id,1,$sort);
$data['sort']['team'] = cs_sort('languests','lanpartys',$start,$lanpartys_id,3,$sort);
$data['sort']['status'] = cs_sort('languests','lanpartys',$start,$lanpartys_id,5,$sort);

if(empty($languests_loop)) {
  $data['lanquests'] = '';
}

for($run=0; $run<$languests_loop; $run++) {
  $cs_languests_user = cs_secure($cs_languests[$run]['users_nick']);
  $data['lanquests'][$run]['nick'] = cs_user($cs_languests[$run]['users_id'],$cs_languests[$run]['users_nick'], $cs_languests[$run]['users_active']);
  $data['lanquests'][$run]['team'] = cs_secure($cs_languests[$run]['languests_team']);
  
  if(empty($cs_languests[$run]['lanroomd_id'])) {
    $lgu_status = $cs_languests[$run]['languests_status'];
    $data['lanquests'][$run]['status'] = $cs_lang['status_' . $lgu_status];
  }
  else {
    $number = $cs_lang['chair'] . ' ' . $cs_languests[$run]['lanroomd_number'];
  	$data['lanquests'][$run]['status'] = cs_link($number,'lanrooms','view','lanroomd_id=' . $cs_languests[$run]['lanroomd_id']);
  }
}

echo cs_subtemplate(__FILE__,$data,'languests','lanpartys');

?>