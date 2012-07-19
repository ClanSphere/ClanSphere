<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'files_name DESC, files_time DESC';
$cs_sort[2] = 'files_name ASC, files_time DESC';
$cs_sort[3] = 'categories_id DESC, files_name ASC';
$cs_sort[4] = 'categories_id ASC, files_name ASC';
$cs_sort[5] = 'files_time DESC, files_name ASC';
$cs_sort[6] = 'files_time ASC, files_name ASC';
$sort = empty($_REQUEST['sort']) ? 5 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$where1 = $data['search']['where'] .'&text='. $data['search']['text'] .'&submit=1';
$result_count = '';

$results = explode(',' ,$data['search']['text']);
$recount = count($results);

$sql_where = "(fil.files_name LIKE '%" . cs_sql_escape($results[0]) . "%' OR fil.files_description LIKE '%" . cs_sql_escape($results[0]) . "%'";
$sql_where .= ') AND fil.files_access <= '.$account['access_files'].' AND cat.categories_access <= '.$account['access_files'];
$select  = 'fil.files_id, fil.files_name, fil.files_time, fil.categories_id, cat.categories_name AS categories_name';
$select .= ', usr.users_nick AS users_nick, usr.users_id AS users_id, usr.users_active AS users_active, usr.users_delete AS users_delete';
$tables  = 'files fil INNER JOIN {pre}_categories cat ON cat.categories_id = fil.categories_id'; 
$tables  .= ' LEFT JOIN {pre}_users usr ON usr.users_id = fil.users_id';
$cs_search = cs_sql_select(__FILE__,$tables,$select,$sql_where,$order,$start,$account['users_limit']);
$search_loop = count($cs_search);

$data2 = array();
$data2['if']['result'] = false;
$data2['if']['access'] = false;
$data2['if']['noresults'] = false;

if (!empty($search_loop)) {
  $data2['if']['result'] = true;
  $data2['result']['count'] = $search_loop;
  $data2['result']['pages'] = cs_pages('search','list',$search_loop,$start,$where1,$sort);
  $data2['sort']['name'] = cs_sort('search','list',$start,$where1,1,$sort);
  $data2['sort']['cat'] = cs_sort('search','list',$start,$where1,3,$sort);
  $data2['sort']['time'] = cs_sort('search','list',$start,$where1,5,$sort);

  for($run=0; $run<$search_loop; $run++) {
      $cs_clans_name = cs_secure($cs_search[$run]['files_name']);
      $data2['results'][$run]['name'] = cs_link(cs_secure($cs_clans_name),'files','view','where=' . $cs_search[$run]['files_id']);
    $data2['results'][$run]['cat'] = cs_link($cs_search[$run]['categories_name'],'files','listcat','where=' . $cs_search[$run]['categories_id']);
      $data2['results'][$run]['date'] = cs_date('unix',$cs_search[$run]['files_time'],1);
      $data2['results'][$run]['user'] = cs_user($cs_search[$run]['users_id'],$cs_search[$run]['users_nick'],$cs_search[$run]['users_active'],$cs_search[$run]['users_delete']);
  }
} else {
$data2['if']['noresults'] = true;
}
echo cs_subtemplate(__FILE__,$data2,'search','mods_files');