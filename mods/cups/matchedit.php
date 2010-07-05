<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

include 'mods/cups/generate.php';

if(!empty($_POST['accept1']) OR !empty($_POST['accept2']) OR !empty($_POST['accept_submit'])) {
  $cupmatches_id = (int) $_POST['cupmatches_id'];
  
  $cells = 'cups_id, squad1_id, squad2_id, cupmatches_round, cupmatches_accepted1, cupmatches_accepted2, cupmatches_winner';
  $matchsel = cs_sql_select(__FILE__,'cupmatches',$cells,'cupmatches_id = ' . $cupmatches_id);

  $cup = cs_sql_select(__FILE__,'cups','cups_system, cups_brackets, cups_teams','cups_id = ' . $matchsel['cups_id']);
  
  $squad = empty($_POST['squad']) ? 0 : $_POST['squad'];
  $squad = $squad == 1 || !empty($_POST['accept1']) ? 1 : 2;
  
  if($cup['cups_system'] == 'teams') {
    $cond = 'users_id = \''.$account['users_id'].'\' AND squads_id = \'';
    $cond .= $squad == 1 ? $matchsel['squad1_id'] . '\'' : $matchsel['squad2_id'] . '\'';
    
    $check = cs_sql_count(__FILE__,'members',$cond);
  } else {
    $check = $matchsel['squad'.$squad.'_id'] == $account['users_id'] ? 1 : 0;
  }
  
  if(!empty($check)) {
    
    if(empty($_POST['accept_submit'])) {
      
      $data = array();
      $data['match']['id'] = $cupmatches_id;
      $data['match']['squadnr'] = $squad;
      
      echo cs_subtemplate(__FILE__, $data, 'cups', 'confirm');
      
    } else {
      
      $cells = array('cupmatches_accepted'.$squad);
      $values = array('1');
      cs_sql_update(__FILE__,'cupmatches',$cells,$values,$cupmatches_id);
      
      $matchsel['cupmatches_accepted'.$squad] = 1;
      
      $cond = '(cupmatches_accepted1 = 0 OR cupmatches_accepted2 = 0) AND cups_id = '. $matchsel['cups_id'];
      $count = cs_sql_count(__FILE__,'cupmatches',$cond);

      if (!empty($matchsel['cupmatches_accepted1']) && !empty($matchsel['cupmatches_accepted2'])) {
        
        $loser = $matchsel['cupmatches_winner'] == $matchsel['squad1_id'] ? $matchsel['squad2_id'] : $matchsel['squad1_id'];
        
        $newmatch = cs_cupmatch ($cupmatches_id, $matchsel['cupmatches_winner'], $loser);
        
        if ($newmatch) $msg = $cs_lang['new_match'];
        
      }
      
      $msg = $cs_lang['successfully_confirmed'];
      if(!empty($message)) $msg .= ' ' . $message;
      
      cs_redirect($msg, 'cups', 'match', 'id=' . $cupmatches_id);
      
    }
  }
  else {
    echo $cs_lang['no_access'];
  }

    
}
elseif(!empty($_POST['result']) || !empty($_POST['result_submit'])) {
  
  $cupmatches_id = (int) $_POST['cupmatches_id'];
  $team = $_POST['team'] == 2 ? 2 : 1;
  
  $tables = 'cupmatches cm INNER JOIN {pre}_cups cp ON cm.cups_id = cp.cups_id';
  $cells = 'cp.cups_system AS cups_system';
  $system = cs_sql_select(__FILE__,$tables,$cells,'cm.cupmatches_id = \''.$cupmatches_id.'\'');
  
  $tables  = 'cupmatches cm ';
  
  if($system['cups_system'] == 'teams') {
    $tables .= 'INNER JOIN {pre}_squads sq1 ON cm.squad1_id = sq1.squads_id ';
    $tables .= 'INNER JOIN {pre}_squads sq2 ON cm.squad2_id = sq2.squads_id';  
    $cells = 'cm.squad1_id AS squad1_id, cm.squad2_id AS squad2_id, ';
    $cells .='sq1.squads_name AS squad1_name, sq2.squads_name AS squad2_name';
  }
  else {
    $tables .= 'INNER JOIN {pre}_users usr1 ON cm.squad1_id = usr1.users_id ';
    $tables .= 'INNER JOIN {pre}_users usr2 ON cm.squad2_id = usr2.users_id ';
    $cells  = 'cm.squad1_id AS user1_id, usr1.users_nick AS user1_nick, ';
    $cells .= 'cm.squad2_id AS user2_id, usr2.users_nick AS user2_nick';
  }
  
  $cs_match = cs_sql_select(__FILE__,$tables,$cells,'cm.cupmatches_id = \''.$cupmatches_id.'\'');
  
  if($system['cups_system'] == 'teams') {
    $cond = 'users_id = \''.$account['users_id'].'\' AND squads_id = \''.$cs_match['squad'.$team.'_id'].'\'';
    $sql = cs_sql_count(__FILE__,'members',$cond);
    $player = empty($sql) ? FALSE : TRUE;
  }
  else {
    $cond = 'users_id = \''.$account['users_id'].'\' AND users_id = \''.$cs_match['user'.$team.'_id'].'\'';
    $sql = cs_sql_count(__FILE__,'users',$cond);
    $player = empty($sql) ? FALSE : TRUE;
  }
  
  if($player == TRUE) {
    if(!empty($_POST['result'])) {
      
      $data = array();
      $data['match']['id'] = $cupmatches_id;
      $data['match']['teamnr'] = $team;
      
      if($system['cups_system'] == 'teams') {
        
        $data['match']['team1_name'] = $cs_match['squad1_name'];
        $data['match']['team2_name'] = $cs_match['squad2_name'];
        $data['match']['team1_id'] = $cs_match['squad1_id'];
        $data['match']['team2_id'] = $cs_match['squad2_id'];
      
      } else {
        
        $data['match']['team1_name'] = $cs_match['user1_nick'];
        $data['match']['team2_name'] = $cs_match['user2_nick'];
        $data['match']['team1_id'] = $cs_match['user1_id'];
        $data['match']['team2_id'] = $cs_match['user2_id'];
        
      }
      
      echo cs_subtemplate(__FILE__, $data, 'cups', 'enter_result');

    } else {
      
      $cs_cups['cupmatches_winner'] = (int) $_POST['cupmatches_winner'];
      $cs_cups['cupmatches_score1'] = (int) $_POST['cupmatches_score1'];
      $cs_cups['cupmatches_score2'] = (int) $_POST['cupmatches_score2'];
      $cs_cups['cupmatches_accepted'.$team] = '1';
    
      $error = '';
      
      if(empty($cs_cups['cupmatches_winner']))
        $error .= cs_html_br(1) . $cs_lang['no_winner'];
      
      if(empty($error)) {
        
        $cells = array_keys($cs_cups);
        $values = array_values($cs_cups);
        
        cs_sql_update(__FILE__,'cupmatches',$cells,$values,$cupmatches_id);
        
        cs_redirect($cs_lang['result_successful'], 'cups', 'center');
        
      } else {
        
        cs_redirect($cs_lang['error_occured'] . $error, 'cups', 'center');
      
      }
    }
  }
  else {
    cs_redirect($cs_lang['no_access'], 'cups', 'center');
  }
}
elseif(!empty($_POST['adminedit']) || !empty($_POST['admin_submit'])) {
  
  if($account['access_cups'] < 4) {
    echo cs_redirect($cs_lang['no_access'], 'cups', 'match', 'id=' . $cupmatches_id);
  } else {
    $cupmatches_id = (int) $_POST['cupmatches_id'];
    
    if(!empty($_POST['admin_submit'])) {
      $cs_match = array();
      $cs_match['cupmatches_score1'] = (int) $_POST['cupmatches_score1'];
      $cs_match['cupmatches_score2'] = (int) $_POST['cupmatches_score2'];
    
      if($_POST['cupmatches_score1'] > $_POST['cupmatches_score2']) {
        $cs_match['cupmatches_winner'] = $_POST['squad1_id'];
      }
      
      if($_POST['cupmatches_score2'] > $_POST['cupmatches_score1']) {
        $cs_match['cupmatches_winner'] = $_POST['squad2_id'];
      }
      
      if($_POST['cupmatches_score2'] == $_POST['cupmatches_score1']) {
        $error = cs_html_br(1) . $cs_lang['no_winner'];
        cs_redirect($cs_lang['error_occured'] . $error, 'cups', 'match', 'id='.$cupmatches_id);
      }
      
      $cs_match['cupmatches_accepted1'] = empty($_POST['cupmatches_accepted1']) ? 0 : (int) $_POST['cupmatches_accepted1'];
      $cs_match['cupmatches_accepted2'] = empty($_POST['cupmatches_accepted2']) ? 0 : (int) $_POST['cupmatches_accepted2'];
      
      $cells = array_keys($cs_match);
      $values = array_values($cs_match);
      
      cs_sql_update(__FILE__,'cupmatches',$cells,$values,$cupmatches_id);
        
      // Check for new round
        
      if (!empty($cs_match['cupmatches_accepted1']) && !empty($cs_match['cupmatches_accepted2'])) {
        
        $loser = $cs_match['cupmatches_winner'] == $_POST['squad1_id'] ? $_POST['squad2_id'] : $_POST['squad1_id'];
        
        $newmatch = cs_cupmatch ($cupmatches_id, $cs_match['cupmatches_winner'], $loser);
        
        if ($newmatch) $msg = $cs_lang['new_match'];
        
      }
        
      $cells = 'cups_id, cupmatches_round';
      $matchsel = cs_sql_select(__FILE__,'cupmatches',$cells,"cupmatches_id = '" . $cupmatches_id . "'");
        
      $cond = '(cupmatches_accepted1 = 0 OR cupmatches_accepted2 = 0) AND cups_id = '. $matchsel['cups_id'];
      $count = cs_sql_count(__FILE__,'cupmatches',$cond);
        
      echo $cs_lang['changes_done'] . '. ';
      
      $message = $cs_lang['changes_done'] . '. ';
      if(!empty($msg)) $message .= ' ' . $msg;
      
      cs_redirect($message, 'cups', 'match', 'id=' . $cupmatches_id);
      
    }
    else {
      
      $tables = 'cupmatches cm INNER JOIN {pre}_cups cp ON cm.cups_id = cp.cups_id';
      $cells = 'cp.cups_system AS cups_system';
      $system = cs_sql_select(__FILE__,$tables,$cells,'cm.cupmatches_id = ' . $cupmatches_id);
      
      $tables  = 'cupmatches cm ';
      
      if($system['cups_system'] == 'teams') {
        $tables .= 'LEFT JOIN {pre}_squads sq1 ON cm.squad1_id = sq1.squads_id ';
        $tables .= 'LEFT JOIN {pre}_squads sq2 ON cm.squad2_id = sq2.squads_id ';
        $tables .= 'LEFT JOIN {pre}_cupsquads cs1 ON cm.squad1_id = cs1.squads_id ';
        $tables .= 'LEFT JOIN {pre}_cupsquads cs2 ON cm.squad2_id = cs2.squads_id ';
        $cells = 'cm.squad1_id AS squad1_id, cm.squad2_id AS squad2_id, ';
        $cells .='sq1.squads_name AS squad1_name, sq2.squads_name AS squad2_name, ';
      } else {
        $tables .= 'LEFT JOIN {pre}_users usr1 ON cm.squad1_id = usr1.users_id ';
        $tables .= 'LEFT JOIN {pre}_users usr2 ON cm.squad2_id = usr2.users_id ';
        $cells  = 'cm.squad1_id AS user1_id, usr1.users_nick AS user1_nick, ';
        $cells .= 'cm.squad2_id AS user2_id, usr2.users_nick AS user2_nick, ';
      }
      
      $cells .= 'cm.cupmatches_accepted1 AS cupmatches_accepted1, ';
      $cells .= 'cm.cupmatches_accepted2 AS cupmatches_accepted2, ';
      $cells .= 'cm.cupmatches_score1 AS cupmatches_score1, ';
      $cells .= 'cm.cupmatches_score2 AS cupmatches_score2';
       
      $data = array();
      
      $data['match'] = cs_sql_select(__FILE__,$tables,$cells,'cm.cupmatches_id = ' . $cupmatches_id);
      
      if ($system['cups_system'] == 'teams') {
        $data['match']['team1_id'] = $data['match']['squad1_id'];
        $data['match']['team2_id'] = $data['match']['squad2_id'];
        $data['match']['team1_name'] = (empty($data['match']['squad1_name']) AND !empty($data['match']['squad1_id'])) ? '? ID:'.$data['match']['squad1_id'] : cs_secure($data['match']['squad1_name']);
        $data['match']['team2_name'] = (empty($data['match']['squad2_name']) AND !empty($data['match']['squad2_id'])) ? '? ID:'.$data['match']['squad2_id'] : cs_secure($data['match']['squad2_name']);
      } else {
        $data['match']['team1_id'] = $data['match']['user1_id'];
        $data['match']['team2_id'] = $data['match']['user2_id'];
        $data['match']['team1_name'] = $data['match']['user1_nick'];
        $data['match']['team2_name'] = $data['match']['user2_nick'];
      }
      
      $data['match']['id'] = $cupmatches_id;
      $data['checked']['team1'] = empty($data['match']['cupmatches_accepted1']) ? '' : ' checked="checked"';
      $data['checked']['team2'] = empty($data['match']['cupmatches_accepted2']) ? '' : ' checked="checked"';
      
      echo cs_subtemplate(__FILE__, $data, 'cups', 'adminedit');
    }
  }
}