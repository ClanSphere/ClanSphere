<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'clans_name DESC';
$cs_sort[2] = 'clans_name ASC';
$cs_sort[3] = 'clans_short DESC';
$cs_sort[4] = 'clans_short ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$where1 = $data['search']['where'] .'&text='. $data['search']['text'] .'&submit=1';
$result_count = '';

$results = explode(',' ,$data['search']['text']);
$recount = count($results);

$sql_where = "clans_name LIKE '%" . cs_sql_escape(trim($results[0])) . "%'";
for($prerun=1; $prerun<$recount; $prerun++) {
  $sql_where = $sql_where . " OR clans_name LIKE '%" . cs_sql_escape(trim($results[$prerun])) . "%'"; 
}
$select = 'clans_country, clans_name, clans_id, clans_short';
$cs_search = cs_sql_select(__FILE__,'clans',$select,$sql_where,$order,$start,$account['users_limit']);
$search_loop = count($cs_search);

$data2 = array();
$data2['if']['result'] = false;
$data2['if']['access'] = false;
$data2['if']['noresults'] = false;

if (!empty($search_loop)) {
  $data2['if']['result'] = true;
  $data2['result']['count'] = $search_loop;
  $data2['result']['pages'] = cs_pages('search','list',$search_loop,$start,$where1,$sort);
  $data2['sort']['name'] = cs_sort('search','list',$start,$where1,3,$sort);
  $data2['sort']['short'] = cs_sort('search','list',$start,$where1,1,$sort);

  for($run=0; $run<$search_loop; $run++) {
    $data2['results'][$run]['country'] = cs_html_img('symbols/countries/' . $cs_search[$run]['clans_country'] . '.png',11,16);
      $cs_clans_name = cs_secure($cs_search[$run]['clans_name']);
      $data2['results'][$run]['clan'] = cs_link(cs_secure($cs_clans_name),'clans','view','id=' . $cs_search[$run]['clans_id']);
      $data2['results'][$run]['short'] = cs_secure($cs_search[$run]['clans_short']);
  }
} else {
$data2['if']['noresults'] = true;
}
echo cs_subtemplate(__FILE__,$data2,'search','mods_clans');