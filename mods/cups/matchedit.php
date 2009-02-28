<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

include 'mods/cups/generate.php';

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['mod'] . ' - ';/* . $cs_lang['accept_result'];
echo cs_html_roco(0);*/

if(!empty($_POST['accept1']) OR !empty($_POST['accept2']) OR !empty($_POST['accept_submit'])) {
  $cupmatches_id = (int) $_POST['cupmatches_id'];
  
  $cells = 'cups_id, squad1_id, squad2_id, cupmatches_round';
  $matchsel = cs_sql_select(__FILE__,'cupmatches',$cells,'cupmatches_id = \''.$cupmatches_id.'\'');
  
  $cup = cs_sql_select(__FILE__,'cups','cups_system, cups_brackets, cups_teams','cups_id = \''.$matchsel['cups_id'].'\'');
  
  $squad = empty($_POST['squad']) ? 0 : $_POST['squad'];
  
  if($squad == 1 OR !empty($_POST['accept1'])) {
    $squad = 1;
  }
  else {
    $squad = 2;
  }
  
  if($cup['cups_system'] == 'teams') {
    $cond = 'users_id = \''.$account['users_id'].'\' AND squads_id = \'';
  
    if($squad == 1) {
      $cond .= $matchsel['squad1_id'] . '\'';
    }
    else {
      $cond .= $matchsel['squad2_id'] . '\'';
    }
    
  $check = cs_sql_count(__FILE__,'members',$cond);
  }
  else {
    $check = $matchsel['squad'.$squad.'_id'] == $account['users_id'] ? 1 : 0;
  }

  echo cs_html_roco(1,'leftc');
  
  if(!empty($check)) {
    if(empty($_POST['accept_submit'])) {
      echo $cs_lang['really_confirm'];
      echo cs_html_roco(0);
      echo cs_html_roco(1,'centerb');
      echo cs_html_form(1,'accept_submit','cups','matchedit');
      echo cs_html_vote('cupmatches_id',$cupmatches_id,'hidden');
      echo cs_html_vote('squad',$squad,'hidden');
      echo cs_html_vote('accept_submit',$cs_lang['confirm'],'submit');
      echo cs_html_form(0);
    }
    else {
      $cells = array('cupmatches_accepted'.$squad);
      $values = array('1');
      cs_sql_update(__FILE__,'cupmatches',$cells,$values,$cupmatches_id);
      
      $cond = '(cupmatches_accepted1 = \'0\' OR cupmatches_accepted2 = \'0\') AND cups_id = \''. $matchsel['cups_id'] .'\'';
      $count = cs_sql_count(__FILE__,'cupmatches',$cond);
      
      if(empty($count) && $matchsel['cupmatches_round'] != 1) {
        cs_cupround($matchsel['cups_id'], $matchsel['cupmatches_round'], $cup['cups_teams'], $cup['cups_brackets']);
        $message = $cs_lang['new_round'];
      }
      
      echo $cs_lang['successfully_confirmed'];
      
      if(!empty($message)) {
        echo ' ' . $message;
      }
  
      echo ' ' . cs_link($cs_lang['continue'],'cups','match','id='.$cupmatches_id);
    }
  }
  else {
    echo $cs_lang['no_access'];
  }

  echo cs_html_roco(0);
  echo cs_html_table(0);    
}
elseif(!empty($_POST['result']) || !empty($_POST['result_submit'])) {
  $cupmatches_id = (int) $_POST['cupmatches_id'];
  $team = $_POST['team'] == '2' ? '2' : '1';
  
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
  
  echo $cs_lang['enter_result'];
  echo cs_html_roco(0);
  echo cs_html_roco(1,'leftc');
  
  if($player == TRUE) {
    if(!empty($_POST['result'])) {
    echo $cs_lang['correct_inputs'];
    echo cs_html_roco(0);
    echo cs_html_table(0);
    echo cs_html_br(1);
    
    echo cs_html_form(1,'matchresult','cups','matchedit');
    echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'leftc');
    echo cs_icon('yast_group_add') . $cs_lang['winner'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_select(1,'cupmatches_winner');
    echo cs_html_option('----',0);
    
    if($system['cups_system'] == 'teams') {
      echo cs_html_option($cs_match['squad1_name'],$cs_match['squad1_id']);
      echo cs_html_option($cs_match['squad2_name'],$cs_match['squad2_id']);
    }
    else {
      echo cs_html_option($cs_match['user1_nick'],$cs_match['user1_id']);
      echo cs_html_option($cs_match['user2_nick'],$cs_match['user2_id']);
    }
    
    echo cs_html_select(0);
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftc');
    echo cs_icon('smallcal') . $cs_lang['result'] . ' ';
      echo $system['cups_system'] == 'teams' ? $cs_match['squad1_name'] : $cs_match['user1_nick'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('cupmatches_score1','','text',5,5);
    echo cs_html_roco(0);
    
    echo cs_html_roco(1,'leftc');
    echo cs_icon('smallcal') . $cs_lang['result'] . ' ';
      echo $system['cups_system'] == 'teams' ? $cs_match['squad2_name'] : $cs_match['user2_nick'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('cupmatches_score2','','text',5,5);
    echo cs_html_roco(0);
    
    echo cs_html_roco(1,'leftc');
    echo cs_icon('ksysguard') . $cs_lang['options'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_vote('squad1_id',$cs_match['squad1_id'],'hidden');
    echo cs_html_vote('squad2_id',$cs_match['squad2_id'],'hidden');
    echo cs_html_vote('cupmatches_id',$cupmatches_id,'hidden');
    echo cs_html_vote('team',$team,'hidden');
    echo cs_html_vote('result_submit',$cs_lang['insert'],'submit');
    echo cs_html_roco(0);
    
    echo cs_html_table(0);
    echo cs_html_form(0);
  }
  else {
    $cs_cups['cupmatches_winner'] = (int) $_POST['cupmatches_winner'];
    $cs_cups['cupmatches_score1'] = (int) $_POST['cupmatches_score1'];
    $cs_cups['cupmatches_score2'] = (int) $_POST['cupmatches_score2'];
    $cs_cups['cupmatches_accepted'.$team] = '1';
  
    $error = '';
    
    if(empty($cs_cups['cupmatches_winner'])) {
      $error .= cs_html_br(1) . $cs_lang['no_winner'];
    }
    
    if(empty($error)) {
      $cells = array_keys($cs_cups);
    $values = array_values($cs_cups);
    cs_sql_update(__FILE__,'cupmatches',$cells,$values,$cupmatches_id);
    
    echo $cs_lang['result_successful'];
    echo ' ';
    echo cs_link($cs_lang['continue'],'cups','center');
      }
    else {
      echo $cs_lang['error_occured'];
      echo $error;
    }
    
    echo cs_html_roco(0);
    echo cs_html_table(0);
  }
  }
  else {
    echo $cs_lang['no_access'];
    echo cs_html_roco(0);
    echo cs_html_table(0);
  }
}
elseif(!empty($_POST['adminedit']) || !empty($_POST['admin_submit'])) {
  echo $cs_lang['adminedit'];
  echo cs_html_roco(0);
  echo cs_html_roco(1,'leftc');
  
  if($account['access_cups'] < 4) {
    echo $cs_lang['no_access'];
    echo cs_html_roco(0);
    echo cs_html_table(0);
  }
  else {
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
    
      $cs_match['cupmatches_accepted1'] = empty($_POST['cupmatches_accepted1']) ? 0 : (int) $_POST['cupmatches_accepted1'];
      $cs_match['cupmatches_accepted2'] = empty($_POST['cupmatches_accepted2']) ? 0 : (int) $_POST['cupmatches_accepted2'];
      
      $cells = array_keys($cs_match);
      $values = array_values($cs_match);
      
      cs_sql_update(__FILE__,'cupmatches',$cells,$values,$cupmatches_id);
      
      // Check for new round
      
      $cells = 'cups_id, cupmatches_round';
    $matchsel = cs_sql_select(__FILE__,'cupmatches',$cells,"cupmatches_id = '" . $cupmatches_id . "'");
      
      $cond = '(cupmatches_accepted1 = \'0\' OR cupmatches_accepted2 = \'0\') AND cups_id = \''. $matchsel['cups_id'] .'\'';
    $count = cs_sql_count(__FILE__,'cupmatches',$cond);
    
    if(empty($count) && $matchsel['cupmatches_round'] != 1) {
      $cells = 'cups_brackets, cups_teams';
      $cup = cs_sql_select(__FILE__,'cups',$cells,"cups_id = '" . $matchsel['cups_id'] . "'");
    
      cs_cupround($matchsel['cups_id'], $matchsel['cupmatches_round'], $cup['cups_teams'], $cup['cups_brackets']);
      $msg = $cs_lang['new_round'];
    }
      
      echo $cs_lang['changes_done'] . '. ';
    
      if(!empty($msg))
    echo ' ' . $msg;
      echo ' ' . cs_link($cs_lang['continue'],'cups','match','id='.$cupmatches_id);
      echo cs_html_roco(0);
      echo cs_html_table(0);
      
    }
  else {
    echo $cs_lang['errors_here'];
      echo cs_html_roco(0);
      echo cs_html_table(0);
      
      $tables = 'cupmatches cm INNER JOIN {pre}_cups cp ON cm.cups_id = cp.cups_id';
      $cells = 'cp.cups_system AS cups_system';
      $system = cs_sql_select(__FILE__,$tables,$cells,'cm.cupmatches_id = \''.$cupmatches_id.'\'');
    
    $tables  = 'cupmatches cm ';
    
    if($system['cups_system'] == 'teams') {
        $tables .= 'INNER JOIN {pre}_squads sq1 ON cm.squad1_id = sq1.squads_id ';
        $tables .= 'INNER JOIN {pre}_squads sq2 ON cm.squad2_id = sq2.squads_id';  
        $cells = 'cm.squad1_id AS squad1_id, cm.squad2_id AS squad2_id, ';
      $cells .='sq1.squads_name AS squad1_name, sq2.squads_name AS squad2_name, ';
      }
    else {
        $tables .= 'INNER JOIN {pre}_users usr1 ON cm.squad1_id = usr1.users_id ';
        $tables .= 'INNER JOIN {pre}_users usr2 ON cm.squad2_id = usr2.users_id ';
        $cells  = 'cm.squad1_id AS user1_id, usr1.users_nick AS user1_nick, ';
        $cells .= 'cm.squad2_id AS user2_id, usr2.users_nick AS user2_nick, ';
      }
    
      $cells .= 'cm.cupmatches_accepted1 AS cupmatches_accepted1, ';
      $cells .= 'cm.cupmatches_accepted2 AS cupmatches_accepted2, ';
      $cells .= 'cm.cupmatches_score1 AS cupmatches_score1, ';
      $cells .= 'cm.cupmatches_score2 AS cupmatches_score2';
    
      $cs_match = cs_sql_select(__FILE__,$tables,$cells,'cm.cupmatches_id = \''.$cupmatches_id.'\'');
      
      $team1 = $system['cups_system'] == 'teams' ? $cs_match['squad1_name'] : $cs_match['user1_nick'];
      $team2 = $system['cups_system'] == 'teams' ? $cs_match['squad2_name'] : $cs_match['user2_nick'];
      $team1_id = $system['cups_system'] == 'teams' ? $cs_match['squad1_id'] : $cs_match['user1_id'];
      $team2_id = $system['cups_system'] == 'teams' ? $cs_match['squad2_id'] : $cs_match['user2_id'];
      
      echo cs_html_br(1);
      echo cs_html_form(1,'adminedit','cups','matchedit');
      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'leftc');
      echo cs_icon('smallcal') . $cs_lang['result'] . ' ' . $team1;
      echo cs_html_roco(2,'leftb');
      echo cs_html_input('cupmatches_score1',$cs_match['cupmatches_score1'],'text',5,5);
      echo cs_html_roco(0);
      echo cs_html_roco(1,'leftc');
      echo cs_icon('smallcal') . $cs_lang['result'] . ' ' . $team2;
      echo cs_html_roco(2,'leftb');
      echo cs_html_input('cupmatches_score2',$cs_match['cupmatches_score2'],'text',5,5);
      echo cs_html_roco(0);
      echo cs_html_roco(1,'leftc');
      echo cs_icon('configure') . $cs_lang['confirmed'];
      echo cs_html_roco(2,'leftb');
      echo cs_html_vote('cupmatches_accepted1','1','checkbox',$cs_match['cupmatches_accepted1']) . ' ' . $team1;
      echo cs_html_br(1);
      echo cs_html_vote('cupmatches_accepted2','1','checkbox',$cs_match['cupmatches_accepted2']) . ' ' . $team2;
      echo cs_html_roco(0);
      echo cs_html_roco(1,'leftc');
      echo cs_icon('ksysguard') . $cs_lang['options'];
      echo cs_html_roco(2,'leftb');
      echo cs_html_vote('squad1_id',$team1_id,'hidden');
      echo cs_html_vote('squad2_id',$team2_id,'hidden');
      echo cs_html_vote('cupmatches_id',$cupmatches_id,'hidden');
      echo cs_html_vote('admin_submit',$cs_lang['edit'],'submit');
      echo cs_html_vote('reset',$cs_lang['reset'],'reset');
      echo cs_html_roco(0);
      echo cs_html_table(0);
      echo cs_html_form(0);
    }
  }
}
?>