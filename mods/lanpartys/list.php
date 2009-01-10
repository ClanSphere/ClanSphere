<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanpartys');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'lanpartys_name DESC';
$cs_sort[2] = 'lanpartys_name ASC';
$cs_sort[3] = 'lanpartys_start DESC';
$cs_sort[4] = 'lanpartys_start ASC';
$cs_sort[5] = 'lanpartys_postalcode DESC';
$cs_sort[6] = 'lanpartys_postalcode ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$lanpartys_count = cs_sql_count(__FILE__,'lanpartys');


$data['lang']['body'] = sprintf($cs_lang['count'], $lanpartys_count);

$data['pages']['list'] = cs_pages('lanpartys','list',$lanpartys_count,$start,0,$sort);

$select = 'lanpartys_name, lanpartys_start, lanpartys_postalcode, lanpartys_place, lanpartys_id';

$cs_lanpartys = cs_sql_select(__FILE__,'lanpartys',$select,0,$order,$start,$account['users_limit']);
$lanpartys_loop = count($cs_lanpartys);

$data['sort']['name'] = cs_sort('lanpartys','list',$start,0,1,$sort);
$data['sort']['start'] = cs_sort('lanpartys','list',$start,0,3,$sort);
$data['sort']['postal_place'] = cs_sort('lanpartys','list',$start,0,5,$sort);

if(empty($lanpartys_loop)) {
  $data['lanpartys'] = '';
}

for($run=0; $run<$lanpartys_loop; $run++) {
  $data['lanpartys'][$run]['name'] = cs_link(cs_secure($cs_lanpartys[$run]['lanpartys_name']),'lanpartys','view','id=' . $cs_lanpartys[$run]['lanpartys_id']);
  $data['lanpartys'][$run]['start'] = cs_date('unix',$cs_lanpartys[$run]['lanpartys_start'],1);

  if(!empty($cs_lanpartys[$run]['lanpartys_postalcode'])) {
    $data['lanpartys'][$run]['lanpartys_postalcode'] = $cs_lanpartys[$run]['lanpartys_postalcode'];
  }
	
  if(!empty($cs_lanpartys[$run]['lanpartys_place'])) {
    $data['lanpartys'][$run]['lanpartys_place'] = cs_secure($cs_lanpartys[$run]['lanpartys_place']);
  }
}

echo cs_subtemplate(__FILE__,$data,'lanpartys','list');
?>
