<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('awards');
$cs_get = cs_get('id,agree,cancel');
$awards_id = $cs_get['id'];

if(isset($cs_get['agree'])) {
  cs_sql_delete(__FILE__,'awards',$cs_get['id']);
  cs_redirect($cs_lang['del_true'], 'awards');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'awards');
}

$award = cs_sql_select(__FILE__,'awards','awards_event','awards_id = ' . $cs_get['id'],0,0,1);
if(!empty($award)) {
  $data['head']['topline'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_remove'],$award['awards_event']);
  $data['awards']['content'] = cs_link($cs_lang['confirm'],'awards','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['awards']['content'] .= ' - ';
  $data['awards']['content'] .= cs_link($cs_lang['cancel'],'awards','remove','id=' . $cs_get['id'] . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'awards','remove');
}
else {
  cs_redirect('','awards');
}
