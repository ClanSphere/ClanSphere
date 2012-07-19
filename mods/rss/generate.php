<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_update_rss($mod, $action, $name, $desc, $array, $abcode = 0) {

  global $cs_main;
  $cs_main['rss'] = 1;
  $abcode = is_array($abcode) ? $abcode : array(0 => 1, 1 => 0, 2 => 0, 3 => 0, 4 => 0);
  $target = 'uploads/rss/';

  $name_sec = htmlspecialchars($name, ENT_NOQUOTES, $cs_main['charset']);
  $desc_sec = htmlspecialchars($desc, ENT_NOQUOTES, $cs_main['charset']);
  
  if(is_writeable($target)) {
    include_once('system/output/rss_20.php');
    $content = cs_rss_mode(1);
    $content .= cs_rss_channel(1,$mod,$name_sec,$cs_main['php_self']['website'],$desc_sec);
    if(!empty($array)) {
      foreach($array AS $item) {
        if(!empty($item['id']) AND !empty($item['title']) AND !empty($item['text'])) {
          $title = htmlspecialchars($item['title'], ENT_NOQUOTES, $cs_main['charset']);
          $link = $cs_main['php_self']['website'] . cs_url($mod,$action,'id=' . $item['id'], 'index');

          $text = empty($item['readmore']) ? $item['text'] : $item['readmore'];
          $text = cs_secure($text, $abcode[0], $abcode[1], $abcode[2], $abcode[3], $abcode[4]);
          $text  = '<![CDATA[ ' . $text . ' ]]>';
          if(!empty($abcode[3])) {
            # use full uri if needed in html content
            $url_pre = $cs_main['php_self']['website'] . $cs_main['php_self']['dirname'];
            $pattern = "=(background|href|src)\=\"(?!http|\/)(.*?)\"=i";
            $text    = preg_replace($pattern, "\\1=\"" . $url_pre . "\\2\"", $text);
          }

          $date = empty($item['time']) ? 0 : date('D, d M Y H:i:s',$item['time']) . ' +0000';
          # author is presented as 'email (nick)'
          $author = (empty($item['nick']) OR empty($item['author'])) ? '' : 
            ($item['author'] . ' (' . cs_secure($item['nick']) . ')');
          $category = empty($item['cat']) ? '' : htmlspecialchars($item['cat'], ENT_NOQUOTES, $cs_main['charset']);
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
    @chmod($target . $mod . '.xml', 0755);
  }
  else {
    cs_error($target,'cs_update_rss - Unable to write into directory');
  }
  $cs_main['rss'] = 0;
}