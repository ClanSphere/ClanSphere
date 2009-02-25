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
$cs_sort[3] = 'languests_notice DESC';
$cs_sort[4] = 'languests_notice ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$languests_count = cs_sql_count(__FILE__,'languests');


$data['lang']['new'] = cs_link($cs_lang['new_languest'],'languests','create');
$data['count']['all'] = $languests_count;
$data['pages']['list'] = cs_pages('languests','notices',$languests_count,$start,$lanpartys_id,$sort);
$data['url']['form'] = cs_url('languests','notices');

$lanpartys_data = cs_sql_select(__FILE__,'lanpartys','*',0,'lanpartys_name',0,0);
$lanpartys_data_loop = count($lanpartys_data);

if(empty($lanpartys_data_loop)) {
  $data['lanpartys'] = '';
}

for($run=0; $run<$lanpartys_data_loop; $run++) {
  $data['lanpartys'][$run]['id'] = $lanpartys_data[$run]['lanpartys_id'];
  $data['lanpartys'][$run]['name'] = $lanpartys_data[$run]['lanpartys_name'];
}

$data['lang']['manage'] = cs_link($cs_lang['manage'],'languests','manage');
$data['sort']['user'] = cs_sort('languests','notices',$start,$lanpartys_id,1,$sort);
$data['sort']['notices'] = cs_sort('languests','notices',$start,$lanpartys_id,3,$sort);

$from = 'languests lgu INNER JOIN {pre}_users usr ON lgu.users_id = usr.users_id';
$select = 'lgu.languests_notice AS languests_notice, lgu.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete, lgu.languests_id AS languests_id';
$cs_languests = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$languests_loop = count($cs_languests);

if(empty($languests_loop)) {
  $data['languests'] = '';
}

for($run=0; $run<$languests_loop; $run++) {
  $data['languests'][$run]['user'] = cs_user($cs_languests[$run]['users_id'],$cs_languests[$run]['users_nick'], $cs_languests[$run]['users_active'], $cs_languests[$run]['users_delete']);

    $data['languests'][$run]['notices'] = cs_secure($cs_languests[$run]['languests_notice']);

  $data['languests'][$run]['map'] = cs_link(cs_icon('kjumpingcube',16,$cs_lang['map']),'languests','rooms','languests_id=' . $cs_languests[$run]['languests_id']);
  $data['languests'][$run]['edit'] = cs_link(cs_icon('edit',16,$cs_lang['edit']),'languests','edit','id=' . $cs_languests[$run]['languests_id'],0,$cs_lang['edit']);
  $data['languests'][$run]['remove'] = cs_link(cs_icon('editdelete',16,$cs_lang['remove']),'languests','remove','id=' . $cs_languests[$run]['languests_id'],0,$cs_lang['remove']);
}

echo cs_subtemplate(__FILE__,$data,'languests','notices');
?>
