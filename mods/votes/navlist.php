<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('votes');

$users_id = $account['users_id'];
$users_ip = cs_getip();
$time = cs_time();
$mod = 'votes';
$votes_error = '';
$votes_form = 1;
$votes_access = $account['access_votes'];

global $cs_db;
$type = $cs_db['type'];
unset($cs_db);

$from = 'votes';
$select = 'votes_id, votes_question, votes_election, votes_several';
$where = "votes_access <= '" . $votes_access . "' AND votes_start <= '" . $time . "' AND votes_end >= '" . $time . "'";
$sort = (in_array($type, array('mysql', 'mysqli'))) ? '{random}' : 'votes_end ASC';
$cs_votes = cs_sql_select(__FILE__,$from,$select,$where, $sort);
$votes_loop = count($cs_votes);
$votes_id = $cs_votes['votes_id'];

if(!empty($votes_loop)) {
  $where = "voted_mod = 'votes' AND voted_fid = '" . $votes_id . "' AND voted_ip = '" . cs_sql_escape($users_ip) . "'";
  if($users_id > 0) {
    $where = "voted_mod = 'votes' AND voted_fid = '" . $votes_id . "' AND users_id = '" . $users_id . "'";
  }
  $checkit_userip = cs_sql_count(__FILE__,'voted',$where);
}

if(!empty($checkit_userip)) {
  $votes_error++;
}

if(!empty($_REQUEST['mod'])) {
  $vote_mod = $_REQUEST['mod'];
} else {
  $vote_mod = "";
}

if(!empty($_REQUEST['action'])) {
  $vote_action = $_REQUEST['action'];
} else {
  $vote_action = "votes";
}

if(!empty($users_id)) {
  $users_id = $users_id;
} else {
  $users_id = '0';
}

if(!empty($_POST['voted_answer'])) {
  if(!empty($cs_votes['votes_several'])) {
    foreach($_POST['voted_answer'] AS $answer) {
    $voted_answer[] = $answer;
  }
  } else { 
    $voted_answer = $_POST['voted_answer'];
  }
} else {
  $votes_error++;
}

if(!empty($_REQUEST['votes_id'])) {
  $votes_id = $_REQUEST['votes_id'];
} else {
  $votes_error++;
}

if(isset($_POST['submit_votes']) ) {
  if(empty($votes_error)) {
    $votes_form = 0;
  if(isset($_POST['votes_several'])) {
    
    $temp = explode("\n", $cs_votes['votes_election']);
    $count_election = count($temp);
    $count_voted = count($_POST['voted_answer']);
    $error_several = 0;
    $where = "voted_fid = '" . $votes_id . "' AND voted_mod = '" . $mod . "' AND voted_ip = '" . cs_sql_escape($users_ip) . "'";
    $where .= " AND users_id = '" . $users_id . "' AND (";
    $voting = array();
    for ($run = 0; $run < $count_voted; $run++) {
      settype($voted_answer[$run], 'integer');
      if ($voted_answer[$run] < 1 || $voted_answer[$run] >= $count_election || in_array($voted_answer[$run], $voting)) {
        $error_several = 1;
        break;
      }
      $voting[] = $voted_answer[$run];
      $where .= 'voted_answer = "' . $voted_answer[$run] . '" OR ';
    }
    $where = substr($where,0,-4) . ')';
    
    $error_several += cs_sql_count(__FILE__, 'voted', $where);
    
    if (!empty($error_several)) die('Multivote triggered an error with answers -> Execution halted.');
    
    for($run = 0; $run < $count_voted; $run++) {
      $votes_cells = array('voted_fid','users_id','voted_time','voted_answer','voted_ip','voted_mod');
      $votes_save = array($votes_id,$users_id,$time,$voted_answer[$run],$users_ip,$mod);
      if(!empty($voted_answer[$run]))
        cs_sql_insert(__FILE__,'voted',$votes_cells,$votes_save);
      else
        cs_error(__FILE__, 'Empty answer for multivote with ID ' . $cs_votes_id);
    }
  } else {
    $votes_cells = array('voted_fid','users_id','voted_time','voted_answer','voted_ip','voted_mod');
    $votes_save = array($votes_id,$users_id,$time,$voted_answer,$users_ip,$mod);
    if(!empty($voted_answer))
      cs_sql_insert(__FILE__,'voted',$votes_cells,$votes_save);
    else
      cs_error(__FILE__, 'Empty answer for singlevote with ID ' . $cs_votes_id);
  }

  cs_redirect($cs_lang['create_done'],'votes','list');
  } else {
  $votes_form = 0;
  cs_redirect($cs_lang['error_occurred'],'votes','list');
  }
}

if(!empty($cs_votes) AND !empty($votes_form)) {
  $from = 'voted';
  $select = 'voted_id, users_id, voted_ip, voted_answer';
  $where = "voted_fid = \"" . $votes_id . "\" AND voted_mod = 'votes'";
  $cs_voted = cs_sql_select(__FILE__,$from,$select,$where,'','0','0');
  $voted_loop = count($cs_voted);
  $check_user_voted = 0;
  for ($run = 0; $run < $voted_loop; $run++) {
    $voted_users = $cs_voted[$run]['users_id'];
  $voted_ip = $cs_voted[$run]['voted_ip'];
  if($users_id > 0) {
    if($voted_users == $users_id) {
      $check_user_voted++;
    }
  } else {
    if($voted_ip == $users_ip) {
      $check_user_voted++;
    }
  }
  }
  if(empty($check_user_voted)) {
    $votes_navlist = array();
  $votes_navlist['lang']['create'] = $cs_lang['create'];
  $votes_navlist['votes']['id'] = $votes_id;
  $votes_navlist['votes']['type'] = empty($cs_votes['votes_several']) ? 'radio' : 'checkbox';
  $votes_navlist['if']['several'] = empty($cs_votes['votes_several']) ? 0 : 1;
  $votes_navlist['if']['several_name'] = empty($cs_votes['votes_several']) ? 0 : 1;
  $votes_navlist['votes']['question'] = $cs_votes['votes_question'];
#   $votes_navlist['votes']['action']   = '?' . $vote_action . $vote_more;
  $votes_navlist['url']['action'] = cs_url('votes');
//  $votes_navlist['url']['action'] = '?' . $_SERVER['argv'][0];
    
  $temp = explode("\n", $cs_votes['votes_election']);
  $answers_stop = count($temp) - 1;
  for ($run = 0; $run < $answers_stop; $run++) {
    $votes_navlist['answers'][$run]['value'] = ($run + 1);
    $votes_navlist['answers'][$run]['answer'] = $temp[($run + 1)];
  }
  echo cs_subtemplate(__FILE__,$votes_navlist,'votes','navlist_vote');
  } else {
    $votes_navlist = array();
  $votes_navlist['votes']['question'] = $cs_votes['votes_question'];
  $temp = explode("\n", $cs_votes['votes_election']);
  $answers_stop = count($temp) - 1;

  for ($run = 0; $run < $answers_stop; $run++) {
    $answer_count = 0;
    for ($run_2 = 0; $run_2 < $voted_loop; $run_2++) {
      $voted_answer = $cs_voted[$run_2]['voted_answer'];
    if($voted_answer == ($run + 1)) {
      $answer_count++;
    }
    }
    if(!empty($answer_count)) {
    $answer_percent = $answer_count / $voted_loop * 100;
    } else {
    $answer_percent = '0';
    }
    $answer_percent = round($answer_percent,1);
    $votes_navlist['results'][$run]['answer'] = $temp[($run + 1)];
    $votes_navlist['results'][$run]['percent'] = $answer_percent;
    if(!empty($answer_count)) {
      $votes_navlist['results'][$run]['end_img'] = cs_html_img('symbols/votes/vote02.png','13','2');
    } else {
    $votes_navlist['results'][$run]['end_img']  = '';
    }
  }
  $votes_navlist['votes']['id'] = $votes_id;
  $votes_navlist['lang']['current_vote'] = $cs_lang['current_vote'];
  echo cs_subtemplate(__FILE__,$votes_navlist,'votes','navlist_results');
  }
} else {
  if(!empty($votes_form)) {
    echo $cs_lang['no_actvote'];
  }
}