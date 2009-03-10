<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

function cs_revert_script_braces($hits) {
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
                cs_error($source, 'cs_subtemplate - Loop not found: "' . $subname . '"');
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

  $action = !empty($matches[5]) ? $matches[5] : 'list';
  $more = empty($matches[7]) ? 0 : $matches[7];
  $base = empty($matches[2]) ? 0 : $matches[2];

  return cs_url($matches[3], $action, $more, $base);
}

function cs_subtemplate($source, $data, $mod, $action = 'list', $navfiles = 0)
{

  $micro = explode(' ', microtime());

  global $cs_main;
  $cs_main['cellspacing'] = isset($cs_main['cellspacing']) ? $cs_main['cellspacing'] : 0;
  $cs_main['def_theme'] = empty($cs_main['def_theme']) ? 'base' : $cs_main['def_theme'];

  $target = 'themes/' . $cs_main['def_theme'] . '/' . $mod . '/' . $action . '.tpl';
  if ($cs_main['def_theme'] != 'base' and !file_exists($target))
  {
    cs_warning('cs_subtemplate - Custom theme file not found: "' . $target . '"');
    $target = 'themes/base/' . $mod . '/' . $action . '.tpl';
  }
  if (!file_exists($target))
  {
    cs_error($source, 'cs_subtemplate - Theme file not found: "' . $target . '"');
    return false;
  }

  $string = file_get_contents($target);
  $string = str_replace('{page:width}', $cs_main['def_width'], $string);
  $string = str_replace('{page:self}', $_SERVER['PHP_SELF'], $string);
  $string = str_replace('{page:path}', $cs_main['php_self']['dirname'], $string);
  $string = str_replace('{page:mod}', $cs_main['mod'], $string);
  $string = str_replace('{page:cellspacing}', $cs_main['cellspacing'], $string);
  $string = preg_replace_callback("={icon:(.*?)}=i", 'cs_icon', $string);
  $string = cs_conditiontemplate($string, $data);
  $string = cs_looptemplate($source, $string, $data);
  $string = preg_replace_callback("={lang:(.*?)}=i", 'cs_templatelang', $string);
  $string = preg_replace_callback('={url(_([\w]*?))?:(.*?)(_(.*?))?(:(.*?))?}=i', 'cs_templateurl', $string);
    
  if (!empty($navfiles))
    $string = preg_replace_callback("={(?!func)(.*?):(.*?)(:(.*?))*}=i", 'cs_templatefile', $string);

  if (!empty($cs_main['themebar']) AND $action != 'navmeta' AND $action != 'themebar' AND ($mod != 'errors' OR $action != '500')) {

    global $account;
    $data = array();
    $data['data']['load'] = cs_parsetime($micro,5);
    $data['data']['target'] = $target;
    $data['data']['content'] = $string;
    $data['data']['langfile'] = 'lang/' . $account['users_lang'] . '/' . $mod . '.php';
    $phpsource = str_replace('\\', '/', str_replace($cs_main['def_path'], '', $source));
    $data['data']['phpsource'] = substr($phpsource, 1, strlen($phpsource));
    $string = cs_subtemplate(__FILE__, $data, 'clansphere', 'themebar');
  }

  return $string;
}

function cs_templatefile($matches)
{
  $file = 'mods/' . $matches[1] . '/' . $matches[2] . '.php';
  if (!file_exists($file))
  {
    cs_error($file, 'cs_templatefile - File not found');
    return $matches[0];
  }
  if (!empty($matches[3]))
  {
    $data = explode('=', substr($matches[3], 1));
    $backup = empty($_GET[$data[0]]) ? '' : $_GET[$data[0]];
    $_GET[$data[0]] = $data[1];
    $return = cs_filecontent($file);
    if (empty($backup)) unset($_GET[$data[0]]); else $_GET[$data[0]] = $backup;
    return $return;
  }
  return cs_filecontent($file);
}

function cs_filecontent($file)
{
  global $account, $cs_main;
    
  ob_start();
  include $file;
  $content = ob_get_contents();
  ob_end_clean();

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

  if (!empty($_SESSION['messageadd'])) {
    $add = explode(',',$_SESSION['messageadd'],2);
    $icon = empty($add[0]) ? '' : cs_icon($add[0]);
    $id = empty($add[1]) ? 'msg_normal' : $add[1];
    unset($_SESSION['messageadd']);
  } else {
    $icon = '';
    $id = 'msg_normal';
  }
  $string = cs_html_div(1,0,'id="' . $id . '"') . cs_html_div(1);
  $string .= $icon . $_SESSION['message'];
  $string .= cs_html_div(0) . cs_html_div(0);
  unset($_SESSION['message']);

  return $string;
}

function cs_redirect($message, $mod, $action = 'manage', $more = 0, $id = 0, $icon = 0)
{    
  if($mod != "install") {
      cs_redirectmsg($message, $id, $icon);
  }

    $url = str_replace('&amp;', '&', cs_url($mod, $action, $more));
    header('Location: ' . $url);
    exit();
}
function cs_redirectmsg($message, $id = 0, $icon = 0) {

  global $cs_logs;
  global $cs_main;
  global $cs_lang;

  $sql = cs_sql_error();
  $php = $cs_logs['php_errors'];

  if (!empty($cs_main['debug']) && (!empty($sql) || !empty($php))) {
    $message = $cs_lang['error'] . cs_html_br(1);
    $icon = 'alert';
    if (!empty($sql)) $message .= cs_html_div(1, 0, 'id="errors"') . '<b>SQL -></b> ' . $sql . cs_html_div(0);
    if (!empty($php)) $message .= cs_html_div(1, 0, 'id="errors"') . $php . cs_html_div(0);
  }
  $_SESSION['message'] = $message;
  if (!empty($id) || !empty($icon)) $_SESSION['messageadd'] = $icon . ',' . $id;
}

function cs_scriptload($mod, $type, $file) {

  global $cs_main;
  $cs_main['scripts'] = empty($cs_main['scripts']) ? '' : $cs_main['scripts'];
  $wp = $cs_main['php_self']['dirname'];

  if($type == 'javascript')
    $cs_main['scripts'] .= '<script src="' . $wp . 'mods/' . $mod . '/' . $file . '" type="text/javascript"></script>' . "\r\n";
  elseif($type == 'stylesheet')
    $cs_main['scripts'] .= '<link rel="stylesheet" href="' . $wp . 'mods/' . $mod . '/' . $file . '" type="text/css" media="screen" />' . "\r\n";
}

function cs_template($cs_micro, $tpl_file = 'index.htm')
{
    global $account, $cs_logs, $cs_main, $com_lang;
    $wp = $cs_main['php_self']['dirname'];
    $mod = $cs_main['mod'];
    $action = $cs_main['action'];
    $get_axx = 'mods/' . $mod . '/access.php';

    if (!file_exists($cs_main['show'])) {
        cs_error($cs_main['show'], 'cs_template - File not found');
        $cs_main['show'] = 'mods/errors/404.php';
    } elseif (!file_exists($get_axx)) {
        cs_error($get_axx, 'cs_template - Access file not found');
        $cs_main['show'] = 'mods/errors/403.php';
    } else {
        $axx_file = array();
        include($get_axx);
        if (!isset($axx_file[$action])) {
            cs_error($cs_main['show'], 'cs_template - No access defined for target file');
            $cs_main['show'] = 'mods/errors/403.php';
        } elseif (!isset($account['access_' . $mod])) {
            cs_error($cs_main['show'], 'cs_template - No module access defined in database');
            $cs_main['show'] = 'mods/errors/403.php';
        } elseif ($account['access_' . $mod] < $axx_file[$action]) {
            $cs_main['show'] = empty($account['users_id']) ? 'mods/users/login.php' : 'mods/errors/403.php';
        }
    }

    if ((empty($cs_main['public']) or $tpl_file == 'admin.htm') and $account['access_clansphere'] < 3)
    {
        $cs_main['show'] = 'mods/users/login.php';
        $tpl_file = 'login.htm';
    }

    $cs_main['template'] = empty($account['users_tpl']) ? $cs_main['def_tpl'] : $account['users_tpl'];
    if (!empty($_GET['template'])) $cs_main['template'] = str_replace(array('.','/'),'',$_GET['template']);
    if (!empty($_SESSION['tpl_preview'])) { $cs_main['template'] = str_replace(array('.','/'),'',$_SESSION['tpl_preview']); unset($_SESSION['tpl_preview']); }

    $tpl_path = 'templates/' . $cs_main['template'];
    if (!file_exists($tpl_path . '/' . $tpl_file))
    {
        cs_error($tpl_path . '/' . $tpl_file, 'cs_template - Template not found');
        $msg = 'Template not found: ' . $tpl_path . '/' . $tpl_file;
        die(cs_error_internal('tpl', $msg));
    }
    $cs_temp_get = file_get_contents($tpl_path . '/' . $tpl_file);
    $tpl_path = $wp . $tpl_path;

    $pattern = "=\<link(.*?)href\=\"(?!http)(.*?)\"(.*?)\>=i";
    $cs_temp_get = preg_replace($pattern, "<link\\1href=\"" . $tpl_path . "/\\2\"\\3>", $cs_temp_get);
    $pattern = "=background\=\"(?!http)(.*?)\"=i";
    $cs_temp_get = preg_replace($pattern, "background=\"" . $tpl_path . "/\\1\"", $cs_temp_get);
    $pattern = "=src\=\"(?!http)(.*?)\"=i";
    $cs_temp_get = preg_replace($pattern, "src=\"" . $tpl_path . "/\\1\"", $cs_temp_get);

    cs_scriptload('clansphere', 'javascript', 'js/clansphere.js');
    cs_scriptload('clansphere', 'javascript', 'js/ajax.js');

    global $cs_main;
    $cs_main['scripts'] = empty($cs_main['scripts']) ? '' : $cs_main['scripts'];
    $cs_temp_get = str_replace('</head>', $cs_main['scripts'] . '</head>', $cs_temp_get);

    if (!empty($cs_main['debug'])) {
        $script = '<div id="debug"><span id="errors">{func:errors}</span><span id="sql">{func:sql}</span></div>';
        $cs_temp_get = preg_replace('=\<body(.*?)\>=si', '<body\\1>' . $script, $cs_temp_get);
    }
    if (!empty($account['users_ajax']) && !empty($account['access_ajax'])) {
      $var = empty($cs_main['mod_rewrite']) ? 0 : 1;
      $cs_temp_get = str_replace('<body>', '<body onload="initializeAJAX('.$var.','.$cs_main['ajax_reload'].')">', $cs_temp_get);
      $content = strpos($cs_temp_get,'id="content"') === false ? '<div id="content"></div>' : '';
      
      $ajaxes = explode(',',$cs_main['ajax_navlists']);
      if (!empty($ajaxes)) {
        if (strpos($cs_temp_get,'id="cs_users_navlogin"') === false)
          $cs_temp_get = str_replace(array('{users:navlogin}','{users:navlogin2}','{users:navlogin}3','{users:navlogin4}'),array('<div id="cs_users_navlogin">{users:navlogin}</div>','<div id="cs_users_navlogin2">{users:navlogin2}</div>','<div id="cs_users_navlogin3">{users:navlogin3}</div>','<div id="cs_users_navlogin4">{users:navlogin4}</div>'),$cs_temp_get);
        $spans = array('count_navday','count_navone','count_navall','count_navmon','func_parse','func_queries');
        foreach ($ajaxes as $ajax) {
          $placeholder = '{'.str_replace('_',':',$ajax).'}';
          if (strpos($cs_temp_get,'id="cs_'.$ajax.'"') === false) {
            $el = !in_array($ajax,$spans) ? 'div' : 'span';
            $cs_temp_get = str_replace($placeholder,'<'.$el.' id="cs_'.$ajax.'">' . $placeholder . '</'.$el.'>',$cs_temp_get); }
        }
      }
    }
    if (empty($account['users_ajax']) || empty($account['access_ajax'])) {
      $content = str_replace(array('{', '}'), array('&#123;', '&#125;'), cs_filecontent($cs_main['show']));
      $content = preg_replace_callback('/<script([^>]*)>([^<]*)<\/script>/is', 'cs_revert_script_braces', $content);
    }
    $cs_temp_get = str_replace('{func:show}', $content, $cs_temp_get);
    $cs_temp_get = preg_replace_callback('={url(_([\w]*?))?:(.*?)(_(.*?))?(:(.*?))?}=i', 'cs_templateurl', $cs_temp_get);
    $cs_temp_get = preg_replace_callback("={(?!func)(.*?):(.*?)(:(.*?))*}=i", 'cs_templatefile', $cs_temp_get);

    // Set title proper related to module
    if (!empty($cs_main['mod']))
        $cs_main['def_title'] = $cs_main['def_title'] . ' - ' . ucfirst($cs_main['mod']);

    $cs_main['def_title'] = htmlspecialchars($cs_main['def_title'], ENT_QUOTES);
    $cs_temp_get = str_replace('{func:title}', $cs_main['def_title'], $cs_temp_get);
    $cs_temp_get = str_replace('{func:charset}', $com_lang['charset'], $cs_temp_get);
    $cs_temp_get = str_replace('{func:queries}', $cs_logs['queries'], $cs_temp_get);
    $cs_logs['php_errors'] = nl2br($cs_logs['php_errors']);
    $cs_logs['errors'] = nl2br($cs_logs['errors']);
    $cs_temp_get = str_replace('{func:errors}', $cs_logs['php_errors'] . $cs_logs['errors'], $cs_temp_get);
    $cs_logs['sql'] = nl2br(htmlspecialchars($cs_logs['sql'], ENT_QUOTES));
    $cs_temp_get = str_replace('{func:sql}', $cs_logs['sql'], $cs_temp_get);
    $getparse = cs_parsetime($cs_micro);
    $cs_temp_get = str_replace('{func:parse}', $getparse, $cs_temp_get);
    $getmemory = function_exists('memory_get_usage') ? cs_filesize(memory_get_usage()) : '-';
    $cs_temp_get = str_replace('{func:memory}', $getmemory, $cs_temp_get);

    return $cs_temp_get;
}

?>