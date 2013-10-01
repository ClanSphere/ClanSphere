<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_board_comments($board_id) {

  settype($board_id,'integer');
  $from = 'threads thr INNER JOIN {pre}_comments com ON thr.threads_id = com.comments_fid';
  $where = "thr.board_id = '" . $board_id . "' AND comments_mod = 'board'";
  $com_sql = cs_sql_count(__FILE__,$from,$where);

  $cells = array('board_comments');
  $content = array($com_sql);
  cs_sql_update(__FILE__,'board',$cells,$content,$board_id,0,0);

  cs_board_last($board_id);

  return $com_sql;
}

function cs_board_last($board_id) {

  settype($board_id,'integer');

  $from = 'threads thr LEFT JOIN {pre}_users usr ON thr.users_id = usr.users_id LEFT JOIN {pre}_users uco ON thr.threads_last_user = uco.users_id';
  $where = "thr.board_id = '" . $board_id . "'";
  $cells = 'thr.threads_last_time AS board_last_time, thr.threads_headline AS board_last_thread, thr.threads_id AS board_last_threadid, '
            . 'thr.threads_last_user AS board_last_userid, uco.users_nick AS board_last_user, '
            . 'usr.users_nick AS create_user, usr.users_id AS create_userid, thr.threads_time AS create_time';
  $last_sql = cs_sql_select(__FILE__,$from,$cells,$where,'thr.threads_last_time DESC');

  if (empty($last_sql))
    $last_sql = array('board_last_time' => 0, 'board_last_thread' => 0, 'board_last_threadid' => 0, 'board_last_user' => 0, 'board_last_userid' => 0);
  else {
    # fallback to creation if no last data is available
    if(empty($last_sql['board_last_user'])) {
      $last_sql['board_last_user'] = $last_sql['create_user'];
      $last_sql['board_last_userid'] = $last_sql['create_userid'];
      $last_sql['board_last_time'] = $last_sql['create_time'];
    }
    unset($last_sql['create_user'], $last_sql['create_userid'], $last_sql['create_time']);
  }
  
  cs_sql_update(__FILE__,'board',array_keys($last_sql),array_values($last_sql),$board_id);

  return $last_sql;
}

function cs_board_threads($board_id) {

  settype($board_id,'integer');
  $threads = cs_sql_count(__FILE__,'threads',"board_id = '" . $board_id . "'");

  $cells = array('board_threads');
  $content = array($threads);
  cs_sql_update(__FILE__,'board',$cells,$content,$board_id,0,0);

  cs_board_last($board_id);

  return $threads;
}

function cs_threads_comments($threads_id) {

  settype($threads_id,'integer');
  $condition = "comments_mod = 'board' AND comments_fid = '" . $threads_id . "'";
  $comments = cs_sql_count(__FILE__,'comments',$condition);

  $cells = array('threads_comments');
  $content = array($comments);
  cs_sql_update(__FILE__,'threads',$cells,$content,$threads_id,0,0);

  return $comments;
}

function cs_repair_board ($thread_id = 0)
{
  $q_time = "UPDATE {pre}_threads thr SET threads_last_time = (SELECT "
          . "MAX(com.comments_time) FROM {pre}_comments com WHERE thr.threads_id = "
          . "com.comments_fid AND com.comments_mod = 'board')";
  $q_time .= empty($thread_id) ? '' : " WHERE threads_id = " . (int) $thread_id;
  cs_sql_query(__FILE__, $q_time);
         
  $q_user = "UPDATE {pre}_threads thr SET threads_last_user = (SELECT com.users_id "
          . "FROM {pre}_comments com WHERE com.comments_fid = thr.threads_id GROUP BY "
          . " com.comments_fid HAVING MAX(com.comments_time))";
  $q_user .= empty($thread_id) ? '' : " WHERE threads_id = " . (int) $thread_id;
  cs_sql_query(__FILE__, $q_user);
  
  $q_repair = "UPDATE {pre}_threads SET threads_last_user = users_id, "
            . "threads_last_time = threads_time WHERE threads_last_time = 0";
  cs_sql_query(__FILE__, $q_repair);
}