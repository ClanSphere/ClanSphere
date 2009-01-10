<?php
// ClanSphere 2008 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('maps');
$data = array();
$maps_count = cs_sql_count(__FILE__,'maps');

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];
$data['head']['message'] = cs_getmsg();

$data['maps']['maps_count'] = $maps_count;
$data['maps']['maps_pages'] = cs_pages('maps','manage',$maps_count,$start);

$cells = 'maps_id, maps_name';
$data['maplist'] = cs_sql_select(__FILE__,'maps',$cells,0,'maps_id ASC',$start,$account['users_limit']);

echo cs_subtemplate(__FILE__,$data,'maps','manage');

?>