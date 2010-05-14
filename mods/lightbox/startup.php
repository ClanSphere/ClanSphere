<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

// Load scripts for lightbox if needed
global $cs_main, $account;

$gallery = cs_sql_option(__FILE__, 'gallery');

if($gallery['lightbox'] == 1) {

  cs_scriptload('lightbox', 'javascript', 'js/slimbox2.js');
  cs_scriptload('lightbox', 'stylesheet', 'css/slimbox2.css');
}