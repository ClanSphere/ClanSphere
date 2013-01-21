<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('quotes');
$cs_get = cs_get('id');
$cs_post = cs_post('id');
$quotes_id = empty($cs_get['id']) ? $cs_post['id'] : $cs_get['id'];

if(isset($cs_post['agree'])) {
  cs_sql_delete(__FILE__,'quotes',$quotes_id);
  $query = 'DELETE FROM {pre}_comments WHERE comments_mod = \'quotes\' AND comments_fid = ' . $quotes_id;
  cs_sql_query(__FILE__,$query);

  cs_redirect($cs_lang['del_true'], 'quotes');
}

if(isset($cs_post['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'quotes');
}

$quote = cs_sql_select(__FILE__,'quotes','quotes_headline','quotes_id = ' . $quotes_id,0,0,1);
if(!empty($quote)) {
  $data = array();
  $data['head']['mod'] = $cs_lang['mod_name'];
  $data['head']['action'] = $cs_lang['remove'];
  $data['quotes']['id'] = $quotes_id;
  $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_name'],$quote['quotes_headline']);
  $data['lang']['confirm'] = $cs_lang['confirm'];
  $data['lang']['cancel'] = $cs_lang['cancel'];
  echo cs_subtemplate(__FILE__,$data,'quotes','remove');
}
else {
  cs_redirect('','quotes');
}