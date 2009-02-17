<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('newsletter');
$cs_get = cs_get('id');
$data = array();

$newsletter_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($_GET['agree'])) {
  cs_sql_delete(__FILE__,'newsletter',$newsletter_id);
  cs_redirect($cs_lang['del_true'],'newsletter');
}

if(isset($_GET['cancel'])) 
  cs_redirect($cs_lang['del_false'],'newsletter');

else {
  $data['head']['body'] = sprintf($cs_lang['del_rly'],$newsletter_id);
  $data['url']['agree'] = cs_url('newsletter','remove','id=' . $newsletter_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('newsletter','remove','id=' . $newsletter_id . '&amp;cancel');
  
  echo cs_subtemplate(__FILE__,$data,'newsletter','remove');
}

?>
