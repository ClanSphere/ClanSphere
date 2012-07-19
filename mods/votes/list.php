<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('votes');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'votes_end DESC';
$cs_sort[2] = 'votes_end ASC';
$cs_sort[3] = 'votes_question DESC';
$cs_sort[4] = 'votes_question ASC';
$cs_sort[5] = 'votes_id DESC';
$sort = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$users_ip = cs_getip();
$users_id = $account['users_id'];
$votes_access = $account['access_votes'];

$where = "votes_access <= '" . $votes_access . "'";
$from = 'votes';
$select = 'votes_id, votes_question, votes_election, votes_start, votes_end';
$cs_votes = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$votes_loop = count($cs_votes);
$cs_votes_archiv = $cs_votes;
$votes_id = $cs_votes[0]['votes_id'];

if(!empty($votes_loop))
{
  $where = "voted_mod = 'votes' AND voted_fid = '" . $votes_id . "' AND voted_ip = '" . cs_sql_escape($users_ip) . "'";
  if($users_id > 0)
  {
    $where = "voted_mod = 'votes' AND voted_fid = '" . $votes_id . "' AND users_id = '" . $users_id . "'";
  }
  $checkit_userip = cs_sql_count(__FILE__,'voted',$where);
}

$from = 'voted';
$select = 'voted_id, users_id, voted_ip, voted_answer, voted_fid';
$where = "voted_mod = 'votes'";
$cs_voted = cs_sql_select(__FILE__,$from,$select,$where,'','0','0');
$voted_loop = count($cs_voted);

$data['head']['count']  = $votes_loop;
$data['head']['pages']  = cs_pages('votes','list',$votes_loop,$start,0,$sort);
$data['head']['getmsg']    = cs_getmsg();

$data['sort']['question']  = cs_sort('votes','list',$start,0,3,$sort);
$data['sort']['ends_on']  = cs_sort('votes','list',$start,0,1,$sort);

$from = 'comments';
$select = 'comments_fid';
$where = "comments_mod = 'votes'";
$cs_comments = cs_sql_select(__FILE__,$from,$select,$where,'','0','0');
$comments_loop = count($cs_comments);

$com_count = 0;
for ($run_2 = 0; $run_2 < $comments_loop; $run_2++)
{
  $comments_fid = $cs_comments[$run_2]['comments_fid'];
  $votes_id = $cs_votes[0]['votes_id'];
  if($comments_fid == $votes_id)
  {
    $com_count++;
  }
}
$data['votes'] = '';

for($run=0; $run<$votes_loop; $run++)
{
  $question = cs_secure($cs_votes_archiv[$run]['votes_question']);
  $com_count = 0;
  for ($run_2 = 0; $run_2 < $comments_loop; $run_2++)
  {
    $comments_fid = $cs_comments[$run_2]['comments_fid'];
    $votes_id = $cs_votes_archiv[$run]['votes_id'];
    if($comments_fid == $votes_id)
    {
      $com_count++;
    }
  }
  $answers_count = 0;
  $votes_id = $cs_votes_archiv[$run]['votes_id'];
  for ($run_2 = 0; $run_2 < $voted_loop; $run_2++)
  {
    $voted_fid = $cs_voted[$run_2]['voted_fid'];
    if($voted_fid == $votes_id)
    {
      $answers_count++;
    }
  }

  $data['votes'][$run]['question_link'] = cs_link($question,'votes','view','where=' . $cs_votes_archiv[$run]['votes_id']);
  $data['votes'][$run]['com_count'] = $com_count;
  $data['votes'][$run]['elect_count'] = $answers_count;
  $data['votes'][$run]['ends_on'] = cs_date('unix',$cs_votes_archiv[$run]['votes_end'],1);
}

echo cs_subtemplate(__FILE__,$data,'votes');
