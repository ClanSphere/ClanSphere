<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanrooms');

$lanpartys_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];

if(!empty($_POST['lanpartys_id'])) {
  $lanpartys_id = $_POST['lanpartys_id'];
}

settype($lanpartys_id,'integer');
$where = empty($lanpartys_id) ? 0 : "lanpartys_id = '" . $lanpartys_id . "'";

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'lanrooms_name DESC';
$cs_sort[2] = 'lanrooms_name ASC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$lanrooms_count = cs_sql_count(__FILE__,'lanrooms');

$data['lang']['new'] = cs_link($cs_lang['new_lanroom'],'lanrooms','create');
$data['lang']['all'] = $cs_lang['all'];
$data['lang']['count'] = $lanrooms_count;
$data['pages']['list'] = cs_pages('lanrooms','manage',$lanrooms_count,$start,$lanpartys_id,$sort);

$data['head']['message'] = cs_getmsg();

$data['url']['form'] = cs_url('lanrooms','manage');
$lanpartys_data = cs_sql_select(__FILE__,'lanpartys','*',0,'lanpartys_name',0,0);
$lan_data_loop = count($lanpartys_data);
if(empty($lan_data_loop)) {
  $data['lan'] = '';
}

for($run=0; $run<$lan_data_loop; $run++) {
  $data['lan'][$run]['id'] = $lanpartys_data[$run]['lanpartys_id'];
  $data['lan'][$run]['name'] = $lanpartys_data[$run]['lanpartys_name'];
}

$select = 'lanrooms_name, lanrooms_id'; 
$cs_lanrooms = cs_sql_select(__FILE__,'lanrooms',$select,$where,$order,$start,$account['users_limit']);
$lanrooms_loop = count($cs_lanrooms);

$data['sort']['name'] = cs_sort('lanrooms','manage',$start,$lanpartys_id,1,$sort);

if(empty($lanrooms_loop)) {
  $data['lanrooms'] = '';
}

for($run=0; $run<$lanrooms_loop; $run++) {
  $data['lanrooms'][$run]['name'] = cs_link(cs_secure($cs_lanrooms[$run]['lanrooms_name']),'lanrooms','view','id=' . $cs_lanrooms[$run]['lanrooms_id']);
  $data['lanrooms'][$run]['map'] = cs_link(cs_icon('kjumpingcube',16,$cs_lang['map']),'lanrooms','map','id=' . $cs_lanrooms[$run]['lanrooms_id']);
  $data['lanrooms'][$run]['edit'] = cs_link(cs_icon('edit',16,$cs_lang['edit']),'lanrooms','edit','id=' . $cs_lanrooms[$run]['lanrooms_id'],0,$cs_lang['edit']);
    $data['lanrooms'][$run]['del'] = cs_link(cs_icon('editdelete',16,$cs_lang['remove']),'lanrooms','remove','id=' . $cs_lanrooms[$run]['lanrooms_id'],0,$cs_lang['remove']);
}

echo cs_subtemplate(__FILE__,$data,'lanrooms','manage');
?>
