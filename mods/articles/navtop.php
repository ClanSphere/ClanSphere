<?php
// ClanSphere 2009 - www.clansphere.net
// $Id: $

$cs_lang = cs_translate('articles');
$cs_option = cs_sql_option(__FILE__,'articles');
$data = array();

//cut headline after...
$figures = 15;

$select = 'ar.articles_id AS articles_id, ar.articles_headline AS articles_headline, ar.articles_views AS articles_views';
$check = 'ar.articles_navlist > \'0\' AND cat.categories_access <= \'' . $account['access_articles'] . '\'';
$order = 'ar.articles_views DESC';
$tables = 'articles ar INNER JOIN {pre}_categories cat ON ar.categories_id = cat.categories_id';
$cs_articles = cs_sql_select(__FILE__,$tables,$select,$check,'ar.articles_views DESC',0,$cs_option['max_navlist']);

if(empty($cs_articles)) {
  echo $cs_lang['no_data'];
}
else {
  $run = 0;
  foreach ($cs_articles AS $articles) {
    $data['articles'][$run]['articles_views'] = $articles['articles_views'];
    $short = strlen($articles['articles_headline']) <= $figures ? $articles['articles_headline'] : substr($articles['articles_headline'],0,$figures) . '...';
    $data['articles'][$run]['articles_url'] = cs_url('articles','view','id=' . $articles['articles_id']);
    $data['articles'][$run]['articles_short'] = cs_secure($short);
    $data['articles'][$run]['articles_headline'] = cs_secure($articles['articles_headline']);
    $run++;
  }
  echo cs_subtemplate(__FILE__,$data,'articles','navtop');
}