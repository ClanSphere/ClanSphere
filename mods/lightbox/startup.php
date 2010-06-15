<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

global $cs_main, $account;

$gallery = cs_sql_option(__FILE__, 'gallery');

if($gallery['lightbox'] == 1) {

# Slimbox requires jQuery - loaded in cs_template() function
  cs_scriptload('lightbox', 'javascript', 'js/slimbox2.js');
  cs_scriptload('lightbox', 'stylesheet', 'css/slimbox2.css');
}