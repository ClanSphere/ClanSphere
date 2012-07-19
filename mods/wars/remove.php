<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');
$cs_get = cs_get('id');
$data = array();

$wars_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($_GET['agree'])) {
  
  $wars = cs_sql_select(__FILE__,'wars','wars_pictures',"wars_id = '" . $wars_id . "'");
  $wars_string = $wars['wars_pictures'];
  $wars_pics = empty($wars_string) ? array() : explode("\n",$wars_string);
  foreach($wars_pics AS $pics) {
    cs_unlink('wars', 'picture-' . $pics);
    cs_unlink('wars', 'thumb-' . $pics);
  }
  
  cs_sql_delete(__FILE__,'wars',$wars_id);
  cs_sql_delete(__FILE__,'rounds',$wars_id,'wars_id');
  cs_sql_delete(__FILE__,'players',$wars_id,'wars_id');
  cs_redirect($cs_lang['del_true'], 'wars');
}

if(isset($_GET['cancel']))
  cs_redirect($cs_lang['del_false'], 'wars');

else {

  $data['head']['body'] = sprintf($cs_lang['remove_rly'],$wars_id);
  $data['url']['agree'] = cs_url('wars','remove','id=' . $wars_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('wars','remove','id=' . $wars_id . '&amp;cancel');

  echo cs_subtemplate(__FILE__,$data,'wars','remove');
}