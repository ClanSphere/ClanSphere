<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('messages');

if (isset($_POST['submit'])) {
  
  $save = array();
  $save['del_time'] = (int) $_POST['del_time'];
  $save['max_space'] = (int) $_POST['max_space'];
  
  require_once 'mods/clansphere/func_options.php';
  
  cs_optionsave('messages', $save);

  cs_redirect($cs_lang['changes_done'], 'options', 'roots');

} else {
  
  $data = array();
  $data['op'] = cs_sql_option(__FILE__,'messages');
  $data['head']['getmsg'] = cs_getmsg();

  echo cs_subtemplate(__FILE__,$data,'messages','options');
}