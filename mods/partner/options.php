<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('partner');

if (!empty($_POST['submit'])) {
  
  $save = array();
  $save['def_width_navimg'] = (int) $_POST['def_width_navimg'];
  $save['def_height_navimg'] = (int) $_POST['def_height_navimg'];
  $save['max_size_navimg'] = (int) $_POST['max_size_navimg'];
  $save['def_width_listimg'] = (int) $_POST['def_width_listimg'];
  $save['def_height_listimg'] = (int) $_POST['def_height_listimg'];
  $save['max_size_listimg'] = (int) $_POST['max_size_listimg'];
  $save['def_width_rotimg'] = (int) $_POST['def_width_rotimg'];
  $save['def_height_rotimg'] = (int) $_POST['def_height_rotimg'];
  $save['max_size_rotimg'] = (int) $_POST['max_size_rotimg'];
  $save['method'] = $_POST['method'];
  $save['max_navlist']   = (int) $_POST['max_navlist'];
  
  require_once 'mods/clansphere/func_options.php';
  
  cs_optionsave('partner', $save);
  
  cs_redirect($cs_lang['success'], 'options', 'roots');
  
} else {
  
  $data = array();
  $data['partner'] = cs_sql_option(__FILE__,'partner');
    
  $data['sel']['random'] = $data['partner']['method'] == 'random' ? 'selected="selected"' : '';
  $data['sel']['rotation'] = $data['partner']['method'] == 'rotation' ? 'selected="selected"' : '';
  
  $data['head']['body_text'] = empty($error) ? $cs_lang['errors_here'] : $error;
  
  echo cs_subtemplate(__FILE__,$data,'partner','options');
  
}