<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_get = cs_get('catid');
$cs_option = cs_sql_option(__FILE__,'partner');

$select = 'partner_id, partner_name, partner_url, partner_alt, partner_nimg';
$order = 'partner_priority ASC';
$where = empty($cs_get['catid']) ? 'partner_nimg != \'\'' : 'partner_nimg != \'\' AND categories_id = ' . $cs_get['catid'];
$cs_partner = cs_sql_select(__FILE__,'partner',$select,$where,$order,0,$cs_option['max_navlist']);
$data['partner'] = array();

if(!empty($cs_partner)) {
  for ($run = 0; $run < count($cs_partner); $run++) {
    $place = "uploads/partner/";
    $data['partner'][$run]['name'] = cs_secure($cs_partner[$run]['partner_name']);
    $data['partner'][$run]['nimg'] = $place.$cs_partner[$run]['partner_nimg'];
    $data['partner'][$run]['url'] = cs_secure('http://'.$cs_partner[$run]['partner_url']);
    $data['partner'][$run]['alt'] = cs_secure($cs_partner[$run]['partner_alt']);
  }
  echo cs_subtemplate(__FILE__,$data,'partner','navlist');
}