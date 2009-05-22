<?php
// ClanSphere 2009 - www.clansphere.net
// Id: view.php (Tue Nov 25 23:43:05 CET 2008) fAY-pA!N

$cs_lang = cs_translate('modules', 1);
$cs_lang = cs_translate('access', 1);

$data['if']['access_explorer'] = FALSE;

$dir = empty($_GET['dir']) ? $_REQUEST['where'] : $_GET['dir'];
if(empty($dir) OR !preg_match("=^[_a-z0-9-]+$=i",$dir)) { 
  $dir = $cs_main['def_mod'];
}

include('mods/' . $dir . '/info.php');

$data['mod']['name'] = $mod_info['name'];
$data['mod']['version'] = $mod_info['version'];
$data['mod']['released'] = cs_date('date',$mod_info['released']);
$data['mod']['protected'] = empty($mod_info['protected']) ? $cs_lang['no'] : $cs_lang['yes'];
$data['mod']['creator'] = $mod_info['creator'];
$data['mod']['team'] = $mod_info['team'];
$data['mod']['url'] = cs_html_link('http://' . $mod_info['url'],$mod_info['url']);
$data['mod']['icon_48'] = empty($mod_info['icon']) ? '' : cs_icon($mod_info['icon'],'48');
$data['mod']['icon_16'] = empty($mod_info['icon']) ? '' : cs_icon($mod_info['icon']);
$data['mod']['text'] = $mod_info['text'];

if(!empty($account['access_explorer'])) {
    $data['if']['access_explorer'] = TRUE;
    $data['extended']['link'] = cs_link($cs_lang['jump_to_explorer'],'explorer','roots','dir=mods/'.$dir.'/');
}


if(file_exists('mods/' . $dir . '/access.php')) {

  $sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];

  $data['sort']['file'] = cs_sort('modules','view',0,0,1,$sort,'dir=' . $dir);
  $data['sort']['access'] = cs_sort('modules','view',0,0,3,$sort,'dir=' . $dir);

  $axx_file = array();
  include 'mods/' . $dir . '/access.php';

  switch($sort) {
    case 1:
      krsort($axx_file);
    break;
    case 3:
      arsort($axx_file);
    break;
    case 4:
      asort($axx_file);
    break;
    default:
      ksort($axx_file);
  }

  $pre = /*$dir == 'clansphere' ? 'clansphere_' :*/ 'lev_';
  $run = 0;
  foreach($axx_file AS $list_name => $list_axx) {

    $data['axx'][$run]['file'] = $list_name . '.php';
    $data['axx'][$run]['access'] = $list_axx . ' - ' . $cs_lang[$pre . $list_axx];
    
    $run++;
  }
} else {
	$data['axx'] = array();
	$data['sort']['file'] = '';
	$data['sort']['access'] = '';
}

echo cs_subtemplate(__FILE__,$data,'modules','view');