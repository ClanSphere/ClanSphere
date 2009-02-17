<?php
// ClanSphere 2008 - www.clansphere.net
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
          $out = $modul_now == $mod['dir'] ? $mod['name'] :
            cs_link($mod['name'],$mod['dir'],$mod['action'],'id=' . $id);
          $var .= $out . "\r\n - ";
      }
    }
  }
  $var = substr($var,0,-3);
  return $var;
}

if(!function_exists('str_ireplace')) {
  function str_ireplace ($search, $replace, $subject) {
    $search = preg_quote($search, "/");
    return preg_replace("/".$search."/i", $replace, $subject);
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

    static $modules = array();
    if(!isset($modules[$dir])) {
        global $account;
        $filename = $dir . '_' . $account['users_lang'] . '.tmp';
        if(file_exists('uploads/cache/' . $filename)) {
            $modules[$dir] = unserialize(file_get_contents('uploads/cache/' . $filename));
        }
        else {
            require_once('system/core/cachegen.php');
            $modules[$dir] = cs_cachegen($filename, $dir);
        }
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

function cs_datereal($mode,$time = 0) {

  $time = empty($time) ? cs_time() : $time;
    $time = cs_timediff($time);
  return date($mode,$time);
}

function cs_datepost($name,$mode) {

  $var = 0;
  if(!empty($_POST[$name . '_year']) AND !empty($_POST[$name . '_month']) AND
    !empty($_POST[$name . '_day'])) {
    if($mode == 'unix') {
      global $account;
      $var = mktime($_POST[$name . '_hours'], $_POST[$name . '_mins'] , 0,
      $_POST[$name . '_month'], $_POST[$name . '_day'], $_POST[$name . '_year']);
      $var = cs_timediff($var,1);
    }
    elseif($mode == 'date') {
      $var = $_POST[$name . '_year'] . '-' . $_POST[$name . '_month'] . '-' . $_POST[$name . '_day'];
    }
  }
  return $var;
}

function cs_dateselect($name,$mode,$data,$year_start = 0) {

  $real_start = $mode == 'unix' ? 1970 : 1950;
  $year_start = empty($year_start) ? $real_start : $year_start;

  if(empty($data)) {
    $explode = array(0 => 0, 1 => 0, 2=> 0, 3=> 0, 4=> 0);
  }
  elseif($mode == 'date') {
    $explode = explode('-', $data);
  }
  elseif($mode == 'unix') {
    $explode[0] = cs_datereal('Y',$data);
    $explode[1] = cs_datereal('m',$data);
    $explode[2] = cs_datereal('d',$data);
    $explode[3] = cs_datereal('H',$data);
    $explode[4] = cs_datereal('i',$data);
  }
  $year_end = cs_datereal('Y') + 4;
  $year = cs_html_select(1,$name . '_year');
  $year .= cs_html_option('----',0,0);
  while($year_start<$year_end) {
    $sel = $explode[0] == $year_start ? 1 : 0;
    $year .= cs_html_option($year_start,$year_start,$sel);
    $year_start++;
  }
  $year .= cs_html_select(0);

  $month_start = 1;
  $month_end = 13;
  $month = cs_html_select(1,$name . '_month');
  $month .= cs_html_option('----',0,0);
  while($month_start<$month_end) {
    $month_value = $month_start < 10 ? '0' . $month_start : $month_start;
    $explode[1] == $month_value ? $sel = 1 : $sel = 0;
    $month .= cs_html_option($month_start,$month_value,$sel);
    $month_start++;
  }
  $month .= cs_html_select(0);

  $day_start = 1;
  $day_end = 32;
  $day = cs_html_select(1,$name . '_day');
  $day .= cs_html_option('----',0,0);
  while($day_start<$day_end) {
    $day_value = $day_start < 10 ? '0' . $day_start : $day_start;
    $explode[2] == $day_value ? $sel = 1 : $sel = 0;
    $day .= cs_html_option($day_start,$day_value,$sel);
    $day_start++;
  }
  $day .= cs_html_select(0);

  $var = $year . ' - ' . $month . ' - ' . $day;
  if($mode == 'unix') {
    $hours = cs_html_input($name . '_hours',$explode[3],'text',2,2);
    $mins = cs_html_input($name . '_mins',$explode[4],'text',2,2);
    $var .= ' T ' . $hours . ' : ' . $mins;
  }
  return $var;
}

function cs_dropdown($name,$list,$array,$select = 0, $key = 0) {

  global $com_lang;

  $key = empty($key) ? $name : $key;
  $var = cs_html_select(1,$name);
  $var .= cs_html_option('----',0,0);
  $loop = count($array);
  for($run=0; $run < $loop; $run++) {
    $sel = $select == $array[$run][$key] ? 1 : 0;
    $content =   htmlentities($array[$run][$list], ENT_QUOTES, $com_lang['charset']);
    $var .= cs_html_option($content,$array[$run][$key],$sel);
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

function cs_filesize($size, $float = 2) {

  $name = array(0 => 'Byte', 1 => 'KiB', 2 => 'MiB', 3 => 'GiB', 4 => 'TiB');
  $digits = 0;
  while($size >= 1024) {
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

  global $cs_main, $com_lang;
  $subject = $cs_main['def_org'] . ' - ' . $title;
  $from = empty($from) ? $cs_main['def_mail'] : $from;
  $type = empty($type) ? 'text/plain' : $type;
  $headers = "From: " . $from . "\r\n";
  $headers .= "Content-type: " . $type . "; charset=" . $com_lang['charset'];
  $headers .= "Reply-To: " . $from;
  $headers .= "MIME-Version: 1.0";
  $headers .= "X-Mailer: PHP/" . phpversion();

  $result = mail($email,$subject,$message,$headers) ? TRUE : FALSE;
  return $result;
}

// Sends a private message
function cs_message($users_id=0, $messages_subject, $messages_text, $users_id_to) {

  $messages_cells = array(  'users_id',
                            'messages_time',
                            'messages_subject',
                            'messages_text',
                            'users_id_to',
                            'messages_show_receiver');

  $messages_save = array(   $users_id,
                            cs_time(),
                            $messages_subject,
                            $messages_text,
                            $users_id_to,
                            1 );

  cs_sql_insert(__FILE__,'messages',$messages_cells,$messages_save);

}

// Gets the notification setting for the current user
function cs_notifications($notification_name = '', $users_id = 0) {
  global $account;
  $users_id = empty($users_id) ? $account['users_id'] : $users_id;
  $data = cs_sql_select(__FILE__, 'notifications', $notification_name, 'users_id = ' . $users_id);
  return $data[$notification_name];
}

// Notifies a person upon its notification settings
function cs_notify($email='', $title='', $message='', $users_id=0, $notification_name = '', $type = 1) {
  $type = empty($notification_name) ? $type : cs_notifications($notification_name, $users_id);
  switch($type) {
    // No notification
    case 0:
      return;
      break;

    // eMail notification
    case 1:
      cs_mail($email,$title,$message);
      break;

    // PM notification
    case 2:
      cs_message(0, $title, $message, $users_id);
      break;

    default:
      return;
      break;
  }
}

function cs_pages($mod,$action,$records,$start,$where = 0,$sort = 0, $limit = 0, $small = 0) {

  global $account, $cs_lang;
  $limit = empty($limit) ? $account['users_limit'] : $limit;
  $add_where = empty($where) ? '' : '&amp;where=' . $where;
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
  $result = empty($small) ? cs_link('&lt;',$mod,$action,$more) . ' ' : '';

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
  $result .= empty($small) ? ' ' . cs_link('&gt;',$mod,$action,$more): '';
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
        if($filename != '.' && $filename != '..' && $filename != '.svn' && $filename != '_svn') {
          $path_array[$filename] = 0;
        }
      }
      closedir($goal);
    }
  }
  else {
    $scandir = is_dir($dir) ? scandir($dir) : array();
    foreach($scandir as $filename) {
      if($filename != '.' && $filename != '..' && $filename != '.svn' && $filename != '_svn') {
        $path_array[$filename] = 0;
      }
    }
  }
  return $path_array;
}

function cs_sort($mod,$action,$start,$where,$up,$active = 0,$more = 0) {

  $down = $up + 1;
  $add_start = empty($start) ? '' : '&amp;start=' . $start;
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

function cs_timediff($unix = 0, $reverse = 0) {

    global $account;
    $unix = empty($reverse) ? ($unix + $account['users_timezone']) : ($unix - $account['users_timezone']);
    if(empty($account['users_dstime']) AND date('I',$unix) != '0' OR $account['users_dstime'] == 'on') {
        $unix = empty($reverse) ? ($unix + 3600) : ($unix - 3600);
    }
    return $unix;
}

function cs_translate($mod = '') {

  global $account, $cs_main, $cs_lang, $cs_lang_main;

  if (empty($mod)) {
     $lang = empty($account['users_lang']) ? $cs_main['def_lang'] : $account['users_lang'];
     include 'lang/'.$lang.'/system/main.php';
     return $cs_lang;
  }

  $cs_lang = array_merge($cs_lang, $cs_lang_main);
  $file = 'lang/' . $account['users_lang'] . '/' . $mod . '.php';

  if(file_exists($file)) {
    include $file;
    return $cs_lang;
  } else {
    cs_error($file,'cs_translate - File not found');
    return $cs_lang;
  }
}

function cs_unlink($mod, $filename, $sub = '') {

  global $cs_main;
  $path = $cs_main['def_path'] . '/uploads/' . $mod . '/';
  $path = $sub == '' ? $path : $path . str_replace('..','',$sub) . '/';
  $target = $path . str_replace('..','',$filename);
  if(unlink($target)) {
    return TRUE;
  }
  else {
    cs_error($target,'cs_unlink - Failed to remove the file');
    return FALSE;
  }
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

function cs_ajaxfiles_clear() {
  if (!empty($_SESSION['ajaxuploads'])) {
    foreach ($_SESSION['ajaxuploads'] as $name) {
      @unlink('uploads/cache/' . $name);
    }
    unset($_SESSION['ajaxuploads']);
  }
}

function cs_files() {
  
  global $cs_main;
  global $account;
  
  if (!empty($_FILES) || $cs_main['php_self']['basename'] != 'content.php' || empty($account['users_ajax']) || empty($_SESSION['ajaxuploads']) || (!empty($_SESSION['ajaxuploads']) && empty($_POST))) {
    cs_ajaxfiles_clear();
    return $_FILES;
  }
  
  $files = array();
  foreach ($_SESSION['ajaxuploads'] as $key => $name) {
    $files[$key]['tmp_name'] = 'uploads/cache/' . $name;
    $files[$key]['name'] = $name;
    $files[$key]['size'] = @filesize($files[$key]['tmp_name']);
  }
  
  return $files;
}

function cs_url($mod, $action = 'list', $more = 0, $base = 0) {

  global $cs_main, $account;
  if(!file_exists('mods/' . $mod . '/' . $action . '.php')) {
    cs_error('mods/' . $mod . '/' . $action . '.php','cs_url - File not found');
  }

  $return = $cs_main['php_self']['dirname'];

  if(empty($cs_main['mod_rewrite'])) {
    $base = empty($base) ? $cs_main['php_self']['basename'] : $base . '.php';
    $return .= $base . '?mod=' . $mod . '&amp;action=' . $action;
    return empty($more) ? $return : $return . '&amp;' . $more;
  }
  else {
    $return .= basename($cs_main['php_self']['basename'], '.php') . '/' . $mod . '/' . $action;
    return empty($more) ? $return : $return . '/' . strtr($more, array('&amp;' => '/', '=' => '/', '&' => '/'));
  }
}

function cs_user($users_id, $users_nick, $users_active = 1) {
  settype($users_id, 'integer');

  return !empty($users_active) ? cs_link($users_nick, 'users', 'view', 'id=' . $users_id) : $users_nick;
}

function cs_userstatus($laston = 0, $invisible = 0, $mode = 0) {

  $cs_lang = cs_translate('system/userstatus');

  $on_now = cs_time() - 300;
  $on_week = cs_time() - 604800;

  if ($mode == 1 || $mode == 2) {
    $style = 'padding: 4px 0 4px 0; color:';
    $text = $on_now <= $laston && empty($invisible) ? cs_html_div(1,$style.'#00FF00') . $cs_lang['online']  . cs_html_div(0) : cs_html_div(1,$style.'maroon') . $cs_lang['offline'] . cs_html_div(0);
    if ($on_week >= $laston) $text = cs_html_div(1,$style.'#555') . $cs_lang['inactive']   . cs_html_div(0);
  }
  if ($mode != 1) {
    $icon = $on_now <= $laston && empty($invisible) ? 'green' : 'red';
    if($on_week >= $laston) $icon = 'grey';
    $icon = cs_html_img('symbols/clansphere/' . $icon . '.gif');
  }
  if ($mode == 1) return $text;
  return $mode == 2 ? $icon . ' ' . $text : $icon;

}

?>