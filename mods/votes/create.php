<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('votes');

$cs_vote_tpl = array();
$cs_vote_tpl['head']['mod']      = $cs_lang['mod_name'];
$cs_vote_tpl['head']['action']  = $cs_lang['head_create'];
$cs_vote_tpl['head']['body']    = $cs_lang['body_create'];

echo cs_subtemplate(__FILE__,$cs_vote_tpl,'votes','action_head');

$time = cs_time();
$vote_error = 5;
$vote_form = 1;
$votes_access = 0;
$votes_start = '';
$votes_end = '';
$votes_question = '';
$votes_election = '';
$votes_several = '';
$errormsg = '';
$votes_close = '';

  if(!empty($_POST['votes_access'])) {
    $votes_access = $_POST['votes_access'];
    $levels = $_POST['votes_access'];
  } else {
    $levels = 0;
  }

  if(!empty($account['users_id'])) {
    $vote_userid = $account['users_id'];
    $vote_error--;
  }

  $votes_close = empty($_POST['votes_close']) ? 0 : $_POST['votes_close'];
  $votes_several = empty($_POST['votes_several']) ? 0 : $_POST['votes_several'];

  if(!empty($_POST['votes_question'])) {
    $votes_question = $_POST['votes_question'];
    $vote_error--;
  } else {
    $errormsg .= $cs_lang['error_question'] . cs_html_br(1);
  }
  
  $run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 1;
  $cs_votes['votes_election'] = '';
  
  for($run=0; $run < $run_loop; $run++) {
    $num = $run+1;
    if(!empty($_POST["votes_election_$num"])) {
      $cs_votes["votes_election"] = $cs_votes["votes_election"] . "\n" . $_POST["votes_election_$num"];
    }
  }
  if(!empty($cs_votes["votes_election"])) {
    $votes_election = $cs_votes["votes_election"];
    $vote_error--;
  } else {
    $errormsg .= $cs_lang['error_election'] . cs_html_br(1);
  }

  if (!empty($_POST['votes_start_year'])) {
    $votes_start = cs_datepost('votes_start','unix');
    $vote_error--;
  } else {
    $votes_start = cs_time();
  }
  
  if (!empty($_POST['votes_start_year'])) { 
    $votes_end = cs_datepost('votes_end','unix');
    $vote_error--;
  } else {
    $errormsg .= $cs_lang['error_time'] . cs_html_br(1);
    $votes_end = cs_time() + 604800;
  }

if(isset($_POST['submit']))
{
  if(empty($vote_error))
  {
    $vote_form = 0;
    $vote_cells = array('users_id','votes_access','votes_time','votes_question','votes_election','votes_start','votes_end','votes_close','votes_several');
    $vote_save = array($vote_userid,$votes_access,$time,$votes_question,$votes_election,$votes_start,$votes_end,$votes_close,$votes_several);
    cs_sql_insert(__FILE__,'votes',$vote_cells,$vote_save);

    cs_redirect($cs_lang['create_done'],'votes');
  }
  else
  {
    $cs_vote_tpl['lang']['error_occurred'] = $cs_lang['error_occurred'];
    $cs_vote_tpl['error']['message'] = $errormsg;

    echo cs_subtemplate(__FILE__,$cs_vote_tpl,'votes','error');
  }
}

if(isset($_POST['preview']))
{
  if(empty($vote_error))
  {
    $cs_vote_tpl['votes']['action']    = '?mod=votes&amp;action=list';
    $cs_vote_tpl['votes']['question'] = cs_secure($_POST['votes_question']);

    $vote_ans = cs_secure($cs_votes["votes_election"]);
    $vote_ans_loop = count($vote_ans);
    for ($run = 0; $run < $vote_ans_loop; $run++)
    {
      $temp = explode("\n", $vote_ans);
      $tpl_run = 0;
      $count_temp = count($temp);
      for ($run = 1; $run < $count_temp; $run++)
      {
        $cs_vote_tpl['answers'][$tpl_run]['value']  = $run;
        $cs_vote_tpl['answers'][$tpl_run]['answer']  = $temp[$run];
        $tpl_run++;
      }
    }

    $cs_vote_tpl['votes']['type'] = empty($votes_several) ? 'radio' : 'checkbox';
    echo cs_subtemplate(__FILE__,$cs_vote_tpl,'votes','action_vote');
    unset($cs_vote_tpl['answers']);
  }
  else
  {
    $cs_vote_tpl['lang']['error_occurred'] = $cs_lang['error_occurred'];
    $cs_vote_tpl['error']['message'] = $errormsg;

    echo cs_subtemplate(__FILE__,$cs_vote_tpl,'votes','error');
  }
}

if(isset($_POST['election']))
{
  $vote_userid = $account['users_id'];
  $votes_access = $_POST['votes_access'];
  $levels = $_POST['votes_access'];
  $votes_question = $_POST['votes_question'];
  $votes_start = cs_datepost('votes_start','unix');
  $votes_end = cs_datepost('votes_end','unix');
  $votes_close = empty($_POST['votes_close']) ? 0 : $_POST['votes_close'];
  $votes_several = empty($_POST['votes_several']) ? 0 : $_POST['votes_several'];
  $_POST['run_loop']++;
}
if(!empty($vote_form))
{
  $levels = 0;
  while($levels < 6)
  {
    $votes_access == $levels ? $sel = 'selected="selected"' : $sel = '';
    $cs_vote_tpl['access'][$levels]['level_id']    = $levels;
    $cs_vote_tpl['access'][$levels]['level_name']  = $cs_lang['lev_'.$levels];
    $cs_vote_tpl['access'][$levels]['selected']    = $sel;
    $levels++;
  }


  $run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 1;
  for($run=0; $run < $run_loop; $run++)
  {
    $num = $run+1;
    $cs_votes["votes_election_$num"] = isset($_POST["votes_election_$num"]) ? $_POST["votes_election_$num"] : '';
    $cs_vote_tpl['form_answers'][$run]['number']  = $num;
    $cs_vote_tpl['form_answers'][$run]['name']    = 'votes_election_'.$num;
    $cs_vote_tpl['form_answers'][$run]['value']    = $cs_votes["votes_election_$num"];
  }

  $cs_vote_tpl['lang']['start'] = $cs_lang['votes_start'];
  $cs_vote_tpl['lang']['end'] = $cs_lang['votes_end'];

  $cs_vote_tpl['votes']['start_dateselect'] = cs_dateselect('votes_start','unix',$votes_start,2005);
  $cs_vote_tpl['votes']['end_dateselect'] = cs_dateselect('votes_end','unix',$votes_end,2005);
  $cs_vote_tpl['votes']['question'] = $votes_question;
  $cs_vote_tpl['votes']['answers_count'] = $run_loop;
  $cs_vote_tpl['form']['action'] = cs_url('votes','create');
  $cs_vote_tpl['votes']['lang_submit'] = $cs_lang['create'];
  $cs_vote_tpl['votes']['id'] = '';
  $cs_vote_tpl['several']['checked'] = empty($votes_several) ? '' : 'checked';

  echo cs_subtemplate(__FILE__,$cs_vote_tpl,'votes','action_form');
}
