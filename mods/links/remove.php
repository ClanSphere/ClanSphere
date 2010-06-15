<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('links');
$cs_get = cs_get('id');
$data = array();

$links_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($_GET['agree'])) {
  
  $banner = cs_sql_select(__FILE__,'links','links_banner',"links_id = '" . $links_id . "'");
  if(!empty($banner['links_banner'])) {
    cs_unlink('links',$banner['links_banner']);
  }
  
 cs_sql_delete(__FILE__,'links',$links_id);
 cs_redirect($cs_lang['del_true'],'links');
}

if(isset($_GET['cancel']))
 cs_redirect($cs_lang['del_false'],'links');

else {
  $data['head']['body'] = sprintf($cs_lang['del_rly'],$links_id);
  $data['url']['agree'] = cs_url('links','remove','id=' . $links_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('links','remove','id=' . $links_id . '&amp;cancel');

 echo cs_subtemplate(__FILE__,$data,'links','remove');
}
