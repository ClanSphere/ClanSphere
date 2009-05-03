<?php
// ClanSphere 2009 - www.clansphere.net
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
$diff_count = 0;
$total_diff = $cs_lang['total_diff'];

$missing_file = $cs_lang['missing_file'];
$lang_mods = cs_checkdirs('mods');

$run = 0;
$data['diff'] = array();

if(empty($lang_mods))
  $data['diff'][0] = array('file' => '', 'diff' => '');

foreach($lang_mods AS $mods) {
  $file_origine = 'lang/' . $lang_diff . '/' . $mods['dir'] . '.php';
  $file_lang = 'lang/' . $dir . '/' . $mods['dir'] . '.php';
  
  if(file_exists($file_origine)) {
    if(file_exists($file_lang)) {
      $diff = 0;
      $cs_lang = array();
      include $file_origine;
      $cs_lang_default = $cs_lang;
      if(!empty($php_ok)) {
        $cs_lang = array();
        include $file_lang;
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

$data['count']['total'] = sprintf($total_diff,$diff_count);

echo cs_subtemplate(__FILE__,$data,'clansphere','lang_view');