<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$op_news = cs_sql_option(__FILE__,'news');

$from = 'news nws INNER JOIN {pre}_categories cat ON nws.categories_id = cat.categories_id';
$select = 'nws.news_headline AS title, nws.news_time AS time, nws.news_text AS text, '
        . 'nws.news_readmore AS readmore, cat.categories_name AS cat, nws.news_id AS id';
$where = 'nws.news_public = 1 AND cat.categories_access < 2';
$cs_news = cs_sql_select(__FILE__,$from,$select,$where,'news_time DESC',0,8);

$cs_option = cs_sql_option(__FILE__, 'news');
$abcode = explode(",", $cs_option['abcode']);

include_once('mods/rss/generate.php');

cs_update_rss('news','view',$op_news['rss_title'],$op_news['rss_description'],$cs_news, $abcode);