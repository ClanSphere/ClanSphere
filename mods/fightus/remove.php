<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('fightus');
$cs_get = cs_get('id,agree,cancel');

if(isset($cs_get['agree'])) {
  cs_sql_delete(__FILE__,'fightus',$cs_get['id']);
  cs_cache_delete('count_fightus');
  cs_redirect($cs_lang['fight_del_true'], 'fightus');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'fightus');
}

$fightus = cs_sql_select(__FILE__,'fightus','fightus_nick','fightus_id = ' . $cs_get['id'],0,0,1);
if(!empty($fightus)) {
  $data = array();
  $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_name'],$fightus['fightus_nick']);
  $data['url']['agree'] = cs_url('fightus','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['url']['cancel'] = cs_url('fightus','remove','id=' . $cs_get['id'] . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'fightus','remove');
}
else {
  cs_redirect('','fightus');
}