<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanvotes');

$lanpartys_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];

if(!empty($_POST['lanpartys_id'])) {
	$lanpartys_id = $_POST['lanpartys_id'];
}

settype($lanpartys_id,'integer');
$where = empty($lanpartys_id) ? 0 : "lanpartys_id = '" . $lanpartys_id . "'";

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'lanvotes_question DESC';
$cs_sort[2] = 'lanvotes_question ASC';
$cs_sort[3] = 'lanvotes_start DESC';
$cs_sort[4] = 'lanvotes_start ASC';
$cs_sort[5] = 'lanvotes_end DESC';
$cs_sort[6] = 'lanvotes_end ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$lanvotes_count = cs_sql_count(__FILE__,'lanvotes');


$data['lang']['new'] = cs_link($cs_lang['new_lanvote'],'lanvotes','create');
$data['lang']['count'] = $lanvotes_count;
$data['pages']['list'] = cs_pages('lanvotes','manage',$lanvotes_count,$start,$lanpartys_id,$sort);
$data['url']['form'] = cs_url('lanvotes','manage');

$data['head']['message'] = cs_getmsg();

$lanpartys_data = cs_sql_select(__FILE__,'lanpartys','*',0,'lanpartys_name',0,0);
$lanpartys_data_loop = count($lanpartys_data);

if(empty($lanpartys_data_loop)) {
  $data['lanvotes'] = '';
}

for($run=0; $run<$lanpartys_data_loop; $run++) {
  $data['lanpartys'][$run]['id'] = $lanpartys_data[$run]['lanpartys_id'];
  $data['lanpartys'][$run]['name'] = $lanpartys_data[$run]['lanpartys_name'];
}

$select = 'lanvotes_question, lanvotes_start, lanvotes_end, lanvotes_id'; 
$cs_lanvotes = cs_sql_select(__FILE__,'lanvotes',$select,$where,$order,$start,$account['users_limit']);
$lanvotes_loop = count($cs_lanvotes);

$data['sort']['question'] = cs_sort('lanvotes','manage',$start,$lanpartys_id,1,$sort);
$data['sort']['start'] = cs_sort('lanvotes','manage',$start,$lanpartys_id,3,$sort);
$data['sort']['end'] = cs_sort('lanvotes','manage',$start,$lanpartys_id,5,$sort);

if(empty($lanvotes_loop)) {
  $data['lanvotes'] = '';
}

for($run=0; $run<$lanvotes_loop; $run++) {
  $question = cs_secure($cs_lanvotes[$run]['lanvotes_question']);
  $data['lanvotes'][$run]['question'] = cs_link($question,'lanvotes','view','id=' . $cs_lanvotes[$run]['lanvotes_id']);
  $data['lanvotes'][$run]['start'] = cs_date('unix',$cs_lanvotes[$run]['lanvotes_start']);
  $data['lanvotes'][$run]['end'] = cs_date('unix',$cs_lanvotes[$run]['lanvotes_end']);
  $data['lanvotes'][$run]['edit'] = cs_link(cs_icon('edit',16,$cs_lang['edit']),'lanvotes','edit','id=' . $cs_lanvotes[$run]['lanvotes_id'],0,$cs_lang['edit']);
  $data['lanvotes'][$run]['del'] = cs_link(cs_icon('editdelete',16,$cs_lang['remove']),'lanvotes','remove','id=' . $cs_lanvotes[$run]['lanvotes_id'],0,$cs_lang['remove']);
}

echo cs_subtemplate(__FILE__,$data,'lanvotes','manage');
?>
