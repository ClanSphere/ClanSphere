<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('votes');

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'votes_start DESC';
$cs_sort[2] = 'votes_start ASC';
$cs_sort[3] = 'votes_end DESC';
$cs_sort[4] = 'votes_end ASC';
$cs_sort[5] = 'votes_question DESC';
$cs_sort[6] = 'votes_question ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$cs_vote = cs_sql_select(__FILE__,'votes','*',0,$order,$start,$account['users_limit']);
$vote_loop = count($cs_vote);

$cs_vote_tpl['head']['votes_count'] = cs_sql_count(__FILE__,'votes');
$cs_vote_tpl['head']['pages']  = cs_pages('votes','manage',$cs_vote_tpl['head']['votes_count'],$start,0,$sort);

$cs_vote_tpl['head']['message'] = cs_getmsg();

$cs_vote_tpl['sort']['start']  = cs_sort('votes','manage',$start,0,1,$sort);
$cs_vote_tpl['sort']['end']    = cs_sort('votes','manage',$start,0,3,$sort);
$cs_vote_tpl['sort']['question'] = cs_sort('votes','manage',$start,0,5,$sort);

if (empty($vote_loop))
  $cs_vote_tpl['votes'] = '';

for($run=0; $run<$vote_loop; $run++)
{
  $cs_vote_tpl['votes'][$run]['start'] = cs_date('unix',$cs_vote[$run]['votes_start']);
  $cs_vote_tpl['votes'][$run]['end']   = cs_date('unix',$cs_vote[$run]['votes_end']);
  $cs_vote_tpl['votes'][$run]['question'] = cs_secure($cs_vote[$run]['votes_question']);
  $cs_vote_tpl['votes'][$run]['id'] = $cs_vote[$run]['votes_id'];
}

echo cs_subtemplate(__FILE__,$cs_vote_tpl,'votes','manage');