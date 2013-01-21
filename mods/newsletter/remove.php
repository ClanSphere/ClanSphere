<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('newsletter');
$cs_get = cs_get('id,agree,cancel');

if(isset($cs_get['agree'])) {
  cs_sql_delete(__FILE__,'newsletter',$cs_get['id']);
  cs_redirect($cs_lang['del_true'],'newsletter');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'],'newsletter');
}

$newsletter = cs_sql_select(__FILE__,'newsletter','newsletter_subject','newsletter_id = ' . $cs_get['id'],0,0,1);
if(!empty($newsletter)) {
  $data = array();
  $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_name'],$newsletter['newsletter_subject']);
  $data['url']['agree'] = cs_url('newsletter','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['url']['cancel'] = cs_url('newsletter','remove','id=' . $cs_get['id'] . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'newsletter','remove');
}
else {
  cs_redirect('','newsletter');
}
