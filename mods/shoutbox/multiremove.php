<?php
// ClanSphere 2010 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('shoutbox');

$data = array();
$shoutbox_id = (int) $_GET['id'];

if(isset($_GET['confirm'])) {
  $values = explode('-',$_GET['ids']);
  
  $query = 'DELETE FROM {pre}_shoutbox WHERE ';
  $count_values = count($values);
  
  for($run = 0; $run < $count_values; $run++) {
    $id = (int) $values[$run];
    
  if($run != 0) { $query .= ' OR '; }
    $query .= 'shoutbox_id = \'' . $id . '\'';
  }
  cs_sql_query(__FILE__,$query);
  
  cs_redirect($cs_lang['del_true'],'shoutbox','manage');
}
else {
  $values = $_POST;
  $ids = '';
  
  foreach($values AS $key => $value) {
    if(strpos($key,'select_') === false) { continue; }
    $ids .= substr($key,7) . '-';
  }

  if(empty($ids)) { 
  cs_redirect($cs_lang['no_selection'],'shoutbox','manage');
  }
  else { 
    $ids = substr($ids,0,-1);
    
    $data['content']['head'] = $cs_lang['really_remove_selected'];
    $data['content']['bottom']  = cs_link($cs_lang['confirm'],'shoutbox','multiremove','ids='.$ids.'&amp;confirm');
    $data['content']['bottom'] .= ' - ';
    $data['content']['bottom'] .= cs_link($cs_lang['cancel'],'shoutbox','remove','&amp;cancel');
  }
}

echo cs_subtemplate(__FILE__,$data,'shoutbox','remove');