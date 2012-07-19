<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('links');
$data = array();

$links_count = cs_sql_count(__FILE__,'links','links_sponsor = 1');
$data['head']['body'] = sprintf($cs_lang['all1'], $links_count);

$select = 'links_name, links_url, links_banner, links_info';
$data['links'] = cs_sql_select(__FILE__,'links',$select,'links_sponsor = 1',0,0,0);
$links_loop = count($data['links']);

for($run = 0; $run < $links_loop; $run++) {

  $data['links'][$run]['name'] = cs_secure($data['links'][$run]['links_name']);
  
  $target = 'http://' . $data['links'][$run]['links_url'];
  $data['links'][$run]['url_img'] = cs_html_link($target,$data['links'][$run]['links_url']);
  
  if(!empty($data['links'][$run]['links_banner'])) {
    $place = 'uploads/links/' .$data['links'][$run]['links_banner'];
    $img = cs_html_img ($place,0,0,0,$data['links'][$run]['links_name']);
    $data['links'][$run]['url_img'] = cs_html_link($target,$img);
  }
  
  $data['links'][$run]['info'] = cs_secure($data['links'][$run]['links_info'],1,1,1,1);
}

echo cs_subtemplate(__FILE__,$data,'links','sponsors');