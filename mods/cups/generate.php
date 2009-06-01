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

function cs_cupmatch ($cupmatches_id, $winner, $loser) {
	
	settype($winner, 'integer');
	
	$match = cs_sql_select(__FILE__,'cupmatches','cups_id, cupmatches_round, cupmatches_loserbracket',"cupmatches_id = '" . $cupmatches_id . "'");
	$cups_id = $match['cups_id'];
	$round = $match['cupmatches_round'];
	$loserbracket = empty($match['cupmatches_loserbracket']) ? 0 : 1;
	
	if ($round == 1) return false;
	
	$cup = cs_sql_select(__FILE__,'cups','cups_teams, cups_brackets',"cups_id = '" . $cups_id . "'");
	$rounds = strlen(decbin($cup['cups_teams'])) - 1;
	
	if ($round == $rounds) { // If it was the first round
		
		$cond = 'cupmatches_id < "' . $cupmatches_id . '" AND cups_id = "' . $cups_id . '" AND cupmatches_round = "' . $round . '"';
		$matches_before = cs_sql_count(__FILE__, 'cupmatches', $cond);
		
		$opponent_position = $matches_before % 2 == 0 ? 1 : 0; // 1 for opponent below, 0 for opponent above
		
		if (empty($opponent_position)) {
			$order = 'cupmatches_id DESC';
			$where = 'cupmatches_id < "' . $cupmatches_id . '"';
		} else {
			$order = 'cupmatches_id ASC';
			$where = 'cupmatches_id > "' . $cupmatches_id . '"';
		}
		$cells = 'cupmatches_accepted1, cupmatches_accepted2, cupmatches_winner';
		if (!empty($cup['cups_brackets'])) $cells .= ', squad1_id, squad2_id';
		
		$opponent = cs_sql_select (__FILE__, 'cupmatches', $cells, $where, $order);
		
	} else {
		
		$cupmatches = array();
		$round_now = $rounds - $round;
		
		$cells = 'squad1_id, squad2_id, cupmatches_winner';
		$where = 'cups_id = "' . $cups_id . '" AND cupmatches_round = "';
		
		$cupmatches[0] = cs_sql_select(__FILE__, 'cupmatches', $cells, $where . $rounds . '"','cupmatches_id',0,0);
		
		for ($r = 1; $r <= $round_now; $r++) {
			$roundsel = $rounds - $r;
			
			$cupmatches[$r] = cs_sql_select(__FILE__, 'cupmatches', $cells, $where . $roundsel . '" AND cupmatches_loserbracket = "' . $loserbracket . '"',0,0,0);
			$cupmatches[$r] = cs_cupmatches_fix ($cupmatches, $r);
		}

		$cupmatches = $cupmatches[$round_now]; // Delete unnecessary matches
		
		foreach ($cupmatches AS $key => $values) {
			if ($values['cupmatches_winner'] == $winner)
				break;
		}
		
		$opponent_position = $key % 2 == 0 ? 1 : 0; // 1 for opponent below, 0 for opponent above
		$opponent_key = empty($opponent_position) ? $key - 1 : $key + 1;
		
		$opponent = $cupmatches[$opponent_key];
		
		$opponent['cupmatches_accepted1'] = 1;
		
		$where  = 'cups_id = "' . $cups_id . '" AND squad1_id = "' . $opponent['squad1_id'] . '" AND squad2_id = "' . $opponent['squad2_id'] . '"';
		$where .= ' AND cupmatches_accepted1 = "1" AND cupmatches_accepted2 = "1"';
		
		$opponent['cupmatches_accepted2'] = cs_sql_count(__FILE__, 'cupmatches', $where);
		
	}
	
	if (empty($opponent['cupmatches_accepted1']) || empty($opponent['cupmatches_accepted2']))
		return false;
	
	$newmatch = array();
	$newmatch['cups_id'] = $cups_id;
	$newmatch['squad1_id'] = $winner;
	$newmatch['squad2_id'] = $opponent['cupmatches_winner'];
	$newmatch['cupmatches_round'] = $round - 1;
	$newmatch['cupmatches_loserbracket'] = $match['cupmatches_loserbracket'];
	
	cs_sql_insert (__FILE__, 'cupmatches', array_keys($newmatch), array_values($newmatch));
	
	if (!empty($cup['cups_brackets']) && $round == $rounds) { // If it was the first round, now create a match for the losers too
		
		$newmatch = array();
		$newmatch['cups_id'] = $cups_id;
		$newmatch['squad1_id'] = $loser;
		$newmatch['squad2_id'] = $opponent['cupmatches_winner'] == $opponent['squad1_id'] ? $opponent['squad2_id'] : $opponent['squad1_id'];
		$newmatch['cupmatches_round'] = $round - 1;
		$newmatch['cupmatches_loserbracket'] = 1;
		
		cs_sql_insert (__FILE__, 'cupmatches', array_keys($newmatch), array_values($newmatch));
		
	}
	
	return false;
}

function cs_cupmatches_fix ($cupmatches, $round) {
	
	$count = count($cupmatches[$round]);
	$fixes = array();
	
	for ($i = 0; $i < $count; $i++) {
		
		if (!empty($cupmatches[$round][$i]['cupmatches_winner']) && 
		    $cupmatches[$round][$i]['cupmatches_winner'] != $cupmatches[$round-1][$i]['squad1_id'] &&
		    $cupmatches[$round][$i]['cupmatches_winner'] != $cupmatches[$round-1][$i]['squad2_id']) {
		    	$key = cs_multiarray_search ($cupmatches[$round-1], $cupmatches[$round][$i]['cupmatches_winner'], 'squad1_id');
		    	if (!$key) $key = cs_multiarray_search ($cupmatches[$round-1], $cupmatches[$round][$i]['cupmatches_winner'], 'squad2_id');
		    	$key = ceil(($key + 1) / 2) - 1;
				$fixes[$key] = $cupmatches[$round][$i];
				unset($cupmatches[$round][$i]);
				
		}
		
	}

	$fixed = array();
	$max1 = empty($fixes) ? 0 : max(array_keys($fixes));
	$max2 = empty($cupmatches[$round]) ? 0 : max(array_keys($cupmatches[$round]));
	$count = max($max1, $max2);

	for ($i = 0; $i <= $count; $i++) {
		
		$fixed[$i] = empty($fixes[$i]) ? $cupmatches[$round][$i] : $fixes[$i];
		
	}
	
	return $fixed;
	
}

function cs_multiarray_search ($array, $search, $key) {
	
	$count = count($array);
	
	for ($i = 0; $i < $count; $i++) {
		if ($array[$i][$key] == $search) return $i;
	}
	
	return false;
	
}