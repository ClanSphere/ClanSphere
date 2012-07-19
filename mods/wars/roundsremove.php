<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');
$cs_get = cs_get('id');
$data = array();

$rounds_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
$cs_rounds = cs_sql_select(__FILE__,'rounds','wars_id',"rounds_id = '" . $rounds_id ."'");

if (isset($_GET['agree'])) {

  cs_sql_delete(__FILE__,'rounds',$rounds_id);
  
  cs_redirect($cs_lang['del_true'],'wars','rounds','id='.$cs_rounds['wars_id']);

}
if(isset($_GET['cancel']))
  cs_redirect($cs_lang['del_false'],'wars','rounds','id='.$cs_rounds['wars_id']);

else {
  
  $data['head']['body'] = sprintf($cs_lang['really_delete'],$rounds_id);
  $data['url']['agree'] = cs_url('wars','roundsremove','id=' . $rounds_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('wars','roundsremove','id=' . $rounds_id . '&amp;cancel');

  echo cs_subtemplate(__FILE__,$data,'wars','remove');
}