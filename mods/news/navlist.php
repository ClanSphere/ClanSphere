<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('news');

$cs_option = cs_sql_option(__FILE__,'news');

$select = 'ne.news_id AS news_id, ne.news_headline AS news_headline, ne.news_time AS news_time';
$public = 'ne.news_public > \'0\' AND cat.categories_access <= \'' . $account['access_news'] . '\'';
$order = 'ne.news_time DESC';
$tables = 'news ne INNER JOIN {pre}_categories cat ON ne.categories_id = cat.categories_id';
$cs_news = cs_sql_select(__FILE__,$tables,$select,$public,'ne.news_time DESC',0,$cs_option['max_navlist']);

if($cs_option['max_navlist'] == '1') {
  $anews = array();
  array_push($anews,$cs_news);
  unset($cs_news);
  $cs_news = $anews;
}

if(empty($cs_news)) {
  echo $cs_lang['no_data'];
}
else {
  $data = array();
  $run = 0;
  foreach ($cs_news AS $news) {    
    $data['news'][$run]['news_time'] = cs_date('unix',$news['news_time'],1,1,0);
    $short = strlen($news['news_headline']) <= 15 ? $news['news_headline'] : substr($news['news_headline'],0,15) . '...';
    $data['news'][$run]['news_url'] = cs_url('news','view','id=' . $news['news_id']);
    $data['news'][$run]['news_short'] = cs_secure($short);
    $data['news'][$run]['news_headline'] = cs_secure($news['news_headline']);
    $run++;
  }

  echo cs_subtemplate(__FILE__,$data,'news','navlist');
}