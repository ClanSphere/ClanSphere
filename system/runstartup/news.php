<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

// Publish News when time has come

global $cs_main;

if ($cs_main['mod'] == 'news') {
  
  $filename = 'uploads/cache/news_publish.tmp';
  
  if (!file_exists($filename)) {
    
    $where = 'news_public = "0" AND news_publishs_at != "0"';
    $next_publish = cs_sql_select(__FILE__, 'news', 'news_publishs_at', $where, 'news_publishs_at ASC');
    $next_publish = empty($next_publish) ? '0' : $next_publish['news_publishs_at'];
    
    $fp = fopen($filename, 'w');
    fwrite($fp, $next_publish);
    fclose($fp);
    
  } else {
    $next_publish = file_get_contents($filename);
  }
  
  if ($next_publish != 0 && cs_time() > $next_publish) {
    
    $cond = 'news_publishs_at != "0" AND news_public = "0" AND news_publishs_at < "' . cs_time() . '"';
    $publish = cs_sql_select(__FILE__,'news','news_id, news_publishs_at, news_public', $cond,0,0,0);
    
    if (!empty($publish)) {
      $count_publish = count($publish);
      for($run = 0; $run < $count_publish; $run++)
        cs_sql_update(__FILE__, 'news', array('news_public','news_time'), array('1',$publish[$run]['news_publishs_at']), $publish[$run]['news_id']);
    }
    
    cs_unlink('cache', 'news_publish.tmp');
    
  }
}

?>