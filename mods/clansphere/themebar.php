<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_themebar($source, $string, $mod, $action) {

  global $cs_main, $account; 
  // themebar has some side-effects, so it is forbidden in a few mod/action combinations
  $forbidden = array('abcode/sourcebox', 'clansphere/debug', 'clansphere/navmeta', 'clansphere/themebar', 'errors/500', 'pictures/select');
  if(!in_array($mod . '/' . $action, $forbidden)) {

    // prevent from double inserting the xsrf protection key
    $xsrf = $cs_main['xsrf_protection'];
    $cs_main['xsrf_protection'] = false;

    $data = array();
    $data['data']['content'] = $string;
    $data['raw']['target'] = 'themes/' . $cs_main['def_theme'] . '/' . $mod . '/' . $action . '.tpl';
    $data['raw']['langfile'] = 'lang/' . $account['users_lang'] . '/' . $mod . '.php';
    $phpsource = str_replace('\\', '/', str_replace($cs_main['def_path'], '', $source));
    $data['raw']['phpsource'] = substr($phpsource, 1, strlen($phpsource));

    // use lightweight version if explorer is not available
    if(empty($account['access_explorer']))
      $string = cs_subtemplate(__FILE__, $data, 'clansphere', 'themebar_light');
    else {
      include_once 'mods/explorer/functions.php';
      $data['link']['target'] = cs_explorer_path($data['raw']['target'], 'escape');
      $data['link']['langfile'] = cs_explorer_path($data['raw']['langfile'], 'escape');
      $data['link']['phpsource'] = cs_explorer_path($data['raw']['phpsource'], 'escape');
      $string = cs_subtemplate(__FILE__, $data, 'clansphere', 'themebar');
    }

    // reset the xsrf protection option
    $cs_main['xsrf_protection'] = $xsrf;
  }
  return $string;
}