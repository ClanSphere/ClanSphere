<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('boardranks');
$cs_get = cs_get('id,agree,cancel');
$boardranks_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($cs_get['agree'])) {
  cs_sql_delete(__FILE__,'boardranks',$boardranks_id);
  cs_redirect($cs_lang['del_true'], 'boardranks');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'boardranks');
}

$boardrank = cs_sql_select(__FILE__,'boardranks','boardranks_name','boardranks_id = ' . $boardranks_id,0,0,1);
if(!empty($boardrank)) {
  $data = array();
  $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_remove'],$boardrank['boardranks_name']);
  $data['url']['agree'] = cs_url('boardranks','remove','id=' . $boardranks_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('boardranks','remove','id=' . $boardranks_id . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'boardranks','remove');
}
else {
  cs_redirect('','boardranks');
}