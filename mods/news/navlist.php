<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('news');
$cs_get = cs_get('catid');
$cs_option = cs_sql_option(__FILE__,'news');
$data = array();

$tables = 'news ne INNER JOIN {pre}_categories cat ON ne.categories_id = cat.categories_id';
$select = 'ne.news_id AS news_id, ne.news_headline AS news_headline, ne.news_time AS news_time';
$public = 'ne.news_public > \'0\' AND cat.categories_access <= \'' . $account['access_news'] . '\'';
if(!empty($cs_get['catid'])) {
  $public .= ' AND cat.categories_id = ' . $cs_get['catid'];
}
$order = 'ne.news_time DESC';
$cs_news = cs_sql_select(__FILE__,$tables,$select,$public,$order,0,$cs_option['max_navlist']);

if(empty($cs_news)) {
  echo $cs_lang['no_data'];
}
else {
  if($cs_option['max_navlist'] == 1)
    $cs_news = array(0 => $cs_news);

  $run = 0;
  foreach ($cs_news AS $news) {    
    $data['news'][$run]['news_time'] = cs_date('unix',$news['news_time'],1,1,0);
    $short = strlen($news['news_headline']) <= $cs_option['max_headline'] ? $news['news_headline'] : cs_substr($news['news_headline'],0,$cs_option['max_headline']) . '...';
    $data['news'][$run]['news_url'] = cs_url('news','view','id=' . $news['news_id']);
    $data['news'][$run]['news_short'] = cs_secure($short);
    $data['news'][$run]['news_headline'] = cs_secure($news['news_headline']);
    $run++;
  }

  echo cs_subtemplate(__FILE__,$data,'news','navlist');
}