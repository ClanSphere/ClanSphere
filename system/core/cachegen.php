<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_cache_dirs($dir, $lang, $return_startup = 0) {

  # $cs_lang and $cs_main are needed for info.php file content parsing
  global $cs_lang, $cs_main;
  $cachename = $dir . '_' . $lang;
  $content = cs_cache_load($cachename);

  if($content === false) {
    $startup = array();
    $cs_lang_old = $cs_lang;
    $info = array();
    $dirlist = cs_paths($dir);
    unset($dirlist['index.html'], $dirlist['.htaccess'], $dirlist['web.config']);
    $directories = array_keys($dirlist);
    foreach($directories as $target) {
      $this_info = $dir . '/' . $target . '/info.php';
      if(file_exists($this_info)) {
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
          if($dir == 'mods' AND !empty($mod_info['startup']))
            $startup[$target] = TRUE;
        }
        unset($info[$name]['text'], $info[$name]['url'], $info[$name]['team'], $info[$name]['creator']);
      }
      elseif(is_dir($dir . '/' . $target)) {
        cs_error($this_info, 'cs_cache_dirs - Required file not found');
      }
    }
    ksort($info);
    $cs_lang = $cs_lang_old;

    if($dir == 'mods' AND cs_cache_load('startup') === false)
      cs_cache_save('startup', array_keys($startup));

    cs_cache_save($cachename, $info);

    return empty($return_startup) ? $info : array_keys($startup);
  }
  else {
    return empty($return_startup) ? $content : cs_cache_load('startup');
  }
}

function cs_cache_template($filename) {

  global $cs_main;
  $tpl_real = 'templates/' . $cs_main['template'] . '/' . $filename;
  $tpl_temp = 'tpl_' . $cs_main['template'] . '_' . $cs_main['php_self']['filename'] . '_' . $filename;
  $tpl_data = cs_cache_load($tpl_temp);

  if($tpl_data != false)
    if($cs_main['cache_mode'] != 'file' OR filemtime($tpl_real) < filemtime('uploads/cache/' . $tpl_temp . '.tmp'))
      return $tpl_data;

  $tpl_data = file_get_contents($tpl_real);
  $tpl_path = $cs_main['php_self']['dirname'] . 'templates/' . $cs_main['template'];

  $tpl_data = str_replace('{func:path}', $cs_main['php_self']['dirname'], $tpl_data);

  if(strpos($tpl_data, 'id="csp_content"') !== false)
    cs_error($tpl_real, 'cs_cache_template - The ID tag "csp_content" is reserved for AJAX');
  if(strpos($tpl_data, '{func:stylesheet}') === false)
    $tpl_data = str_ireplace('</head>', '{func:stylesheet}</head>', $tpl_data);
  if(strpos($tpl_data, '{func:javascript}') === false)
    $tpl_data = str_ireplace('</body>', '{func:javascript}</body>', $tpl_data);
  if(strpos($tpl_data, '{func:debug}') === false)
    $tpl_data = preg_replace('=\<body(.*?)\>=si', "<body\\1{func:body_add}>\n{func:debug}", $tpl_data, 1);
  else
    $tpl_data = preg_replace('=\<body(.*?)\>=si', '<body\\1{func:body_add}>', $tpl_data, 1);

  $pattern = "=\<link(.*?)href\=\"(?!http|\/)(.*?)\"(.*?)\>=i";
  $tpl_data = preg_replace($pattern, "<link\\1href=\"" . $tpl_path . "/\\2\"\\3>", $tpl_data);
  $pattern = "=(background|src)\=\"(?!http|\/)(.*?)\"=i";
  $tpl_data = preg_replace($pattern, "\\1=\"" . $tpl_path . "/\\2\"", $tpl_data);

  $tpl_data = preg_replace_callback('={url(?:_([\w]*?))?:([\w]*?)(?:_([\w]*?)((?::(?:(?:[\S]*?{[\S]*?}[\S]*?)*?|[\S]*?))*?))?}=i', 'cs_templateurl', $tpl_data);

  $tpl_data = str_replace('{func:charset}', $cs_main['charset'], $tpl_data);

  $tpl_data = cs_tokenizer_split($tpl_data);

  return cs_cache_save($tpl_temp, $tpl_data);
}

function cs_cache_theme($mod, $action) {

  global $cs_main;
  $tpl_temp = 'thm_' . $mod . '_' . $action . '_' . $cs_main['php_self']['filename'];
  $tpl_data = cs_cache_load($tpl_temp);

  $tpl_real = cs_subtemplate_check($mod, $action);

  if($tpl_real === false)
    return false;
  elseif($tpl_data != false)
    if($cs_main['cache_mode'] != 'file' OR filemtime($tpl_real) < filemtime('uploads/cache/' . $tpl_temp . '.tmp'))
      return $tpl_data;

  $tpl_data = file_get_contents($tpl_real);

  # the default template is used since users may have different templates activated
  $tpl_data = str_replace('{page:template}', $cs_main['def_tpl'], $tpl_data);
  # page path does always end with a slash
  $tpl_data = str_replace('{page:path}', $cs_main['php_self']['dirname'], $tpl_data);
  $tpl_data = str_replace('{page:width}', $cs_main['def_width'], $tpl_data);
  $tpl_data = str_replace('{page:cellspacing}', $cs_main['cellspacing'], $tpl_data);
  $tpl_data = preg_replace_callback("={icon:([\S]*?)}=i", 'cs_icon', $tpl_data);

  $tpl_data = preg_replace_callback('={url(?:_([\w]*?))?:([\w]*?)(?:_([\w]*?)((?::(?:(?:[\S]*?{[\S]*?}[\S]*?)*?|[\S]*?))*?))?}=i', 'cs_templateurl', $tpl_data);

  return cs_cache_save($tpl_temp, $tpl_data);
}