<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('links');
$cs_get = cs_get('id,agree,cancel');
$links_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($cs_get['agree'])) {
  $banner = cs_sql_select(__FILE__,'links','links_banner',"links_id = '" . $links_id . "'");
  if(!empty($banner['links_banner'])) {
    cs_unlink('links',$banner['links_banner']);
  }
  cs_sql_delete(__FILE__,'links',$links_id);
  cs_redirect($cs_lang['del_true'],'links');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'],'links');
}

$links = cs_sql_select(__FILE__,'links','links_name','links_id = ' . $links_id,0,0,1);
if(!empty($links)) {
  $data = array();
  $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_name'],$links['links_name']);
  $data['url']['agree'] = cs_url('links','remove','id=' . $links_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('links','remove','id=' . $links_id . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'links','remove');
}
else {
  cs_redirect('','links');
}