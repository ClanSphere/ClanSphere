<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_cache_clear() {

  apc_clear_cache('user');

  $unicode = extension_loaded('unicode') ? 1 : 0;
  $where = "options_mod = 'clansphere' AND options_name = 'cache_unicode'";
  cs_sql_update(__FILE__, 'options', array('options_value'), array($unicode), 0, $where); 
 }

function cs_cache_delete($name, $ttl = 0) {

  $token = empty($ttl) ? $name : 'ttl_' . $name;
  if(apc_exists($token))
    apc_delete($token);
}

function cs_cache_info() {

  $form = array();
  $info = apc_cache_info('user');
  foreach($info['cache_list'] AS $num => $data) {
    $handle = $data['info'] . ' (' . $num . ')';
    $form[$handle] = array('name' => $handle, 'time' => $data['mtime'], 'size' => $data['mem_size']);
  }
  ksort($form);
  return array_values($form);
}

function cs_cache_load($name, $ttl = 0) {

  $token = empty($ttl) ? $name : 'ttl_' . $name;
  if(apc_exists($token)) {
      return apc_fetch($token);
  }

  return false;
}

function cs_cache_save($name, $content, $ttl = 0) {

  $token = empty($ttl) ? $name : 'ttl_' . $name;
  cs_cache_delete($token);

  if(is_bool($content))
    cs_error($name, 'cs_cache_save - It is not allowed to just store a boolean');
  else
    apc_store($token, $content, $ttl);

  return $content;
}