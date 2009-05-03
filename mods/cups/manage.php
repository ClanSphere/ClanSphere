<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

$data = array();
$data['vars']['count'] = cs_sql_count(__FILE__,'cups');
$data['vars']['message'] = cs_getmsg();

$cells = 'cups_id, games_id, cups_name, cups_start, cups_teams';
$data['cups'] = cs_sql_select(__FILE__,'cups',$cells,'','cups_start ASC',0,0);
$count_cups = count($data['cups']);

$img_start = cs_icon('forward');

for ($i = 0; $i < $count_cups; $i++) {  
  $data['cups'][$i]['participations'] = cs_sql_count(__FILE__, 'cupsquads', 'cups_id = "' . $data['cups'][$i]['cups_id'].'"');  
      
  if(file_exists('uploads/games/' . $data['cups'][$i]['games_id'] . '.gif')) {
    $data['cups'][$i]['game'] = cs_html_img('uploads/games/' . $data['cups'][$i]['games_id'] . '.gif');
  } else {
    $data['cups'][$i]['game'] = '';
  }
	
  $where = "games_id = '" . $data['cups'][$i]['games_id'] . "'";
  $cs_game = cs_sql_select(__FILE__,'games','games_name, games_id',$where);
  $id = 'id=' . $cs_game['games_id'];
  $data['cups'][$i]['game'] .= ' ' . cs_link($cs_game['games_name'],'games','view',$id);  
  
  $matchcount = cs_sql_count(__FILE__,'cupmatches','cups_id = "' . $data['cups'][$i]['cups_id'] . '"');
  $data['cups'][$i]['start_link'] = empty($matchcount) && $data['cups'][$i]['cups_start'] < cs_time() ?
    cs_link($img_start,'cups','start','id=' . $data['cups'][$i]['cups_id'], 0, $cs_lang['start']) : '-';
  
}

echo cs_subtemplate(__FILE__, $data, 'cups', 'manage');