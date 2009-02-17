<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

function cs_cachegen($filename, $dir) {

    global $cs_lang, $cs_main;
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
                cs_error($this_info, 'cs_cachegen - Translated name "' . $name . '" is already in use');
            }
            else {
                $info[$name] = $mod_info;
                $info[$name]['name'] = $name;
                $info[$name]['dir'] = $target;
            }
            unset($info[$name]['text'], $info[$name]['url'], $info[$name]['team'], $info[$name]['creator']);
        }
        elseif(is_dir($dir . '/' . $target)) {
            cs_error($this_info, 'cs_cachegen - Required file not found');
      }
    }
    ksort($info);
    $cs_lang = $cs_lang_old;

    if(is_writeable('uploads/cache/')) {
        $content = serialize($info);
        $cache_file = 'uploads/cache/' . $filename;
        $save_cache = fopen($cache_file,'a');
        fwrite($save_cache,$content);
        fclose($save_cache);
        chmod($cache_file,0644);
    }
    elseif($cs_main['mod'] != 'install') {
        cs_error('uploads/cache/' . $filename, 'cs_cachegen - Unable to write cache file');
    }
    return $info;
}

?>