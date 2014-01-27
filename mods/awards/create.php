<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('awards');

$cs_awards['users_id'] = $account['users_id'];
$now = cs_time();
$awards_year = isset($_POST['datum_year']) ? $_POST['datum_year'] : cs_date('unix',$now,0,1,'Y');
$awards_month = isset($_POST['datum_month']) ? $_POST['datum_month'] : cs_date('unix',$now,0,1,'m');
$awards_day = isset($_POST['datum_day']) ? $_POST['datum_day'] : cs_date('unix',$now,0,1,'d');
$cs_awards['awards_time'] = $awards_year . '-' . $awards_month . '-' .  $awards_day;
$cs_awards['games_id'] =  isset($_POST['games_id']) ? (int)$_POST['games_id'] : 0;
$cs_awards['awards_rank'] =  isset($_POST['awards_rank']) ? (int)$_POST['awards_rank'] : 0;
$cs_awards['awards_event'] =  isset($_POST['awards_event']) ? $_POST['awards_event'] : '';
$cs_awards['awards_event_url'] =  isset($_POST['awards_event_url']) ? $_POST['awards_event_url'] : '';
$cs_awards['squads_id'] =  isset($_POST['squads_id']) ? (int)$_POST['squads_id'] : 0;

$error = 0;
$errormsg = '';

settype($cs_awards['awards_rank'], 'integer');

if(isset($_POST['submit'])) {
  
  $awards_check_time = str_replace('-', '', $cs_awards['awards_time']);
  if($awards_check_time <= '000') {
    $error++;
    $errormsg .= $cs_lang['no_date'] . cs_html_br(1);
  }
  if(empty($cs_awards['awards_event'])) {
    $error++;
    $errormsg .= $cs_lang['no_event'] . cs_html_br(1);
  }
  if(empty($cs_awards['awards_event_url'])) {
    $error++;
    $errormsg .= $cs_lang['no_event_url'] . cs_html_br(1);
  }
  if(empty($cs_awards['games_id']) AND empty($cs_games['games_name'])) {
    $error++;
    $errormsg .= $cs_lang['no_game'] . cs_html_br(1);
  }
  if(empty($cs_awards['awards_rank'])) {
    $error++;
    $errormsg .= $cs_lang['no_rank'] . cs_html_br(1);
  }
}

if(!isset($_POST['submit']) OR (isset($_POST['submit']) AND !empty($error)))
{
  $data = array();
  
  $data['head']['body_create'] = !isset($_POST['submit']) ? $cs_lang['body_create'] : $errormsg;
  
  $data['awards']['awards_event_url'] = $cs_awards['awards_event_url'];
  $data['awards']['awards_event'] = $cs_awards['awards_event'];
  $data['awards']['awards_rank'] = $cs_awards['awards_rank'];
  
  $games = cs_sql_select(__FILE__,'games','games_name, games_id',0,1,1,0);
  $data['select']['game'] = cs_dropdown('games_id','games_name',$games,$cs_awards['games_id']);

  $data_squads = cs_sql_select(__FILE__,'squads','squads_name,squads_id',0,'squads_name',0,0);
  $data['squads'] = cs_dropdownsel($data_squads, $cs_awards['squads_id'], 'squads_id');
  
  $data['select']['date'] = cs_dateselect('datum','date',$cs_awards['awards_time']);
  echo cs_subtemplate(__FILE__,$data,'awards','create');

  
}

  
  
if(isset($_POST['submit']) AND (empty($error))) {

  $awards_cells = array_keys($cs_awards);
  $awards_save = array_values($cs_awards);
  cs_sql_insert(__FILE__,'awards',$awards_cells,$awards_save);
    
  cs_redirect($cs_lang['create_done'],'awards');
  
}