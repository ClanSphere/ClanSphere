<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('rules');
$cs_get = cs_get('id');

if(isset($cs_get['agree'])) {
  cs_sql_delete(__FILE__,'rules',$cs_get['id']);
  cs_redirect($cs_lang['del_true'], 'rules');
}
if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'rules');
}

$rule = cs_sql_select(__FILE__,'rules','rules_title','rules_id = ' . $cs_get['id'],0,0,1);
if(!empty($rule)) {
  $data = array();
  $data['head']['topline'] = sprintf($cs_lang['remove_entry'],$cs_lang['rule'],$rule['rules_title']);
  $data['rules']['content'] = cs_link($cs_lang['confirm'],'rules','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['rules']['content'] .= ' - ';
  $data['rules']['content'] .= cs_link($cs_lang['cancel'],'rules','remove','id=' . $cs_get['id'] . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'rules','remove');
}
else {
  cs_redirect('','rules');
}