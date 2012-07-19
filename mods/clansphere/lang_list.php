<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

# clear old cache content to get actual results
$languages = cs_checkdirs('lang');
foreach($languages AS $ln)
  cs_cache_delete('lang_' . $ln['dir']);

$languages = cs_checkdirs('lang');
$lng_all = count($languages);

$activate = isset($_GET['activate']) ? $_GET['activate'] : 0;
$allow = 0;

if(!empty($activate)) {
  foreach($languages as $mod) {
    if($mod['dir'] == $activate) {
    $allow++;
  }
  }
}

$data['lang']['body'] = sprintf($cs_lang['languages_list'],$lng_all);
$data['link']['cache'] = cs_url('clansphere','cache');

$data['if']['done'] = false;

if($account['access_wizard'] == 5) {
  $wizard = cs_sql_count(__FILE__,'options',"options_name = 'done_lang' AND options_value = '1'");
  if(empty($wizard)) {
  $data['if']['done'] = true;
  $data['link']['wizard'] = cs_link($cs_lang['show'],'wizard','roots') . ' - ' . cs_link($cs_lang['task_done'],'wizard','roots','handler=lang&amp;done=1');
  }
}

if(!empty($activate) AND !empty($allow)) {

  require_once 'mods/clansphere/func_options.php';
  $save['def_lang'] = $activate;
  cs_optionsave('clansphere', $save);

  cs_redirect($cs_lang['change'],'clansphere','lang_list');
}
else {
  $data['lang']['getmsg'] = cs_getmsg();

  $run = 0;
  
  if(empty($languages)) {
    $data['lang_list'] = '';
  }
  
  foreach($languages as $mod) {
  $data['lang_list'][$run]['icon'] = $mod['symbol'];
  $data['lang_list'][$run]['name'] = $mod['name'];
  $data['lang_list'][$run]['link'] = cs_url('clansphere','lang_view','dir=' . $mod['dir']);
  $data['lang_list'][$run]['version'] = $mod['version'];
  $data['lang_list'][$run]['date'] = cs_date('date',$mod['released']);
  
  if($mod['dir'] == $cs_main['def_lang']) {
    $data['lang_list'][$run]['active'] = cs_icon('submit','16',$cs_lang['yes']);
    }
  else {
    $data['lang_list'][$run]['active'] = cs_link(cs_icon('cancel','16',$cs_lang['no']),'clansphere','lang_list','activate=' . $mod['dir']);
  }
  $run++;
  }
}

echo cs_subtemplate(__FILE__,$data,'clansphere','lang_list');