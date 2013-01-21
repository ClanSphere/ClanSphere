<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('ranks');
$cs_get = cs_get('id,agree,cancel');

if(isset($cs_get['agree'])) {
  cs_sql_delete(__FILE__,'ranks',$cs_get['id']);
  cs_redirect($cs_lang['del_true'], 'ranks');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'ranks');
}

$rank = cs_sql_select(__FILE__,'ranks','ranks_name','ranks_id = ' . $cs_get['id'],0,0,1);
if(!empty($rank)) {
  $data = array();
  $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_remove'],$rank['ranks_name']);
  $data['url']['agree'] = cs_url('ranks','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['url']['cancel'] = cs_url('ranks','remove','id=' . $cs_get['id'] . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'ranks','remove');
}
else {
  cs_redirect('','ranks');
}