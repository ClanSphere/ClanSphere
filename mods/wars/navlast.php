<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');
$cs_get = cs_get('catid');
$data = array();

$tables  = 'wars w INNER JOIN {pre}_squads sq ON w.squads_id = sq.squads_id ';
$tables .= 'INNER JOIN {pre}_clans c ON w.clans_id = c.clans_id';
$cells  = 'w.wars_id AS wars_id, w.wars_score1 AS score1, w.wars_score2 AS score2, w.wars_status AS status, ';
$cells .= 'sq.squads_id AS squads_id, sq.squads_picture AS squads_picture, ';
$cells .= 'sq.squads_name AS squads_name, c.clans_id AS clans_id, ';
$cells .= 'c.clans_name AS clans_name, c.clans_picture AS clans_picture';
$where = empty($cs_get['catid']) ? 0 : 'w.categories_id = ' . $cs_get['catid'];
$data['war'] = cs_sql_select(__FILE__,$tables, $cells, $where, 'wars_date DESC');

if(!empty($data['war']) && $data['war']['status'] == 'played' ) {
  $data['if']['win'] = $data['war']['score1'] > $data['war']['score2'] ? 1 : 0;
  $data['if']['draw'] = $data['war']['score1'] == $data['war']['score2'] ? 1 : 0;
  echo cs_subtemplate(__FILE__,$data,'wars','navlast');
}
else {
  echo $cs_lang['no_data'];
}