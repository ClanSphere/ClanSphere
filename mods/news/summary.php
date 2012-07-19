<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('news');

$where = "nws.news_public > 0 AND cat.categories_access <= '" . $account['access_news'] . "'";
$join = 'news nws INNER JOIN {pre}_categories cat ON nws.categories_id = cat.categories_id';
$newsmod = "categories_mod = 'news' AND categories_access <= '" . $account['access_news'] . "'";
$select = 'nws.news_headline AS news_headline, nws.news_time AS news_time, nws.news_id AS news_id';
$cs_news = cs_sql_select(__FILE__,$join,$select,$where,'news_time DESC',0,$account['users_limit']);

$day = -1;
$run = 0;
$lastday = 0;

if(empty($cs_news)) {
  $data['days'] = '';
}

foreach($cs_news AS $news) {
  $newsday = cs_date('unix',$news['news_time']);
  if($newsday != $lastday) {
    $day++;
    $run = 0;
    $lastday = $newsday;
    $dayname = cs_datereal('l',$news['news_time']);
    $data['days'][$day]['content'] = $cs_lang[$dayname] . ' - ' . cs_date('unix',$news['news_time']);
  }

  $data['days'][$day]['news'][$run]['news_time'] = cs_date('unix',$news['news_time'],1,0);
  $sec_head = cs_secure($news['news_headline']);
  $data['days'][$day]['news'][$run]['news_headline'] = cs_link($sec_head,'news','view','id=' . $news['news_id']);
  $run++;
}

echo cs_subtemplate(__FILE__,$data,'news','summary');