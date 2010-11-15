<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$data = array();

$data['charset']['result_setup_file']  = '';
$data['charset']['result_tpl_setting'] = '';
$data['charset']['result_web_setting'] = '';
$data['charset']['result_sql_setting'] = '';

# Check for correct setup.php charset information
$charset = strtolower($cs_main['charset']);
if($charset != 'utf-8' AND cs_substr($charset, 0, 9) != 'iso-8859-') {
  $data['charset']['result_setup_file'] = $cs_lang['charset_unexpected'] . ' : ' . $cs_main['charset'];
  $data['charset']['result_setup_file'] .= cs_html_br(2) . $cs_lang['charset_unexpected_hint'];
}

# Check every .htm file in the activated template for a matching charset definition
$tpl_charset = array();
$tpl_files = cs_paths('templates/' . $cs_main['def_tpl']);
foreach($tpl_files AS $file => $int)
  if(strtolower(substr($file,-4,4)) == '.htm') {
    $filename = 'templates/' . $cs_main['def_tpl'] . '/' . $file;
    $fp = fopen($filename, 'r');
    $tpl_content = fread($fp, filesize($filename));
    fclose($fp);

    preg_match_all("=(charset|encoding)\s*\=\s*\"*(.*?)(\s+|\")=si", $tpl_content, $tpl_check);
    if(empty($tpl_check[2])) {
      $data['charset']['result_tpl_setting'] .= $cs_lang['charset_missing'] . cs_html_br(1);
      $data['charset']['result_tpl_setting'] .= $cs_lang['file'] . ': ' . $filename . cs_html_br(2);
    }
    foreach($tpl_check[2] AS $found) {
      $foundlow = strtolower($found);
      if($foundlow != '{func:charset}' AND $foundlow != $charset) {
        $data['charset']['result_tpl_setting'] .= $cs_lang['charset_unexpected'] . ' : ' . $found . cs_html_br(1);
        $data['charset']['result_tpl_setting'] .= $cs_lang['file'] . ': ' . $filename . cs_html_br(2);
      }
      else $tpl_charset[$foundlow] = $found;
    }
  }
if(!empty($data['charset']['result_tpl_setting'])) $data['charset']['result_tpl_setting'] .= $cs_lang['charset_tpl_hint'];

# Check for charset information inside the .htaccess file
$web_charset = '';
$file = $cs_main['def_path'] . '/.htaccess';
if(file_exists($cs_main['def_path'] . '/web.config'))
  $web_charset = 'IIS default';
if(file_exists($file)) {
  $fp = fopen($file, 'r');
  $web_content = fread($fp, filesize($file));
  fclose($fp);

  preg_match_all("=(#\s*|)adddefaultcharset\s+(.*?)\s+=si", $web_content, $web_check, PREG_SET_ORDER);
  foreach($web_check AS $found) {
    if(substr($found[1],0,1) != '#') {
      if(!empty($found[2])) $web_charset = $found[2];
      $foundlow = strtolower($found[2]);
      if($foundlow != $charset) {
        $data['charset']['result_web_setting'] .= $cs_lang['charset_unexpected'] . ' : ' . $found[2] . cs_html_br(1);
        $data['charset']['result_web_setting'] .= $cs_lang['file'] . ': ' . $file . cs_html_br(2);
      }
    }
  }
}
if(empty($web_charset)) {
  $data['charset']['result_web_setting'] .= $cs_lang['charset_missing'] . cs_html_br(1);
  $data['charset']['result_web_setting'] .= $cs_lang['file'] . ': ' . $file . cs_html_br(2);
}
if(!empty($data['charset']['result_web_setting']))
  $data['charset']['result_web_setting'] .= $cs_lang['charset_web_hint'];

# Check for possible SQL related charset problems
$sql_info = cs_sql_version(__FILE__);
$sql_charset = strtolower($sql_info['encoding']);
$sql_valid = 0;
if($charset == 'utf-8' AND ($sql_charset == 'utf-8' OR $sql_charset == 'utf8' OR $sql_charset == 'unicode'))
  $sql_valid = 1;
elseif(cs_substr($charset, 0, 9) == 'iso-8859-' AND (cs_substr($sql_charset, 0, 9) == 'iso-8859-' OR cs_substr($sql_charset,0,5) == 'latin'))
  $sql_valid = 1;
elseif($sql_charset == 'default' OR $sql_charset == 'pdo encoding')
  $sql_valid = 1;
else
  $data['charset']['result_sql_setting'] = $cs_lang['charset_unexpected'] . ' : ' . $sql_info['encoding'];

# Check for MySQL version 4.1.8 or above due to charset / collation support
$data['if']['old_mysql'] = 0;
global $cs_db;
$ext_mysql = array('mysql', 'mysqli', 'pdo_mysql');
if(in_array($cs_db['type'], $ext_mysql)) {
  $myv = explode('.', $sql_info['server']);
  settype($myv[2], 'integer');
  if($myv[0] < 4 OR $myv[0] == 4 AND $myv[1] < 1 OR $myv[0] == 4 AND $myv[1] == 1 AND $myv[2] < 8)
    $data['if']['old_mysql'] = 1;
}

# Define test result icons
$data['charset']['check_setup_file']  = empty($data['charset']['result_setup_file'])  ? cs_icon('submit') : cs_icon('stop');
$data['charset']['check_tpl_setting'] = empty($data['charset']['result_tpl_setting']) ? cs_icon('submit') : cs_icon('stop');
$data['charset']['check_web_setting'] = empty($data['charset']['result_web_setting']) ? cs_icon('submit') : cs_icon('stop');
$data['charset']['check_sql_setting'] = empty($data['charset']['result_sql_setting']) ? cs_icon('submit') : cs_icon('stop');

# Add positive results to output variables
if(empty($data['charset']['result_setup_file']))  $data['charset']['result_setup_file']  = $cs_main['charset'];
if(empty($data['charset']['result_tpl_setting']))
  foreach($tpl_charset AS $lowercase => $found)
    $data['charset']['result_tpl_setting'] .= $found . cs_html_br(1);
if(empty($data['charset']['result_web_setting'])) $data['charset']['result_web_setting'] = $web_charset;
if(empty($data['charset']['result_sql_setting'])) $data['charset']['result_sql_setting'] = $sql_info['encoding'];

echo cs_subtemplate(__FILE__, $data, 'clansphere', 'charset');