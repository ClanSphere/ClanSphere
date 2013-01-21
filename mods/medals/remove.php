<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('medals');
$cs_get = cs_get('id,confirm,');

if (isset($_GET['confirm'])) {
  cs_sql_delete(__FILE__,'medalsuser',$cs_get['id'],'medals_id');
  cs_sql_delete(__FILE__,'medals',$cs_get['id']);
  cs_redirect($cs_lang['del_true'], 'medals', 'manage');
}

$medal = cs_sql_select(__FILE__,'medals','medals_name',"medals_id = '" . $cs_get['id'] . "'");
if(!empty($medal)) {
  $data = array();
  $medals_name = cs_secure($medal['medals_name']);
  $data['medals']['message'] = sprintf($cs_lang['rly_remove'],$medals_name);
  $data['medals']['url_confirm'] = cs_url('medals','remove','id=' . $cs_get['id'] . '&amp;confirm');
  echo cs_subtemplate(__FILE__,$data,'medals','remove');
}
else {
  cs_redirect('','medals');
}