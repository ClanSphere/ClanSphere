<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('comments');
$cs_get = cs_get('id');
$data = array();

$com_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
$cs_com = cs_sql_select(__FILE__,'comments','comments_mod',"comments_id ='" . $com_id . "'",0,0);

if(isset($_GET['agree'])) {
  cs_sql_delete(__FILE__,'comments',$com_id);
  cs_redirect($cs_lang['del_true'],'comments','manage','where=' . $cs_com['comments_mod']);
  
}
elseif(isset($_GET['cancel']))
  cs_redirect($cs_lang['del_false'],'comments','manage','where=' . $cs_com['comments_mod']);
  
else {
  $data['head']['body'] = sprintf($cs_lang['del_rly'],$com_id);
  $data['url']['agree'] = cs_url('comments','remove','id=' . $com_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('comments','remove','id=' . $com_id . '&amp;cancel');
  
  echo cs_subtemplate(__FILE__,$data,'comments','remove');
}

?>