<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

if (isset($_POST['cancel']))
  cs_redirect($cs_lang['canceled'], 'cups');
elseif(!isset($_POST['submit'])) {
  
  $cups_id = (int) $_GET['id'];
  
  if(empty($cups_id)) {
    cs_redirect($cs_lang['no_selection'],'cups','manage');
  } else {
    
    $data = array();
    $data['lang']['del_rly'] = sprintf($cs_lang['del_rly'],$cups_id);
    $data['cup']['id'] = $cups_id;
    
    echo cs_subtemplate(__FILE__, $data, 'cups', 'remove');
  }
} else {
  $cups_id = (int) $_POST['id'];
  cs_sql_delete(__FILE__,'cupmatches',$cups_id,'cups_id');
  cs_sql_delete(__FILE__,'cupsquads',$cups_id,'cups_id');
  cs_sql_delete(__FILE__,'cups',$cups_id);
  cs_redirect($cs_lang['del_true'], 'cups');
}