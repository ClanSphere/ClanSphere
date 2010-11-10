<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

require_once 'mods/categories/functions.php';

$cs_cups = array();
$cs_cups['cups_name'] = empty($_POST['cups_name']) ? '' : $_POST['cups_name'];
$cs_cups['games_id'] = empty($_POST['games_id']) ? 0 : (int) $_POST['games_id'];
$cs_cups['cups_teams'] = empty($_POST['cups_teams']) ? 0 : (int) $_POST['cups_teams'];
$cs_cups['cups_start'] = cs_datepost('cups_start','unix');
$cs_cups['cups_system'] = empty($_POST['cups_system']) ? '' : $_POST['cups_system'];
$cs_cups['cups_text'] = empty($_POST['cups_text']) ? '' : $_POST['cups_text'];
$cs_cups['cups_brackets'] = empty($_POST['cups_brackets']) ? 0 : 1;

if (isset($_POST['submit'])) {
  
  $error = '';
  
  if (empty($cs_cups['cups_name']))
    $error .= cs_html_br(1) . $cs_lang['no_name'];
  if (empty($cs_cups['games_id']))
    $error .= cs_html_br(1) . $cs_lang['no_game'];
  if (empty($cs_cups['cups_teams']))
    $error .= cs_html_br(1) . $cs_lang['no_maxteams'];
  elseif (substr_count(decbin($cs_cups['cups_teams']),1) != 1)
    $error .= cs_html_br(1) . $cs_lang['wrong_maxteams'];
}

if (empty($_POST['submit']) || !empty($error)) {
  
  $cups_id = empty($error) ? (int) $_GET['id'] : (int) $_POST['cups_id'];
  
  if (empty($error)) {
    $cells = 'cups_id, games_id, cups_name, cups_system, cups_text, cups_teams, cups_start, cups_brackets';
    $cs_cups = cs_sql_select(__FILE__,'cups',$cells,'cups_id=\''.$cups_id.'\'');
  }
  
  $data = array('cups' => $cs_cups);
  
  if (!empty($error)) $data['lang']['edit_cup'] = $cs_lang['error_occured'] . $error;
  
  $cups_start = empty($cs_cups['cups_start']) ? cs_time() : $cs_cups['cups_start'];
  $data['cups']['start'] = cs_dateselect('cups_start', 'unix', $cups_start, 2007);
  $data['cups']['teams'] = !isset($cs_cups['cups_teams']) ? 32 : $cs_cups['cups_teams'];
  $data['cups']['cups_id'] = $cups_id;
  
  $cups_system = empty($cs_cups['cups_system']) ? 'teams' : $cs_cups['cups_system'];
  $data['sel']['teams'] = $cups_system == 'teams' ? ' selected="selected"' : '';
  $data['sel']['users'] = $cups_system == 'users' ? ' selected="selected"' : '';
  $data['sel']['ko'] = empty($cs_cups['cups_brackets']) ? ' selected="selected"' : '';
  $data['sel']['brackets'] = !empty($cs_cups['cups_brackets']) ? ' selected="selected"' : '';
  
  $data['games'] = cs_sql_select(__FILE__,'games','games_name,games_id',0,'games_name',0,0);
  $games_count = count($data['games']);
  
  if (!empty($cs_cups['games_id']))
    for ($i = 0; $i < $games_count; $i++)
      $data['games'][$i]['selected'] = $data['games'][$i]['games_id'] == $cs_cups['games_id'] ? 'selected="selected"' : '';  
  
  echo cs_subtemplate(__FILE__, $data, 'cups', 'edit');
  
} else {
  
  $cups_id = (int) $_POST['cups_id'];
  
  $cells = array_keys($cs_cups);
  $values = array_values($cs_cups);
  
  cs_sql_update(__FILE__,'cups',$cells,$values,$cups_id);
  
  cs_redirect($cs_lang['changes_done'], 'cups') ;
  
}