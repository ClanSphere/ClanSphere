<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cups');

include 'mods/cups/generate.php';

if (!empty($_POST['reduce'])) {
  
  $id = (int) $_POST['id'];
  
  $cs_cups['cups_teams'] = (int) $_POST['teams'];
  
  $cells = array_keys($cs_cups);
  $values = array_values($cs_cups);
  
  cs_sql_update(__FILE__,'cups',$cells,$values,$id);
  
}

if (!empty($_POST['start']) || !empty($_POST['reduce'])) {
  
  $id = (int) $_POST['id'];
  
  $maxteams = cs_sql_select(__FILE__,'cups','cups_teams','cups_id = ' . $id);
  $halfmax = $maxteams['cups_teams'] / 2;
  $select = cs_sql_select(__FILE__,'cupsquads','squads_id','cups_id = ' . $id,0,0,0);
  
  if(!empty($select)) {
    $x = 0;
    shuffle($select);
    foreach ($select AS $squad) {
      $x++;
      $z = $x > $halfmax ? $x - $halfmax : $x;
      $y = $x > $halfmax ? 2 : 1;
      $matches[$z][$y] = $squad['squads_id'];
    }
    // this is the result of the loop above: $matches[group][team 1 or 2] = squadid
  }

  if(!empty($matches)) {
    
    $round = strlen(decbin($maxteams['cups_teams'])) - 1;
    $run=1;
    foreach ($matches AS $match) {
      $cs_cups = array();
      $cs_cups['cups_id'] = $id;
      $cs_cups['squad1_id'] = $match[1];
      $cs_cups['squad2_id'] = empty($match[2]) ? 0 : $match[2];
      $cs_cups['cupmatches_round'] = $round;
      
      if (empty($match[2])) {
        $cs_cups['cupmatches_winner'] = $match[1];
        $cs_cups['cupmatches_accepted1'] = 1;
        $cs_cups['cupmatches_accepted2'] = 1;
        $cs_cups['cupmatches_score1'] = 1;
        $temp[$run] = TRUE;
      }
      else
        $temp[$run] = FALSE;
      
      $cells = array_keys($cs_cups);
      $values = array_values($cs_cups);
      cs_sql_insert(__FILE__,'cupmatches',$cells,$values);
      
      if($run%2 == 0 AND $temp[$run] === TRUE AND $temp[$run-1] === TRUE) { // if there are two free tickets consecutive
        $cs_cups = array();
        $cs_cups['cups_id'] = $id;
        $cs_cups['squad1_id'] = $last_squad;
        $cs_cups['squad2_id'] = $match[1];
        $cs_cups['cupmatches_round'] = $round-1;
        
        $cells = array_keys($cs_cups);
        $values = array_values($cs_cups);
        cs_sql_insert(__FILE__,'cupmatches',$cells,$values);
      }
      $last_squad = $match[1];
      $run++;
    }
    
    
  }

  cs_redirect($cs_lang['started_successfully'],'cups','manage');
  
} else {

  $id = (int) $_GET['id'];
  
  // if you like to remove squads automatically which doesn't exist anymore in the database uncomment the following lines:
  /*
  $del = cs_sql_select(__FILE__,'cupsquads cq LEFT JOIN {pre}_squads sq ON cq.squads_id = sq.squads_id','cq.squads_id','sq.squads_id IS NULL AND cups_id = ' . $id,0,0,0);
  foreach($del as $del_id)
    cs_sql_delete(__FILE__,'cupsquads', $del_id['squads_id'], 'squads_id');
  */
  
  $cupsel = cs_sql_select(__FILE__,'cups','cups_teams','cups_id = ' . $id);
  $squads_count = cs_sql_count(__FILE__,'cupsquads','cups_id = ' . $id);
  
  if (($cupsel['cups_teams'] / 2) >= $squads_count) {
    
    $bin = decbin($squads_count);
    if (substr_count($bin,'1') != 1) {
      // Get the smallest potency of 2 bigger then the team count
      $new = '1';
      for ($x = 0; $x < strlen($bin); $x++) {
        $new .= '0';
      }
      settype($new,'integer');
      $new = bindec($new);
    } else {
      // If the team count is a potency of 2 already
      $new = $squads_count == 1 ? 2 : $squads_count;
    }
    
    $data = array();
    $data['lang']['reduce'] = $cs_lang['more_teams_required'] . $cs_lang['reduce_1'] . $new . $cs_lang['reduce_2'];
    $data['var']['cups_id'] = $id;
    $data['var']['teams'] = $new;
    
    echo cs_subtemplate(__FILE__, $data, 'cups', 'start_reduce');
    
  } else {
    
    $data = array();
    $data['cup']['id'] = $id;
    
    echo cs_subtemplate(__FILE__, $data, 'cups', 'start');
    
  }  
}