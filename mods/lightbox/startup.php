<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

global $cs_main, $account;

if(!empty($account['access_lightbox'])) {

  $gallery = cs_sql_option(__FILE__, 'gallery');

  if($gallery['lightbox'] == 1) {

    cs_scriptload('lightbox', 'stylesheet', 'css/slimbox2.css');

    # Slimbox requires jQuery - loaded in jQuery mod startup.php file
    cs_scriptload('lightbox', 'javascript', 'js/slimbox2.js');
  }
}