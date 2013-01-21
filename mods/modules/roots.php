<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('modules');

# clear old cache content to get actual results
$languages = cs_checkdirs('lang');
foreach($languages AS $ln)
  cs_cache_delete('mods_' . $ln['dir']);

$data = array();

$modules = cs_checkdirs('mods');
$mod_all = count($modules);

$data['if']['wizard'] = FALSE;

$data['head']['count'] = $mod_all;
$data['head']['getmsg'] = cs_getmsg();

if($account['access_wizard'] == 5) {
  $wizard = cs_sql_count(__FILE__,'options',"options_name = 'done_mods' AND options_value = '1'");
  if(empty($wizard)) {
  $data['if']['wizard'] = TRUE;
    $data['wizard']['roots'] = cs_link($cs_lang['show'],'wizard','roots');
    $data['wizard']['task_done'] = cs_link($cs_lang['task_done'],'wizard','roots','handler=mods&amp;done=1');
  }
}

$cs_access = cs_sql_select(__FILE__,'access','*',0,0,0,0);
$groups = count($cs_access);

$run = 0;
foreach($modules as $mod) {

  $data['mod'][$run]['icon'] = empty($mod['icon']) ? '' : cs_icon($mod['icon']); 
   $data['mod'][$run]['name_url'] = empty($mod['name']) ? '' : cs_link($mod['name'],'modules','view','dir=' . $mod['dir']);
  $data['mod'][$run]['version'] = empty($mod['version']) ? '' : $mod['version'];
  $data['mod'][$run]['released'] = empty($mod['released']) ? '' : cs_date('date',$mod['released']);
  
  $listed = isset($cs_access[0]['access_'.$mod['dir']]) ? 1 : 0;
  $access = 0;
  
  if (!empty($listed))
    for ($run2 = 0; $run2 < $groups; $run2++)
    $access += $cs_access[$run2]['access_'.$mod['dir']];
  
  if (!empty($listed) && !empty($access) && empty($mod['protected'])) {
    $data['mod'][$run]['protected'] = cs_link(cs_icon('gpg'),'modules','deactivate','dir=' . $mod['dir'],'',$cs_lang['deactivate']);
  } elseif (!empty($listed) && empty($mod['protected'])) {
    $data['mod'][$run]['protected'] = cs_link(cs_icon('submit'),'modules','accessedit','dir=' . $mod['dir'].'&amp;activate','',$cs_lang['activate']);
  } else {
    $data['mod'][$run]['protected'] = '';
  }
  
  $data['mod'][$run]['access'] = empty($listed) ? '' : cs_link(cs_icon('access'),'modules','accessedit','dir=' . $mod['dir'],'',$cs_lang['access']);

  $run++;
}

echo cs_subtemplate(__FILE__,$data,'modules','roots');