<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('partner');

$partner_id = $_GET['id'];
settype($partner_id,'integer');

$data['head']['mod'] = $cs_lang['mod_name'];
$data['head']['action'] = $cs_lang['remove'];

if(isset($_GET['agree'])) {

  $select = 'partner_limg, partner_nimg, partner_rimg';
  $partner = cs_sql_select(__FILE__,'partner',$select,"partner_id = '" . $partner_id . "'");
  if(!empty($partner['partner_limg'])) cs_unlink('partner',$partner['partner_limg']);
  if(!empty($partner['partner_nimg'])) cs_unlink('partner',$partner['partner_nimg']);
  if(!empty($partner['partner_rimg'])) cs_unlink('partner',$partner['partner_rimg']);
  
  cs_sql_delete(__FILE__,'partner',$partner_id);

  cs_redirect($cs_lang['del_true'], 'partner');
}
elseif(isset($_GET['cancel'])) 
  cs_redirect($cs_lang['del_false'], 'partner');
else {

  $data['head']['topline'] = sprintf($cs_lang['really'],$partner_id);
  $data['partner']['content'] = cs_link($cs_lang['confirm'],'partner','remove','id=' . $partner_id . '&amp;agree');
  $data['partner']['content'] .= ' - ';
  $data['partner']['content'] .= cs_link($cs_lang['cancel'],'partner','remove','id=' . $partner_id . '&amp;cancel');
}

echo cs_subtemplate(__FILE__,$data,'partner','remove');

?>