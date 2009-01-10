<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('languests');

$lanpartys_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
settype($lanpartys_id,'integer');
$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$where = empty($lanpartys_id) ? 0 : "lanpartys_id = '" . $lanpartys_id . "'";
$cs_sort[1] = 'users_nick DESC';
$cs_sort[2] = 'users_nick ASC';
$cs_sort[3] = 'languests_since DESC';
$cs_sort[4] = 'languests_since ASC';
$cs_sort[5] = 'languests_status DESC';
$cs_sort[6] = 'languests_status ASC';
empty($_REQUEST['sort']) ? $sort = 3 : $sort = $_REQUEST['sort'];
$order = $cs_sort[$sort];
$languests_count = cs_sql_count(__FILE__,'languests');

$data['lang']['new'] = cs_link($cs_lang['new_languest'],'languests','create');
$data['count']['all'] = $languests_count;
$data['pages']['list'] = cs_pages('languests','manage',$languests_count,$start,$lanpartys_id,$sort);

$data['head']['message'] = cs_getmsg();

$data['url']['form'] = cs_url('languests','manage');
$lanpartys_data = cs_sql_select(__FILE__,'lanpartys','*',0,'lanpartys_name',0,0);
$lanpartys_data_loop = count($lanpartys_data);

if(empty($lanpartys_data_loop)) {
  $data['lanpartys'] = '';
}

for($run=0; $run<$lanpartys_data_loop; $run++) {
  $data['lanpartys'][$run]['id'] = $lanpartys_data[$run]['lanpartys_id'];
  $data['lanpartys'][$run]['name'] = $lanpartys_data[$run]['lanpartys_name'];
}

$data['lang']['notices'] = cs_link($cs_lang['notices'],'languests','notices');

$from = 'languests lgu LEFT JOIN {pre}_users usr ON lgu.users_id = usr.users_id LEFT JOIN {pre}_lanroomd lrd ON lgu.lanroomd_id = lrd.lanroomd_id';
$select = 'lgu.languests_since AS languests_since, lgu.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, lgu.languests_status AS languests_status, lgu.languests_id AS languests_id, lrd.lanroomd_id AS lanroomd_id, lrd.lanroomd_number AS lanroomd_number';
$cs_languests = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$languests_loop = count($cs_languests);

$data['sort']['user'] = cs_sort('languests','manage',$start,$lanpartys_id,1,$sort);
$data['sort']['since'] = cs_sort('languests','manage',$start,$lanpartys_id,3,$sort);
$data['sort']['status'] = cs_sort('languests','manage',$start,$lanpartys_id,5,$sort);

if(empty($languests_loop)) {
  $data['languests'] = '';
}

for($run=0; $run<$languests_loop; $run++) {
  $data['languests'][$run]['user'] = cs_user($cs_languests[$run]['users_id'],$cs_languests[$run]['users_nick'], $cs_languests[$run]['users_active']);
  $data['languests'][$run]['since'] = cs_date('unix',$cs_languests[$run]['languests_since']);

  if(empty($cs_languests[$run]['lanroomd_id'])) {
    $data['languests'][$run]['status'] = $cs_lang['status_' . $cs_languests[$run]['languests_status']];
  }
  else {
    $data['languests'][$run]['status'] = cs_link($cs_lang['chair'] . ' ' . $cs_languests[$run]['lanroomd_number'],'lanrooms','view','lanroomd_id=' . $cs_languests[$run]['lanroomd_id']);
  }
	
  $data['languests'][$run]['map'] = cs_link(cs_icon('kjumpingcube',16,$cs_lang['map']),'languests','rooms','languests_id=' . $cs_languests[$run]['languests_id']);

  $data['languests'][$run]['edit'] = cs_link(cs_icon('edit',16,$cs_lang['edit']),'languests','edit','id=' . $cs_languests[$run]['languests_id'],0,$cs_lang['edit']);
  $data['languests'][$run]['remove'] = cs_link(cs_icon('editdelete',16,$cs_lang['remove']),'languests','remove','id=' . $cs_languests[$run]['languests_id'],0,$cs_lang['remove']);
}

echo cs_subtemplate(__FILE__,$data,'languests','manage');
?>
