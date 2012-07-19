<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

# clear old cache content to get actual results
$languages = cs_checkdirs('lang');
foreach($languages AS $ln)
  cs_cache_delete('themes_' . $ln['dir']);

$themes = cs_checkdirs('themes');
$themes_count = count($themes);

if(!empty($_GET['activate'])) {
  foreach ($themes as $try) {
      if($try['dir'] == $_GET['activate']) {
        require_once 'mods/clansphere/func_options.php';
      $save['def_theme'] = $_GET['activate'];
      cs_optionsave('clansphere', $save);
          $current = $_GET['activate'];
      }
    }
}

$current = empty($current) ? $cs_main['def_theme'] : $current;

$data['lang']['body'] = sprintf($cs_lang['themes_listed'],$themes_count);
$data['link']['cache'] = cs_url('clansphere','cache');

$run = 0;

if(empty($themes)) {
  $data['themes_list'] = '';
}

foreach ($themes as $theme) {
  $data['themes_list'][$run]['name'] = $theme['name'];
  $data['themes_list'][$run]['active'] = $theme['dir'] != $current ? cs_link(cs_icon('cancel'),'clansphere','themes_list','activate='.$theme['dir']) : cs_icon('submit');
  $run++;
}

echo cs_subtemplate(__FILE__,$data,'clansphere','themes_list');