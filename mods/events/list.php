<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');
$data = array();

$categories_id = empty($_REQUEST['where']) ? 0 : (int) $_REQUEST['where'];
$where = empty($categories_id) ? 0 : "categories_id = '" . $categories_id . "'";
$where2 = empty($categories_id) ? 0 : 'evs.' . $where;

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'evs.events_time DESC';
$cs_sort[2] = 'evs.events_time ASC';
$cs_sort[3] = 'evs.events_name DESC';
$cs_sort[4] = 'evs.events_name ASC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$count_all = cs_sql_count(__FILE__,'events',$where);

$data['head']['count_all'] = $count_all;
$data['head']['pages'] = cs_pages('events','list',$count_all,$start,$categories_id,$sort);

$cond = "categories_mod = 'events' AND categories_access <= '" . $account['access_events'] . "'";
$categories_data = cs_sql_select(__FILE__,'categories','categories_name, categories_id',$cond,'categories_name',0,0);
$data['head']['dropdown'] = cs_dropdown('where','categories_name',$categories_data,$categories_id,'categories_id');

$data['sort']['name'] = cs_sort('events','list',$start,$categories_id,3,$sort);
$data['sort']['date'] = cs_sort('events','list',$start,$categories_id,1,$sort);

$cells = 'evs.events_name AS events_name, evs.events_time AS events_time, evs.events_venue AS events_venue, evs.events_id AS events_id, evs.categories_id AS categories_id, cat.categories_name AS categories_name, cat.categories_picture AS categories_picture, evs.events_cancel AS events_cancel';
$tables = 'events evs INNER JOIN {pre}_categories cat ON evs.categories_id = cat.categories_id';
$data['events'] = cs_sql_select(__FILE__,$tables,$cells,$where2,$order,$start,$account['users_limit']);
$events_count = count($data['events']);

for ($i = 0; $i < $events_count; $i++) {

  $data['events'][$i]['time'] = cs_date('unix',$data['events'][$i]['events_time'],1);
  $data['events'][$i]['canceled'] = empty($data['events'][$i]['events_cancel']) ? '' : cs_html_br(1) . $cs_lang['canceled'];

  if(empty($data['events'][$i]['categories_picture'])) {
    $data['events'][$i]['categories_picture'] = '&nbsp;';
  } else {
    $place = 'uploads/categories/' . $data['events'][$i]['categories_picture'];
    $size = getimagesize($cs_main['def_path'] . '/' . $place);
    $data['events'][$i]['categories_picture'] = cs_html_img($place,$size[1],$size[0]);
  }  
}

echo cs_subtemplate(__FILE__, $data, 'events');