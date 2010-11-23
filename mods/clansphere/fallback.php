<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

// This file makes it possible to see an error page on too old php versions

// Template caching requires str_ireplace, so fake it with str_replace
if(!function_exists('str_ireplace')) {

  function str_ireplace($search, $replace, $subject, $count = 0) {

    return str_replace($search, $replace, $subject);
  }
}

// IP detection needs stripos, so fake it with strpos
if(!function_exists('stripos')) {

  function stripos($haystack, $needle, $offset = 0) {

    return strpos(strtolower($haystack), strtolower($needle), $offset);
  }
}

// Throw internal error page
die(cs_error_internal('cs_init', 'PHP Version 5.0 or newer is required, but found ' . $phpversion));