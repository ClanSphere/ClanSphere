<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('awards');

$awards_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $_POST['id'];
settype($awards_id,'integer');
$awards_edit = cs_sql_select(__FILE__,'awards','*',"awards_id = '" . $awards_id . "'"); 

$cs_awards['users_id'] = $account['users_id'];
$awards_year = isset($_POST['datum_year']) ? $_POST['datum_year'] : '';
$awards_month = isset($_POST['datum_month']) ? $_POST['datum_month'] : '';
$awards_day = isset($_POST['datum_day']) ? $_POST['datum_day'] : '';
$cs_awards['awards_time'] = $awards_year . '-' . $awards_month . '-' .  $awards_day;
$cs_awards['games_id'] = isset($_POST['games_id']) ? (int)$_POST['games_id'] : 0;
$cs_awards['awards_rank'] =  isset($_POST['awards_rank']) ? (int)$_POST['awards_rank'] : 0;
$cs_awards['awards_event'] =  isset($_POST['awards_event']) ? $_POST['awards_event'] : '';
$cs_awards['awards_event_url'] =  isset($_POST['awards_event_url']) ? $_POST['awards_event_url'] : '';
$cs_awards['squads_id'] =  isset($_POST['squads_id']) ? (int)$_POST['squads_id'] : 0;

$cs_games['games_name'] = isset($_POST['games_name']) ? $_POST['games_name'] : 0;

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

if(!isset($_POST['submit']) OR (isset($_POST['submit']) AND !empty($error))) {
  $data = array();
  
  if(!isset($_POST['submit'])) {
    $data['head']['body_create'] = $cs_lang['body_create'];
  }
  else {
    $data['head']['body_create'] = $errormsg;
  }
  
  $data['awards']['awards_event_url'] = $awards_edit['awards_event_url'];
  $data['awards']['awards_event'] = $awards_edit['awards_event'];
  $data['awards']['awards_rank'] = $awards_edit['awards_rank'];
  $data['awards']['awards_id'] = $awards_edit['awards_id'];
  
  $games = cs_sql_select(__FILE__,'games','games_id, games_name',0,1,1,0);
  $data['select']['game'] = cs_dropdown('games_id','games_name',$games,$awards_edit['games_id']);
  $data['select']['date'] = cs_dateselect('datum','date',$awards_edit['awards_time']);

  $data_squads = cs_sql_select(__FILE__,'squads','squads_name,squads_id',0,'squads_name',0,0);
  $data['squads'] = cs_dropdownsel($data_squads, $awards_edit['squads_id'], 'squads_id');

  echo cs_subtemplate(__FILE__,$data,'awards','edit');
}

if(isset($_POST['submit']) AND (empty($error))) { 

  if(!empty($cs_games['games_name']) AND empty($cs_games['games_id'])) { 

    $games_cells = array_keys($cs_games); 
    $games_save = array_values($cs_games); 

    cs_sql_insert(__FILE__,'games',$games_cells,$games_save); 

    $lastid = cs_sql_insertid(__FILE__);
    $cs_awards['games_id'] = $lastid; 

  } 
  else { 

    $awards_cells = array_keys($cs_awards); 
    $awards_save = array_values($cs_awards); 

    cs_sql_update(__FILE__,'awards',$awards_cells,$awards_save,$awards_id); 

    cs_redirect($cs_lang['changes_done'], 'awards') ;

  } 
}