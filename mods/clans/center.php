<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clans');

$op_clans = cs_sql_option(__FILE__,'clans');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'clans_name DESC';
$cs_sort[2] = 'clans_name ASC';
$cs_sort[3] = 'clans_short DESC';
$cs_sort[4] = 'clans_short ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$data['lang']['getmsg'] = cs_getmsg();
$data['lang']['mod_name'] = $cs_lang[$op_clans['label']];

$own = "users_id = '" . $account['users_id'] . "'";
$clans_count = cs_sql_count(__FILE__,'clans',$own);

$data['lang']['mod_name'] = $cs_lang[$op_clans['label']];
$data['lang']['new'] = cs_link($cs_lang['new_'.$op_clans['label']],'clans','new');
$data['lang']['all'] = $cs_lang['total'] . ': ';
$data['lang']['count'] = $clans_count;
$data['pages']['list'] = cs_pages('clans','center',$clans_count,$start,0,$sort);

$select = 'clans_name, clans_short, clans_id';
$cs_clans = cs_sql_select(__FILE__,'clans',$select,$own,$order,$start,$account['users_limit']);
$clans_loop = count($cs_clans);

$data['sort']['name'] = cs_sort('clans','center',$start,0,1,$sort);
$data['sort']['short'] = cs_sort('clans','center',$start,0,3,$sort);

if(empty($clans_loop)) {
  $data['clans'] = '';
}

for($run=0; $run<$clans_loop; $run++) {
  $data['clans'][$run]['name'] = cs_link(cs_secure($cs_clans[$run]['clans_name']),'clans','view','id=' . $cs_clans[$run]['clans_id']);
  $data['clans'][$run]['short'] = cs_secure($cs_clans[$run]['clans_short']);
  $data['clans'][$run]['edit'] = cs_link(cs_icon('edit',16,$cs_lang['edit']),'clans','change','id=' . $cs_clans[$run]['clans_id'],0,$cs_lang['edit']);
  
  if($cs_clans[$run]['clans_id'] == 1) {
  $data['clans'][$run]['remove'] = '-';
  }
  else {
    $data['clans'][$run]['remove'] = cs_link(cs_icon('editdelete',16,$cs_lang['remove']),'clans','delete','id=' . $cs_clans[$run]['clans_id'],0,$cs_lang['remove']);
  }
}

echo cs_subtemplate(__FILE__,$data,'clans','center');
