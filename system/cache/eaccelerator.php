<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_cache_clear() {

  eaccelerator_clear();

  $unicode = extension_loaded('unicode') ? 1 : 0;
  $where = "options_mod = 'clansphere' AND options_name = 'cache_unicode'";
  cs_sql_update(__FILE__, 'options', array('options_value'), array($unicode), 0, $where); 
 }

function cs_cache_delete($name) {

  eaccelerator_rm($name);
}

function cs_cache_load($name) {

  $content = eaccelerator_get($name);
  if($content == NULL)
    return false;
  else
    return $content;
}

function cs_cache_save($name, $content) {

  if(is_bool($content))
    cs_error($name, 'cs_cache_save - It is not allowed to just store a boolean');
  else
     eaccelerator_put($name, $content);

  return $content;
}