<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanvotes');

$lanpartys_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];

if(!empty($_POST['lanpartys_id'])) {
  $lanpartys_id = $_POST['lanpartys_id'];
}

settype($lanpartys_id,'integer');
$where = empty($lanpartys_id) ? '' : "lvs.lanpartys_id = '" . $lanpartys_id . "' AND ";

$cs_sort[1] = 'lvs.lanvotes_question DESC';
$cs_sort[2] = 'lvs.lanvotes_question ASC';
$cs_sort[3] = 'lvs.lanvotes_start DESC';
$cs_sort[4] = 'lvs.lanvotes_start ASC';
$cs_sort[5] = 'lvs.lanvotes_end DESC';
$cs_sort[6] = 'lvs.lanvotes_end ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$lanvotes_count = cs_sql_count(__FILE__,'lanvotes');


$data['lang']['link'] = cs_link($cs_lang['results'],'lanvotes','list');
$data['url']['form'] = cs_url('lanvotes','center');
$lanpartys_data = cs_sql_select(__FILE__,'lanpartys','*',0,'lanpartys_name',0,0);
$lanpartys_data_loop = count($lanpartys_data);

if(empty($lanpartys_data_loop)) {
  $data['lanvotes'] = '';
}

for($run=0; $run<$lanpartys_data_loop; $run++) {
  $data['lanpartys'][$run]['id'] = $lanpartys_data[$run]['lanpartys_id'];
  $data['lanpartys'][$run]['name'] = $lanpartys_data[$run]['lanpartys_name'];
}

$select = 'lvs.lanvotes_question AS lanvotes_question, lvs.lanvotes_start AS lanvotes_start, lvs.lanvotes_end AS lanvotes_end, lvs.lanvotes_id AS lanvotes_id';
$from = 'lanvotes lvs INNER JOIN {pre}_languests lgu ON lvs.lanpartys_id = lgu.lanpartys_id';
$where .= 'lvs.lanvotes_end > ' . cs_time() . " AND lvs.lanvotes_status = lgu.languests_status AND lgu.users_id = '" . $account['users_id'] . "'";

$cs_lanvotes = cs_sql_select(__FILE__,$from,$select,$where,$order,0,$account['users_limit']);
$lanvotes_loop = count($cs_lanvotes);

$data['sort']['question'] = cs_sort('lanvotes','center',0,$lanpartys_id,1,$sort);
$data['sort']['start'] = cs_sort('lanvotes','center',0,$lanpartys_id,3,$sort);
$data['sort']['end'] = cs_sort('lanvotes','center',0,$lanpartys_id,5,$sort);

if(empty($lanvotes_loop)) {
  $data['lanvotes'] = '';
}

for($run=0; $run<$lanvotes_loop; $run++) {
  $question = cs_secure($cs_lanvotes[$run]['lanvotes_question']);
  $data['lanvotes'][$run]['question'] = cs_link($question,'lanvotes','elect','id=' . $cs_lanvotes[$run]['lanvotes_id']);
  $data['lanvotes'][$run]['start'] = cs_date('unix',$cs_lanvotes[$run]['lanvotes_start']);
  $data['lanvotes'][$run]['end'] = cs_date('unix',$cs_lanvotes[$run]['lanvotes_end']);
}

echo cs_subtemplate(__FILE__,$data,'lanvotes','center');
?>
