<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('computers');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$where = empty($_REQUEST['where']) ? $_GET['id'] : $_REQUEST['where'];
settype($where,'integer');
$cs_sort[1] = 'computers_name DESC';
$cs_sort[2] = 'computers_name ASC';
$cs_sort[3] = 'computers_since ASC';
$cs_sort[4] = 'computers_since DESC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$cru = "users_id = '" . $where . "'";
$computers_count = cs_sql_count(__FILE__,'computers',$cru);

$data['users']['addons'] = cs_addons('users','view',$where,'computers');
$data['pages']['list'] = cs_pages('computers','users',$computers_count,$start,$where,$sort);
$data['sort']['name'] = cs_sort('computers','users',$start,$where,1,$sort);
$data['sort']['since'] = cs_sort('computers','users',$start,$where,3,$sort);

$select = 'computers_name, computers_since, computers_id';
$cs_computers = cs_sql_select(__FILE__,'computers',$select,$cru,$order,$start,$account['users_limit']);
$computers_loop = count($cs_computers);

if(empty($computers_loop)) {
  $data['computers'] = '';
}

for($run=0; $run<$computers_loop; $run++) {
  $cs_name = cs_secure($cs_computers[$run]['computers_name']);
  $data['computers'][$run]['name'] = cs_link($cs_name,'computers','view','id=' . $cs_computers[$run]['computers_id']);
  $data['computers'][$run]['since'] = cs_date('unix',$cs_computers[$run]['computers_since']);
}

echo cs_subtemplate(__FILE__,$data,'computers','users');