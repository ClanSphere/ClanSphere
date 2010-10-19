<?php
// ClanSphere 2010 - www.clansphere.net
// Id: remove.php (Tue Nov 25 13:20:50 CET 2008) fAY-pA!N

$cs_lang = cs_translate('boardranks');
$cs_get = cs_get('id,agree,cancel');
$data = array();

$boardranks_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
$agree = !isset($cs_get['agree']) ? 0 : 1;
$cancel = !isset($cs_get['cancel']) ? 0 : 1;

if(!empty($agree)) {
  cs_sql_delete(__FILE__,'boardranks',$boardranks_id);
  cs_redirect($cs_lang['del_true'], 'boardranks');
}

if(!empty($cancel))
cs_redirect($cs_lang['del_false'], 'boardranks');

if(empty($agree) AND empty($cancel)) {
  $boardrank = cs_sql_select(__FILE__,'boardranks','boardranks_name','boardranks_id = ' . $boardranks_id,0,0,1);
  if(!empty($boardrank)) {
    $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_remove'],$boardrank['boardranks_name']);
    $data['url']['agree'] = cs_url('boardranks','remove','id=' . $boardranks_id . '&amp;agree');
    $data['url']['cancel'] = cs_url('boardranks','remove','id=' . $boardranks_id . '&amp;cancel');
    echo cs_subtemplate(__FILE__,$data,'boardranks','remove');
  }
  else {
    cs_redirect('','boardranks');
  }

}