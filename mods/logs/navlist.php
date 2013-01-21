<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

if($account['access_clansphere'] >= 3 AND $account['access_logs'] >= 3) {

  global $cs_logs;

  $limit = 5;
  $run = 0;
  $temp_file = array();
  $handle = opendir($cs_logs['dir'] . '/errors');  
  while ($file = readdir ($handle)) {
    if ($file != "." && $file != ".." && strrchr($file,".") == ".log") {
      $temp_file[$run] = $file;
      $run++;
    }
  }
  closedir($handle);

  rsort($temp_file);
  $limit = $limit > $run ? $run : $limit;

  for ($i = 0; $i < $limit; $i++) {
    $content = file_get_contents($cs_logs['dir'] . '/errors/' . $temp_file[$i]);
    $content = explode('--------', $content);
    $count = count($content) - 1;
    echo cs_link($temp_file[$i], 'logs', 'view', 'art=1&amp;log=' . $i);
    echo ' [' . $count . ']' . cs_html_br(1);
  }
}

if(empty($run))
  echo '----';