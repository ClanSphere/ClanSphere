<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

$cups_id = !empty($_POST['where']) ? (int) $_POST['where'] : (int) $_GET['where'];

$maxteams = cs_sql_select(__FILE__,'cups','cups_teams','cups_id = \''.$cups_id.'\'');
$cupteams = strlen(decbin($maxteams['cups_teams']));

$round = !empty($_POST['round']) ? (int) $_POST['round'] : 1;
$round = !empty($_GET['round']) ? (int) $_GET['round'] : $round;
$round2 = $cupteams - $round;

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];

$system = cs_sql_select(__FILE__,'cups','cups_system, cups_brackets','cups_id = \''.$cups_id.'\'');

if ($system['cups_system'] == 'teams') {
  $cs_sort[1] = 'sq1.squads_name ASC';
  $cs_sort[2] = 'sq1.squads_name DESC';
  $cs_sort[3] = 'sq2.squads_name ASC';
  $cs_sort[4] = 'sq2.squads_name DESC';
} else {
  $cs_sort[1] = 'usr1.users_nick ASC';
  $cs_sort[2] = 'usr1.users_nick DESC';
  $cs_sort[3] = 'usr2.users_nick ASC';
  $cs_sort[4] = 'usr2.users_nick DESC';
}
$cs_sort[5] = 'cm.cupmatches_loserbracket ASC';
$cs_sort[6] = 'cm.cupmatches_loserbracket DESC';

$sort = empty($_GET['sort']) ? 3 : $_GET['sort'];
$order = $cs_sort[$sort];

$tables  = 'cupmatches cm ';
if ($system['cups_system'] == 'teams') {
  $tables .= 'INNER JOIN {pre}_squads sq1 ON cm.squad1_id = sq1.squads_id ';
  $tables .= 'INNER JOIN {pre}_squads sq2 ON cm.squad2_id = sq2.squads_id';
} else {
  $tables .= 'INNER JOIN {pre}_users usr1 ON cm.squad1_id = usr1.users_id ';
  $tables .= 'INNER JOIN {pre}_users usr2 ON cm.squad2_id = usr2.users_id';
}

$cells  = 'cm.cupmatches_id AS cupmatches_id, cm.cupmatches_score1 AS cupmatches_score1, ';
$cells .= 'cm.cupmatches_score2 AS cupmatches_score2, ';
if (!empty($system['cups_brackets']))
   $cells .= 'cm.cupmatches_loserbracket AS cupmatches_loserbracket, ';
if ($system['cups_system'] == 'teams') {
  $cells .= 'sq1.squads_id AS squad1_id, sq1.squads_name AS squad1_name, ';
  $cells .= 'sq2.squads_id AS squad2_id, sq2.squads_name AS squad2_name';
} else {
  $cells .= 'usr1.users_id AS user1_id, usr1.users_nick AS user1_nick, ';
  $cells .= 'usr2.users_id AS user2_id, usr2.users_nick AS user2_nick';
}

$cond = 'cm.cupmatches_round = \''.$round2.'\' and cm.cupmatches_id > \''.$start.'\' and cm.cups_id = \''.$cups_id.'\'';

$select = cs_sql_select(__FILE__,$tables,$cells,$cond,$order,0,$account['users_limit']);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['mod'] . ' - ' . $cs_lang['matchlist'];
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc');
echo cs_icon('contents') . $cs_lang['total'].': '.count($select);
echo cs_html_roco(2,'leftc');
echo cs_pages('cups','matchlist',count($select),$start,$cups_id,$sort);
echo cs_html_roco(0);

echo cs_html_roco(1,'leftc',0,2);
echo cs_html_form(1,'cups_tree','cups','matchlist');
echo cs_html_vote('where',$cups_id,'hidden');
echo cs_html_select(1,'round');

for ($x = 1; $x < $cupteams; $x++) {
  
  $sel = $x == $round ? 1 : 0;
  echo cs_html_option($cs_lang['round'] . $x,$x,$sel);
}

echo cs_html_select(0);
echo cs_html_vote('submit',$cs_lang['show'],'submit');
echo cs_html_form(0);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);


echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');

if (!empty($system['cups_brackets'])) {
  echo cs_sort('cups','matchlist',$start,$cups_id.'&amp;round='.$round,5,$sort);
  echo $cs_lang['bracket'];
  echo cs_html_roco(2,'headb');
}

echo cs_sort('cups','matchlist',$start,$cups_id.'&amp;round='.$round,1,$sort);
if ($system['cups_system'] == 'teams') {
  echo $cs_lang['team'] . ' 1';
} else {
  echo $cs_lang['player'] . ' 1';
}
echo cs_html_roco(2,'headb');
echo $cs_lang['result'];
echo cs_html_roco(3,'headb');
echo cs_sort('cups','matchlist',$start,$cups_id.'&amp;round='.$round,3,$sort);
if ($system['cups_system'] == 'teams') {
  echo $cs_lang['team'] . ' 2';
} else {
  echo $cs_lang['player'] . ' 2';
}
echo cs_html_roco(4,'headb');
echo $cs_lang['match'];
echo cs_html_roco(0);

if (!empty($select)) {
  
  $img_details = cs_icon('demo');
  
  foreach ($select AS $match) {
    
    echo cs_html_roco(1,'leftb');
    if (!empty($system['cups_brackets'])) {
      echo empty($match['cupmatches_loserbracket']) ? $cs_lang['winners'] : $cs_lang['losers'];
      echo cs_html_roco(2,'leftb');
    }
    
    if ($system['cups_system'] == 'teams') {
      echo cs_link($match['squad1_name'],'squads','view','id='.$match['squad1_id']);
    } else {
      $users_data = cs_sql_select(__FILE__,'users','users_active, users_delete',"users_id = '" . $match['user1_id'] . "'");
    echo cs_user($match['user1_id'],$match['user1_nick'], $users_data['users_active'], $users_data['users_delete']);
    }
    echo cs_html_roco(2,'leftb');
    echo $match['cupmatches_score1'] . ' : ' . $match['cupmatches_score2'];
    echo cs_html_roco(3,'leftb');
    if ($system['cups_system'] == 'teams') {
      echo cs_link($match['squad2_name'],'squads','view','id='.$match['squad2_id']);
    } else {
      $users_data = cs_sql_select(__FILE__,'users','users_active',"users_id = '" . $match['user2_id'] . "'");
    
    echo cs_user($match['user2_id'],$match['user2_nick'], $users_data['users_active']);
    }
    echo cs_html_roco(4,'leftb');
    echo cs_link($img_details,'cups','match','id='.$match['cupmatches_id']);
    echo cs_html_roco(0);
    
  }
  
} else {
  
  echo cs_html_roco(1,'leftc',0,empty($system['cups_brackets']) ? 4 : 5);
  echo $cs_lang['no_matches'];
  echo cs_html_roco(0);
  
}

echo cs_html_table(0);

?>