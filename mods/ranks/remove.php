<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('ranks');
$cs_get = cs_get('id');
$data = array();

$ranks_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($_GET['agree'])) {
  cs_sql_delete(__FILE__,'ranks',$ranks_id);
  cs_redirect($cs_lang['del_true'], 'ranks');
}

if(isset($_GET['cancel']))
  cs_redirect($cs_lang['del_false'], 'ranks');

else {
  $data['head']['body'] = sprintf($cs_lang['del_rly'],$ranks_id);
  $data['url']['agree'] = cs_url('ranks','remove','id=' . $ranks_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('ranks','remove','id=' . $ranks_id . '&amp;cancel');

  echo cs_subtemplate(__FILE__,$data,'ranks','remove');
}

?>
