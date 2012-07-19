<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('votes');

$cs_vote_tpl = array();
$cs_vote_tpl['head']['mod']      = $cs_lang['mod_name'];
$cs_vote_tpl['head']['action']  = $cs_lang['head_remove'];
$cs_vote_tpl['head']['body']    = '-';

echo cs_subtemplate(__FILE__,$cs_vote_tpl,'votes','action_head');

$vote_form = 1;
$vote_id = $_REQUEST['id'];

if(isset($_POST['agree']))
{
  $vote_form = 0;
  cs_sql_delete(__FILE__,'votes',$vote_id);
  $query = "DELETE FROM {pre}_voted WHERE voted_mod='votes' AND ";
  $query .= "voted_fid='" . $vote_id . "'";
  cs_sql_query(__FILE__,$query);
  cs_sql_delete(__FILE__,'voted',$vote_id,'voted_fid');

  cs_redirect($cs_lang['del_true'], 'votes');
}

if(isset($_POST['cancel']))
  cs_redirect($cs_lang['del_false'], 'votes');

if(!empty($vote_form))
{
  $cs_vote_tpl['remove']['mode'] = 'votes_remove';
  $cs_vote_tpl['remove']['action'] = 'remove';
  $cs_vote_tpl['remove']['id'] = $vote_id;
  $cs_vote_tpl['lang']['del_before']  = $cs_lang['del_before'];
  $cs_vote_tpl['lang']['del_next']    = $cs_lang['del_next'];
  $cs_vote_tpl['lang']['confirm']      = $cs_lang['confirm'];
  $cs_vote_tpl['lang']['cancel']      = $cs_lang['cancel'];

  echo cs_subtemplate(__FILE__,$cs_vote_tpl,'votes','remove');
}