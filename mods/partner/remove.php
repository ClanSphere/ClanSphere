<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('partner');
$cs_get = cs_get('id,agree,cancel');

if(isset($cs_get['agree'])) {
  $select = 'partner_limg, partner_nimg, partner_rimg';
  $partner = cs_sql_select(__FILE__,'partner',$select,"partner_id = '" . $cs_get['id'] . "'");
  if(!empty($partner['partner_limg'])) {
    cs_unlink('partner',$partner['partner_limg']);
  }
  if(!empty($partner['partner_nimg'])) {
    cs_unlink('partner',$partner['partner_nimg']);
  }
  if(!empty($partner['partner_rimg'])) {
    cs_unlink('partner',$partner['partner_rimg']);
  }

  cs_sql_delete(__FILE__,'partner',$cs_get['id']);

  cs_redirect($cs_lang['del_true'], 'partner');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'partner');
}

$partner = cs_sql_select(__FILE__,'partner','partner_name','partner_id = ' . $cs_get['id'],0,0,1);
if(!empty($partner)) {
  $data = array();
  $data['head']['mod'] = $cs_lang['mod_name'];
  $data['head']['action'] = $cs_lang['remove'];
  $data['head']['topline'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_name'],$partner['partner_name']);
  $data['partner']['content'] = cs_link($cs_lang['confirm'],'partner','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['partner']['content'] .= ' - ';
  $data['partner']['content'] .= cs_link($cs_lang['cancel'],'partner','remove','id=' . $cs_get['id'] . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'partner','remove');
}
else {
  cs_redirect('','partner');
}