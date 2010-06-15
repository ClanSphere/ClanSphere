<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('search');

empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start'];
$cs_sort[1] = 'news_time DESC';
$cs_sort[2] = 'news_time ASC';
$cs_sort[3] = 'news_headline DESC';
$cs_sort[4] = 'news_headline ASC';
empty($_REQUEST['sort']) ? $sort = 2 : $sort = $_REQUEST['sort'];
$order = $cs_sort[$sort];

$where1 = $data['search']['where'] .'&text='. $data['search']['text'] .'&submit=1';

$results = explode(',' ,$data['search']['text']);
$recount = count($results);

$sql_where = "news_headline LIKE '%" . cs_sql_escape($results[0]) . "%'";
for($prerun=1; $prerun<$recount; $prerun++) {
  $sql_where = $sql_where . " OR news_headline LIKE '%" . cs_sql_escape($results[$prerun]) . "%'"; 
}
$select = 'news_headline, news_time, news_id';
$cs_search = cs_sql_select(__FILE__,'news',$select,$sql_where,$order,$start,$account['users_limit']);
$search_loop = count($cs_search);

$data2 = array();
$data2['if']['result'] = false;
$data2['if']['access'] = false;
$data2['if']['noresults'] = false;

if (!empty($search_loop)) {
  $data2['if']['result'] = true;
  $data2['result']['count'] = $search_loop;
  $data2['result']['pages'] = cs_pages('search','list',$search_loop,$start,$where1,$sort);
  $data2['sort']['headline'] = cs_sort('search','list',$start,$where1,3,$sort);
  $data2['sort']['date'] = cs_sort('search','list',$start,$where1,1,$sort);

  for($run=0; $run<$search_loop; $run++) {
      $cs_news_headline = cs_secure($cs_search[$run]['news_headline']);
      $data2['results'][$run]['headline'] = cs_link($cs_news_headline,'news','view','id=' . $cs_search[$run]['news_id']);
    $data2['results'][$run]['date'] = cs_date('unix',$cs_search[$run]['news_time'],1);
  }
} else {
$data2['if']['noresults'] = true;
}
echo cs_subtemplate(__FILE__,$data2,'search','mods/news');