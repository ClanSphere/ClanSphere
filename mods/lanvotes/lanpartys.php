<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanvotes');

$lanpartys_id = empty($_REQUEST['id']) ? 0 : $_REQUEST['id'];
$lanpartys_id = empty($_REQUEST['where']) ? $lanpartys_id : $_REQUEST['where'];

settype($lanpartys_id,'integer');
$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$where = empty($lanpartys_id) ? 0 : "lanpartys_id = '" . $lanpartys_id . "'";
$cs_sort[1] = 'lanvotes_question DESC';
$cs_sort[2] = 'lanvotes_question ASC';
$cs_sort[3] = 'lanvotes_start DESC';
$cs_sort[4] = 'lanvotes_start ASC';
$cs_sort[5] = 'lanvotes_end DESC';
$cs_sort[6] = 'lanvotes_end ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];

$order = $cs_sort[$sort];
$lanvotes_count = cs_sql_count(__FILE__,'lanvotes');

$data['lang']['addons'] = cs_addons('lanpartys','view',$lanpartys_id,'lanvotes');;
$data['output']['count'] = $lanvotes_count;
$data['pages']['list'] = cs_pages('lanvotes','lanpartys',$lanvotes_count,$start,$lanpartys_id,$sort);

$select = 'lanvotes_question, lanvotes_start, lanvotes_end, lanvotes_id'; 
$cs_lanvotes = cs_sql_select(__FILE__,'lanvotes',$select,$where,$order,$start,$account['users_limit']);
$lanvotes_loop = count($cs_lanvotes);

$data['sort']['question'] = cs_sort('lanvotes','lanpartys',$start,$lanpartys_id,1,$sort);
$data['sort']['start'] = cs_sort('lanvotes','lanpartys',$start,$lanpartys_id,3,$sort);
$data['sort']['end'] = cs_sort('lanvotes','lanpartys',$start,$lanpartys_id,5,$sort);

if(empty($lanvotes_loop)) {
  $data['lanvotes'] = '';
}

for($run=0; $run<$lanvotes_loop; $run++) {
  $question = cs_secure($cs_lanvotes[$run]['lanvotes_question']);
  $data['lanvotes'][$run]['question'] = cs_link($question,'lanvotes','view','id=' . $cs_lanvotes[$run]['lanvotes_id']);
  $data['lanvotes'][$run]['start'] = cs_date('unix',$cs_lanvotes[$run]['lanvotes_start']);
  $data['lanvotes'][$run]['end'] = cs_date('unix',$cs_lanvotes[$run]['lanvotes_end']);
}

echo cs_subtemplate(__FILE__,$data,'lanvotes','lanpartys');
?>
