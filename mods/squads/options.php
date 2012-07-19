<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('squads');

if(isset($_POST['submit'])) {

  $save = array();
  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];
  $save['def_order'] = (int) $_POST['def_order'];
  $save['label'] = $_POST['label'];
  
  require_once 'mods/clansphere/func_options.php';
  
  cs_optionsave('squads', $save);

  cs_redirect($cs_lang['success'],'options','roots');
  
}

$data = array();

$data['op'] = cs_sql_option(__FILE__,'squads');

$data['head']['mod'] = $cs_lang[$data['op']['label'].'s'];
$data['head']['getmsg'] = cs_getmsg();

$data['op']['squad'] = $data['op']['label'] == 'squad' ? 'selected="selected"' : '';
$data['op']['group'] = $data['op']['label'] == 'group' ? 'selected="selected"' : '';
$data['op']['section'] = $data['op']['label'] == 'section' ? 'selected="selected"' : '';
$data['op']['team'] = $data['op']['label'] == 'team' ? 'selected="selected"' : '';
$data['op']['class'] = $data['op']['label'] == 'class' ? 'selected="selected"' : '';

echo cs_subtemplate(__FILE__,$data,'squads','options');