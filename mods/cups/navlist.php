<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$data = array();
$limit = 4;
$maxname = 20;
$cells = 'cups_id, cups_name, cups_start';
$data['cups'] = cs_sql_select(__FILE__,'cups',$cells,0,'cups_start DESC',0,$limit);
$count_cups = count($data['cups']);

for ($i = 0; $i < $count_cups; $i++) {
  $data['cups'][$i]['view_url'] = cs_url('cups','view','id=' . $data['cups'][$i]['cups_id']);
  if (strlen($data['cups'][$i]['cups_name']) > $maxname)
    $data['cups'][$i]['cups_name'] = substr($data['cups'][$i]['cups_name'],0,$maxname - 2) . '..';
  $data['cups'][$i]['cups_start'] = cs_date('unix',$data['cups'][$i]['cups_start']);
}

echo cs_subtemplate(__FILE__,$data,'cups','navlist');