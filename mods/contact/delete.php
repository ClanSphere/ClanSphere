<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('contact');
$cs_get = cs_get('id');
$data = array();

$contact_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($_GET['agree'])) {
  cs_sql_delete(__FILE__,'mail',$contact_id);
  cs_cache_delete('count_mail_unread');
  cs_redirect($cs_lang['del_true'], 'contact');
}
elseif(isset($_GET['cancel']))   
  cs_redirect($cs_lang['del_false'], 'contact');
else {
  $data['head']['body'] = sprintf($cs_lang['del_rly'],$contact_id);
  $data['url']['agree'] = cs_url('contact','delete','id=' . $contact_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('contact','delete','id=' . $contact_id . '&amp;cancel');

  echo cs_subtemplate(__FILE__,$data,'contact','delete');
}