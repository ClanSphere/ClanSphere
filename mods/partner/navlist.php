<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$categories_id = empty($_GET['pid']) ? 0 : $_GET['pid'];
settype($categorie_id,'integer');

$select = 'partner_id, partner_name, partner_url, partner_alt, partner_nimg';
$order = 'partner_priority ASC';
$where = empty($categories_id) ? "partner_nimg != ''" : "partner_nimg != '' AND categories_id = '".$categories_id."'";
$cs_partner = cs_sql_select(__FILE__,'partner',$select,$where,$order,0,0);
$data['partner'] = array();

if(!empty($cs_partner)) {
  $count_partner = count($cs_partner);
  for ($run = 0; $run < $count_partner; $run++) {
    $place = "uploads/partner/";
    $data['partner'][$run]['name'] = cs_secure($cs_partner[$run]['partner_name']);
    $data['partner'][$run]['nimg'] = $place.$cs_partner[$run]['partner_nimg'];
    $data['partner'][$run]['url'] = cs_secure('http://'.$cs_partner[$run]['partner_url']);
    $data['partner'][$run]['alt'] = cs_secure($cs_partner[$run]['partner_alt']);
  }
  echo cs_subtemplate(__FILE__,$data,'partner','navlist');
}