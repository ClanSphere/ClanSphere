<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

# clear old cache content to get actual results
$languages = cs_checkdirs('lang');
foreach($languages AS $ln)
  cs_cache_delete('templates_' . $ln['dir']);

$templates = cs_checkdirs('templates');
$tpl_all = count($templates);

$activate = isset($_GET['activate']) ? $_GET['activate'] : 0;
$activate = $activate == 'install' ? 0 : $activate;
$allow = 0;
if(!empty($activate)) {
  foreach($templates as $mod) {
    if($mod['dir'] == $activate) {
      $allow++;
    }
  }
  if (!empty($allow)) {
    $cond = "options_mod = 'clansphere' AND options_name = 'def_tpl' AND options_value = '" . $activate . "'";
    $already = cs_sql_count(__FILE__,'options',$cond);
    if (!empty($already)) $allow = 0;
  }
}

$data['if']['done'] = false;

if($account['access_wizard'] == 5) {
  $wizard = cs_sql_count(__FILE__,'options',"options_name = 'done_temp' AND options_value = '1'");
  if(empty($wizard)) {
    $data['if']['done'] = true;
    $data['link']['wizard'] = cs_link($cs_lang['show'],'wizard','roots') . ' - ' . cs_link($cs_lang['task_done'],'wizard','roots','handler=temp&amp;done=1');
  }
}

if(!empty($activate) AND !empty($allow)) {
  require_once 'mods/clansphere/func_options.php';
  $save = array();
  $save['def_tpl'] = $activate;
  if(isset($templates[ucfirst($activate)]['themes'])) {
      $themes = cs_checkdirs('themes');
      if(isset($themes[ucfirst($templates[ucfirst($activate)]['themes'])])) {
          $save['def_theme'] = $templates[ucfirst($activate)]['themes'];
      }
    }
    cs_optionsave('clansphere', $save);
  
  $msg = file_exists('themes/'.$activate) ? $cs_lang['theme_found'] . cs_link($cs_lang['change_to_this'],'clansphere','themes_list','activate='.$activate) : $cs_lang['success'];
  
  cs_redirect($msg,'clansphere','temp_list');
}
else {
  $data['lang']['getmsg'] = cs_getmsg();
  
  $run = 0;
  
  foreach($templates as $mod) {
    
    if ($mod['dir'] == 'install') {
      $tpl_all--;
      continue;
    }
    
    $data['temp_list'][$run]['name'] = $mod['name'];
    $data['temp_list'][$run]['dir'] = $mod['dir'];
    $data['temp_list'][$run]['version'] = $mod['version'];
    $data['temp_list'][$run]['date'] = cs_date('date',$mod['released']);
    $data['temp_list'][$run]['if']['active'] = $mod['dir'] == $cs_main['template'] ? 1 : 0;
    $data['temp_list'][$run]['if']['def'] = $mod['dir'] == $cs_main['def_tpl'] ? 1 : 0;

    $run++;
  }
}

$data['lang']['body'] = sprintf($cs_lang['body_temp_list'],$tpl_all);
$data['link']['cache'] = cs_url('clansphere','cache');

echo cs_subtemplate(__FILE__,$data,'clansphere','temp_list');