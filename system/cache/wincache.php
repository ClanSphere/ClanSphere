<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_cache_clear() {

  wincache_ucache_clear();

  $unicode = extension_loaded('unicode') ? 1 : 0;
  $where = "options_mod = 'clansphere' AND options_name = 'cache_unicode'";
  cs_sql_update(__FILE__, 'options', array('options_value'), array($unicode), 0, $where); 
 }

function cs_cache_delete($name, $ttl = 0) {

  $token = empty($ttl) ? $name : 'ttl_' . $name;
  if(wincache_ucache_exists($token))
    wincache_ucache_delete($token);
}

function cs_cache_info() {

  $form = array();
  $info = wincache_ucache_info();
  foreach($info['ucache_entries'] AS $num => $data) {
    $handle = $data['key_name'] . ' (' . $num . ')';
    $age = time() - $data['age_seconds'];
    $form[$handle] = array('name' => $handle, 'time' => $age, 'size' => $data['value_size']);
  }
  ksort($form);
  return array_values($form);
}

function cs_cache_load($name, $ttl = 0) {

  $token = empty($ttl) ? $name : 'ttl_' . $name;
  if(wincache_ucache_exists($token)) {
      return wincache_ucache_get($token);
  }

  return false;
}

function cs_cache_save($name, $content, $ttl = 0) {

  $token = empty($ttl) ? $name : 'ttl_' . $name;
  cs_cache_delete($token);

  if(is_bool($content))
    cs_error($name, 'cs_cache_save - It is not allowed to just store a boolean');
  else
    wincache_ucache_set($token, $content, $ttl);

  return $content;
}