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

function cs_cache_delete($name) {

  if(file_exists('uploads/cache/' . $name . '.tmp'))
    unlink('uploads/cache/' . $name . '.tmp');
}

function cs_cache_info() {

  $info = cs_paths('uploads/cache');
  unset($info['index.html'], $info['.htaccess'], $info['web.config']);

  foreach($info AS $filename => $num)
    $form[$filename] = array('name' => $filename, 'time' => filemtime('uploads/cache/' . $filename), 'size' => filesize('uploads/cache/' . $filename));

  $form = array_values($form);
  return $form;
}

function cs_cache_load($name) {

  if(!file_exists('uploads/cache/' . $name . '.tmp'))
    return false;
  else
    return unserialize(file_get_contents('uploads/cache/' . $name . '.tmp'));
}

function cs_cache_save($name, $content) {

  global $cs_main;
  if(is_bool($content))
    cs_error($name, 'cs_cache_save - It is not allowed to just store a boolean');
  elseif(file_exists('uploads/cache/' . $name . '.tmp'))
    cs_error($name, 'cs_cache_save - This name is already placed in the cache');
  elseif(is_writeable('uploads/cache/')) {
    $store = serialize($content);
    $cache_file = 'uploads/cache/' . $name . '.tmp';
    $save_cache = fopen($cache_file,'a');
    # set stream encoding if possible to avoid converting issues
    if(function_exists('stream_encoding'))
      stream_encoding($save_cache, $cs_main['charset']);
    fwrite($save_cache,$store);
    fclose($save_cache);
    chmod($cache_file,0644);
  }
  elseif($cs_main['mod'] != 'install')
    cs_error('uploads/cache/' . $name . '.tmp', 'cs_cache_save - Unable to write cache file');

  return $content;
}