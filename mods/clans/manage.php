<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clans');

$op_clans = cs_sql_option(__FILE__,'clans');
$data = array();

$data['lang']['mod_name'] = $cs_lang[$op_clans['label']];
$data['count']['all'] = cs_sql_count(__FILE__,'clans');
$data['lang']['new_clan'] = $cs_lang['new_'.$op_clans['label']];
$select = 'clans_name, clans_short, clans_id';

if (!empty($_POST['search_name'])) {
  $data['pages']['list'] = '[1]';
  $data['sort']['name'] = '';
  $data['sort']['short'] = '';
  $data['head']['message'] = '';
  
  $clans_data = cs_sql_select(__FILE__, 'clans', $select, 'clans_name LIKE \'%' . cs_sql_escape($_POST['search_name']) . '%\'', 'clans_name',0,0);
  $data['search']['name'] = cs_sql_escape($_POST['search_name']);
  $count_clans = count($clans_data);
  $data['count']['search'] = $count_clans.'/';
}
else {
  $start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
  $cs_sort[1] = 'clans_name DESC';
  $cs_sort[2] = 'clans_name ASC';
  $cs_sort[3] = 'clans_short DESC';
  $cs_sort[4] = 'clans_short ASC';
  $sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
  $order = $cs_sort[$sort];
  $data['search']['sort'] = $sort;
  $data['search']['name'] = '';
  $data['head']['message'] = cs_getmsg();

  $data['sort']['name'] = cs_sort('clans','manage',$start,0,1,$sort);
  $data['sort']['short'] = cs_sort('clans','manage',$start,0,3,$sort);

  $data['pages']['list'] = cs_pages('clans','manage',$data['count']['all'],$start,0,$sort);
  $clans_data = cs_sql_select(__FILE__,'clans',$select,0,$order,$start,$account['users_limit']);
  $count_clans = count($clans_data);
  $data['count']['search'] = '';
}


if(empty($count_clans)) {
  $data['clans'] = '';
}

for($run = 0; $run < $count_clans; $run++) {
  $data['clans'][$run]['name'] =  cs_link(cs_secure($clans_data[$run]['clans_name']),'clans','view','id=' . $clans_data[$run]['clans_id']);
  $data['clans'][$run]['short'] = cs_secure($clans_data[$run]['clans_short']);
  
  $data['clans'][$run]['edit'] = cs_link(cs_icon('edit',16,$cs_lang['edit']),'clans','edit','id=' . $clans_data[$run]['clans_id'],0,$cs_lang['edit']);
  
  if($clans_data[$run]['clans_id'] == 1) {
    $data['clans'][$run]['remove'] = '-';
  }
  else {
    $data['clans'][$run]['remove'] = cs_link(cs_icon('editdelete',16,$cs_lang['remove']),'clans','delete','id=' . $clans_data[$run]['clans_id'],0,$cs_lang['remove']);
  }
}

$data['if']['done'] = false;

if($account['access_wizard'] == 5) {
  $wizard = cs_sql_count(__FILE__,'options',"options_name = 'done_clan' AND options_value = '1'");
  if(empty($wizard)) {
    $data['if']['done'] = true;
    $data['link']['wizard'] = cs_link($cs_lang['show'],'wizard','roots') . ' - ' . cs_link($cs_lang['task_done'],'wizard','roots','handler=clan&amp;done=1');
  }
}

echo cs_subtemplate(__FILE__,$data,'clans','manage');
