<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('rules');
$cs_get = cs_get('id');
$data = array();

$rules_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($_GET['agree'])) {
  cs_sql_delete(__FILE__,'rules',$rules_id);
  cs_redirect($cs_lang['del_true'], 'rules');
}
elseif(isset($_GET['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'rules');  
else {
  $data['head']['topline'] = sprintf($cs_lang['del_rly'],$rules_id);
  $data['rules']['content'] = cs_link($cs_lang['confirm'],'rules','remove','id=' . $rules_id . '&amp;agree');
  $data['rules']['content'] .= ' - ';
  $data['rules']['content'] .= cs_link($cs_lang['cancel'],'rules','remove','id=' . $rules_id . '&amp;cancel');
}

echo cs_subtemplate(__FILE__,$data,'rules','remove');

?>
