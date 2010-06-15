<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

$data = array();
$time_now = cs_time();

$cups_id = (int) $_GET['id'];

$tables = 'cups cp INNER JOIN {pre}_games gms ON cp.games_id = gms.games_id';
$cells = 'cp.cups_name AS cups_name, gms.games_name AS games_name, cp.cups_system AS cups_system, ';
$cells .='cp.cups_teams AS cups_teams, cp.cups_text AS cups_text, cp.cups_start AS cups_start, ';
$cells .='cp.games_id AS games_id, cp.cups_brackets AS cups_brackets';
$data['cup'] = cs_sql_select(__FILE__,$tables,$cells,'cp.cups_id = '.$cups_id.'');

$data['lang']['max_participants'] = $cs_lang['max_'.$data['cup']['cups_system']];
$data['lang']['registered_participants'] = $cs_lang['registered_'.$data['cup']['cups_system']];

$data['var']['message'] = cs_getmsg();

$data['cup']['system'] = $data['cup']['cups_system'] == 'teams' ? $cs_lang['team_vs_team'] : $cs_lang['user_vs_user'];
$data['cup']['kind'] = empty($data['cup']['cups_brackets']) ? $cs_lang['ko'] : $cs_lang['brackets'];
$data['cup']['reg'] = cs_sql_count(__FILE__,'cupsquads','cups_id = ' . $cups_id);
$data['cup']['start_date'] = cs_date('unix',$data['cup']['cups_start'],1);
$data['cup']['cups_text'] = cs_secure($data['cup']['cups_text'],1,1);

if(file_exists('uploads/games/' . $data['cup']['games_id'] . '.gif')) {
    $data['cup']['game'] = cs_html_img('uploads/games/' . $data['cup']['games_id'] . '.gif');
  } else {
    $data['cup']['game'] = '';
  }
  
  $where = "games_id = '" . $data['cup']['games_id'] . "'";
  $cs_game = cs_sql_select(__FILE__,'games','games_name, games_id',$where);
  $id = 'id=' . $cs_game['games_id'];
  $data['cup']['game'] .= ' ' . cs_link($cs_game['games_name'],'games','view',$id);
 
$data['if']['running'] = false;

$matchcells = 'cupmatches_round, cupmatches_score1, cupmatches_score2, cupmatches_winner, squad1_id, ';
$matchcells .= 'squad2_id, cupmatches_accepted1, cupmatches_accepted2';
$matchsel = cs_sql_select(__FILE__,'cupmatches',$matchcells,'cups_id = ' . $cups_id,'cupmatches_round');
if (empty($matchsel)) {
  $data['cup']['status'] = $cs_lang['upcoming'];
}
else {
  if( $matchsel['cupmatches_round'] == '1' && ( !empty($matchsel['cupmatches_score1']) || !empty($matchsel['cupmatches_score2']) ) && ( !empty($matchsel['cupmatches_accepted1']) && !empty($matchsel['cupmatches_accepted2']) )) {
    $data['cup']['status'] = $cs_lang['finished'];  
  }
  else {
    $data['if']['running'] = true;
    $data['cup']['status'] = $cs_lang['playing'] . ', ' . $cs_lang['round'];
    $data['cup']['status_rounds'] = strlen(decbin($data['cup']['cups_teams'])) - $matchsel['cupmatches_round'];
  }
}

$data['cup']['rounds'] = empty($matchsel) ? '-' : $matchsel['cupmatches_round'] - 1;

if (empty($matchsel['cupmatches_winner']) || !empty($data['if']['running'])) {
  $data['cup']['winner'] = '-';
} else {
  if ($data['cup']['cups_system'] == 'teams') {
    $winnername = cs_sql_select(__FILE__,'squads','squads_name','squads_id = \''.$matchsel['cupmatches_winner'].'\'');
    $data['cup']['winner'] = cs_link($winnername['squads_name'],'squads','view','id='.$matchsel['cupmatches_winner']);
  } else {
    $winnername = cs_sql_select(__FILE__,'users','users_nick, users_active, users_delete','users_id = \''.$matchsel['cupmatches_winner'].'\'');
    $data['cup']['winner'] = cs_user($matchsel['cupmatches_winner'],$winnername['users_nick'], $winnername['users_active'], $winnername['users_delete']);
  }
}

$data['cup']['extended'] = '-';

if (empty($login['mode'])) {
  $data['cup']['extended'] = cs_link($cs_lang['login'],'users','login');
}

if ($time_now > $data['cup']['cups_start'])
  $data['cup']['extended'] = $cs_lang['cup_started'];
elseif ($data['cup']['reg'] < $data['cup']['cups_teams']) {
  if ($data['cup']['cups_system'] == 'teams') {

    $membership = cs_sql_count(__FILE__,'members',"users_id = '" . $account['users_id'] . "' AND members_admin = '1'");
    
    if(!empty($membership)) {
      $tables = 'cupsquads csq INNER JOIN {pre}_members mem ON csq.squads_id = mem.squads_id';
      $where = "mem.users_id = '" . $account['users_id'] . "' AND csq.cups_id = " . $cups_id;
      $participant = cs_sql_count(__FILE__,$tables,$where);
    }
  } else {
    $participant = cs_sql_count(__FILE__,'cupsquads','cups_id = ' . $cups_id . ' AND squads_id = \''.$account['users_id'].'\'');
  }
  $started = cs_sql_count(__FILE__,'cupmatches','cups_id = ' . $cups_id);

  if($account['access_cups'] >= 2 && $time_now < $data['cup']['cups_start'] && empty($started)) {
    
    if(!empty($participant)) {
      $data['cup']['extended'] = $cs_lang['join_done'];
    }
    elseif(!empty($membership) || $data['cup']['cups_system'] == 'users') {
      $data['cup']['extended'] = cs_link($cs_lang['join'],'cups','join','id=' . $cups_id);
    }
    else {
      $data['cup']['extended'] = cs_link($cs_lang['need_squad'],'squads','center');
    }
  }
} else {
  $data['cup']['extended'] = $cs_lang['already_full'];
  
  if ($data['cup']['cups_system'] == 'teams') {

    $membership = cs_sql_count(__FILE__,'members',"users_id = '" . $account['users_id'] . "' AND members_admin = '1'");
    
    if(!empty($membership)) {
      $tables = 'cupsquads csq INNER JOIN {pre}_members mem ON csq.squads_id = mem.squads_id';
      $where = "mem.users_id = '" . $account['users_id'] . "' AND csq.cups_id = '" . $cups_id . "'";
      $participant = cs_sql_count(__FILE__, $tables, $where);
    }
  } else {
    $participant = cs_sql_count(__FILE__,'cupsquads','cups_id = "' . $cups_id . '" AND squads_id = "' . $account['users_id'] . '"');
  }
  if(!empty($participant)) {
    $data['cup']['extended'] = $cs_lang['join_done'];
  }
}

$data['cup']['match_url'] = cs_url('cups','matchlist','where='.$cups_id);
$data['if']['teams'] = false;
$data['if']['players'] = false;

if($data['cup']['cups_system'] == 'teams') {
  $squads_ids = cs_sql_select(__FILE__,'cupsquads','squads_id, cupsquads_id','cups_id = ' . $cups_id,0,0,0);
  $run=0;
  $squads = array();
  
  if (!empty($squads_ids)) {
    foreach($squads_ids as $squads_run) {
      $squads_name = cs_sql_select(__FILE__,'squads','squads_name','squads_id = ' . $squads_run['squads_id']);
      if(empty($squads_name)) {
        $squads[$run]['squads_id'] = 0;
        $squads[$run]['squads_name'] = '? ID:'.$squads_run['squads_id'];
      }
      else {
        $squads[$run]['squads_id'] = $squads_run['squads_id'];
        $squads[$run]['squads_name'] = $squads_name['squads_name'];
      }
      $run++;
    }
  }
  if(!empty($squads)) {
    $data['if']['teams'] = true;
    
    $run=0;
    foreach($squads as $squads_run) {
      $data['squads'][$run]['name'] = empty($squads_run['squads_id']) ? cs_secure($squads_run['squads_name']) : cs_link(cs_secure($squads_run['squads_name']),'squads','view','id=' . $squads_run['squads_id']);
    
      $part_tab = 'members mem INNER JOIN {pre}_users usr ON mem.users_id = usr.users_id';
      $part_cells = 'mem.members_admin AS members_admin, usr.users_nick AS users_nick, usr.users_id AS users_id, usr.users_active AS users_active, usr.users_country AS users_country';
      $where = "mem.squads_id = '" . $squads_run['squads_id'] . "'";
      $members = cs_sql_select(__FILE__,$part_tab,$part_cells,$where,'mem.members_order',0,0);
      
      if(empty($members)) {
        $data['loop']['members'] = '';
        $data['stop']['members'] = '';
        $data['squads'][$run]['members']['country'] = '';
        $data['squads'][$run]['members']['name'] = '';
        $data['squads'][$run]['members']['dot'] = '';
      }
      else {
        $members_loop = count($members);
        for($run_2=0; $run_2<$members_loop; $run_2++) {
          $users_nick = cs_secure($members[$run_2]['users_nick']);
          $users_link = cs_user($members[$run_2]['users_id'],$members[$run_2]['users_nick'], $members[$run_2]['users_active']);
           
          if(!empty($members[$run_2]['members_admin'])) {
            $users_link = cs_html_big(1) . $users_link . cs_html_big(0);
          }
          $all = $run_2 == ($members_loop - 1) ? '' : ', ';
      
          if(empty($members[$run_2]['users_country'])) {
            $country = '-';
          }
          else {
            $url = 'symbols/countries/' . $members[$run_2]['users_country'] . '.png';
            $country =  cs_html_img($url,11,16);
          }
      
          $data['squads'][$run]['members'][$run_2]['country'] = $country;
          $data['squads'][$run]['members'][$run_2]['name'] = $users_link;
          $data['squads'][$run]['members'][$run_2]['dot'] = $all;
          
        }
      }
      $run++;
    }
    
  }  
}
else {
  $tables = 'cupsquads cs INNER JOIN {pre}_users usr ON cs.squads_id = usr.users_id';
  $cells = 'cs.squads_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active';
  $select = cs_sql_select(__FILE__,$tables,$cells,'cs.cups_id = ' . $cups_id,'usr.users_nick',0,0);
  
  if(!empty($select)) {
    $data['if']['players'] = true;
    
    foreach ($select AS $user) {
      $data['cup_loop'][]['players'] = cs_user($user['users_id'],$user['users_nick'], $user['users_active']);
    }
  }
}

echo cs_subtemplate(__FILE__,$data,'cups','view');