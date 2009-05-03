<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('modules');

$data = array();
$dir = $_GET['dir'];

if (isset($_GET['confirm'])) {
  
  cs_sql_query(__FILE__,'UPDATE {pre}_access SET access_'.cs_sql_escape($dir).' = \'0\'');
  
  $access = cs_sql_select(__FILE__,'access','access_id',0,'access_clansphere ASC',0,0);
  
  foreach ($access AS $level) {
  	if (file_exists('uploads/cache/access_' . $level['access_id'] . '.tmp'))
      cs_unlink('cache', 'access_' . $level['access_id'] . '.tmp');
  }
  
  cs_redirect($cs_lang['success'],'modules','roots');
  
} elseif (isset($_GET['cancel'])) {
  
  cs_redirect($cs_lang['remove_canceled'],'modules','roots');
  
} else {

  $data['content']['deactivate'] = sprintf($cs_lang['rly_deactivate'],$dir);
  
  $data['content']['actions']  = cs_link($cs_lang['confirm'],'modules','deactivate','dir='.$dir.'&amp;confirm');
  $data['content']['actions'] .= ' - ';
  $data['content']['actions'] .= cs_link($cs_lang['cancel'],'modules','deactivate','dir='.$dir.'&amp;cancel');
}

echo cs_subtemplate(__FILE__,$data,'modules','deactivate');