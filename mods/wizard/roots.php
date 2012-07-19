<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wizard');

$cs_options = cs_sql_option(__FILE__,'wizard');

$task_array = array(
  0 => array(
    'icon' => 'locale',
    'handler' => 'lang',
    'mod' => 'clansphere',
    'action' => 'lang_list'
  ),
  1 => array(
    'icon' => 'style',
    'handler' => 'temp',
    'mod' => 'clansphere',
    'action' => 'temp_list'
  ),
  2 => array(
    'icon' => 'package_system',
    'handler' => 'opts',
    'mod' => 'clansphere',
    'action' => 'options'
  ),
  3 => array(
    'icon' => 'knetconfig',
    'handler' => 'meta',
    'mod' => 'clansphere',
    'action' => 'metatags'
  ),
  4 => array(
    'icon' => 'looknfeel',
    'handler' => 'setp',
    'mod' => 'users',
    'action' => 'setup'
  ),
  5 => array(
    'icon' => 'personal',
    'handler' => 'prfl',
    'mod' => 'users',
    'action' => 'profile'
  ),
  6 => array(
    'icon' => 'kdmconfig',
    'handler' => 'clan',
    'mod' => 'clans',
    'action' => 'create'
  ),
  7 => array(
    'icon' => 'kontact',
    'handler' => 'cont',
    'mod' => 'contact',
    'action' => 'imp_edit'
  ),
  8 => array(
    'icon' => 'kcmdf',
    'handler' => 'mods',
    'mod' => 'modules',
    'action' => 'roots'
  ),
  9 => array(
    'icon' => 'log',
    'handler' => 'logs',
    'mod' => 'logs',
    'action' => 'roots'
  )
);

$handler = isset($_GET['handler']) ? $_GET['handler'] : 0;
if(!empty($handler)) {
  foreach($task_array as $step) {

    if($step['handler'] == $handler) {
      
      require_once 'mods/clansphere/func_options.php';
      
      $save = array();
      $save['done_' . $handler] = isset($_GET['done']) ? $_GET['done'] : 0;
      
      cs_optionsave('wizard', $save);
      $cs_options['done_' . $handler . ''] = $save['done_' . $handler];
      break;
    }
  }
}

$run = 0;
$done = 0;
$next = 0;
$next_task = '-';
$data = array('head' => array(),'wizard' => array());

foreach($task_array AS $step) {
  $data['wizard'][$run]['icon'] = cs_icon($step['icon'],48);
  $data['wizard'][$run]['link'] = cs_link($cs_lang['' . $step['handler'] . '_name'],$step['mod'],$step['action']);
  $data['wizard'][$run]['text'] = $cs_lang['' . $step['handler'] . '_text'];
  if(empty($cs_options['done_' . $step['handler'] . ''])) {
    $next_task = empty($next) ? cs_link($cs_lang['' . $step['handler'] . '_name'],$step['mod'],$step['action']) : $next_task;
    $data['wizard'][$run]['next'] = empty($next) ? '&gt;&gt; ' . $cs_lang['next_step'] . ' &lt;&lt;' : '';
    $data['wizard'][$run]['done'] = cs_link(cs_icon('cancel'),'wizard','roots','handler=' . $step['handler'] . '&amp;done=1');
    $data['wizard'][$run]['class'] = 'b';
    $next++;
  }
  else {
    $data['wizard'][$run]['next'] = '';
    $data['wizard'][$run]['done'] = cs_link(cs_icon('submit'),'wizard','roots','handler=' . $step['handler'] . '&amp;done=0');
    $data['wizard'][$run]['class'] = 'c';
    $done++;
  }
  $run++;
}

$data['head']['next_task'] = $cs_lang['next_step'] . ': ' . $next_task;
$data['head']['parts_done'] = sprintf($cs_lang['parts_done'],$done,$run);

echo cs_subtemplate(__FILE__,$data,'wizard','roots');