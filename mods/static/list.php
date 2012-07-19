<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('static');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'static_title DESC';
$cs_sort[2] = 'static_title ASC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$where = "static_access <= '" . $account['access_static'] . "'";
$static_count = cs_sql_count(__FILE__,'static',$where);
  
  $data['head']['total'] = $static_count;
  $data['head']['pages'] = cs_pages('static','list',$static_count,$start,$where,$sort);

  $data['sort']['title'] = cs_sort('static','list',$start,$where,1,$sort);
  
  $select = 'static_id, static_title';
  $cs_static = cs_sql_select(__FILE__,'static',$select,$where,$order,$start,$account['users_limit']);
  $static_loop = count($cs_static);
  
  for($run=0; $run<$static_loop; $run++) {
  
  $cs_static[$run]['static_id'] = $cs_static[$run]['static_id'];
  $cs_static[$run]['static_title'] = $cs_static[$run]['static_title'];
  $cs_static[$run]['url_view'] = cs_url('static','view','id='.$cs_static[$run]['static_id']);
  }

  $data['static'] = $cs_static;
  echo cs_subtemplate(__FILE__,$data,'static','list');