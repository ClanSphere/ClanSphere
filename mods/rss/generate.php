<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_update_rss($mod, $action, $name, $desc, $array, $abcode = 0) {

  global $cs_main;
  $cs_main['rss'] = 1;
  $abcode = is_array($abcode) ? $abcode : array(0 => 1, 1 => 0, 2 => 0, 3 => 0, 4 => 0);
  $target = 'uploads/rss/';

  if(is_writeable($target)) {
    include_once('system/output/rss_20.php');
    $content = cs_rss_mode(1);
    $page = $cs_main['php_self']['website'];
    $content .= cs_rss_channel(1,$mod,$name,$page,$desc);
    if(!empty($array)) {
      foreach($array AS $item) {
        if(!empty($item['id']) AND !empty($item['title']) AND !empty($item['text'])) {
          $title = htmlspecialchars($item['title'], ENT_NOQUOTES, $cs_main['charset']);
        $save = $cs_main['php_self']['basename'];
        $cs_main['php_self']['basename'] = 'index.php';
        $link = $page . cs_url($mod,$action,'id=' . $item['id']);
        $cs_main['php_self']['basename'] = $save;
          
        if(!empty($item['readmore'])) {
          $text  = '<![CDATA[ ' . cs_secure($item['readmore'], $abcode[0], $abcode[1], $abcode[2], $abcode[3], $abcode[4]);
          $text .= cs_html_br(2) . cs_secure($item['text'], $abcode[0], $abcode[1], $abcode[2], $abcode[3], $abcode[4]) . ' ]]>';
        }
        else {
          $text = '<![CDATA[ ' . cs_secure($item['text'], $abcode[0], $abcode[1], $abcode[2], $abcode[3], $abcode[4]) . ' ]]>';
        }
    
        $date = empty($item['time']) ? 0 : date('D, d M Y H:i:s',$item['time']) . ' +0000';
        $author = empty($item['author']) ? 0 : $item['author'];
        $author .= empty($item['nick']) ? '' : ' (' . cs_secure($item['nick']) . ')';
        $category = empty($item['cat']) ? 0 : htmlspecialchars($item['cat'], ENT_NOQUOTES, $cs_main['charset']);
        $content .= cs_rss_item($title, $link, $text, $date, $author, $category);
      }
    }
  }
  $content .= cs_rss_channel(0);
  $content .= cs_rss_mode(0);

  $save_file = fopen($target . $mod . '.xml','w');
  # set stream encoding if possible to avoid converting issues
  if(function_exists('stream_encoding'))
    stream_encoding($save_file, $cs_main['charset']);
  fwrite($save_file,$content);
  fclose($save_file);
  @chmod($target . $mod . '.xml',0644);
  }
  else {
  cs_error($target,'cs_update_rss - Unable to write into directory');
  }
  $cs_main['rss'] = 0;
}