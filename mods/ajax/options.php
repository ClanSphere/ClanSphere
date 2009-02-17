<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('ajax');
$files = cs_files();

if (!empty($_POST['submit'])) {
  
  $errors = '';
  
  if (!empty($files['loading']['tmp_name'])) {
    $ext = strtolower(substr($files['loading']['tmp_name'],strrpos($files['loading']['tmp_name'],'.')+1));
    if ($ext != 'gif') $errors .= cs_html_br(1) . '- ' . $cs_lang['ext_only_gif'];
  }
  
  if (empty($errors)) {
    if (!empty($files)) cs_upload('ajax','loading.gif',$files['loading']['tmp_name']);
    
    settype($_POST['ajax_reload'],'integer');
    if (empty($_POST['ajax'])) $_POST['ajax_reload'] = 0;
    
    $navlists = $_POST['navlists'];
    $list = implode(',',$navlists);
    if (!empty($list)) $list .= ',';
    $list .= $_POST['additionals'];
    if (substr($list,-1) != ',') $list .= ',';
    
    $list = str_replace('shoutbox_navlist','shoutbox_navlist2',$list);
    
    require 'mods/clansphere/func_options.php';
  
    $save = array();
    $save['ajax'] = $_POST['ajax'];
    $save['ajax_reload'] = $_POST['ajax_reload'];
    $save['ajax_navlists'] = $list;
  
    cs_optionsave('clansphere', $save);
    
    if ($cs_main['ajax'] && empty($_POST['ajax']) && function_exists('ajax_js')) die(ajax_js("window.location.reload();"));
    
    cs_redirect($cs_lang['success'], 'options','roots');
  }
}

$data = array();
$selected = ' selected="selected"';
if (!empty($errors)) $data['lang']['errors_here'] = $cs_lang['error_occured'] . $errors;

$data['options']['ajax_reload'] = $cs_main['ajax_reload'];
$data['ajax_navlists'] = explode(',',str_replace('shoutbox_navlist2','shoutbox_navlist',$cs_main['ajax_navlists']));
$leftovers = str_replace('shoutbox_navlist2','',$cs_main['ajax_navlists']);

if (empty($cs_main['ajax'])) {
  $data['options']['ajax_on'] = '';
  $data['options']['ajax_off'] = $selected;
} else {
  $data['options']['ajax_on'] = $selected;
  $data['options']['ajax_off'] = '';
}

$data['switch']['ajax_on'] = empty($cs_main['ajax']) ? 'display: none' : '';

$template = file_get_contents('templates/' . $cs_main['template'] . '/index.htm');
$template = str_replace('{url:','',$template);
preg_match_all("={(?!func)(.*?):(?!navmeta)(.*?)(:(.*?))*}=i",$template,$matches);

$count_matches = count($matches[0]);
$checked = ' checked="checked"';

for ($i = 0; $i < $count_matches; $i++) {
  $data['navlists'][$i]['raw'] = str_replace(':','_',substr($matches[0][$i],1,-1));
  $data['navlists'][$i]['mod'] = strtoupper($matches[1][$i]{0}) . substr($matches[1][$i],1);
  $data['navlists'][$i]['action'] = strtoupper($matches[2][$i]{0}) . substr($matches[2][$i],1);
  $data['navlists'][$i]['checked'] = in_array($data['navlists'][$i]['raw'],$data['ajax_navlists']) ? $checked : '';
  $leftovers = str_replace($data['navlists'][$i]['raw'] . ',','',$leftovers);
}

if (substr($leftovers,-1) == ',') $leftovers = substr($leftovers,0,-1);
$data['options']['additionals'] = $leftovers;

echo cs_subtemplate(__FILE__,$data,'ajax','options');

?>