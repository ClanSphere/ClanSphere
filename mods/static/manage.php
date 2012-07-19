<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('static');

$access_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
settype($access_id,'integer');
$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'static_id DESC';
$cs_sort[2] = 'static_id ASC';
$cs_sort[3] = 'static_title DESC';
$cs_sort[4] = 'static_title ASC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$where = empty($access_id) ? 0 : "static_access >= '" . $access_id . "'";
$static_count = cs_sql_count(__FILE__,'static',$where);

$data['head']['total'] = $static_count;
$data['head']['pages'] = cs_pages('static','manage',$static_count,$start,$where,$sort);

$data['access'] = array();
for($levels = 0; $levels < 6; $levels++) {
  $sel = $access_id == $levels ? 'selected="selected"' : '';
  $data['access'][$levels]['level_id']    = $levels;
  $data['access'][$levels]['level_name']  = $cs_lang['lev_'.$levels];
  $data['access'][$levels]['selected']    = $sel;
}

$data['url']['new_staticpage'] = cs_url('static','create');
$data['url']['form'] = cs_url('static','manage');

$data['head']['message'] = cs_getmsg();

$data['sort']['id'] = cs_sort('static','manage',$start,$access_id,1,$sort);
$data['sort']['title'] = cs_sort('static','manage',$start,$access_id,3,$sort);

$select = 'static_id, static_title, static_access';
$cs_static = cs_sql_select(__FILE__,'static',$select,$where,$order,$start,$account['users_limit']);
$static_loop = count($cs_static);

for($run=0; $run<$static_loop; $run++) {

  $cs_static[$run]['static_id'] = $cs_static[$run]['static_id'];
  $cs_static[$run]['static_title'] = $cs_static[$run]['static_title'];
  $stat_access = $cs_static[$run]['static_access'];
  $cs_static[$run]['static_access'] = $stat_access . ' - ' . $cs_lang['lev_'.$stat_access];
  $cs_static[$run]['url_delete'] = cs_url('static','remove','id='.$cs_static[$run]['static_id']);
  $cs_static[$run]['url_edit'] = cs_url('static','edit','id='.$cs_static[$run]['static_id']);
  $cs_static[$run]['url_view'] = cs_url('static','view','id='.$cs_static[$run]['static_id']);
}

$data['static'] = $cs_static;
echo cs_subtemplate(__FILE__,$data,'static','manage');