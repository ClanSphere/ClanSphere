<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('links');
$cs_get = cs_get('id');
$data = array();

$links_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$select = 'links_name, links_url, links_stats, links_banner, links_info';
$cs_links = cs_sql_select(__FILE__,'links',$select,"links_id = '" . $links_id . "'");

$data['links']['name'] = cs_secure($cs_links['links_name']);
$data['links']['url'] = $cs_links['links_url'];

if($cs_links['links_stats'] == 'on') {
  $data['links']['color'] = 'lime';
  $data['links']['on_off'] = $cs_lang['online'];
}else{
  $data['links']['color'] = 'red';
  $data['links']['on_off'] = $cs_lang['offline'];
}

$data['if']['img'] = FALSE;
if(!empty($cs_links['links_banner'])) {
  $src = 'uploads/links/' . $cs_links['links_banner'];
  $data['links']['img'] = cs_html_img($src);
  $data['if']['img'] = TRUE;
}

$data['links']['info'] = cs_secure ($cs_links['links_info'],1,1,1,1);

echo cs_subtemplate(__FILE__,$data,'links','view');