<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

// Publish News when time has come

global $cs_main, $account;

if ($cs_main['mod'] == 'news' AND !empty($account['access_news'])) {

  $next_publish = cs_cache_load('news_publish');

  if($next_publish === false) {

    $where = 'news_public = 0 AND news_publishs_at != 0';
    $next_publish = cs_sql_select(__FILE__, 'news', 'news_publishs_at', $where, 'news_publishs_at ASC');
    $next_publish = empty($next_publish) ? '0' : $next_publish['news_publishs_at'];
    cs_cache_save('news_publish', $next_publish);
  }

  if ($next_publish != 0 AND cs_time() > $next_publish) {

    $cond = 'news_publishs_at != 0 AND news_public = 0 AND news_publishs_at < ' . cs_time();
    $publish = cs_sql_select(__FILE__, 'news', 'news_id, news_publishs_at, news_public', $cond, 0, 0, 0);

    if (!empty($publish)) {
      $count_publish = count($publish);
      for($run = 0; $run < $count_publish; $run++)
        cs_sql_update(__FILE__, 'news', array('news_public','news_time'), array('1',$publish[$run]['news_publishs_at']), $publish[$run]['news_id']);
    }

    cs_cache_delete('news_publish');

    if (!empty($publish))
      include_once 'mods/news/rss.php';
  }
}