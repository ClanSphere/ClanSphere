<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('search');

empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start'];
$cs_sort[1] = 'files_name DESC';
$cs_sort[2] = 'files_name ASC';
$cs_sort[3] = 'categories_id DESC';
$cs_sort[4] = 'categories_id ASC';
$cs_sort[5] = 'files_time DESC';
$cs_sort[6] = 'files_time ASC';
empty($_REQUEST['sort']) ? $sort = 2 : $sort = $_REQUEST['sort'];
$order = $cs_sort[$sort];

$where1 = $data['search']['where'] .'&text='. $data['search']['text'] .'&submit=1';
$result_count = '';

$results = explode(',' ,$data['search']['text']);
$recount = count($results);

$sql_where = "files_name LIKE '%" . cs_sql_escape($results[0]) . "%' OR files_description LIKE '%" . cs_sql_escape($results[0]) . "%'";
for($prerun=1; $prerun<$recount; $prerun++) {
	$sql_where = $sql_where . " OR files_name LIKE '%" . cs_sql_escape($results[$prerun]) . "%' OR files_description LIKE '%" . cs_sql_escape($results[0]) . "%'";
}
$select = 'files_id, files_name, files_time, users_id, categories_id';
$cs_search = cs_sql_select(__FILE__,'files',$select,$sql_where,$order,$start,$account['users_limit']);
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
		$select = 'categories_id, categories_name';
		$where = "categories_id = '" . $cs_search[$run]['categories_id'] . "'";
		$files_cat = cs_sql_select(__FILE__,'categories',$select,$where,0,0,1);
		$data2['results'][$run]['cat'] = $files_cat['categories_name'];
		$data2['results'][$run]['date'] = cs_date('unix',$cs_search[$run]['files_time'],1);
		$select = 'users_id, users_nick';
		$where = "users_id = '" . $cs_search[$run]['users_id'] . "'";
		$files_user = cs_sql_select(__FILE__,'users',$select,$where,0,0,1);
		$data2['results'][$run]['user'] = $files_user['users_nick'];
	}
} else {
$data2['if']['noresults'] = true;
}
echo cs_subtemplate(__FILE__,$data2,'search','mods/files');
?>