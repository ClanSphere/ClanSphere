<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('access');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'access_name DESC';
$cs_sort[2] = 'access_name ASC';
$cs_sort[3] = 'access_access DESC';
$cs_sort[4] = 'access_access ASC';
$cs_sort[5] = 'access_clansphere DESC';
$cs_sort[6] = 'access_clansphere ASC';
$sort = empty($_REQUEST['sort']) ? 5 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$access_count = cs_sql_count(__FILE__,'access');

$data['lang']['create'] = cs_url('access','create');
$data['lang']['count'] = $access_count;
$data['pages']['list'] = cs_pages('access','manage',$access_count,$start,0,$sort);

$select = 'access_id, access_name, access_access, access_clansphere';
$cs_access = cs_sql_select(__FILE__,'access',$select,0,$order,$start,$account['users_limit']);
$access_loop = count($cs_access);

$data['lang']['getmsg'] = cs_getmsg();
$data['sort']['name'] = cs_sort('access','manage',$start,0,1,$sort);
$data['sort']['access'] = cs_sort('access','manage',$start,0,3,$sort);
$data['sort']['clansphere'] = cs_sort('access','manage',$start,0,5,$sort);

$img_edit = cs_icon('edit',16,$cs_lang['edit']);
$img_del = cs_icon('editdelete',16,$cs_lang['remove']);
$img_users = cs_icon('kdmconfig',16,$cs_lang['remove']);

if(empty($access_loop)) {
  $data['access'] = '';
}

for($run=0; $run<$access_loop; $run++) {
  $data['access'][$run]['name'] = cs_secure($cs_access[$run]['access_name']);
  $data['access'][$run]['access'] = $cs_access[$run]['access_access'] . ' - ' . $cs_lang['lev_' . $cs_access[$run]['access_access']];
  $data['access'][$run]['clansphere'] = $cs_access[$run]['access_clansphere'] . ' - ' . $cs_lang['clansphere_' . $cs_access[$run]['access_clansphere']];
  $data['access'][$run]['edit'] = cs_link($img_edit,'access','edit','id=' . $cs_access[$run]['access_id'],0,$cs_lang['edit']);
  $data['access'][$run]['users'] = cs_link($img_users,'access','users','id=' . $cs_access[$run]['access_id'],0,$cs_lang['user_list']);

  if($cs_access[$run]['access_id'] < 6) {
    $data['access'][$run]['remove'] = '-';
  }
  else {
    $data['access'][$run]['remove'] = cs_link($img_del,'access','remove','id=' . $cs_access[$run]['access_id'],0,$cs_lang['remove']);
  }
}

echo cs_subtemplate(__FILE__,$data,'access','manage');