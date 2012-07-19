<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('articles');
$cs_get = cs_get('catid');
$cs_option = cs_sql_option(__FILE__,'articles');
$data = array();

//cut headline after...
$figures = 15;

$select = 'ar.articles_id AS articles_id, ar.articles_headline AS articles_headline, ar.articles_time AS articles_time';
$check = 'ar.articles_navlist > \'0\' AND cat.categories_access <= \'' . $account['access_articles'] . '\'';
if(!empty($cs_get['catid'])) {
  $check .= ' AND cat.categories_id = ' . $cs_get['catid'];
}
$order = 'ar.articles_time DESC';
$tables = 'articles ar INNER JOIN {pre}_categories cat ON ar.categories_id = cat.categories_id';
$cs_articles = cs_sql_select(__FILE__,$tables,$select,$check,'ar.articles_time DESC',0,$cs_option['max_navlist']);

if(empty($cs_articles)) {
  echo $cs_lang['no_data'];
}
else {
  if($cs_option['max_navlist'] == 1)
    $cs_articles = array(0 => $cs_articles);

  $run = 0;
  foreach ($cs_articles AS $articles) {
    $data['articles'][$run]['articles_time'] = cs_date('unix',$articles['articles_time'],1,1,0);
    $short = strlen($articles['articles_headline']) <= $figures ? $articles['articles_headline'] : cs_substr($articles['articles_headline'],0,$figures) . '...';
    $data['articles'][$run]['articles_url'] = cs_url('articles','view','id=' . $articles['articles_id']);
    $data['articles'][$run]['articles_short'] = cs_secure($short);
    $data['articles'][$run]['articles_headline'] = cs_secure($articles['articles_headline']);
    $run++;
  }
  echo cs_subtemplate(__FILE__,$data,'articles','navlist');
}