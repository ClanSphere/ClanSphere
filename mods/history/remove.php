<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('history');
$cs_get = cs_get('id,agree,cancel');

if(isset($cs_get['agree'])) {
  cs_sql_delete(__FILE__,'history',$cs_get['id']);
  cs_redirect($cs_lang['del_true'], 'history');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'history');
}

$history = cs_sql_select(__FILE__,'history','history_text','history_id = ' . $cs_get['id']);
if(!empty($history)) {
  $data = array();
  $data['head']['topline'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_name'],cs_substr($history['history_text'],0,15));
  $data['history']['content'] = cs_link($cs_lang['confirm'],'history','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['history']['content'] .= ' - ';
  $data['history']['content'] .= cs_link($cs_lang['cancel'],'history','remove','id=' . $cs_get['id'] . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'history','remove');
}
else {
  cs_redirect('','history');
}