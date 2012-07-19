<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_temp = cs_translate('clansphere');

$dir = empty($_GET['dir']) ? '' : $_GET['dir'];

if(empty($dir) OR !preg_match("=^[_a-z0-9-]+$=i",$dir)) { 
  $dir = $cs_main['def_tpl'];
}

include('templates/' . $dir . '/info.php');

$data['temp_view']['name'] = $mod_info['name'];
$data['temp_view']['version'] = $mod_info['version'];
$data['temp_view']['mod_released'] = cs_date('date',$mod_info['released']);
$data['temp_view']['creator'] = $mod_info['creator'];
$data['temp_view']['mod_team'] = $mod_info['team'];
$data['temp_view']['mod_url'] = cs_html_link('http://' . $mod_info['url'],$mod_info['url']);
$data['temp_view']['mod_desc'] = $mod_info['text'];

echo cs_subtemplate(__FILE__,$data,'clansphere','temp_view');