<?php
// ClanSphere 2010 - www.clansphere.net
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


    require_once 'mods/clansphere/func_options.php';

    $save = array();
    $save['ajax'] = empty($_POST['ajax']) ? '0' : (int) $_POST['for'];
    $save['ajax_reload'] = $_POST['ajax_reload'];

    cs_optionsave('clansphere', $save);


    cs_redirect($cs_lang['success'], 'options','roots');
    
  }
}

$data = array();
$selected = ' selected="selected"';
if (!empty($errors)) $data['lang']['errors_here'] = $cs_lang['error_occured'] . $errors;

$data['options']['ajax_reload'] = $cs_main['ajax_reload'];


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


echo cs_subtemplate(__FILE__,$data,'ajax','options');