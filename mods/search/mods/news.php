<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'news_time DESC';
$cs_sort[2] = 'news_time ASC';
$cs_sort[3] = 'news_headline DESC';
$cs_sort[4] = 'news_headline ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$where1 = $data['search']['where'] .'&text='. $data['search']['text'] .'&submit=1';

$results = explode(',' ,$data['search']['text']);
$recount = count($results);

$sql_where = "(nws.news_headline LIKE '%" . cs_sql_escape(trim($results[0])) . "%'";
for($prerun=1; $prerun<$recount; $prerun++) {
  $sql_where = $sql_where . " OR nws.news_headline LIKE '%" . cs_sql_escape(trim($results[$prerun])) . "%'"; 
}
$sql_where .= ') AND nws.news_public = 1 AND cat.categories_access <= '.$account['access_news'];
$select = 'nws.news_headline, nws.news_time, nws.news_id';
$tables = 'news nws INNER JOIN {pre}_categories cat ON nws.categories_id = cat.categories_id';
$cs_count  = cs_sql_count(__FILE__, $tables, $sql_where);
$cs_search = cs_sql_select(__FILE__,$tables,$select,$sql_where,$order,$start,$account['users_limit']);
$search_loop = count($cs_search);

$data2 = array();
$data2['if']['result'] = false;
$data2['if']['access'] = false;
$data2['if']['noresults'] = false;

if (!empty($search_loop)) {
  $data2['if']['result'] = true;
  $data2['result']['count'] = $cs_count;
  $data2['result']['pages'] = cs_pages('search','list',$cs_count,$start,$where1,$sort);
  $data2['sort']['headline'] = cs_sort('search','list',$start,$where1,3,$sort);
  $data2['sort']['date'] = cs_sort('search','list',$start,$where1,1,$sort);

  for($run=0; $run<$search_loop; $run++) {
      $cs_news_headline = cs_secure($cs_search[$run]['news_headline']);
      $data2['results'][$run]['headline'] = cs_link($cs_news_headline,'news','view','id=' . $cs_search[$run]['news_id']);
    $data2['results'][$run]['date'] = cs_date('unix',$cs_search[$run]['news_time'],1);
  }
}
else
  $data2['if']['noresults'] = true;

echo cs_subtemplate(__FILE__,$data2,'search','mods_news');