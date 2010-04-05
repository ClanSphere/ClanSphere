<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

function cs_optionsave ($mod, $save) {
  
  $condition = "options_mod = '" . $mod . "' AND options_name = ";
  $cells = array('options_value');
  
  foreach ($save AS $options_name => $options_value) {
    $values = array($options_value);
    cs_sql_update(__FILE__,'options',$cells,$values,0,$condition . "'" . $options_name . "'");
  }
  
  if (file_exists('uploads/cache/op_' . $mod . '.tmp'))
    cs_unlink('cache', 'op_' . $mod . '.tmp');
  
}