<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('faq');
$cs_get = cs_get('id');
$cs_post = cs_post('id');
$faq_id = empty($cs_get['id']) ? $cs_post['id'] : $cs_get['id'];

if(isset($cs_post['agree'])) {
  cs_sql_delete(__FILE__,'faq',$faq_id);
  cs_redirect($cs_lang['del_true'], 'faq');
}

if(isset($cs_post['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'faq');
}

$faq = cs_sql_select(__FILE__,'faq','faq_question','faq_id = ' . $faq_id,0,0,1);
if(!empty($faq)) {
  $data['lang']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_name'],$faq['faq_question']);
  $data['action']['form'] = cs_url('faq','remove');
  $data['faq']['id'] = $faq_id;
  echo cs_subtemplate(__FILE__,$data,'faq','remove');
}
else {
  cs_redirect('','faq');
}
