<?php

$data = array();
chdir($cs_main['def_path'].'/lang/');
$goal = opendir('.');
$run_1 = 0;

while(false !== ($language = readdir($goal))) {
  if(is_dir($language)) {
    if($language{0} == '.') continue;
    $data['languages'][$run_1]['name'] = $language;
    $data['languages'][$run_1]['modules'] = array();
    
    $run_2 = 0;
    $goal2 = opendir($language);
    while (false !== ($module = readdir($goal2))) {
      if($module{0} == '.' || substr($module, -4) != '.php') continue;
      $module = substr($module,0,-4);
      $data['languages'][$run_1]['modules'][$run_2]['name'] = $module;
      $run_2++;
    }
    closedir($goal2);
    $run_1++;
  }
}

chdir($cs_main['def_path']);
closedir($goal);

echo cs_subtemplate(__FILE__,$data,'clansphere','lang_validate');