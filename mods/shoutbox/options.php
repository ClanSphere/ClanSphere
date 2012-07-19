<?php
// ClanSphere 2010 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('shoutbox');

if (!empty($_POST['submit'])) {

  $save = array();
  $save['max_text'] = (int) $_POST['max_text'];
  $save['order'] = $_POST['order'];
  $save['linebreak'] = (int) $_POST['linebreak'];
  $save['limit'] = (int) $_POST['limit'];
  
  require_once 'mods/clansphere/func_options.php';
  
  cs_optionsave('shoutbox', $save);
  
  cs_redirect($cs_lang['success'],'options','roots');
  
}

$data = array();
$data['op'] = cs_sql_option(__FILE__,'shoutbox');

$data['selected']['desc'] = $data['op']['order'] == 'DESC' ? 'selected="selected"' : '';
$data['selected']['asc'] = $data['op']['order'] == 'ASC' ? 'selected="selected"' : '';

echo cs_subtemplate(__FILE__,$data,'shoutbox','options');