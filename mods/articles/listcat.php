<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('articles');

$categories_id = empty($_GET['id']) ? $_REQUEST['where'] : $_GET['id'];
settype($categories_id,'integer');

empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start'];
$cs_sort[1] = 'articles_headline DESC';
$cs_sort[2] = 'articles_headline ASC';
$cs_sort[3] = 'articles_time DESC';
$cs_sort[4] = 'articles_time ASC';
empty($_REQUEST['sort']) ? $sort = 3 : $sort = $_REQUEST['sort'];
$order = $cs_sort[$sort];
$articles_count = cs_sql_count(__FILE__,'articles','categories_id =' .$categories_id);

$where = "categories_id= '" . $categories_id . "' AND categories_access <= '" . $account['access_categories'] . "'";
$category = cs_sql_select(__FILE__,'categories','categories_name',$where);

if (empty($category)) {
  echo $cs_lang['nocat_axx'];
} else {
  $data['head']['categories_name'] = cs_secure($category['categories_name']);
  $data['head']['articles_count'] = $articles_count;
  $data['head']['pages'] = cs_pages('articles','listcat',$articles_count,$start,$categories_id,$sort);
  
  $cs_articles = cs_sql_select(__FILE__,'articles','*',"categories_id = '" . $categories_id . "'",$order,$start,$account['users_limit']);
  $articles_loop = count($cs_articles);
  
  $data['sort']['headline'] = cs_sort('articles','listcat',$start,$categories_id,1,$sort);
  $data['sort']['date'] = cs_sort('articles','listcat',$start,$categories_id,3,$sort);
  
  for($run=0; $run<$articles_loop; $run++) {
  
    $cs_articles[$run]['articles_headline'] = cs_link($cs_articles[$run]['articles_headline'],'articles','view','id=' . $cs_articles[$run]['articles_id']);
    $cs_articles_user = cs_sql_select(__FILE__,'users','users_nick, users_active, users_delete',"users_id = '" . $cs_articles[$run]['users_id'] . "'");
    $cs_articles[$run]['articles_user'] = cs_user($cs_articles[$run]['users_id'],$cs_articles_user['users_nick'],$cs_articles_user['users_active'],$cs_articles_user['users_delete']);
    $cs_articles[$run]['articles_date'] = cs_date('unix',$cs_articles[$run]['articles_time'],1);
    $cs_articles[$run]['articles_views'] = cs_secure($cs_articles[$run]['articles_views']) . ' ' . $cs_lang['xtimes'];
    
  }
    
  $data['articles'] = $cs_articles;
  echo cs_subtemplate(__FILE__,$data,'articles','listcat');
}