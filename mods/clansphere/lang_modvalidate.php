<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

if((substr(phpversion(), 0, 3) >= '5.0') AND (substr(phpversion(), 0, 3) < '6.0'))
  @error_reporting(E_ALL | E_STRICT);
else
  @error_reporting(E_ALL);

@ini_set('arg_separator.output','&amp;');
@ini_set('session.use_trans_sid','0');
@ini_set('session.use_cookies','1');
@ini_set('session.use_only_cookies','1');
@ini_set('display_errors','on');
@ini_set('magic_quotes_runtime','off');

if(substr(phpversion(), 0, 3) >= '5.1')
  @date_default_timezone_set('Europe/Berlin');

$cs_micro = explode(' ', microtime()); # starting parsetime
$cs_logs = array('php_errors' => '', 'errors' => '', 'sql' => '', 'queries' => 0, 'warnings' => 0, 'dir' => 'logs');

chdir('../../');
require 'system/core/functions.php';
@set_error_handler("php_error");

require 'system/core/servervars.php';
require 'system/core/tools.php';
require 'system/core/abcode.php';
require 'system/core/templates.php';
require 'system/output/xhtml_10_old.php';

if(file_exists('setup.php')) {
    
  require 'setup.php';
  require 'system/database/' . $cs_db['type'] . '.php';
  $cs_db['con'] = cs_sql_connect($cs_db);
  unset($cs_db['pwd']);
  unset($cs_db['user']);

  $cs_main = cs_sql_option(__FILE__,'clansphere');

  require 'system/core/content.php';
  require 'system/core/account.php';

  cs_tasks('system/extensions', 1); # load extensions
  cs_tasks('system/runstartup'); # load startup files

  $cs_main['debug'] = false;
}
else
  cs_error_internal('setup');


$language = $_GET['language'];
$module = $_GET['module'];
$fix = !isset($_GET['fix']) ? 0 : 1;

$file = 'lang/' . $language . '/' . $module . '.php';

if(!file_exists($file)) {
  echo 'Datei nicht gefunden: ' . $file;
  return;
}

$cs_main['mod'] = 'clansphere';
$cs_main['action'] = 'lang_modvalidate';

if($account['access_clansphere'] < 5) {
  echo 'Kein Zugriff';
  return;
}

$cs_lang = array();
include 'lang/' . $language . '/system/main.php';
$cs_lang_global = $cs_lang;
$errors_count = 0;
$count_line = 0;
$data = array();
$cs_lang_main = cs_translate();
$cs_lang2 = cs_translate('clansphere');
$cs_lang = array();
$file_new = '';

function cs_validate ($matches) {
  global $cs_lang, $cs_lang_global;
  
  $result = '';
  
  if(array_key_exists($matches[1],$cs_lang)) {
    $result = 'same';
    if($cs_lang[$matches[1]] != $matches[3])
      $result .= $cs_lang[$matches[1]];
  } elseif (array_key_exists($matches[1],$cs_lang_global)) {
    $result = 'main';
    if($cs_lang_global[$matches[1]] != $matches[3])
      $result .= $cs_lang_global[$matches[1]];
  }
  return $result;
}

$fp = file($file);

foreach ($fp AS $line) {
  $count_line++;
  
  if(substr($line,0,9) != '$cs_lang[' || strpos($line,'.=') !== false || substr($line,-3,1) != ';' || strpos($line,'"') !== false) {
    $file_new .= $line;
    continue;
  }
  
  $result = preg_replace_callback('=\$cs_lang\[\'(.*?)\'\](.*?)\'(.*?)\';=si',"cs_validate",$line);
  $result = trim($result);
  
  if(empty($result)) {
    eval($line);
    $file_new .= $line;
  }
  else {
    ob_start();
    highlight_string('<?php ' . $line . ' ?>');
    $string = ob_get_contents();
    ob_end_clean();
    $search = array('&lt;?php&nbsp;',
                '<br />&nbsp;</span><span style="color: #0000BB">?&gt;</span>',
                '<br />&nbsp;</font><font color="#0000BB">?&gt;</font>');
    $string = str_replace($search,array('','</span>','</font>'),$string);
    $data['errors'][$errors_count]['line'] = $count_line;
    $data['errors'][$errors_count]['file'] = substr($result,0,4);
    $data['errors'][$errors_count]['text'] = $string;
    $data['errors'][$errors_count]['old_value'] = substr($result,4);
    $data['errors'][$errors_count]['type'] = empty($data['errors'][$errors_count]['old_value']) ? $cs_lang2['repetition'] : $cs_lang2['overwrite'];
    
    $file_new .= empty($data['errors'][$errors_count]['old_value']) ? '' : $line;
    
    $errors_count++;
  }
}

if(!empty($fix)) {
  $fp2 = fopen($file,'w');
  fwrite($fp2,$file_new);
  fclose($fp2);
  
  $cs_lang = array();
  include 'lang/' . $language . '/system/main.php';
  $cs_lang_global = $cs_lang;
  $errors_count = 0;
  $count_line = 0;
  $data = array();
  $cs_lang_main = cs_translate();
  $cs_lang2 = cs_translate('clansphere');
  $cs_lang = array();
  $file_new = '';
  $fp = file($file);

  foreach($fp AS $line) {
  
    $count_line++;
    
    if(substr($line,0,9) != '$cs_lang[' || strpos($line,'.=') !== false || substr($line,-3,1) != ';' || strpos($line,'"') !== false) {
      $file_new .= $line;
      continue;
    }
    
    $result = preg_replace_callback('=\$cs_lang\[\'(.*?)\'\](.*?)\'(.*?)\';=si',"cs_validate",$line);
    $result = trim($result);
    
    if(empty($result)) {
      eval($line);
      $file_new .= $line;
    }
  else {
    ob_start();
      highlight_string('<?php ' . $line . ' ?>');
      $string = ob_get_contents();
      ob_end_clean();
      $search = array('&lt;?php&nbsp;',
                  '<br />&nbsp;</span><span style="color: #0000BB">?&gt;</span>',
                  '<br />&nbsp;</font><font color="#0000BB">?&gt;</font>');
      $string = str_replace($search,array('','</span>','</font>'),$string);
      $data['errors'][$errors_count]['line'] = $count_line;
      $data['errors'][$errors_count]['file'] = substr($result,0,4);
      $data['errors'][$errors_count]['text'] = $string;
      $data['errors'][$errors_count]['old_value'] = substr($result,4);
      $data['errors'][$errors_count]['type'] = empty($data['errors'][$errors_count]['old_value']) ? $cs_lang2['repetition'] : $cs_lang2['overwrite'];
      
      $file_new .= empty($data['errors'][$errors_count]['old_value']) ? '' : $line;
      
      $errors_count++;
    }
  }
}

if(empty($errors_count)) {
  echo 'Keine Fehler vorhanden.';
  return;
}

$cs_lang = $cs_lang2;

$data['info']['lang'] = $language;
$data['info']['mod'] = $module;

ob_start();
highlight_string($file_new);
$data['file']['fixed'] = ob_get_contents();
ob_end_clean();

echo cs_subtemplate(__FILE__,$data,'clansphere','lang_modvalidate');

chdir('mods/clansphere/');

?>