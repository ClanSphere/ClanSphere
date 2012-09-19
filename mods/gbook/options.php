<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gbook');

if(isset($_POST['submit'])) {
  
  $save = array();
  $save['lock'] = (int) $_POST['lock'];
  $save['captcha_users'] = (int) $_POST['captcha_users'];
  
  require_once 'mods/clansphere/func_options.php';
  
  cs_optionsave('gbook', $save);
  
  cs_redirect($cs_lang['changes_done'],'options','roots');

} else {
  
  $data = array();
  $data['option'] = cs_sql_option(__FILE__,'gbook');
  
  $data['select']['no'] = $data['option']['lock'] == 0 ? 'selected="selected"' : '';
  $data['select']['yes'] = $data['option']['lock'] == 1 ? 'selected="selected"' : '';
  
  $data['captcha']['no'] = $data['option']['captcha_users'] == 0 ? 'selected="selected"' : '';
  $data['captcha']['yes'] = $data['option']['captcha_users'] == 1 ? 'selected="selected"' : '';

  echo cs_subtemplate(__FILE__,$data,'gbook','options');
}