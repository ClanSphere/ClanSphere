<?php

function cs_cupround ($cups_id, $round, $maxteams, $brackets = 0) {
  
  settype($cups_id, 'integer');
  settype($round, 'integer');
  settype($maxteams, 'integer');
  
  // Get the winners
  
  $condition = "cups_id = '" . $cups_id . "' AND cupmatches_round = '" . $round . "'";
  $condition .= " AND cupmatches_loserbracket = '0'";
  $select = cs_sql_select(__FILE__,'cupmatches','cupmatches_winner',$condition,0,0,0);
  shuffle($select);
  $halfmax = count($select) / 2;
  
  $x = 0;
  foreach ($select AS $squad) {
    $x++;
    $z = $x > $halfmax ? $x - $halfmax : $x;
    $y = $x > $halfmax ? 2 : 1;
    $matches[$z][$y] = $squad['cupmatches_winner'];
  }
  
  // This is the result of the loop above: $matches[group][team 1 or 2] = squadid
  
  foreach ($matches AS $match) {
    $cs_cups = array();
    $cs_cups['cups_id'] = $cups_id;
    $cs_cups['squad1_id'] = $match[1];
    $cs_cups['squad2_id'] = $match[2];
    $cs_cups['cupmatches_round'] = $round - 1;
    
    $cells = array_keys($cs_cups);
    $values = array_values($cs_cups);
    cs_sql_insert(__FILE__,'cupmatches',$cells,$values);
    
  }
  
  if (!empty($brackets)) {
    
    // Losers (if brackets are activated)
    
    $matches = array();
    $x = 0;
    
    if ($round+1 == strlen(decbin($maxteams))) {
      
      // If the round before was the first, the losers go on
      
      $condition = 'cups_id = \''.$cups_id.'\' AND cupmatches_round = \''.$round.'\'';
      $teams = cs_sql_select(__FILE__,'cupmatches','cupmatches_winner, squad1_id, squad2_id',$condition,0,0,0);
      $halfmax = count($teams) / 2;
      shuffle($teams);
      
      foreach ($teams as $squad) {
        $x++;
        $z = $x > $halfmax ? $x - $halfmax : $x;
        $y = $x > $halfmax ? 2 : 1;
        $matches[$z][$y] = $squad['cupmatches_winner'] == $squad['squad1_id'] ? $squad['squad2_id'] : $squad['squad1_id'];
      }
      
    } else {
      
      // If the last round was not the first, the winners of the matches in the loserbracket go on
      
      $condition = 'cups_id = \''.$cups_id.'\' AND cupmatches_round = \''.$round.'\'';
      $condition .= ' AND cupmatches_loserbracket = \'1\'';
      $teams = cs_sql_select(__FILE__,'cupmatches','cupmatches_winner',$condition,0,0,0);
      $halfmax = count($teams) / 2;
      shuffle($teams);
      
      foreach ($teams as $squad) {
        $x++;
        $z = $x > $halfmax ? $x - $halfmax : $x;
        $y = $x > $halfmax ? 2 : 1;
        $matches[$z][$y] = $squad['cupmatches_winner'];
      }
      
    }
    
    foreach ($matches AS $match) {
      $cs_cups['cups_id'] = $cups_id;
      $cs_cups['squad1_id'] = $match[1];
      $cs_cups['squad2_id'] = $match[2];
      $cs_cups['cupmatches_round'] = $round - 1;
      $cs_cups['cupmatches_loserbracket'] = 1;
      
      $cells = array_keys($cs_cups);
      $values = array_values($cs_cups);
      cs_sql_insert(__FILE__,'cupmatches',$cells,$values);
    }
  }    
  
}

?>