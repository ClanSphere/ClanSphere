<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_addons($modul,$action,$id,$modul_now) {

  global $account, $cs_main;
  $show = $modul . '/' . $action;
  $addons = cs_checkdirs('mods',$show);
  $count = count($addons);
  $var = '';

  if(!empty($count)) {
      foreach($addons as $mod) {
        $acc_dir = 'access_' . $mod['dir'];
        if(array_key_exists($acc_dir,$account) AND $account[$acc_dir] >= $mod['show'][$show]) {
          $mod['action'] = $modul == $mod['dir'] ? $action : $modul;
          $out = $modul_now == $mod['dir'] ? $mod['name'] : cs_link($mod['name'],$mod['dir'],$mod['action'],'id=' . $id);

          if($mod['dir'] == $modul) {
            if($modul == 'users') {
              $cs_user = cs_sql_select(__FILE__,'users','users_nick, users_active, users_delete','users_id = ' . $id);
              $user = cs_user($id,$cs_user['users_nick'], $cs_user['users_active'], $cs_user['users_delete']);
              $var = $mod['name'] . ' - ' . $user . cs_html_hr('100%') . $var;
            }
            else {
              $cs_refer = cs_sql_select(__FILE__,$modul,$modul . '_name',$modul . '_id = ' . $id);
              $name = cs_secure($cs_refer[$modul . '_name']);
              $var = $mod['name'] . ' - ' . cs_link($name,$modul,$action,'id=' . $id) . cs_html_hr('100%') . $var;
            }
          }
          else {
            if(!empty($mod['references'][$modul])) {
              /*
              * @TODO ACCESS rights (usersgallery) for count columns
              */
              $column = empty($mod['references'][$modul . '_column']) ? $modul . '_id' : $mod['references'][$modul . '_column'];
              $more = empty($mod['references'][$modul . '_where']) ? '' : ' AND (' . $mod['references'][$modul . '_where'] . ')';

            $count = cs_sql_count(__FILE__, $mod['references'][$modul], $column . ' = ' . $id . $more);
          
              $var .= $out . " (" . $count . ")\r\n - ";
            }
            else {
              $var .= $out . "\r\n - ";
            }
          }
      }
    }
  }
  $var = substr($var,0,-3);
  return $var;
}

function cs_ajaxfiles_clear() {

  if (!empty($_SESSION['ajaxuploads'])) {
    foreach ($_SESSION['ajaxuploads'] as $name) {
      if(file_exists('uploads/cache/' . $name))
        unlink('uploads/cache/' . $name);
    }
    unset($_SESSION['ajaxuploads']);
  }
}

function cs_captchacheck($input, $mini = 0) {

  if(!extension_loaded('gd'))
    return true;

  $ip = cs_getip();
  $timeout = cs_time() - 900;
  $string = empty($mini) ? cs_sql_escape($input) : 'mini_' . cs_sql_escape($input);
  $cond  = 'captcha_ip = \'' . cs_sql_escape($ip) . '\' AND ';
  $cond .= 'captcha_time > \'' . $timeout . '\' AND ';
  $cond .= 'captcha_string = \'' . $string . '\'';

  $hash_db = cs_sql_select(__FILE__,'captcha','captcha_id',$cond);

  if(empty($hash_db))
    return false;

  cs_sql_delete(__FILE__,'captcha',$hash_db['captcha_id']);
  return true;
}

function cs_checkdirs($dir,$show = 0) {

  global $account;
  static $modules = array();
  if(!isset($modules[$dir])) {
    $modules[$dir] = cs_cache_dirs($dir, $account['users_lang']);
  }

  if(empty($show)) {
    $clean = $modules[$dir];
  }
  else {
    $clean = array();
    foreach($modules[$dir] AS $target) {
      if(isset($target['show'][$show])) {
        $create = $target['name'];
        $clean[$create] = $target;
      }
    }
  }
  return $clean;
}

function cs_date($mode,$data,$show_time = 0, $show_date = 1, $format = 0) {

  global $com_lang;
  if($mode=='date' AND preg_match('=-=',$data)) {
    $explode = explode('-', $data);
    $data = mktime(0,0,1,$explode[1],$explode[2],$explode[0]);
  }
  else {
    $data = cs_timediff($data);
  }
  $format = empty($format) ? $com_lang['dateset'] : $format;
  $var = empty($show_date) ? '' : date($format,$data);
  if(!empty($show_time)) {
    $var .= empty($show_date) ? '' : ' ' . $com_lang['dtcon'] . ' ';
    $var .= date($com_lang['timeset'],$data) . ' ' . $com_lang['timename'];
  }
  return $var;
}

function cs_datepost($name,$mode) {

  $time['year'] = empty($_POST[$name . '_year']) ? 0 : (int) $_POST[$name . '_year'];
  $time['month'] = empty($_POST[$name . '_month']) ? 1 : (int) $_POST[$name . '_month'];
  $time['day'] = empty($_POST[$name . '_day']) ? 1 : (int) $_POST[$name . '_day'];

  $var = '';
  if($mode == 'unix' AND $time['year'] >= 1970) {
    $time['mins'] = empty($_POST[$name . '_mins']) ? 0 : (int) $_POST[$name . '_mins'];
    $time['hours'] = empty($_POST[$name . '_hours']) ? 0 : (int) $_POST[$name . '_hours'];
    if(!empty($_POST[$name . '_ampm'])) {
      if($_POST[$name . '_ampm'] == 'pm' AND $time['hours'] < 12)
        $time['hours'] += 12;
      elseif($_POST[$name . '_ampm'] == 'am' AND $time['hours'] == 12)
        $time['hours'] = 0;
    }
    $var = mktime($time['hours'], $time['mins'] , 0, $time['month'], $time['day'], $time['year']);
    $var = cs_timediff($var, 1);
  }
  elseif($mode == 'date' AND $time['year'] >= 1950) {
    if(strlen($time['month']) == 1) $time['month'] = '0' . $time['month'];
    if(strlen($time['day']) == 1) $time['day'] = '0' . $time['day'];
    $var = $time['year'] . '-' . $time['month'] . '-' . $time['day'];
  }

  return $var;
}

function cs_datereal($mode,$time = 0, $reverse = 0) {

  $time = empty($time) ? cs_time() : $time;
  $time = cs_timediff($time, $reverse);
  return date($mode,$time);
}

function cs_dateselect($name,$mode,$time,$year_start = 0) {

  global $com_lang;
  $data = array();
  $data['date']['name'] = $name;
  $data['if']['ampm'] = 0;

  $real_start = $mode == 'unix' ? 1970 : 1950;
  $year_start = empty($year_start) ? $real_start : $year_start;

  if(empty($time)) {
    $explode = array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 'am');
  }
  elseif($mode == 'date') {
    $explode = explode('-', $time);
  }
  elseif($mode == 'unix') {
    $explode[0] = cs_datereal('Y',$time);
    $explode[1] = cs_datereal('m',$time);
    $explode[2] = cs_datereal('d',$time);
    $explode[4] = cs_datereal('i',$time);

    if(strpos($com_lang['timeset'], 'a') === false AND strpos($com_lang['timeset'], 'A') === false) {
      $explode[3] = cs_datereal('H',$time);
    }
    else {
      $explode[3] = cs_datereal('h',$time);
      $explode[5] = cs_datereal('a',$time);

      $data['if']['ampm'] = 1;
      $data['ampm']['options']  = cs_html_option('am', 'am', $explode[5] == 'am' ? 1 : 0);
      $data['ampm']['options'] .= cs_html_option('pm', 'pm', $explode[5] == 'pm' ? 1 : 0);
    }
  }

  #year
  $year_end = cs_datereal('Y') + 4;
  $data['year']['options'] = cs_html_option('----',0,0);
  while($year_start < $year_end) {
    $sel = $explode[0] == $year_start ? 1 : 0;
    $data['year']['options'] .= cs_html_option($year_start,$year_start,$sel);
    $year_start++;
  }

  #month
  $month_start = 1;
  $month_end = 13;
  $data['month']['options'] = '';
  while($month_start < $month_end) {
    $month_value = $month_start < 10 ? '0' . $month_start : $month_start;
    $explode[1] == $month_value ? $sel = 1 : $sel = 0;
    $data['month']['options'] .= cs_html_option($month_start,$month_value,$sel);
    $month_start++;
  }

  #day
  $day_start = 1;
  $day_end = 32;
  $data['day']['options'] = '';
  while($day_start < $day_end) {
    $day_value = $day_start < 10 ? '0' . $day_start : $day_start;
    $explode[2] == $day_value ? $sel = 1 : $sel = 0;
    $data['day']['options'] .= cs_html_option($day_start,$day_value,$sel);
    $day_start++;
  }

  #unix (hours + minutes)
  $data['if']['unix'] = 0;
  if($mode == 'unix') {
    $data['if']['unix'] = 1;
    $data['expl']['hours'] = $explode[3];
    $data['expl']['mins'] = $explode[4];
  }

  return cs_subtemplate(__FILE__,$data,'clansphere','dateselect');
}

function cs_dropdown($name,$list,$array,$select = 0, $key = 0, $def_option = 0) {

  global $cs_main;

  $key = empty($key) ? $name : $key;
  $var = cs_html_select(1,$name);
  if(empty($def_option)) {
    $var .= cs_html_option('----',0,0);
  }
  $array = is_array($array) ? $array : array();
  foreach($array AS $data) {
    $sel = $select == $data[$key] ? 1 : 0;
    $content = html_entity_decode($data[$list], ENT_QUOTES, $cs_main['charset']);
    $content = htmlentities($content, ENT_QUOTES, $cs_main['charset']);
    $var .= cs_html_option($content,$data[$key],$sel);
  }
  return $var . cs_html_select(0);
}

function cs_dropdownsel($data, $id, $index) {

  $count = count($data);
  for ($run = 0; $run < $count; $run++) {
    $data[$run]['selection'] = $id != $data[$run][$index] ? '' : ' selected="selected"';
  }
  return $data;
}

function cs_files() {

  global $account, $cs_main;
  if (!empty($_FILES) || empty($cs_main['ajaxrequest']) || empty($_SESSION['ajaxuploads']) || (!empty($_SESSION['ajaxuploads']) && empty($_POST))) {
    cs_ajaxfiles_clear();
    return $_FILES;
  }

  $files = array();
  foreach ($_SESSION['ajaxuploads'] as $key => $name) {
    $files[$key]['tmp_name'] = 'uploads/cache/' . $name;
    $files[$key]['name'] = $name;
    $files[$key]['size'] = filesize($files[$key]['tmp_name']);
    $files[$key]['type'] = cs_mimetype($files[$key]['tmp_name']);
  }
  return $files;
}

function cs_filesize($size, $float = 2) {

  $name = array(0 => 'Byte', 1 => 'KiB', 2 => 'MiB', 3 => 'GiB', 4 => 'TiB');
  $digits = 0;
  while($size >= 1024 AND $digits < 4) {
    $size = $size / 1024;
    $digits++;
  }
  $result = round($size,$float) . ' ' . $name[$digits];
  return $result;
}

function cs_icon($img,$size = 16,$alt = 0,$space = 1) {

  global $cs_main;
  $img = is_array($img) ? $img[1] : $img;
  $alt = empty($alt) ? '' : $alt;
  if(!empty($cs_main['img_path']) AND !empty($cs_main['img_ext'])) {
    $iconpath = 'symbols/' . $cs_main['img_path'] . '/' . $size . '/';
    $iconpath .= $img . '.' . $cs_main['img_ext'];
    if(file_exists($iconpath)) {
      $end = empty($space) ? '' : ' ';
      return cs_html_img($iconpath,$size,$size,0,$alt) . $end;
    }
    else {
      cs_error($iconpath,'cs_icon - File not found');
    }
  }
  else {
    return $alt;
  }
}

function cs_link($name,$mod,$action = 'list',$more = 0,$class = 0, $title = 0) {

    $url = cs_url($mod,$action,$more);
    return cs_html_link($url,$name,0,$class,$title);
}

function cs_mail($email,$title,$message,$from = 0,$type = 0) {

  include_once 'mods/contact/func_mail.php';

  $options = cs_sql_option(__FILE__, 'contact');
  $mail = cs_mail_prepare($email, $title, $message, $from, $type, $options);

  if(empty($options['smtp_host']))
    return cs_mail_send($mail);
  else
    return cs_mail_smtp($mail, $options);
}

function cs_mimetype ($file) {

  global $cs_main;
  if (function_exists('mime_content_type'))
    return mime_content_type($cs_main['def_path'] . '/' . $file);

  if (function_exists('finfo_open') && $fp = finfo_open(FILEINFO_MIME)) {
    $return = finfo_file($fp, $file);
    finfo_close($fp);
    return $return;
  }

  $zip_type = 'application/x-zip-compressed';
  $mimes = array('jpg' => 'image/jpeg','jpeg' => 'image/jpeg', 'jpe' => 'image/jpeg',
    'gif' => 'image/gif', '.zip' => $zip_type, 'png' => 'image/png');

  $ending = strtolower(substr(strrchr($file, '.'),1));
  return isset($mimes[$ending]) ? $mimes[$ending] : 'text/plain';
}

// Sends a private message
function cs_message($users_id = 0, $messages_subject, $messages_text, $users_id_to) {

  $messages_cells = array('users_id','messages_time','messages_subject','messages_text','users_id_to','messages_show_receiver');
  $messages_save = array($users_id,cs_time(),$messages_subject,$messages_text,$users_id_to,1);

  cs_sql_insert(__FILE__,'messages',$messages_cells,$messages_save);
}

function cs_pages($mod, $action, $records, $start, $where = 0, $sort = 0, $limit = 0, $small = 0, $more = 0) {

  global $account;
  settype($sort, 'integer');
  settype($start, 'integer');
  settype($limit, 'integer');

  if(empty($limit))
    $limit = empty($account['users_limit']) ? 20 : $account['users_limit'];

  $add_where = empty($where) ? '' : '&amp;where=' . $where;
  $add_where .= empty($more) ? '' : '&amp;' . $more;
  $add_sort = empty($sort) ? '' : '&amp;sort=' . $sort;
  $pages = $records / $limit;
  if(round($pages) < $pages OR round($pages) < 1) {
    $pages++;
  }
  $pages = round($pages);
  $actual = empty($start) ? 1 : round($start / $limit) + 1;
  $maxpages = $pages >= 9 ? 9 : $pages;
  $last = $actual <= 2 ? 0 : $start - $limit;
  $next = $actual >= $pages ? ($pages - 1) * $limit : $start + $limit;
  $more = 'start=' . $last . $add_where . $add_sort;
  $result = (empty($small) AND $actual != 1) ? cs_link('&lt;',$mod,$action,$more) . ' ' : '';

  $run = 0;
  while($maxpages > 0) {
    $run++;
    if($pages > 9 AND $maxpages == 6 AND $actual > 5) {
      $result .= ' ... ';
      $run = $actual > $pages - 4 ? $pages - 5 : $actual - 1;
    }
    if($pages > 9 AND $maxpages == 3 AND ($actual + 4) < $pages) {
      $result .= ' ... ';
      $run = $pages - 2;
    }
    if($run == $actual AND empty($small)) {
      $result .= ' [' . $run . '] ';
    }
    else {
      $more = 'start=' . ($run - 1) * $limit . $add_where . $add_sort;
      $result .= ' ' . cs_link($run,$mod,$action,$more);
    }
    $maxpages--;
  }
  $more = 'start=' . $next . $add_where . $add_sort;
  $result .= (empty($small) AND $actual != $pages) ? ' ' . cs_link('&gt;',$mod,$action,$more): '';

  $cs_lang = cs_translate($mod);
  $result = $cs_lang['page'] . ' ' . $result;
  return $result;
}

function cs_paths($dir) {

  $path_array = array();
  $php_ok = version_compare(phpversion(),'5.1.0','>=');
  if(empty($php_ok)) {
    if(is_dir($dir)) {
      $goal = opendir($dir);
      while(false !== ($filename = readdir($goal))) {
        if($filename != '.' && $filename != '..' && $filename != '.git') {
          $path_array[$filename] = 0;
        }
      }
      closedir($goal);
    }
  }
  else {
    $scandir = is_dir($dir) ? scandir($dir) : array();
    foreach($scandir as $filename) {
      if($filename != '.' && $filename != '..' && $filename != '.git') {
        $path_array[$filename] = 0;
      }
    }
  }
  return $path_array;
}

function cs_sort($mod,$action,$start,$where,$up,$active = 0,$more = 0) {

  $down = $up + 1;
  $add_start = empty($start) ? '' : '&amp;start=' . (int) $start;
  $add_where = empty($where) ? '' : '&amp;where=' . $where;

  $file_up = $active == $up ? 'up_arrow_active.png' : 'up_arrow.png';
  $img_up = cs_html_img('symbols/clansphere/' . $file_up);
  $more2 = empty($more) ? "sort=" . $up . $add_start . $add_where : $more . "&amp;sort=" . $up . $add_start . $add_where;
  $result = cs_link($img_up,$mod,$action,$more2) . ' ';

  $file_down = $active == $down ? 'down_arrow_active.png' : 'down_arrow.png';
  $img_down = cs_html_img('symbols/clansphere/' . $file_down);
  $more3 = empty($more) ? "sort=" . $down . $add_start . $add_where : $more . "&amp;sort=" . $down . $add_start . $add_where;
  $result .= cs_link($img_down,$mod,$action,$more3) . ' ';

  return $result;
}

function cs_substr($string, $start, $length = 0) {

  # substr is based on byte offsets, but a real char offset is needed
  global $cs_main;
  if(function_exists('iconv_substr'))
    return iconv_substr($string, $start, $length, $cs_main['charset']);
  elseif(function_exists('mb_substr'))
    return mb_substr($string, $start, $length, $cs_main['charset']);
  else
    return substr($string, $start, $length);
}

function cs_timediff($unix = 0, $reverse = 0) {

    global $account;
    $unix = empty($reverse) ? ((int) $unix + $account['users_timezone']) : ((int)$unix - $account['users_timezone']);
    if(empty($account['users_dstime']) AND date('I',$unix) != '0' OR $account['users_dstime'] == 'on') {
        $unix = empty($reverse) ? ($unix + 3600) : ($unix - 3600);
    }
    return $unix;
}

function cs_translate($mod, $main = 0) {

  global $account, $cs_main;
  $lang = empty($account['users_lang']) ? $cs_main['def_lang'] : $account['users_lang'];
  static $lang_main = 0;
  static $lang_mods = array();
  $cs_lang = array();

  if(empty($lang_main)) {
    require 'lang/'.$lang.'/system/main.php';
    $lang_main = $cs_lang;
    $cs_lang = array();
  }

  if(empty($lang_mods[$mod])) {
    $file = 'lang/' . $lang . '/' . $mod . '.php';
    if(file_exists($file)) {
      require $file;
      $lang_mods[$mod] = $cs_lang;
      if(!empty($main))
        $lang_main = array_merge($lang_main, $cs_lang);
    }
    else {
      cs_error($file,'cs_translate - File not found');
      $lang_mods[$mod] = array('mod' => $mod, 'mod_info' => '');
    }
  }

  return array_merge($lang_main, $lang_mods[$mod]);
}

function cs_unlink($mod, $filename, $sub = '') {

  global $cs_main;
  $path = $cs_main['def_path'] . '/uploads/' . $mod . '/';
  $path = $sub == '' ? $path : $path . str_replace('..','',$sub) . '/';
  $target = $path . str_replace('..','',$filename);
  if(is_file($target)) {
    if(unlink($target)) {
      return TRUE;
    }
    else {
      cs_error($target,'cs_unlink - Failed to remove the file');
      return FALSE;
    }
  }
  else
    return FALSE;
}

function cs_upload($mod,$filename,$upname, $ajaxclean = 1) {

  global $cs_main;
  $path = $cs_main['def_path'] . '/uploads/' . $mod . '/';
  $target = $path . $filename;
  $bool = empty($_SESSION['ajaxuploads']) ? move_uploaded_file($upname,$target) : rename($upname,$target);
  if($bool) {
    chmod($target,0755);
    $return = true;
  } else {
    $message = is_writable($path) ? 'cs_upload - Failed to save the file' :
      'cs_upload - Failed to save the file because of missing permission';
    cs_error($target,$message);
    $return  = false;
  }
  if (!empty($ajaxclean)) cs_ajaxfiles_clear();
  return $return;
}

function cs_url($mod, $action = 'list', $more = 0, $base = 0, $placeholder = 0) {

  global $cs_main, $account;
  if(!file_exists('mods/' . $mod . '/' . $action . '.php'))
  {
    if(empty($placeholder))
      cs_error('mods/' . $mod . '/' . $action . '.php','cs_url - File not found');
    else
      return $action == 'list' ? '{url:' . $mod . '}' : '{url:' . $mod . '_' . $action . '}';
  }

  $return = $cs_main['php_self']['dirname'];

  if(empty($cs_main['mod_rewrite'])) {
    $base = empty($base) ? $cs_main['php_self']['basename'] : $base . '.php';
    $return .= $base . '?mod=' . $mod . '&amp;action=' . $action;
    return empty($more) ? $return : $return . '&amp;' . $more;
  }
  else {
    $base = empty($base) ? $cs_main['php_self']['filename'] : $base;
    $return .= $base . '/' . $mod . '/' . $action;
    return empty($more) ? $return : $return . '/' . strtr($more, array('&amp;' => '/', '=' => '/', '&' => '/'));
  }
}

function cs_url_self($full = 0, $ignore_post = 0, $decode = 0) {

  global $cs_main;
  if(empty($ignore_post) AND !empty($_POST))
    return false;

  if(empty($cs_main['mod_rewrite'])) {
    $request = empty($_SERVER['REQUEST_URI']) ? '' : $_SERVER['REQUEST_URI'];
    $ajax = strrpos($request, '&xhr=');
    $url = empty($ajax) ? $request : substr($request, 0, $ajax);
  }
  else {
    $request = empty($cs_main['php_self']['params']) ? '' : $cs_main['php_self']['params'];
    $url = $cs_main['php_self']['dirname'] . $cs_main['php_self']['filename'] . $request;
  }

  # do not use htmlspecialchars with charset in this function due to website
  $url = htmlspecialchars($url, ENT_QUOTES);
  $url = empty($full) ? $url : $cs_main['php_self']['website'] . $url;
  if(empty($decode))
    return $url;
  else
    return html_entity_decode($url, ENT_QUOTES);
}

function cs_user($users_id, $users_nick, $users_active = 1, $users_delete = 0) {

  settype($users_id, 'integer');
  $users_nick = cs_secure($users_nick);
  if(!empty($users_active) && empty($users_delete))
    return cs_link($users_nick, 'users', 'view', 'id=' . $users_id);
  else
    return $users_nick;
}

function cs_userstatus($laston = 0, $invisible = 0, $mode = 0) {

  global $cs_main;
  $cs_lang = cs_translate($cs_main['mod']);
  $on_now = cs_time() - 300;
  $on_week = cs_time() - 604800;

  if ($mode == 1 || $mode == 2) {
    $text = $on_now <= $laston && empty($invisible) ? '<div class="uonline">' . $cs_lang['online']  . '</div>' :
      '<div class="uoffline">' . $cs_lang['offline'] . '</div>';
    if ($on_week >= $laston) $text = '<div class="uinactive">' . $cs_lang['inactive']   .'</div>';
  }
  if ($mode != 1) {
    $icon = $on_now <= $laston && empty($invisible) ? 'green' : 'red';
    if($on_week >= $laston) $icon = 'grey';
    $icon = cs_html_img('symbols/clansphere/' . $icon . '.gif');
  }
  if ($mode == 1) return $text;
  return $mode == 2 ? $icon . ' ' . $text : $icon;
}