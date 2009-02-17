<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('linkus');
$cs_get = cs_get('id');
$data = array();

$linkus_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($_GET['agree'])) {

  $linkus = cs_sql_select(__FILE__,'linkus','linkus_banner',"linkus_id = '" . $linkus_id . "'");
  cs_sql_delete(__FILE__,'linkus',$linkus_id);
  cs_unlink('linkus',$linkus['linkus_banner']);
  
  cs_redirect($cs_lang['del_true'],'linkus');
}

if(isset($_GET['cancel'])) 
  cs_redirect($cs_lang['del_false'],'linkus');

else {

  $data['head']['body'] = sprintf($cs_lang['del_rly'],$linkus_id);
  $data['url']['agree'] = cs_url('linkus','remove','id=' . $linkus_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('linkus','remove','id=' . $linkus_id . '&amp;cancel');

  echo cs_subtemplate(__FILE__,$data,'linkus','remove');
}

?>
