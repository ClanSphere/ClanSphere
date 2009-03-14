<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

if (!empty($_SESSION['tpl_preview'])) $ending = substr($_SESSION['tpl_preview'],-3);
if (!empty($ending) && $ending != '{2}') {
  $_SESSION['tpl_preview'] .= '{2}';
  die();
} elseif (!empty($ending)) {
	$cs_main['template'] = substr($_SESSION['tpl_preview'],0,-3);
	unset($_SESSION['tpl_preview']);
} elseif (!empty($_GET['template']) && !empty($account['users_ajax'])) {
  $_SESSION['tpl_preview'] = $_GET['template'];
  $shorten = "window.location.href = window.location.href.substr(0,window.location.href.lastIndexOf('template')); ";
  die(ajax_js($shorten . "window.location.reload();"));
}

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

$data['lang']['body'] = sprintf($cs_lang['body_temp_list'],$tpl_all);
$data['link']['cache'] = cs_url('clansphere','cache');

$data['if']['done'] = false;

if($account['access_wizard'] == 5) {
  $wizard = cs_sql_count(__FILE__,'options',"options_name = 'done_temp' AND options_value = '1'");
  if(empty($wizard)) {
    $data['if']['done'] = true;
    $data['link']['wizard'] = cs_link($cs_lang['show'],'wizard','roots') . ' - ' . cs_link($cs_lang['task_done'],'wizard','roots','handler=temp&amp;done=1');
  }
}

if(!empty($activate) AND !empty($allow)) {
  require('mods/clansphere/func_options.php');
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
  
  if(!empty($account['users_ajax']) && $cs_main['php_self']['filename'] == 'content') {
      cs_redirectmsg($msg);
      die(ajax_js('window.location.reload();'));
    } else {
      cs_redirect($msg,'clansphere','temp_list');
    }
}
else {
  $data['lang']['getmsg'] = cs_getmsg();
  
  $run = 0;
  
  if(empty($templates)) {
    $data['temp_list'] = '';
  }
  
  foreach($templates as $mod) {
    $data['temp_list'][$run]['name'] = $mod['name'];
    $data['temp_list'][$run]['link'] = cs_url('clansphere','temp_view','dir=' . $mod['dir']);
    $data['temp_list'][$run]['version'] = $mod['version'];
    $data['temp_list'][$run]['date'] = cs_date('date',$mod['released']);
    
    if ($mod['dir'] == 'install') {
    	$data['temp_list'][$run]['preview'] = cs_icon('editdelete','16','----');
    	$data['temp_list'][$run]['active'] = cs_icon('editdelete','16','----');
    	continue;
    }
    
    $data['temp_list'][$run]['preview'] = $mod['dir'] == $cs_main['template'] ? cs_icon('submit','16',$cs_lang['yes']) :
      cs_link(cs_icon('cancel','16',$cs_lang['no']),'clansphere','temp_list','template=' . $mod['dir']);
    $data['temp_list'][$run]['active'] = $mod['dir'] == $cs_main['def_tpl'] ? cs_icon('submit','16',$cs_lang['yes']) :
      cs_link(cs_icon('cancel','16',$cs_lang['no']),'clansphere','temp_list','activate=' . $mod['dir']);
    
    $run++;
  }
}

echo cs_subtemplate(__FILE__,$data,'clansphere','temp_list');

?>