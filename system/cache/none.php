<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_cache_clear() {

  $content = cs_paths('uploads/cache');
  unset($content['index.html'], $content['.htaccess'], $content['web.config']);

  foreach($content AS $file => $name)
    unlink('uploads/cache/' . $file);

  $unicode = extension_loaded('unicode') ? 1 : 0;
  $where = "options_mod = 'clansphere' AND options_name = 'cache_unicode'";
  cs_sql_update(__FILE__, 'options', array('options_value'), array($unicode), 0, $where); 
}

function cs_cache_delete($name, $ttl = 0) {

  $token = empty($ttl) ? $name : 'ttl_' . $name;
  if(file_exists('uploads/cache/' . $token . '.tmp'))
    unlink('uploads/cache/' . $token . '.tmp');
}

function cs_cache_info() {

  $info = cs_paths('uploads/cache');
  unset($info['index.html'], $info['.htaccess'], $info['web.config']);

  $form = array();
  foreach($info AS $filename => $num)
    $form[$filename] = array('name' => $filename, 'time' => filemtime('uploads/cache/' . $filename), 'size' => filesize('uploads/cache/' . $filename));

  $form = array_values($form);
  return $form;
}

function cs_cache_load($name, $ttl = 0) {

  return false;
}

function cs_cache_save($name, $content, $ttl = 0) {

  global $cs_main;
  if(is_bool($content))
    cs_error($name, 'cs_cache_save - It is not allowed to just store a boolean');
  elseif(!is_writeable('uploads/cache/') AND $cs_main['mod'] != 'install')
    cs_error('uploads/cache/' . $token . '.tmp', 'cs_cache_save - Unable to write cache file');

  return $content;
}