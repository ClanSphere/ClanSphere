<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');

if(isset($_POST['submit'])) {
  
  $opt['month_out'] = empty($_POST['month_out']) ? 0 : (float) $_POST['month_out'];
  $opt['currency']  = empty($_POST['currency']) ? '' : $_POST['currency'];
  
  require_once 'mods/clansphere/func_options.php';
  
  $save = array();
  $save['month_out'] = $opt['month_out'];
  $save['currency']  = $opt['currency'];
  
  cs_optionsave('cash', $save);
  
  cs_redirect($cs_lang['success'], 'options', 'roots');

} else {
  
  $data = array();
  
  $data['op'] = cs_sql_option(__FILE__, 'cash');
  settype($data['op']['month_out'], 'float');

  echo cs_subtemplate(__FILE__,$data,'cash','options');
}