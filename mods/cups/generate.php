<?php
function find_current_order ($aMatches) {
  if(!is_array($aMatches))
    return 0;
  
  $iTemp = 0;
  foreach ($aMatches as $aMatch) {
    if($iTemp != $aMatch['cupmatches_tree_order']) // match noch nicht vorhanden also abbrechen
      break;
    
    $iTemp++;
  }      
  return $iTemp;
}

function cs_cupmatch ($cupmatches_id, $winner, $loser) {
  settype($cupmatches_id,'integer');
  settype($winner,'integer');
  settype($loser,'integer');
  
  $match = cs_sql_select(__FILE__,'cupmatches','cups_id, cupmatches_round, cupmatches_loserbracket, cupmatches_tree_order','cupmatches_id = ' . $cupmatches_id);
  $cups_id = $match['cups_id'];
  $round = $match['cupmatches_round'];
  $loserbracket = empty($match['cupmatches_loserbracket']) ? 0 : 1;
  
  if ($round == 1) return FALSE;  // If it was the last round
  
  $cup = cs_sql_select(__FILE__,'cups','cups_teams, cups_brackets','cups_id = ' . $cups_id);
  $rounds = strlen(decbin($cup['cups_teams'])) - 1;
  
  $position = $match['cupmatches_tree_order']%2 == 0 ? 1 : -1;
  $opponent_position = $match['cupmatches_tree_order']+$position;
  $where = 'cups_id = ' . $cups_id . ' AND cupmatches_round = ' . $round . ' AND cupmatches_tree_order = ' . $opponent_position . ' AND cupmatches_loserbracket = ' . $match['cupmatches_loserbracket'];
  $cells = 'cupmatches_accepted1, cupmatches_accepted2, cupmatches_winner';
  if (!empty($cup['cups_brackets'])) $cells .= ', squad1_id, squad2_id';
  $opponent = cs_sql_select(__FILE__, 'cupmatches', $cells, $where);
  
  if (empty($opponent['cupmatches_accepted1']) || empty($opponent['cupmatches_accepted2']))
    return FALSE; // match not finished
  
  $newmatch = array();
  $newmatch['cups_id'] = $cups_id;
  $newmatch['squad1_id'] = $position==1 ? $winner : $opponent['cupmatches_winner'];
  $newmatch['squad2_id'] = $position==1 ? $opponent['cupmatches_winner'] : $winner;
  $newmatch['cupmatches_round'] = $round - 1;
  $newmatch['cupmatches_loserbracket'] = $match['cupmatches_loserbracket'];
  $newmatch['cupmatches_tree_order'] = floor($match['cupmatches_tree_order'] / 2);
  cs_sql_insert (__FILE__, 'cupmatches', array_keys($newmatch), array_values($newmatch));
  
  if (!empty($cup['cups_brackets']) && $round == $rounds) { // If it was the first round, now create a match for the losers too
    // calc number of loser-matches
    $losers = cs_sql_count(__FILE__,'cupsquads','cups_id = '.$cups_id) - $cup['cups_teams'] / 2;
    $n=2;
    while ( $losers > $n ) $n *= 2;
    $count_matches = $n;
    $halfmax = $count_matches / 2;
    $roundl = strlen(decbin($count_matches)) - 1;
    $matches = array();
    for ($x=1; $x <= $losers; $x++) {
      $z = $x > $halfmax ? $x - $halfmax : $x;
      $y = $x > $halfmax ? 2 : 1;
      $matches[$z][$y] = TRUE;
    }
    
    $newmatch = array();
    $newmatch['cups_id'] = $cups_id;
    $newmatch['squad1_id'] = $loser;
    $newmatch['squad2_id'] = $opponent['cupmatches_winner'] == $opponent['squad1_id'] ? $opponent['squad2_id'] : $opponent['squad1_id'];
    $newmatch['cupmatches_round'] = $roundl;
    $newmatch['cupmatches_loserbracket'] = 1;
    $where = 'cups_id = ' . $cups_id . ' AND cupmatches_loserbracket = 1 AND cupmatches_round = ' . $roundl;
    $temp = find_current_order(cs_sql_select(__FILE__,'cupmatches','cupmatches_tree_order', $where, 'cupmatches_tree_order ASC',0,0));
    $newmatch['cupmatches_tree_order'] = empty($newmatch['squad2_id']) ? ($halfmax-1) : $temp;
    
    if (empty($matches[$newmatch['cupmatches_tree_order']+1][2])) { // Keine Gegner mehr, also Freilose erstellen
      $newmatch["cupmatches_accepted1"] = 1;
      $newmatch["cupmatches_accepted2"] = 1;
      $newmatch["cupmatches_winner"] = $loser;
      $newmatch["cupmatches_score1"] = 1;
      $newmatch["cupmatches_score2"] = 0;
      $newmatch['squad2_id'] = 0;
      cs_sql_insert (__FILE__, 'cupmatches', array_keys($newmatch), array_values($newmatch));
      
      // erstes freilos-match ist drin, also kommt jetzt das zweite
      // 2^(n - 1) - 1 == letzte cupmatches_tree_order-nummer in dieser runde
      $newmatch['cupmatches_tree_order']++;
      if(pow(2, $roundl - 1) > $newmatch['cupmatches_tree_order']) {
        $new_match = floor($newmatch['cupmatches_tree_order'] / 2);
        $newmatch['squad1_id'] = $loser == $opponent['squad1_id'] ? $opponent['squad2_id'] : $opponent['squad1_id'];
        $newmatch["cupmatches_winner"] = $newmatch['squad1_id'];
        cs_sql_insert (__FILE__, 'cupmatches', array_keys($newmatch), array_values($newmatch));
      }
    }
    else
      cs_sql_insert (__FILE__, 'cupmatches', array_keys($newmatch), array_values($newmatch));
    
    if(isset($new_match) && $roundl > 2) { // neues match für die beiden freilos-spiele erstellen, die gerade erstellt wurden
      $newmatch = array();
      $newmatch['cups_id'] = $cups_id;
      $newmatch['squad1_id'] = $loser;
      $newmatch['squad2_id'] = $opponent['cupmatches_winner'] == $opponent['squad1_id'] ? $opponent['squad2_id'] : $opponent['squad1_id'];
      $newmatch['cupmatches_round'] = $roundl - 1;
      $newmatch['cupmatches_loserbracket'] = 1;
      $newmatch['cupmatches_tree_order'] = $new_match;
      cs_sql_insert (__FILE__, 'cupmatches', array_keys($newmatch), array_values($newmatch));
    }
  }
  return TRUE;
}