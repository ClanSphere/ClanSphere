<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');
$cs_get = cs_get('catid');
$data = array();

$select = 'war.wars_date AS wars_date, sqd.squads_name AS squads_name, sqd.squads_id AS squads_id, sqd.squads_picture AS squads_picture, cln.clans_name AS clans_name, owncln.clans_picture AS squad_picture, cln.clans_picture AS clans_picture, cln.clans_id AS clans_id, war.wars_id AS wars_id';
$from = 'wars war INNER JOIN {pre}_squads sqd ON war.squads_id = sqd.squads_id INNER JOIN {pre}_clans cln ON war.clans_id = cln.clans_id INNER JOIN {pre}_clans owncln ON owncln.clans_id = sqd.clans_id';
$where = 'war.wars_date > ' . cs_time() . ' AND war.wars_status = \'upcoming\' AND war.wars_topmatch = 1';
if(!empty($cs_get['catid'])) {
  $where .= ' AND war.categories_id = ' . $cs_get['catid'];
}
$data['wars'] = cs_sql_select(__FILE__,$from,$select,$where,'{random}',0,1);

if(empty($data['wars'])) {
  echo $cs_lang['no_data'];
} else {
  $data['wars']['squads_name'] = cs_link(cs_secure($data['wars']['squads_name']),'squads','view','id=' . $data['wars']['squads_id']);
  $data['wars']['clans_name'] = cs_link(cs_secure($data['wars']['clans_name']),'clans','view','id=' . $data['wars']['clans_id']);
  $data['wars']['ownlogo'] = ! empty($data['wars']['squad_picture']) ? cs_html_img('uploads/clans/' . $data['wars']['squad_picture']) : $cs_lang['no_logo'];
  $data['wars']['enemylogo'] = ! empty($data['wars']['clans_picture']) ? cs_html_img('uploads/clans/' . $data['wars']['clans_picture']) : $cs_lang['no_logo'];
  $data['wars']['date'] = cs_date('unix',$data['wars']['wars_date'],1,1);
  echo cs_subtemplate(__FILE__,$data,'wars','navtop');
}