<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('banners');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'banners_name DESC';
$cs_sort[2] = 'banners_name ASC';
$cs_sort[3] = 'banners_order DESC';
$cs_sort[4] = 'banners_order ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$banners_count = cs_sql_count(__FILE__,'banners');

$data['count']['all'] = $banners_count;
$data['pages']['list'] = cs_pages('banners','manage',$banners_count,$start,0,$sort);

$data['lang']['getmsg'] = cs_getmsg();

$select = 'banners_id, banners_name, banners_order';
$cs_banners = cs_sql_select(__FILE__,'banners',$select,0,$order,$start,$account['users_limit']);
$banners_loop = count($cs_banners);

$data['sort']['name'] = cs_sort('banners','manage',$start,0,1,$sort);
$data['sort']['order'] = cs_sort('banners','manage',$start,0,3,$sort);

if(empty($banners_loop)) {
  $data['banners'] = '';
}

for($run=0; $run<$banners_loop; $run++) {
  $data['banners'][$run]['name'] = cs_secure($cs_banners[$run]['banners_name']);
  $data['banners'][$run]['order'] = cs_secure($cs_banners[$run]['banners_order']);
  $data['banners'][$run]['edit'] = cs_url('banners','edit','id=' . $cs_banners[$run]['banners_id']);
  $data['banners'][$run]['remove'] = cs_url('banners','remove','id=' . $cs_banners[$run]['banners_id']);
}

echo cs_subtemplate(__FILE__,$data,'banners','manage');