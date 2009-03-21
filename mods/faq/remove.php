<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('faq');

$faq_form = 1;
$faq_id = $_REQUEST['id'];

if(isset($_POST['agree'])) {
  $faq_form = 0;
  cs_sql_delete(__FILE__,'faq',$faq_id);
  cs_redirect($cs_lang['del_true'], 'faq');
}

if(isset($_POST['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'faq');
}

if(!empty($faq_form)) {
  $data['lang']['body'] = sprintf($cs_lang['del_rly'],$faq_id);
  $data['action']['form'] = cs_url('faq','remove');
  $data['faq']['id'] = $faq_id;
  
  echo cs_subtemplate(__FILE__,$data,'faq','remove');
}

?>