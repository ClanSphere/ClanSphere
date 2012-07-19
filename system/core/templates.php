<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_revert_script_braces($hits) {
  $hits[3] = empty($hits[3]) ? '' : $hits[3];
  return '<script' . $hits[1] . '>' . str_replace(array('&#123;', '&#125;'), array('{', '}'), $hits[2]) . $hits[3] . '</script>';
}

function cs_looptemplate($source, $string, $data)
{
  foreach ($data as $subname => $subdata)
  {
    if (empty($subdata) or isset($subdata[0]) and is_array($subdata[0]))
    {
      $pattern = "=(.*){loop:" . $subname . "}(.*?){stop:" . $subname . "}(.*)=si";
      $content = array();
      preg_match_all($pattern, $string, $content);
      if (isset($content[1][0]) and isset($content[2][0]) and isset($content[3][0]))
      {
        $string = $content[1][0];
        if (!empty($subdata))
        {
          foreach ($subdata as $loopdata)
          {
            $new_content = cs_conditiontemplate($content[2][0], $loopdata);
            foreach ($loopdata as $name => $value)
            {
              $new_content = !is_array($value) ? str_replace('{' . $subname . ':' . $name . '}', $value, $new_content) : $new_content = cs_looptemplate($source, $new_content, array($name => $value));
            }
            $string .= $new_content;
          }
        }
        $string .= $content[3][0];
      }
      else
      {
        cs_error($source, 'cs_looptemplate - Loop not found: "' . $subname . '"');
      }
    }
    elseif (is_array($subdata))
    {
      foreach ($subdata as $name => $value)
      {
          $string = str_replace('{' . $subname . ':' . $name . '}', $value, $string);
      }
    }
  }
  return $string;
}

function cs_conditiontemplate($string, $data)
{
  if (!isset($data['if']))
    return $string;

    foreach ($data['if'] as $condition => $value) {
    $replace = array('', '\\1');
    $string = preg_replace("={if:" . $condition . "}(.*?){stop:" . $condition . "}=si", $replace[$value], $string);
    $string = preg_replace("={unless:" . $condition . "}(.*?){stop:" . $condition . "}=si", $replace[!$value], $string);
  }
  return $string;
}

function cs_templateurl($matches) {

  $action = empty($matches[3]) ? 'list' : $matches[3];
  $base = empty($matches[1]) ? 0 : $matches[1];
  if(empty($matches[4]))
    $more = 0;
  else
  {
    $more = substr($matches[4], 1);
    $more = preg_replace('=:(?![^{]+})=i', '&amp;', $more);
  }

  return cs_url($matches[2], $action, $more, $base, 1);
}

function cs_subtemplate($source, $data, $mod, $action = 'list', $navfiles = 0)
{
  global $account, $cs_lang, $cs_main;
  $cs_lang = cs_translate($mod);
  $data = is_array($data) ? $data : array();

  $string = cs_cache_theme($mod, $action, $navfiles);
  $string = cs_conditiontemplate($string, $data);
  $string = cs_looptemplate($source, $string, $data);

  $string = preg_replace_callback("={lang:([\S]*?)}=i", 'cs_templatelang', $string);

  if($cs_main['xsrf_protection'] === true)
    $string = preg_replace_callback("/<form(.*?)method=\"post\"(.*?)>/i", 'cs_xsrf_protection_field', $string);

  if(!empty($navfiles))
  {
    $string = cs_tokenizer_split($string);
    $theme = cs_tokenizer_parse($string);
    $string = '';
    foreach($theme AS $num => $content)
      $string .= $content;
  }

  if(!empty($cs_main['themebar']) AND (!empty($cs_main['developer']) OR $account['access_clansphere'] > 4)) {

    include_once 'mods/clansphere/themebar.php';
    $string = cs_themebar($source, $string, $mod, $action);
  }
  
  return $string;
}

function cs_subtemplate_check($mod, $action) {

  global $cs_main;
  $theme_file = 'themes/' . $cs_main['def_theme'] . '/' . $mod . '/' . $action . '.tpl';

  if($cs_main['def_theme'] != 'base' and !file_exists($theme_file))
    $theme_file = 'themes/base/' . $mod . '/' . $action . '.tpl';
  if(file_exists($theme_file))
    return $theme_file;
  else {
    cs_error($theme_file, 'cs_subtemplate_check - Theme file not found');
    return false;
  }
}

function cs_xsrf_protection_field($matches) {
  global $cs_main;
  static $xsrf_key;
  if(!isset($_SESSION['cs_xsrf_keys']) || !is_array($_SESSION['cs_xsrf_keys'])) {
    $_SESSION['cs_xsrf_keys'] = array();
  }
  if(empty($xsrf_key)) {
    
    # disable browser / proxy caching
    header("Cache-Control: max-age=0, no-cache, no-store, must-revalidate");
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    
    $xsrf_key = ($cs_main['ajaxrequest']&&isset($_REQUEST['xhr_nocontent'])&&!empty($_SESSION['cs_xsrf_keys'])) ? end($_SESSION['cs_xsrf_keys']) : md5(microtime() . rand());
    $_SESSION['cs_xsrf_keys'][] = $xsrf_key;
  }
  
  return $matches[0] . "\n" . '<div style="display:none;"><input type="hidden" name="cs_xsrf_key" value="' . end($_SESSION['cs_xsrf_keys']) . '" /></div>' . "\n";
}

function cs_wrap_templatefile($matches)
{
  global $cs_main;
  $nav = $matches[0] . '_' . $matches[1];
  $exceptions = array('clansphere_navmeta');
  if(!in_array($nav, $exceptions)) {
    if(isset($cs_main['ajax']) AND $cs_main['ajax']) {
      $spans = array('count_navday','count_navone','count_navall','count_navmon','count_navusr','count_navyes','clansphere_navtime');

      $id = str_replace('=','-', implode('-', $matches));
      $el = !in_array($nav,$spans) ? 'div' : 'span';
      return "<{$el} id=\"cs_navlist_{$id}\" class=\"cs_navlist\">" . cs_templatefile($matches) . "</{$el}>";
    }
  }
  return cs_templatefile($matches);
}

function cs_template_info($template) {
  global $cs_main;
  $tpl_navlist = array();
  if(file_exists('templates/' . $template . '/info.php')) {
    require_once 'templates/' . $template . '/info.php';
    if(isset($mod_info['navlist'])) {
      $tpl_navlist = $mod_info['navlist'];
    }
  }
  return $tpl_navlist;
}

function cs_templatefile($matches)
{
  $return = '';
  $file = 'mods/' . $matches[0] . '/' . $matches[1] . '.php';
  if(!file_exists($file)) {
    cs_error($file, 'cs_templatefile - File not found');
    $match_count = count($matches);
    for($i = 0; $i < $match_count; $i++)
      $return .= 'm[' . $i . '] ' . $matches[$i] . ' - ';
      return $return;
  }

  # only one get parameter is allowed
  $param = NULL;
  $value = NULL;
  if(!empty($matches[2])) {
    if(empty($matches[3]) AND $pos = strpos($matches[2], '=')) {
      $matches[3] = substr($matches[2], $pos + 1);
      $matches[2] = substr($matches[2], 0, $pos);
    }
    $param = $matches[2];
    $value = $matches[3];
  }

  return cs_filecontent($file, $param, $value);
}

function cs_filecontent($file, $param = NULL, $value = NULL)
{
  global $account, $cs_main;

  if($param != NULL) {
    $backup = isset($_GET[$param]) ? $_GET[$param] : NULL;
    $_GET[$param] = $value;
  }

  ob_start();
  include $file;
  $content = ob_get_contents();
  ob_end_clean();

  if($param != NULL)
    if(isset($backup))
      $_GET[$param] = $backup;
    else
      unset($_GET[$param]);

  return $content;
}

function cs_templatelang($matches)
{
  global $cs_lang;

  return !empty($cs_lang[$matches[1]]) ? $cs_lang[$matches[1]] : $matches[0];
}

function cs_getmsg()
{
  if (!isset($_SESSION['message']) || empty($_SESSION['message']))
    return '';

  $data = array();

  if (!empty($_SESSION['messageadd'])) {
    $add = explode(',',$_SESSION['messageadd'],2);
    $data['msg']['icon'] = empty($add[0]) ? '' : cs_icon($add[0]);
    $data['msg']['id'] = empty($add[1]) ? 'msg_normal' : $add[1];
    unset($_SESSION['messageadd']);
  } else {
    $data['msg']['icon'] = '';
    $data['msg']['id'] = 'msg_normal';
  }
  $data['msg']['text'] = $_SESSION['message'];
  unset($_SESSION['message']);

  return cs_subtemplate(__FILE__, $data, 'clansphere', 'message');
}

function cs_redirect($message, $mod, $action = 'manage', $more = '', $id = 0, $icon = 0)
{
  if($mod != "install" && $message) {
      cs_redirectmsg($message, $id, $icon);
  }

  $persistent_params = array('xhr', 'xhr_navlists');

  $more = explode('#', $more);

  foreach($persistent_params AS $p) {
    if(isset($_REQUEST[$p])) {
      $more[0] .= !empty($more[0]) ? '&' : '';
      $more[0] .= $p . '=' . $_REQUEST[$p];
    }
  }

  $more = implode('#', $more);

  $more = empty($more) ? 0 : $more;

  $url = str_replace('&amp;', '&', cs_url($mod, $action, $more));

  header('Location: ' . $url);
  exit();
}

function cs_redirectmsg($message, $id = 0, $icon = 0) {

  global $cs_lang, $cs_logs, $cs_main;

  $sql = cs_sql_error();
  $php = $cs_logs['php_errors'];

  if (!empty($cs_main['debug']) && (!empty($sql) || !empty($php))) {
    $message = $cs_lang['error'] . cs_html_br(1);
    $icon = 'alert';
    if (!empty($sql)) $message .= '<div id="errors">' . '<strong>SQL -></strong> ' . $sql . '</div>';
    if (!empty($php)) $message .= '<div id="errors">' . $php . '</div>';
  }
  $_SESSION['message'] = $message;
  if (!empty($id) || !empty($icon)) $_SESSION['messageadd'] = $icon . ',' . $id;
}

function cs_scriptload($mod, $type, $file, $top = 0, $media = 'screen') {

  global $cs_main;
  $script = '';
  if(!isset($cs_main['scriptload']))
    $cs_main['scriptload'] = array('javascript' => '', 'stylesheet' => '');

  if(strpos($file, '://') === false)
    $target = $cs_main['php_self']['dirname'] . 'mods/' . $mod . '/' . $file;
  else
    $target = $file;

  if($type == 'javascript')
    $script = '<script src="' . $target . '" type="text/javascript"></script>' . "\r\n";
  elseif($type == 'stylesheet')
    $script = '<link rel="stylesheet" href="' . $target . '" type="text/css" media="' . $media . '" />' . "\r\n";

  if(!isset($cs_main['scriptload'][$type]))
    cs_error($target, 'cs_scriptload - Incorrect filetype specified: ' . $type);
  elseif(empty($top))
    $cs_main['scriptload'][$type] .= $script;
  else
    $cs_main['scriptload'][$type] = $script . $cs_main['scriptload'][$type];
}

function cs_tokenizer_split($content)
{
  $content = preg_split("=\{([\S]*?:[\S]*?(?::(?:[\S]*?)\=(?:[\S]*?))*(?:\|noajax)*)\}=i", $content, -1, PREG_SPLIT_DELIM_CAPTURE);
  $parts   = count($content);
  $ajax    = 0;

  for($i = 1; $i < $parts; $i++)
  {
    if(substr($content[$i], 0, 5) != 'func:')
    {
      if(substr($content[$i], -7, 7) == '|noajax')
      {
        $content[$i] = substr($content[$i], 0, -7);
        $ajax = 1;
      }

      $content[$i] = explode(':', $content[$i]);

      if($ajax == 1)
      {
        $content[$i][99] = 'noajax';
      }

      $content[$i] = array_flip($content[$i]);
    }
    $ajax = 0;
    $i++;
  }

  return $content;
}

function cs_tokenizer_parse($template)
{
  global $cs_main;
  $parts = count($template);

  for($i = 1; $i < $parts; $i++)
  {
    if(is_array($template[$i]))
    {
      if(isset($template[$i]['noajax']) OR empty($cs_main['ajax']))
        $template[$i] = cs_templatefile(array_flip($template[$i]));
      else
        $template[$i] = cs_wrap_templatefile(array_flip($template[$i]));
    }
    $i++;
  }

  return $template;
}

function cs_template($cs_micro, $tpl_file = 'index.htm')
{
  global $account, $cs_logs, $cs_main;

  if ((empty($cs_main['public']) or ($tpl_file == 'admin.htm' and $account['access_clansphere'] < 3)) and $account['access_clansphere'] < $cs_main['maintenance_access'])
  {
    $cs_main['show'] = 'mods/users/login.php';
    $tpl_file = 'login.htm';
    $cs_main['ajax'] = 0;
  }

  if (!empty($account['users_tpl']))
    $cs_main['template'] = $account['users_tpl'];
  if (!empty($_GET['template']))
    $cs_main['template'] = str_replace(array('.','/'),'',$_GET['template']);
  if (!empty($_SESSION['tpl_preview']))
    $cs_main['template'] = str_replace(array('.','/'),'',$_SESSION['tpl_preview']);
  if ($tpl_file == 'error.htm')
    $cs_main['template'] = 'install';
  if ($cs_main['template'] != $cs_main['def_tpl'] AND !is_dir('templates/' . $cs_main['template']))
    $cs_main['template'] = $cs_main['def_tpl'];

  $tpl_path = $cs_main['def_path'] . '/templates/' . $cs_main['template'] . '/' . $tpl_file;
  if (!file_exists($tpl_path))
  {
    cs_error($tpl_path, 'cs_template - Template file not found');
    $msg = 'Template file not found: ' . $tpl_file;
    if($tpl_file != 'error.htm')
      die(cs_error_internal('tpl', $msg));
    else
      die($msg);
  }

  # Initalize array of upcoming additions and get show content
  $replace = array('func:body_add' => '');
  $replace['func:show'] = '<div id="csp_content">' . cs_contentload($cs_main['show']) . '</div>';

  if (isset($cs_main['ajax']) AND $cs_main['ajax'] == 2 OR (!empty($account['users_ajax']) AND !empty($account['access_ajax'])))
  {
    $replace['func:body_add'] = ' onload="Clansphere.initialize(' . $cs_main['mod_rewrite'] . ',\'' . $_SERVER['SCRIPT_NAME'] . '\',' . $cs_main['ajax_reload'] * 1000 . ')"';
  }

  # Provide the def_title and a title with more information
  $replace['func:title_website'] = htmlentities($cs_main['def_title'], ENT_QUOTES, $cs_main['charset']);
  $replace['func:title'] = cs_title();

  # Fetch template file and parse exploded contents
  $template = cs_cache_template($tpl_file);
  $template = cs_tokenizer_parse($template);

  # Add scriptload to replaces
  global $cs_main;
  $replace['func:stylesheet'] = empty($cs_main['scriptload']['stylesheet']) ? '' : $cs_main['scriptload']['stylesheet'];
  $replace['func:javascript'] = empty($cs_main['scriptload']['javascript']) ? '' : $cs_main['scriptload']['javascript'];

  # Prepare debug and log data
  $debug = '';
  $logsql = '';
  if (!empty($cs_main['developer']) OR $account['access_clansphere'] > 4)
  {
    $cs_logs['php_errors'] = nl2br($cs_logs['php_errors']);
    $cs_logs['errors'] = nl2br($cs_logs['errors']);
    $logsql = cs_log_format('sql');
  }
  else
  {
    $cs_logs['php_errors'] = '';
    $cs_logs['errors'] = 'Developer mode is turned off';
  }
  if (!empty($cs_main['debug']))
  {
    $data = array('data');
    $data['data']['log_sql'] = $logsql;
    $data['data']['php_errors'] = $cs_logs['php_errors'];
    $data['data']['csp_errors'] = $cs_logs['errors'];
    $debug = cs_subtemplate(__FILE__, $data, 'clansphere', 'debug');
  }

  $replace['func:queries'] = $cs_logs['queries'];
  $replace['func:errors'] = $cs_logs['php_errors'] . $cs_logs['errors'];
  $replace['func:sql']    = $logsql;
  $replace['func:debug']  = $debug;
  $replace['func:parse']  = cs_parsetime($cs_micro);

  $replace['func:memory'] = function_exists('memory_get_usage') ? cs_filesize(memory_get_usage()) : '-';
  if (function_exists('memory_get_peak_usage'))
    $replace['func:memory'] .= ' [peak ' . cs_filesize(memory_get_peak_usage()) . ']';

  # Assemble content parts
  $result = '';
  foreach($template AS $num => $content)
    if(array_key_exists($content, $replace))
      $result .= $replace[$content];
    else
      $result .= $content;

  # Enable zlib output compression if possible
  if(!empty($cs_main['zlib']) AND extension_loaded('zlib'))
    ob_start('ob_gzhandler');

  # Send content type header with charset
  header('Content-type: text/html; charset=' . $cs_main['charset']);

  return $result;
}