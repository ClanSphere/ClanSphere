<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_rss_mode($func) {

  if(!empty($func)) {
    global $cs_main;
    $var = "<?xml version=\"1.0\" encoding=\"" . $cs_main['charset'] . "\" ?>\n";
    $var .= "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
    return $var;
  }
  else {
    return '</rss>';
  }
}

function cs_rss_channel($func,$mod='',$title = 0,$link = 0,$desc = 0) {

  if(!empty($func)) {
        global $cs_main;
        $rss_file = $cs_main['php_self']['website'] . $cs_main['php_self']['dirname'] . 'uploads/rss/' . $mod . '.xml';
        $var = "<channel> \n";
    $var .= "<generator>ClanSphere</generator>\n";
        $var .= "<atom:link href=\"" . $rss_file . "\" rel=\"self\" type=\"application/rss+xml\" />\n";
    $var .= "<title>" . $title . "</title>\n";
    $var .= "<link>" . $link . "</link>\n";
    $var .= "<description>" . $desc . "</description>\n";
    return $var;
  }
  else {
    return "</channel>\n";
  }
}

function cs_rss_item($title, $link, $desc, $date = 0, $author = '', $category = '') {

  $var = "<item>\n";
  if(!empty($date)) {
    $var .= "<pubDate>" . $date . "</pubDate>\n";
  }
  if(!empty($author)) {
    $var .= "<author>" . $author . "</author>\n";
  }
  if(!empty($category)) {
    $var .= "<category>" . $category . "</category>\n";
  }
  $var .= "<title>" . $title . "</title>\n";
  $var .= "<link>" . $link . "</link>\n";
  $var .= "<guid>" . $link . "</guid>\n";
  $var .= "<description>" . $desc . "</description>\n";
  return $var . "</item>\n";
}