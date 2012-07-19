<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('votes');

$cs_vote_tpl = array();
$cs_vote_tpl['head']['mod']      = $cs_lang['mod_name'];
$cs_vote_tpl['head']['action']  = $cs_lang['head_edit'];
$cs_vote_tpl['head']['body']    = $cs_lang['body_edit'];

echo cs_subtemplate(__FILE__,$cs_vote_tpl,'votes','action_head');

$vote_id = $_REQUEST['id'];
settype($vote_id,'integer');
$vote_edit = cs_sql_select(__FILE__,'votes','*',"votes_id = '" . $vote_id . "'");
unset($vote_edit['vote_id']);

$vote_error = 5;
$vote_form = 1;
$votes_start = $vote_edit['votes_start'];
$votes_end = $vote_edit['votes_end'];
$votes_access = $vote_edit['votes_access'];
$votes_question = $vote_edit['votes_question'];
$votes_election = $vote_edit['votes_election'];
$votes_several = $vote_edit['votes_several'];
$votes_close = $vote_edit['votes_close'];
$errormsg = '';

if(isset($_POST['submit']) OR isset($_POST['preview']))
{
  if(!empty($_POST['votes_question']))
  {
    $votes_question = $_POST['votes_question'];
    $vote_error--;
  }
  else
  {
    $errormsg .= $cs_lang['error_question'] . cs_html_br(1);
  }

  if(!empty($account['users_id']))
  {
    $vote_userid = $account['users_id'];
    $vote_error--;
  }

  $run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 1;
  $cs_files['votes_election'] = '';
  for($run=0; $run < $run_loop; $run++)
  {
      $num = $run+1;
    if(!empty($_POST["votes_election_$num"]))
    {
      $cs_files["votes_election"] = $cs_files["votes_election"] . "\n" . $_POST["votes_election_$num"];
    }
  }
  if(!empty($cs_files["votes_election"]))
  {
    $votes_election = $cs_files["votes_election"];
    $vote_error--;
  }
  else
  {
    $errormsg .= $cs_lang['error_election'] . cs_html_br(1);
  }

  if(cs_datepost('votes_start','unix'))
  {
    $votes_start = cs_datepost('votes_start','unix');
    $vote_error--;
  }

  if(cs_datepost('votes_end','unix'))
  {
    $votes_end = cs_datepost('votes_end','unix');
    $vote_error--;
  }
  else
  {
    $errormsg .= $cs_lang['error_time'] . cs_html_br(1);
  }
}
if(isset($_POST['submit']))
{
  if(empty($vote_error))
  {
    $votes_close = isset($_POST['votes_close']) ? $_POST['votes_close'] : 0;
    $votes_access = isset($_POST['votes_access']) ? $_POST['votes_access'] : 0;
    $votes_several = isset($_POST['votes_several']) ? $_POST['votes_several'] : 0;

    $vote_form = 0;
    $vote_cells = array('users_id','votes_access','votes_question','votes_election','votes_start','votes_end','votes_close','votes_several');
    $vote_save = array($vote_userid,$votes_access,$votes_question,$votes_election,$votes_start,$votes_end,$votes_close,$votes_several);
    cs_sql_update(__FILE__,'votes',$vote_cells,$vote_save,$vote_id);

    cs_redirect($cs_lang['changes_done'], 'votes') ;
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

    $vote_ans = cs_secure($cs_files["votes_election"]);
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


  if(isset($_POST['election']))
  {
    $run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 1;
  }
  else
  {
    $temp = explode("\n", $votes_election);
    $run_loop = count($temp);
  }
  $tpl_run = 0;
  for($run=1; $run < $run_loop; $run++)
  {
    $num = $run+1;
    if(isset($_POST['election']))
      {
      $cs_files["votes_election_$num"] = isset($_POST["votes_election_$num"]) ? $_POST["votes_election_$num"] : '';
    }
    else
    {
      $cs_files["votes_election_$num"] = $temp[$run];
    }
    $cs_vote_tpl['form_answers'][$tpl_run]['number']  = $run;
    $cs_vote_tpl['form_answers'][$tpl_run]['name']    = 'votes_election_'.$num;
    $cs_vote_tpl['form_answers'][$tpl_run]['value']    = $cs_files["votes_election_$num"];
    $tpl_run++;
  }

  $cs_vote_tpl['lang']['start'] = $cs_lang['votes_start'];
  $cs_vote_tpl['lang']['end']    = $cs_lang['votes_end'];
  $cs_vote_tpl['lang']['access'] = $cs_lang['access'];
  $cs_vote_tpl['lang']['question'] = $cs_lang['question'];
  $cs_vote_tpl['lang']['answer'] = $cs_lang['answer'];
  $cs_vote_tpl['lang']['more']  = $cs_lang['more'];
  $cs_vote_tpl['lang']['restrict_comments'] = $cs_lang['restrict_comments'];
  $cs_vote_tpl['lang']['options'] = $cs_lang['options'];
  $cs_vote_tpl['lang']['preview'] = $cs_lang['preview'];
  $cs_vote_tpl['lang']['reset'] = $cs_lang['reset'];
  $cs_vote_tpl['lang']['add_election'] = $cs_lang['add_election'];

  $cs_vote_tpl['votes']['start_dateselect'] = cs_dateselect('votes_start','unix',$votes_start,2005);
  $cs_vote_tpl['votes']['end_dateselect'] = cs_dateselect('votes_end','unix',$votes_end,2005);
  $cs_vote_tpl['votes']['question'] = $votes_question;
  $cs_vote_tpl['votes']['answers_count'] = $run_loop;
  $cs_vote_tpl['form']['action'] = cs_url('votes','edit');
  $cs_vote_tpl['votes']['lang_submit'] = $cs_lang['edit'];
  $cs_vote_tpl['votes']['id'] = $vote_id;
  $cs_vote_tpl['several']['checked'] = empty($votes_several) ? '' : 'checked';

  echo cs_subtemplate(__FILE__,$cs_vote_tpl,'votes','action_form');
}