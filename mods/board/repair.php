<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

function cs_board_comments($board_id) {

  settype($board_id,'integer');
  $from = 'threads thr INNER JOIN {pre}_comments com ON thr.threads_id = com.comments_fid';
  $where = "thr.board_id = '" . $board_id . "' AND comments_mod = 'board'";
  $com_sql = cs_sql_count(__FILE__,$from,$where);

  $cells = array('board_comments');
  $content = array($com_sql);
  cs_sql_update(__FILE__,'board',$cells,$content,$board_id);

  return $com_sql;
}

function cs_board_threads($board_id) {

  settype($board_id,'integer');
  $threads = cs_sql_count(__FILE__,'threads',"board_id = '" . $board_id . "'");

  $cells = array('board_threads');
  $content = array($threads);
  cs_sql_update(__FILE__,'board',$cells,$content,$board_id);

  return $threads;
}

function cs_threads_comments($threads_id) {

  settype($threads_id,'integer');
  $condition = "comments_mod = 'board' AND comments_fid = '" . $threads_id . "'";
  $comments = cs_sql_count(__FILE__,'comments',$condition);

  $cells = array('threads_comments');
  $content = array($comments);
  cs_sql_update(__FILE__,'threads',$cells,$content,$threads_id);

  return $comments;
}

?>