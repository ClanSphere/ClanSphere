<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('articles');

$categories_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
if(!empty($_POST['categories_id'])) {
  $categories_id = $_POST['categories_id'];
}
empty($categories_id) ? $where = 0 : $where = "categories_id = '" . cs_sql_escape($categories_id) . "'";
$cs_sort[1] = 'articles_headline DESC';
$cs_sort[2] = 'articles_headline ASC';
$cs_sort[3] = 'articles_time DESC';
$cs_sort[4] = 'articles_time ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$articles_count = cs_sql_count(__FILE__,'articles');

$data['head']['articles_count'] = $articles_count;
$data['head']['pages'] = cs_pages('articles','manage',$articles_count,$start,$categories_id,$sort);
$catmod = "categories_mod = 'articles'";
$cells = 'categories_name, categories_id';
$categories_data = cs_sql_select(__FILE__,'categories', $cells, $catmod,'categories_name',0,0);
$data['head']['dropdown'] = cs_dropdown('categories_id','categories_name',$categories_data,$categories_id);

$data['head']['message'] = cs_getmsg();

$cat_where = empty($categories_id) ? 0 : 'categories_id = "' . $categories_id . '"';
$cells = 'articles_headline, articles_id, articles_time, users_id';

$cs_articles = cs_sql_select(__FILE__,'articles', $cells,$cat_where,$order,$start,$account['users_limit']);
$articles_loop = count($cs_articles);

  $data['sort']['headline'] = cs_sort('articles','manage',$start,$categories_id,1,$sort);
  $data['sort']['date'] = cs_sort('articles','manage',$start,$categories_id,3,$sort);

for($run=0; $run<$articles_loop; $run++) {

    $id = $cs_articles[$run]['articles_id'];
  $cs_articles[$run]['articles_headline'] = cs_link($cs_articles[$run]['articles_headline'],'articles','view','id=' . $id);
  $cs_user = cs_sql_select(__FILE__,'users','users_nick, users_active, users_delete',"users_id = '" . $cs_articles[$run]['users_id'] . "'");
  $cs_articles[$run]['users_link'] = cs_user($cs_articles[$run]['users_id'],$cs_user['users_nick'],$cs_user['users_active'],$cs_user['users_delete']);
  $cs_articles[$run]['articles_date'] = cs_date('unix',$cs_articles[$run]['articles_time'],1);
  $cs_articles[$run]['url_edit'] = cs_url('articles','edit','id=' . $id);
  $cs_articles[$run]['url_remove'] = cs_url('articles','remove','id=' . $id);

}
$data['articles'] = $cs_articles;
echo cs_subtemplate(__FILE__,$data,'articles','manage');
