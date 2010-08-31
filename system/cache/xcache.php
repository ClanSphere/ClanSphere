<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_cache_clear() {

  $cache_count = xcache_count(XC_TYPE_VAR);
  for($i = 0; $i < $cache_count; $i++)
    xcache_clear_cache(XC_TYPE_VAR, $i);
    
  $unicode = extension_loaded('unicode') ? 1 : 0;
  $where = "options_mod = 'clansphere' AND options_name = 'cache_unicode'";
  cs_sql_update(__FILE__, 'options', array('options_value'), array($unicode), 0, $where); 
 }

function cs_cache_delete($name) {

  if(xcache_isset($name))
    xcache_unset($name);
}

function cs_cache_info() {

  $form = array();
  $cache_count = xcache_count(XC_TYPE_VAR);
  for($i = 0; $i < $cache_count; $i++) {
    $info = xcache_list(XC_TYPE_VAR, $i);
    foreach($info['cache_list'] AS $num => $data) {
      $handle = $data['name'] . ' (' . $i . '.' . $num . ')';
      $form[$handle] = array('name' => $handle, 'time' => $data['ctime'], 'size' => $data['size']);
    }
  }
  ksort($form);
  return array_values($form);
}

function cs_cache_load($name) {

  if(xcache_isset($name))
    return xcache_get($name);
  else
    return false;
}

function cs_cache_save($name, $content) {

  cs_cache_delete($name);

  if(is_bool($content))
    cs_error($name, 'cs_cache_save - It is not allowed to just store a boolean');
  else
    xcache_set($name, $content);

  return $content;
}