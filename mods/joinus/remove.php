<?php
// ClanSphere 2010 - www.clansphere.net
// Id: remove.php (Tue Nov 25 12:46:59 CET 2008) fAY-pA!N

$cs_lang = cs_translate('joinus');
$cs_get = cs_get('id');
$data = array();

$joinus_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($_GET['agree'])) {
  cs_sql_delete(__FILE__,'joinus',$joinus_id);
  cs_cache_delete('count_joinus');
  cs_redirect($cs_lang['del_true_join'], 'joinus');
}

elseif(isset($_GET['cancel']))   
  cs_redirect($cs_lang['del_false'], 'joinus');

else {
  
  $data['head']['body'] = sprintf($cs_lang['del_rly'],$joinus_id);
  $data['url']['agree'] = cs_url('joinus','remove','id=' . $joinus_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('joinus','remove','id=' . $joinus_id . '&amp;cancel');
  
  echo cs_subtemplate(__FILE__,$data,'joinus','remove');
}