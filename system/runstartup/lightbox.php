<?php
// ClanSphere 2009 - www.clansphere.net
// $Id: news.php 1942 2009-03-08 01:24:18Z hajo $

// Load scripts for lightbox if needed
global $cs_main, $account;


if(!empty($account['access_gallery']) && $cs_main['mod'] == 'gallery') {

  $gallery = cs_sql_option(__FILE__, 'gallery');
  if($gallery['lightbox'] == '1') {
    cs_scriptload('lightbox', 'javascript', 'js/mootools.js');
    cs_scriptload('lightbox', 'javascript', 'js/slimbox.js');
    cs_scriptload('lightbox', 'stylesheet', 'css/slimbox.css');
    if(isset($cs_main['ajax_js']))
      $cs_main['ajax_js'] .= 'Lightbox.init.bind(Lightbox)';
    else
      $cs_main['ajax_js'] = 'Lightbox.init.bind(Lightbox)';
  }
}