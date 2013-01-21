<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('static');
$cs_get = cs_get('id');

if(isset($cs_get['agree'])) {
  cs_sql_delete(__FILE__,'static',$cs_get['id']);
  cs_redirect($cs_lang['del_true'], 'static');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'static');
}

$static = cs_sql_select(__FILE__,'static','static_title', 'static_id = ' . $cs_get['id'],0,0,1);
if(!empty($static)) {
  $data = array();
  $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_remove'],$static['static_title']);
  $data['remove']['agree'] = cs_link($cs_lang['confirm'],'static','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['remove']['cancel'] = cs_link($cs_lang['cancel'],'static','remove','id=' . $cs_get['id'] . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'static','remove');
}
else {
  cs_redirect('','static');
}