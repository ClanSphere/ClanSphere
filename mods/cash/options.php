<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');

if(isset($_POST['submit'])) {
  
  $opt['month_out'] = empty($_POST['month_out']) ? 0 : (int) $_POST['month_out'];
  
  require_once 'mods/clansphere/func_options.php';
  
  $save = array();
  $save['month_out'] = $opt['month_out'];
  
  cs_optionsave('cash', $save);
  
  cs_redirect($cs_lang['success'], 'options', 'roots');

} else {
  
  $data = array();
  
  $data['op'] = cs_sql_option(__FILE__, 'cash');

  echo cs_subtemplate(__FILE__,$data,'cash','options');
}