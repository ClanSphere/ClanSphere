<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanpartys');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'lanpartys_name DESC';
$cs_sort[2] = 'lanpartys_name ASC';
$cs_sort[3] = 'lanpartys_start DESC';
$cs_sort[4] = 'lanpartys_start ASC';
$cs_sort[5] = 'languests_status DESC';
$cs_sort[6] = 'languests_status ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$data['lang']['getmsg'] = cs_getmsg();
$data['lang']['list'] = cs_link($cs_lang['list_lans'],'lanpartys','list');

$select = 'lpa.lanpartys_name AS lanpartys_name, lpa.lanpartys_id AS lanpartys_id, ';
$select .= 'lpa.lanpartys_start AS lanpartys_start, lgu.languests_status AS languests_status, ';
$select .= 'lgu.languests_id AS languests_id';
$from = 'languests lgu INNER JOIN {pre}_lanpartys lpa ON lgu.lanpartys_id = lpa.lanpartys_id';
$where = 'lanpartys_start > ' . cs_time() . ' AND users_id = ' . $account['users_id'];

$cs_lanpartys = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$lanpartys_loop = count($cs_lanpartys);

$data['sort']['name'] = cs_sort('lanpartys','center',$start,0,1,$sort);
$data['sort']['start'] = cs_sort('lanpartys','center',$start,0,3,$sort);
$data['sort']['status'] = cs_sort('lanpartys','center',$start,0,5,$sort);

if(empty($lanpartys_loop)) {
  $data['lanpartys'] = '';
}

for($run=0; $run<$lanpartys_loop; $run++) {
  $data['lanpartys'][$run]['name'] = cs_link(cs_secure($cs_lanpartys[$run]['lanpartys_name']),'lanpartys','view','id=' . $cs_lanpartys[$run]['lanpartys_id']);
  $data['lanpartys'][$run]['start'] = cs_date('unix',$cs_lanpartys[$run]['lanpartys_start']);
  $data['lanpartys'][$run]['status'] = $cs_lang['status_' . $cs_lanpartys[$run]['languests_status']];
  $data['lanpartys'][$run]['edit'] = cs_link(cs_icon('documentinfo',16,$cs_lang['status']),'lanpartys','status','id=' . $cs_lanpartys[$run]['languests_id'],0,$cs_lang['edit']);
  $data['lanpartys'][$run]['remove'] = cs_link(cs_icon('cancel',16,$cs_lang['signout']),'lanpartys','signout','id=' . $cs_lanpartys[$run]['languests_id'],0,$cs_lang['remove']);
}

echo cs_subtemplate(__FILE__,$data,'lanpartys','center');
?>
