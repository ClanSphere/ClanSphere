<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('news');
$cs_post = cs_post('where,start,sort');
$cs_get = cs_get('where,start,sort');

require_once 'mods/categories/functions.php';

$categories_id = empty($cs_get['where']) ? 0 : $cs_get['where'];
if (!empty($cs_post['where']))  $categories_id = $cs_post['where'];
$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 3 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$where = empty($categories_id) ? 0 : "categories_id = '" . $categories_id . "'";

$cs_sort[1] = 'news_headline DESC';
$cs_sort[2] = 'news_headline ASC';
$cs_sort[3] = 'news_time DESC';
$cs_sort[4] = 'news_time ASC';
$cs_sort[5] = 'news_public DESC';
$cs_sort[6] = 'news_public ASC';
$order = $cs_sort[$sort];
$news_count = cs_sql_count(__FILE__,'news',$where);

$data = array();
$data['count']['news'] = $news_count;
$data['head']['pages'] = cs_pages('news','manage',$news_count,$start,$categories_id,$sort);

$data['head']['message'] = cs_getmsg();

$newsmod = "categories_mod = 'news' AND categories_access <= '" . $account['access_news'] . "'";
$cat_data = cs_sql_select(__FILE__,'categories','*',$newsmod,'categories_name',0,0);
$data['head']['dropdown'] = cs_categories_dropdown2('news', $categories_id,0,'where');

$from = 'news nws LEFT JOIN {pre}_users usr ON nws.users_id = usr.users_id';
$select = 'nws.news_headline AS news_headline, nws.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete, nws.news_time AS news_time, nws.news_public AS news_public, nws.news_id AS news_id';

$cs_news = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$news_loop = count($cs_news);

$data['sort']['news_headline'] = cs_sort('news','manage',$start,$categories_id,1,$sort);
$data['sort']['news_time'] = cs_sort('news','manage',$start,$categories_id,3,$sort);
$data['sort']['news_public'] = cs_sort('news','manage',$start,$categories_id,5,$sort);

for($run=0; $run<$news_loop; $run++) {

  $cs_news[$run]['news_headline'] = cs_secure($cs_news[$run]['news_headline']);
  $cs_news[$run]['url_news'] = cs_url('news','view','id=' . $cs_news[$run]['news_id']);
  $cs_news[$run]['news_time'] = cs_date('unix',$cs_news[$run]['news_time']);
  $public = empty($cs_news[$run]['news_public']) ? 'no' : 'yes';
  $cs_news[$run]['news_public'] = $cs_lang[$public];
  $cs_news[$run]['url_user'] = cs_user($cs_news[$run]['users_id'], $cs_news[$run]['users_nick'], $cs_news[$run]['users_active'], $cs_news[$run]['users_delete']);
  $cs_news[$run]['url_pictures'] = cs_url('news','picture','id=' . $cs_news[$run]['news_id']);
  $cs_news[$run]['url_edit'] = cs_url('news','edit','id='.$cs_news[$run]['news_id']);
  $cs_news[$run]['url_remove'] = cs_url('news','remove','id='.$cs_news[$run]['news_id']);
}
$data['news'] = $cs_news;
echo cs_subtemplate(__FILE__,$data,'news','manage');