<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('members');

if (!empty($_POST['submit'])) {
  
  $save = array();
  $save['label'] = $_POST['label'];
  
  require_once 'mods/clansphere/func_options.php';
  
  cs_optionsave('members', $save);
  
  cs_redirect($cs_lang['success'],'options','roots');
  
}

$data = array();
$data['op'] = cs_sql_option(__FILE__,'members');

$data['lang']['mod_name'] = $cs_lang[$data['op']['label']];

$data['select']['members_select'] = $data['op']['label'] == 'members' ? 'selected="selected"': '';
$data['select']['memberemployees_select'] = $data['op']['label'] == 'employees' ? 'selected="selected"': '';
$data['select']['teammates_select'] = $data['op']['label'] == 'teammates' ? 'selected="selected"': '';
$data['select']['classmates_select'] = $data['op']['label'] == 'classmates' ? 'selected="selected"': '';

echo cs_subtemplate(__FILE__,$data,'members','options');