<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clans');

if(isset($_POST['submit'])) {
  
  $save = array();
  $save['max_width'] = (int) $_POST['max_width'];
  $save['max_height'] = (int) $_POST['max_height'];
  $save['max_size'] = (int) $_POST['max_size'];
  $save['label'] = $_POST['label'];
  
  require_once 'mods/clansphere/func_options.php';
  cs_optionsave('clans', $save);
  
  cs_redirect($cs_lang['changes_done'],'options','roots');
  
} else {
  
  $op_clans = cs_sql_option(__FILE__,'clans');
  
  $data['lang']['getmsg'] = cs_getmsg();
  $data['lang']['mod_name'] = $cs_lang[$op_clans['label']];
  
  $data['clans']['clan'] = $op_clans['label'] == 'clan' ? 'selected="selected"' : '';
  $data['clans']['association'] = $op_clans['label'] == 'association' ? 'selected="selected"' : '';
  $data['clans']['club'] = $op_clans['label'] == 'club' ? 'selected="selected"' : '';
  $data['clans']['guild'] = $op_clans['label'] == 'guild' ? 'selected="selected"' : '';
  $data['clans']['enterprise'] = $op_clans['label'] == 'enterprise' ? 'selected="selected"' : '';
  $data['clans']['school'] = $op_clans['label'] == 'school' ? 'selected="selected"' : '';
  
  $data['clans']['max_width'] = $op_clans['max_width'];
  $data['clans']['max_height'] = $op_clans['max_height'];
  $data['clans']['max_size'] = $op_clans['max_size'];
  
  echo cs_subtemplate(__FILE__,$data,'clans','options');
}