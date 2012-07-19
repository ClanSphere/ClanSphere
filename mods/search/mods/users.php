<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'users_nick DESC';
$cs_sort[2] = 'users_nick ASC';
$cs_sort[3] = 'users_laston DESC';
$cs_sort[4] = 'users_laston ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$where1 = $data['search']['where'] .'&text='. $data['search']['text'] .'&submit=1';

$results = explode(',' ,$data['search']['text']);
$recount = count($results);

$sql_where = "(users_nick LIKE '%" . cs_sql_escape(trim($results[0])) . "%'";
for($prerun=1; $prerun<$recount; $prerun++) {
  $sql_where = $sql_where . " OR users_nick LIKE '%" . cs_sql_escape(trim($results[$prerun])) . "%'"; 
}
$sql_where .= ') AND users_delete = 0';
$sql_select = 'users_country, users_nick, users_id, users_laston, users_active';
$cs_search = cs_sql_select(__FILE__,'users',$sql_select,$sql_where,$order,$start,$account['users_limit']);
$cs_loop = count($cs_search);

$data2 = array();
$data2['if']['result'] = false;
$data2['if']['access'] = false;
$data2['if']['noresults'] = false;

if (!empty($cs_loop)) {
  $data2['if']['result'] = true;
  $data2['result']['count'] = $cs_loop;
  $data2['result']['pages'] = cs_pages('search','list',$cs_loop,$start,$where1,$sort);
  $data2['sort']['nick'] = cs_sort('search','list',$start,$where1,1,$sort);
  $data2['sort']['laston'] = cs_sort('search','list',$start,$where1,3,$sort);

  if ($account['access_id'] >= 2) {
    $data2['if']['access'] = true;
  }
  for($run=0; $run<$cs_loop; $run++) {
      $url = 'symbols/countries/' . $cs_search[$run]['users_country'] . '.png';
      $data2['results'][$run]['img'] = cs_html_img($url,11,16);
      $cs_users_nick = cs_secure($cs_search[$run]['users_nick']);
      $data2['results'][$run]['user'] = cs_user($cs_search[$run]['users_id'],$cs_search[$run]['users_nick'], $cs_search[$run]['users_active']);
      $data2['results'][$run]['date'] = cs_date('unix',$cs_search[$run]['users_laston'],1);
      $on_now = cs_time() - 300; 
      $on_week = cs_time() - 604800;
      $on_now <= $cs_search[$run]['users_laston'] ? $icon = 'green' : $icon = 'red';
      if($on_week>=$cs_search[$run]['users_laston']) {
        $icon = 'grey';
      }
      $data2['results'][$run]['icon'] = cs_html_img('symbols/clansphere/' . $icon . '.gif'); 
    if ($account['access_id'] >= 2) {
      $icon_kon = cs_icon('mail_send');
      $data2['results'][$run]['msg'] = cs_link($icon_kon,'messages','create','to_id=' . $cs_search[$run]['users_id']);
    }
  }
} else {
  $data2['if']['noresults'] = true;
}
echo cs_subtemplate(__FILE__,$data2,'search','mods_users');