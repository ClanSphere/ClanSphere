<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$data = array();

$data['charset']['result_setup_file']  = '';
$data['charset']['result_tpl_setting'] = '';
$data['charset']['result_web_setting'] = '';
$data['charset']['result_php_setting'] = '';
$data['charset']['result_sql_setting'] = '';

# Check for PHP 5 or newer due to charset support
$data['if']['old_php'] = version_compare(phpversion(), 5, '<');

# Check for correct setup.php charset information
$charset = strtolower($cs_main['charset']);
if($charset != 'utf-8' AND substr($charset, 0, 9) != 'iso-8859-') {
  $data['charset']['result_setup_file'] = $cs_lang['charset_unexpected'] . ' : ' . $cs_main['charset'];
  $data['charset']['result_setup_file'] .= cs_html_br(2) . $cs_lang['charset_unexpected_hint'];
}

# Check every .htm file in the activated template for a matching charset definition
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
    }
  }
if(!empty($data['charset']['result_tpl_setting'])) $data['charset']['result_tpl_setting'] .= $cs_lang['charset_tpl_hint'];

$data['charset']['result_web_setting'] = 'To be done';
$data['charset']['result_php_setting'] = 'To be done';
$data['charset']['result_sql_setting'] = 'To be done';

$data['charset']['check_setup_file']  = empty($data['charset']['result_setup_file'])  ? cs_icon('submit') : cs_icon('stop');
$data['charset']['check_tpl_setting'] = empty($data['charset']['result_tpl_setting']) ? cs_icon('submit') : cs_icon('stop');
$data['charset']['check_web_setting'] = empty($data['charset']['result_web_setting']) ? cs_icon('submit') : cs_icon('stop');
$data['charset']['check_php_setting'] = empty($data['charset']['result_php_setting']) ? cs_icon('submit') : cs_icon('stop');
$data['charset']['check_sql_setting'] = empty($data['charset']['result_sql_setting']) ? cs_icon('submit') : cs_icon('stop');

if(empty($data['charset']['result_setup_file']))  $data['charset']['result_setup_file']  = $cs_lang['passed'];
if(empty($data['charset']['result_tpl_setting'])) $data['charset']['result_tpl_setting'] = $cs_lang['passed'];
if(empty($data['charset']['result_web_setting'])) $data['charset']['result_web_setting'] = $cs_lang['passed'];
if(empty($data['charset']['result_php_setting'])) $data['charset']['result_php_setting'] = $cs_lang['passed'];
if(empty($data['charset']['result_sql_setting'])) $data['charset']['result_sql_setting'] = $cs_lang['passed'];

echo cs_subtemplate(__FILE__, $data, 'clansphere', 'charset');