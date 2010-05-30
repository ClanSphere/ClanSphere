<?php
// ClanSphere 2009 - www.clansphere.net
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
  $more = empty($matches[7]) ? 0 : str_replace(':', '&amp;', $matches[7]);
  $base = empty($matches[2]) ? 0 : $matches[2];

  return cs_url($matches[3], $action, $more, $base);
}

function cs_subtemplate($source, $data, $mod, $action = 'list', $navfiles = 0)
{
  global $cs_lang, $cs_main;
  $cs_lang = cs_translate($mod);
  $micro = explode(' ', microtime());

  $cs_main['cellspacing'] = isset($cs_main['cellspacing']) ? $cs_main['cellspacing'] : 0;
  $cs_main['def_theme'] = empty($cs_main['def_theme']) ? 'base' : $cs_main['def_theme'];

  $target = 'themes/' . $cs_main['def_theme'] . '/' . $mod . '/' . $action . '.tpl';
  if ($cs_main['def_theme'] != 'base' and !file_exists($target))
  {
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
    
  if(!empty($navfiles))
    $string = preg_replace_callback("={(?!func)(.*?):(.*?)(:(.*?))*}=i", 'cs_templatefile', $string);

  global $account;
  if(!empty($cs_main['themebar']) AND (!empty($cs_main['developer']) OR $account['access_clansphere'] > 4)) {

    $forbidden = array('abcode/sourcebox', 'clansphere/debug', 'clansphere/navmeta', 'clansphere/themebar', 'errors/500', 'pictures/select');
    if(!in_array($mod . '/' . $action, $forbidden)) {

      $data = array();
      $data['data']['load'] = cs_parsetime($micro,5);
      $data['data']['target'] = $target;
      $data['data']['content'] = $string;
      $data['data']['langfile'] = 'lang/' . $account['users_lang'] . '/' . $mod . '.php';
      $phpsource = str_replace('\\', '/', str_replace($cs_main['def_path'], '', $source));
      $data['data']['phpsource'] = substr($phpsource, 1, strlen($phpsource));
      $string = cs_subtemplate(__FILE__, $data, 'clansphere', 'themebar');
    }
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
	
	/*
		TODO: Refactor this:
		- make use an array() named $persistent_params
		- the array contains a list of paramters that should be kept during the redirect
		
		$persistent_params = array('xhr', 'xhr_navlists')
	*/
	if (isset($_REQUEST['xhr'])) {
		$more = explode('#', $more);
	 	$more = $more[0]; 
		if(!empty($more)) $more .= '&';
		$more .= 'xhr=1';
		if(isset($_REQUEST['xhr_navlists'])) {
			$more .= '&xhr_navlists=' . $_REQUEST['xhr_navlists']; 
		}
		for($i=1,$c=count($more);$i<$c;$i++)
		{
			$more .= '#' . $more[$i];
		}
	} 
	/*
	----------
	*/
	$more = empty($more) ? 0 : $more;
		
  $url = str_replace('&amp;', '&', cs_url($mod, $action, $more));
	
	
	header('location: ' . $url);
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
  if(!isset($cs_main['scriptload']))
    $cs_main['scriptload'] = array('javascript' => '', 'stylesheet' => '');

  $target = $cs_main['php_self']['dirname'] . 'mods/' . $mod . '/' . $file;
  $script = '';

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

function cs_template($cs_micro, $tpl_file = 'index.htm')
{
  global $account, $cs_logs, $cs_main;
  $wp = $cs_main['php_self']['dirname'];

  if ((empty($cs_main['public']) or $tpl_file == 'admin.htm') and $account['access_clansphere'] < $cs_main['maintenance_access'])
  {
    $cs_main['show'] = 'mods/users/login.php';
    $tpl_file = 'login.htm';
  }

  $cs_main['template'] = empty($account['users_tpl']) ? $cs_main['def_tpl'] : $account['users_tpl'];
  if (!empty($_GET['template'])) $cs_main['template'] = str_replace(array('.','/'),'',$_GET['template']);
  if (!empty($_SESSION['tpl_preview'])) { $cs_main['template'] = str_replace(array('.','/'),'',$_SESSION['tpl_preview']); }

  if ($tpl_file == 'error.htm') $cs_main['template'] = 'install';
  $tpl_path = 'templates/' . $cs_main['template'];
  if (!file_exists($tpl_path . '/' . $tpl_file))
  {
    cs_error($tpl_path . '/' . $tpl_file, 'cs_template - Template not found');
    $msg = 'Template not found: ' . $tpl_path . '/' . $tpl_file;
    if($tpl_file != 'error.htm')
      die(cs_error_internal('tpl', $msg));
    else
      die($msg);
  }
  $cs_temp_get = file_get_contents($tpl_path . '/' . $tpl_file);
  $tpl_path = $wp . $tpl_path;

  $pattern = "=\<link(.*?)href\=\"(?!http|\/)(.*?)\"(.*?)\>=i";
  $cs_temp_get = preg_replace($pattern, "<link\\1href=\"" . $tpl_path . "/\\2\"\\3>", $cs_temp_get);
  $pattern = "=background\=\"(?!http|\/)(.*?)\"=i";
  $cs_temp_get = preg_replace($pattern, "background=\"" . $tpl_path . "/\\1\"", $cs_temp_get);
  $pattern = "=src\=\"(?!http|\/)(.*?)\"=i";
  $cs_temp_get = preg_replace($pattern, "src=\"" . $tpl_path . "/\\1\"", $cs_temp_get);

  cs_scriptload('ajax', 'javascript', 'js/ajax.js', 1);
  cs_scriptload('clansphere', 'javascript', 'js/clansphere.js', 1);
  cs_scriptload('clansphere', 'javascript', 'js/jquery.js', 1);

  global $cs_main;
  if(!empty($cs_main['scriptload']['stylesheet']))
    $cs_temp_get = str_replace('</head>', $cs_main['scriptload']['stylesheet'] . '</head>', $cs_temp_get);
  if(!empty($cs_main['scriptload']['javascript']))
    $cs_temp_get = str_replace('</body>', $cs_main['scriptload']['javascript'] . '</body>', $cs_temp_get);

  $content = cs_contentload($cs_main['show']);

  if (isset($cs_main['ajax']) && $cs_main['ajax'] == 2 || (!empty($account['users_ajax']) && !empty($account['access_ajax']))) {
    $cs_temp_get = str_replace('<body', '<body onload="Clansphere.initialize('.$cs_main['mod_rewrite'].',\''.$_SERVER['PHP_SELF'].'\','.$cs_main['ajax_reload'].')"', $cs_temp_get);
    if (strpos($cs_temp_get,'id="content"') === false) $content = '<div id="content">' . $content . '</div>';
    $ajaxes = explode(',',$cs_main['ajax_navlists']);
    if (!empty($cs_main['debug'])) {
      $ajaxes[] = 'func_parse';
      $ajaxes[] = 'func_queries';
     }
    if (!empty($ajaxes)) {
      if (strpos($cs_temp_get,'id="cs_navlist_users_navlogin"') === false)
        $cs_temp_get = preg_replace("={users:navlogin(.*?)}=i", "<div id=\"cs_navlist_users_navlogin\" class=\"csp_navlist\">{users:navlogin\\1}</div>", $cs_temp_get);
      $spans = array('count_navday','count_navone','count_navall','count_navmon','count_navyes','func_parse','func_queries');
      foreach ($ajaxes as $ajax) {
        $placeholder = '{'.str_replace('_',':',$ajax).'}';
        if (strpos($cs_temp_get,'id="cs_navlist_'.$ajax.'"') === false) {
          $el = !in_array($ajax,$spans) ? 'div' : 'span';
          $cs_temp_get = str_replace($placeholder,'<'.$el.' id="cs_navlist_'.$ajax.'" class="csp_navlist">' . $placeholder . '</'.$el.'>',$cs_temp_get); }
      }
    }
  }

  $cs_temp_get = str_replace('{func:show}', $content, $cs_temp_get);
  $cs_temp_get = preg_replace_callback('={url(_([\w]*?))?:(.*?)(_(.*?))?(:(.*?))?}=i', 'cs_templateurl', $cs_temp_get);
  $cs_temp_get = preg_replace_callback("={(?!func)(.*?):(.*?)(:(.*?))*}=i", 'cs_templatefile', $cs_temp_get);
  $cs_temp_get = str_replace('{func:charset}', $cs_main['charset'], $cs_temp_get);
  $cs_temp_get = str_replace('{func:queries}', $cs_logs['queries'], $cs_temp_get);

  # Provide the def_title and a title with mod and page info
  $title_website = htmlentities($cs_main['def_title'], ENT_QUOTES, $cs_main['charset']);
  $cs_temp_get = str_replace('{func:title_website}', $title_website, $cs_temp_get);
  $cs_act_lang = cs_translate($cs_main['mod']);
  $title = ($cs_main['mod'] == 'static' AND $cs_main['action'] == 'view') ? $title_website : $title_website . ' - ' . $cs_act_lang['mod_name'];
  if(!empty($cs_main['page_title']))
    $title .= ' - ' . htmlentities($cs_main['page_title'], ENT_QUOTES, $cs_main['charset']);
  $cs_temp_get = str_replace('{func:title}', $title, $cs_temp_get);

  $logsql = '';
  if (!empty($cs_main['developer']) OR $account['access_clansphere'] > 4) {
    $cs_logs['php_errors'] = nl2br($cs_logs['php_errors']);
    $cs_logs['errors'] = nl2br($cs_logs['errors']);
    if(is_array($cs_logs['sql']))
      foreach($cs_logs['sql'] AS $sql_file => $sql_queries) {
        $logsql .= cs_html_big(1) . str_replace('\\', '\\\\', $sql_file) . cs_html_big(0) . cs_html_br(1);
        $logsql .= nl2br(htmlentities($sql_queries, ENT_QUOTES, $cs_main['charset']));
      }
  }
  else {
    $cs_logs['php_errors'] = '';
    $cs_logs['errors'] = 'Developer mode is turned off';
  }

  if (!empty($cs_main['debug'])) {
    $data = array('data');
    $data['data']['log_sql'] = $logsql;
    $data['data']['php_errors'] = $cs_logs['php_errors'];
    $data['data']['csp_errors'] = $cs_logs['errors'];
    $script = cs_subtemplate(__FILE__, $data, 'clansphere', 'debug');
    $cs_temp_get = preg_replace('=\<body(.*?)\>=si', '<body\\1>' . $script, $cs_temp_get, 1);
  }

  $cs_temp_get = str_replace('{func:errors}', $cs_logs['php_errors'] . $cs_logs['errors'], $cs_temp_get);
  $cs_temp_get = str_replace('{func:sql}', $logsql, $cs_temp_get);
  $getparse = cs_parsetime($cs_micro);
  $cs_temp_get = str_replace('{func:parse}', $getparse, $cs_temp_get);
  $getmemory = function_exists('memory_get_usage') ? cs_filesize(memory_get_usage()) : '-';
  if (function_exists('memory_get_peak_usage')) $getmemory .= ' [peak ' . cs_filesize(memory_get_peak_usage()) . ']';
  $cs_temp_get = str_replace('{func:memory}', $getmemory, $cs_temp_get);

  if(extension_loaded('zlib'))
    ob_start('ob_gzhandler');

  return $cs_temp_get;
}