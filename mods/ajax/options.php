<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('ajax');
$files = cs_files();

if (!empty($_POST['submit'])) {
  
  $errors = '';
  
  if (!empty($files['loading']['tmp_name'])) {
    $ext = strtolower(substr(strrchr($files['loading']['name'],'.'),1));
    if ($ext != 'gif') $errors .= cs_html_br(1) . '- ' . $cs_lang['ext_only_gif'];
  }
  
  if (empty($errors)) {
    if (!empty($files['loading']['tmp_name'])) cs_upload('ajax','loading.gif',$files['loading']['tmp_name']);

    settype($_POST['ajax_reload'],'integer');
    if (empty($_POST['ajax'])) $_POST['ajax_reload'] = 0;

    $navlists = empty($_POST['navlists']) ? array() : $_POST['navlists'];
    $list = implode(',',$navlists);
    if (!empty($list)) $list .= ',';
    $list .= $_POST['additionals'];
    if (substr($list,-1) != ',' && !empty($list)) $list .= ',';

    $list = str_replace('shoutbox_navlist','shoutbox_navlist2',$list);

    require 'mods/clansphere/func_options.php';

    $save = array();
    $save['ajax'] = empty($_POST['ajax']) ? '0' : (int) $_POST['for'];
    $save['ajax_reload'] = $_POST['ajax_reload'];
    $save['ajax_navlists'] = $list;

    cs_optionsave('clansphere', $save);

    if ($cs_main['ajax'] && empty($_POST['ajax']) && function_exists('ajax_js'))
      die(ajax_js("window.location.reload();"));
    if (empty($cs_main['ajax']) && !empty($save['ajax']) && !empty($cs_main['mod_rewrite'])) {
      $turned_on = cs_sql_count(__FILE__, 'users', 'users_id = "' . $account['users_id'] . '" AND users_ajax = "1"');
      if (!empty($turned_on))
        header('Location: ../../' . $cs_main['php_self']['basename']);
    } else

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
  $data['options']['for_severals'] = '';
  $data['options']['for_all'] = '';
} else {
  $data['options']['ajax_on'] = $selected;
  $data['options']['ajax_off'] = '';
  if ($cs_main['ajax'] == 2) {
    $data['options']['for_severals'] = '';
    $data['options']['for_all'] = $selected;
  } else {
    $data['options']['for_severals'] = $selected;
    $data['options']['for_all'] = '';
  }
}

$data['switch']['ajax_on'] = empty($cs_main['ajax']) ? 'display: none' : '';

$template = file_get_contents('templates/' . $cs_main['template'] . '/index.htm');
$template = str_replace('{url:','',$template);
preg_match_all("={(?!func)(.*?):(?!navmeta)(.*?)(:(.*?))*}=i",$template,$matches);

$possibles = array('messages_navmsgs');

$count_matches = count($matches[0]);

for ($i = 0; $i < $count_matches; $i++) {
  $possibles[] = str_replace(':','_',substr($matches[0][$i],1,-1));
}

$checked = ' checked="checked"';
$count_possibles = count($possibles);

for ($i = 0; $i < $count_possibles; $i++) {
  $data['navlists'][$i]['raw'] = $possibles[$i];
  $division = strpos($possibles[$i],'_');
  $data['navlists'][$i]['mod'] = strtoupper($possibles[$i]{0}) . substr($possibles[$i],1, $division-1);
  $data['navlists'][$i]['action'] = strtoupper(substr($possibles[$i],$division+1,1)) . substr($possibles[$i],$division+2);
  $data['navlists'][$i]['checked'] = in_array($possibles[$i],$data['ajax_navlists']) ? $checked : '';

  if (!empty($cs_lang['d_'.$possibles[$i]])) {
    $data['navlists'][$i]['if']['descr'] = true;
    $data['navlists'][$i]['description'] = $cs_lang['d_'.$possibles[$i]];
  } else
    $data['navlists'][$i]['if']['descr'] = false;

  $leftovers = str_replace($possibles[$i] . ',','',$leftovers);
}

if (substr($leftovers,-1) == ',') $leftovers = substr($leftovers,0,-1);
$data['options']['additionals'] = $leftovers;

echo cs_subtemplate(__FILE__,$data,'ajax','options');

?>