<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

$match_id = (int) $_GET['id'];

$tables = 'cupmatches cm INNER JOIN {pre}_cups cp ON cm.cups_id = cp.cups_id';
$cells = 'cp.cups_system AS cups_system';
$system = cs_sql_select(__FILE__,$tables,$cells,'cm.cupmatches_id = \''.$match_id.'\'');

$tables  = 'cupmatches cm ';
$tables .= 'INNER JOIN {pre}_cups cp ON cm.cups_id = cp.cups_id ';
$tables .= 'INNER JOIN {pre}_games gms ON cp.games_id = gms.games_id ';

if ($system['cups_system'] == 'teams') {
  $tables .= 'INNER JOIN {pre}_squads sq1 ON cm.squad1_id = sq1.squads_id ';
  $tables .= 'INNER JOIN {pre}_squads sq2 ON cm.squad2_id = sq2.squads_id';
} else {
  $tables .= 'INNER JOIN {pre}_users usr1 ON cm.squad1_id = usr1.users_id ';
  $tables .= 'INNER JOIN {pre}_users usr2 ON cm.squad2_id = usr2.users_id';
}

$cells  = 'cm.cups_id AS cups_id, cp.cups_name AS cups_name, ';
$cells .= 'cp.games_id AS games_id, gms.games_name AS games_name, ';
$cells .= 'cm.cupmatches_score1 AS cupmatches_score1, ';
$cells .= 'cm.cupmatches_score2 AS cupmatches_score2, ';
$cells .= 'cm.cupmatches_accepted1 AS cupmatches_accepted1, ';
$cells .= 'cm.cupmatches_accepted2 AS cupmatches_accepted2, ';

if ($system['cups_system'] == 'teams') {
  $cells .= 'sq1.squads_name AS squad1_name, sq2.squads_name AS squad2_name, ';
  $cells .= 'cm.squad1_id AS squad1_id, cm.squad2_id AS squad2_id';
} else {
  $cells .= 'usr1.users_nick AS user1_nick, usr2.users_nick AS user2_nick, ';
  $cells .= 'cm.squad1_id AS user1_id, cm.squad2_id AS user2_id';
}

$cs_cups = cs_sql_select(__FILE__,$tables,$cells,'cupmatches_id = \''.$match_id.'\'');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['match'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');
echo $cs_lang['matchdetails'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_html_table(1,'forum',1);

echo cs_html_roco(1,'leftc');
if ($system['cups_system'] == 'teams') {
  echo cs_icon('kdmconfig') . $cs_lang['team'] . ' 1';
} else {
  echo cs_icon('personal') . $cs_lang['player'] . ' 1';
}
echo cs_html_roco(2,'leftb');
if ($system['cups_system'] == 'teams') {
  echo cs_link($cs_cups['squad1_name'],'squads','view','id='.$cs_cups['squad1_id']);
} else {
  $users_data = cs_sql_select(__FILE__,'users','users_active, users_delete',"users_id = '" . $cs_cups['user1_id'] . "'");
  echo cs_user($cs_cups['user1_id'],$cs_cups['user1_nick'], $users_data['users_active'], $users_data['users_delete']);
}
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
if ($system['cups_system'] == 'teams') {
  echo cs_icon('kdmconfig') . $cs_lang['team'] . ' 2';
} else {
  echo cs_icon('personal') . $cs_lang['player'] . ' 2';
}
echo cs_html_roco(2,'leftb');
if ($system['cups_system'] == 'teams') {
  echo cs_link($cs_cups['squad2_name'],'squads','view','id='.$cs_cups['squad2_id']);
} else {
  $users_data = cs_sql_select(__FILE__,'users','users_active',"users_id = '" . $cs_cups['user2_id'] . "'");
  echo cs_user($cs_cups['user2_id'],$cs_cups['user2_nick'], $users_data['users_active']);
}
echo cs_html_roco(0);
  
echo cs_html_roco(1,'leftc');
echo cs_icon('kreversi') . $cs_lang['cup'];
echo cs_html_roco(2,'leftb');
echo cs_link($cs_cups['cups_name'],'cups','view','id='.$cs_cups['cups_id']);
echo cs_html_roco(0);
  
echo cs_html_roco(1,'leftc');
echo cs_icon('package_games') . $cs_lang['game'];
echo cs_html_roco(2,'leftb');
echo cs_link($cs_cups['games_name'],'games','view','id='.$cs_cups['games_id']);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('smallcal') . $cs_lang['result'];
echo cs_html_roco(2,'leftb');
if (!empty($cs_cups['cupmatches_score1']) || !empty($cs_cups['cupmatches_score2'])) {
  echo $cs_cups['cupmatches_score1'] .' : '. $cs_cups['cupmatches_score2'];
} else {
  echo '-';
}
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('demo');
echo $cs_lang['status'];
echo cs_html_roco(2,'leftb');
if (empty($cs_cups['cupmatches_accepted1']) || empty($cs_cups['cupmatches_accepted2'])) {
  echo $cs_lang['open'];
} else {
  echo $cs_lang['closed'];
}
echo cs_html_roco(0);

echo cs_html_table(0);

if ($system['cups_system'] == 'teams') {
  $cond = 'users_id = \''.$account['users_id'].'\' AND squads_id = \''.$cs_cups['squad1_id'].'\'';
  $squad1_member = cs_sql_count(__FILE__,'members',$cond);
  
  $cond = 'users_id = \''.$account['users_id'].'\' AND squads_id = \''.$cs_cups['squad2_id'].'\'';
  $squad2_member = cs_sql_count(__FILE__,'members',$cond);
} else {
  $squad1_member = $cs_cups['user1_id'] == $account['users_id'] ? 1 : 0;
  $squad2_member = $cs_cups['user2_id'] == $account['users_id'] ? 1 : 0;
}

if (!empty($squad1_member) OR !empty($squad2_member) OR $account['access_cups'] >= 4) {
  
  echo cs_html_br(1);
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'centerb');
  echo cs_html_form(1,'matchadmin','cups','matchedit');
  echo '&nbsp;';
  echo cs_html_vote('cupmatches_id',$match_id,'hidden');

  if (
     (!empty($squad1_member) or !empty($squad2_member))
    &&
     (empty($cs_cups['cupmatches_score1']) && empty($cs_cups['cupmatches_score2']))
    &&
     (empty($cs_cups['cupmatches_accepted1']) && empty($cs_cups['cupmatches_accepted1']))
    ) {
    
    $team = !empty($squad2_member) ? 2 : 1;
    echo cs_html_vote('team',$team,'hidden');
    echo cs_html_vote('result',$cs_lang['enter_result'],'submit');
    
  } elseif(!empty($squad1_member) && empty($cs_cups['cupmatches_accepted1'])) {
    
    echo cs_html_vote('accept1',$cs_lang['accept_result'],'submit');
    
  } elseif (!empty($squad2_member) AND empty($cs_cups['cupmatches_accepted2'])) {
    
    echo cs_html_vote('accept2',$cs_lang['accept_result'],'submit');
    
  } elseif (!empty($cs_cups['cupmatches_accepted1']) && !empty($cs_cups['cupmatches_accepted2'])) {
    
    echo $cs_lang['both_confirmed'];
    
  } else {
    
    $other_team = empty($squad2_member) ? 2 : 1;
    
    if ($system['cups_system'] == 'teams') {
      $link = cs_link($cs_cups['squad'.$other_team.'_name'],'squads','view','id='.$cs_cups['squad'.$other_team.'_id']);
    } else {
      $users_data = cs_sql_select(__FILE__,'users','users_active',"users_id = '" . $cs_cups['user'.$other_team.'_id'] . "'");
      
      $link =  cs_user($cs_cups['user'.$other_team.'_id'],$cs_cups['user'.$other_team.'_nick'], $users_data['users_active']);
    }
    printf($cs_lang['waiting'],$link);  
  }
  
  if ($account['access_cups'] >= 4) {
    
    echo cs_html_vote('adminedit',$cs_lang['adminedit'],'submit');
    
  }
  
  echo cs_html_form(0);
  echo cs_html_roco(0);
  echo cs_html_table(0);
}

$count = cs_sql_count(__FILE__,'comments','comments_fid = \''.$match_id.'\' AND comments_mod = \'cups\'');

include_once 'mods/comments/functions.php';

if (!empty($count)) {
  echo cs_html_br(1);
  echo cs_comments_view($match_id,'cups','match',$count);
}
echo cs_comments_add($match_id,'cups');

?>