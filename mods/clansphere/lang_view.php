<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$dir = empty($_GET['dir']) ? '' : $_GET['dir'];

if(empty($dir) OR !preg_match("=^[_a-z0-9-]+$=i",$dir)) { 
  $dir = $cs_main['def_lang'];
}

$lang_diff = $dir == 'German' ? 'English' : 'German';

include('lang/' . $dir . '/info.php');

$data['lang_view']['name'] = $mod_info['name'];
$data['lang_view']['version'] = $mod_info['version'];
$data['lang_view']['mod_released'] = cs_date('date',$mod_info['released']);
$data['lang_view']['creator'] = $mod_info['creator'];
$data['lang_view']['mod_team'] = $mod_info['team'];
$data['lang_view']['mod_url'] = cs_html_link('http://' . $mod_info['url'],$mod_info['url']);
$data['lang_view']['mod_desc'] = $mod_info['text'];

$php_ok = version_compare(phpversion(),'5.1.0','>=');

# note: translation of countries is not checked
$lang_mods = cs_checkdirs('mods');

$lang_more = array('system/main' => array('dir' => 'system/main'), 'system/abcodes' => array('dir' => 'system/abcodes'));

$lang_mods = array_merge($lang_mods, $lang_more);

$data['diff'] = array();

if(empty($lang_mods))
  $data['diff'][0] = array('file' => '', 'diff' => '');

$run   = 0;
$files = 0;
$count = 0;
$diff_count = 0;

$missing_file = $cs_lang['missing_file'];
$total_diff   = $cs_lang['total_diff'];
$lang_stats   = $cs_lang['lang_stats'];

foreach($lang_mods AS $mods) {

  $file_origine = 'lang/' . $lang_diff . '/' . $mods['dir'] . '.php';
  $file_lang = 'lang/' . $dir . '/' . $mods['dir'] . '.php';

  if(file_exists($file_origine)) {
    if(file_exists($file_lang)) {
      $files++;
      $diff = 0;
      $cs_lang = array();
      include $file_origine;
      $cs_lang_default = $cs_lang;
      if(!empty($php_ok)) {
        $cs_lang = array();
        include $file_lang;
        $count += count($cs_lang);
        $diff = array_diff_key($cs_lang_default, $cs_lang);
        if(!empty($diff)) {
          $var = '';
          foreach ($diff AS $out => $res) {
            $var .= $out . ', ';
          }
          $diff = substr($var,0,-2);
        }
      }      
    }
  else {
      $diff = $missing_file;
    }
  }

  if(!empty($diff)) {
    $data['diff'][$diff_count]['file'] = $file_lang;
    $data['diff'][$diff_count]['diff'] = $diff;
    $diff_count++;
    $run++;
  }
}

$data['count']['total'] = sprintf($total_diff, $diff_count);
$data['count']['stats'] = sprintf($lang_stats, $files, $count);

echo cs_subtemplate(__FILE__,$data,'clansphere','lang_view');