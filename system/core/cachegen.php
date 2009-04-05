<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

function cs_cache_dirs($dir, $lang) {

  # $cs_lang and $cs_main are needed for info.php file content parsing
  global $cs_lang, $cs_main;
  $filename = $dir . '_' . $lang;
  $content = cs_cache_load($filename);

  if($content === false) {

    $cs_lang_old = $cs_lang;
    $info = array();
    $directories = array_keys(cs_paths($dir));
    foreach($directories as $target) {
      $this_info = $dir . '/' . $target . '/info.php';
      if(file_exists($this_info)) {
        $cs_lang = array('mod' => '', 'mod_info' => '');
        $mod_info = array('show' => array());
        include($this_info);
        $name = empty($mod_info['name']) ? '[' . $target . ']' : $mod_info['name'];
        if(isset($info[$name])) {
          cs_error($this_info, 'cs_cache_dirs - Translated name "' . $name . '" is already in use');
        }
        else {
          $info[$name] = $mod_info;
          $info[$name]['name'] = $name;
          $info[$name]['dir'] = $target;
        }
        unset($info[$name]['text'], $info[$name]['url'], $info[$name]['team'], $info[$name]['creator']);
      }
      elseif(is_dir($dir . '/' . $target)) {
        cs_error($this_info, 'cs_cache_dirs - Required file not found');
      }
    }
    ksort($info);
    $cs_lang = $cs_lang_old;

    return cs_cache_save($filename, $info);
  }
  else {
    return $content;
  }
}

function cs_cache_load($filename) {

  if(!file_exists('uploads/cache/' . $filename . '.tmp'))
    return false;
  else
    return unserialize(file_get_contents('uploads/cache/' . $filename . '.tmp'));
}

function cs_cache_save($filename, $content) {

  global $cs_main;
  if(is_writeable('uploads/cache/')) {
    $store = serialize($content);
    $cache_file = 'uploads/cache/' . $filename . '.tmp';
    $save_cache = fopen($cache_file,'a');
    fwrite($save_cache,$store);
    fclose($save_cache);
    chmod($cache_file,0644);
  }
  elseif($cs_main['mod'] != 'install') {
    cs_error('uploads/cache/' . $filename . '.tmp', 'cs_cache_save - Unable to write cache file');
  }
  return $content;
}

?>