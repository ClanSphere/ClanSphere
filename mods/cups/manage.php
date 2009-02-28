<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

$data = array();
$data['vars']['count'] = cs_sql_count(__FILE__,'cups');

$cells = 'cups_id, games_id, cups_name, cups_start, cups_teams';
$data['cups'] = cs_sql_select(__FILE__,'cups',$cells,'','cups_start ASC',0,0);
$count_cups = count($data['cups']);

$img_start = cs_icon('forward');

for ($i = 0; $i < $count_cups; $i++) {
  $data['cups'][$i]['if']['gameicon_exists'] = file_exists('uploads/games/' . $data['cups'][$i]['games_id'] . '.gif') ? true : false;
  $data['cups'][$i]['participations'] = cs_sql_count(__FILE__, 'cupsquads', 'cups_id = "' . $data['cups'][$i]['cups_id'].'"');
  
  $matchcount = cs_sql_count(__FILE__,'cupmatches','cups_id = "' . $data['cups'][$i]['cups_id'] . '"');
  $data['cups'][$i]['start_link'] = empty($matchcount) && $data['cups'][$i]['cups_start'] < cs_time() ?
    cs_link($img_start,'cups','start','id=' . $data['cups'][$i]['cups_id'], 0, $cs_lang['start']) : '-';
  
}

echo cs_subtemplate(__FILE__, $data, 'cups', 'manage');

?>