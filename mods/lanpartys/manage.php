<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanpartys');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'lanpartys_name DESC';
$cs_sort[2] = 'lanpartys_name ASC';
$cs_sort[3] = 'lanpartys_start DESC';
$cs_sort[4] = 'lanpartys_start ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$lanpartys_count = cs_sql_count(__FILE__,'lanpartys');


$data['lang']['new'] = cs_link($cs_lang['new_lanparty'],'lanpartys','create');
$data['lang']['count'] = $lanpartys_count;
$data['pages']['list'] = cs_pages('lanpartys','manage',$lanpartys_count,$start,0,$sort);

$data['head']['message'] = cs_getmsg();

$select = 'lanpartys_name, lanpartys_start, lanpartys_id';

$cs_lanpartys = cs_sql_select(__FILE__,'lanpartys',$select,0,$order,$start,$account['users_limit']);
$lanpartys_loop = count($cs_lanpartys);

$data['sort']['name'] = cs_sort('lanpartys','manage',$start,0,1,$sort);
$data['sort']['start'] = cs_sort('lanpartys','manage',$start,0,3,$sort);

if(empty($lanpartys_loop)) {
  $data['lanpartys'] = '';
}

for($run=0; $run<$lanpartys_loop; $run++) {
  $data['lanpartys'][$run]['name'] = cs_link(cs_secure($cs_lanpartys[$run]['lanpartys_name']),'lanpartys','view','id=' . $cs_lanpartys[$run]['lanpartys_id']);
  $data['lanpartys'][$run]['start'] = cs_date('unix',$cs_lanpartys[$run]['lanpartys_start'],1);
  $data['lanpartys'][$run]['picture'] = cs_link(cs_icon('image',16,$cs_lang['picture']),'lanpartys','picture','id=' . $cs_lanpartys[$run]['lanpartys_id']);
  $data['lanpartys'][$run]['edit'] = cs_link(cs_icon('edit',16,$cs_lang['edit']),'lanpartys','edit','id=' . $cs_lanpartys[$run]['lanpartys_id'],0,$cs_lang['edit']);
  $data['lanpartys'][$run]['remove'] = cs_link(cs_icon('editdelete',16,$cs_lang['remove']),'lanpartys','remove','id=' . $cs_lanpartys[$run]['lanpartys_id'],0,$cs_lang['remove']);
}

echo cs_subtemplate(__FILE__,$data,'lanpartys','manage');
?>
