<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('joinus');
$cs_get = cs_get('id,agree,cancel');
$joinus_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($cs_get['agree'])) {
  cs_sql_delete(__FILE__,'joinus',$joinus_id);
  cs_cache_delete('count_joinus');
  cs_redirect($cs_lang['del_true_join'], 'joinus');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'joinus');
}

$joinus = cs_sql_select(__FILE__,'joinus','joinus_name','joinus_id = ' . $cs_get['id'],0,0,1);
if(!empty($joinus)) {
  $data = array();
  $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_name'],$joinus['joinus_name']);
  $data['url']['agree'] = cs_url('joinus','remove','id=' . $joinus_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('joinus','remove','id=' . $joinus_id . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'joinus','remove');
}
else {
  cs_redirect('','joinus');
}
