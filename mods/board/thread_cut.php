<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

if (!empty($_POST['submit'])) {

  $error = '';

  if (empty($_POST['board_id'])) $error .= cs_html_br(1). $cs_lang['no_board_selected'];
  if (empty($_POST['threads_headline'])) $error .= cs_html_br(1). $cs_lang['no_name'];
}

$comments_id = empty($_POST['submit']) ? (int) $_GET['id'] : (int) $_POST['comments_id'];

if (!empty($_POST['submit']) && empty($error)) {

  $cells = 'users_id, comments_time, comments_fid, comments_edit';
  $comment = cs_sql_select(__FILE__,'comments',$cells,'comments_id = "' . $comments_id . '"');

  // Get last comment
  $lastid = !empty($_POST['comments']) ? (int) end($_POST['comments']) : 0;
  $count_comments = !empty($_POST['comments']) ? count($_POST['comments']) : 0;
  $old_threads_id = (int) $_POST['old_threads_id'];

  if (!empty($lastid)) {
    $last = cs_sql_select(__FILE__,'comments','comments_time, users_id','comments_id = "' . $lastid . '"');
  } else {
    $last = array();
    $last['comments_time'] = $comment['comments_time'];
    $last['users_id'] = $comment['users_id'];
  }

  $save = array();
  $save['users_id'] = (int) $comment['users_id'];
  $save['threads_time'] = $comment['comments_time'];
  $save['threads_text'] = $_POST['threads_text'];
  $save['threads_headline'] = $_POST['threads_headline'];
  $save['threads_edit'] = $comment['comments_edit'];
  $save['board_id'] = (int) $_POST['board_id'];
  $save['threads_last_user'] = (int) $last['users_id'];
  $save['threads_last_time'] = $last['comments_time'];
  $save['threads_comments'] = $count_comments;

  $cells = array_keys($save);
  $values = array_values($save);

  cs_sql_insert(__FILE__,'threads',$cells, $values);

  $threads_id = cs_sql_insertid(__FILE__);

  if (empty($threads_id)) {
    cs_redirect($cs_lang['error'] . '.','board','thread','where=' . $comment['comments_fid']);
  }
  cs_sql_delete(__FILE__,'comments',$comments_id);

  // Move selected comments
  if (!empty($_POST['comments'])) {
    $cells = array('comments_fid');
    $content = array($threads_id);
    $cond_files = '';

    foreach ($_POST['comments'] as $comment_id) {
      settype($comment_id, 'integer');
      cs_sql_update(__FILE__,'comments',$cells,$content, $comment_id);
      $cond_files .= ' OR comments_id = "' . $comment_id . '"';
    }

    // Move attachments of the comments
    $cells = array('threads_id');
    $cond_files = substr($cond_files, 4);
    cs_sql_update(__FILE__, 'boardfiles', $cells, $content, 0, $cond_files);
    
  }
  // Move attachments of the thread
  $cells = array('threads_id', 'comments_id');
  $content = array($threads_id, 0);
  cs_sql_update(__FILE__, 'boardfiles', $cells, $content, 0, 'comments_id = "' . $comments_id . '"');

  // Update old threads information
  $cond = 'comments_fid = \'' . $old_threads_id . '\' AND comments_mod = \'board\'';
  $comments_old = cs_sql_count(__FILE__,'comments',$cond);
  $last = cs_sql_select(__FILE__,'comments','users_id, comments_time', $cond, 'comments_time ASC');

  if (empty($last)) {
    $last = cs_sql_select(__FILE__,'threads','users_id, threads_time', "threads_id = '" . $old_threads_id . "'");
    $last_time = $last['threads_time'];
  } else
    $last_time = $last['comments_time'];

  $save = array();
  $save['threads_last_user'] = $last['users_id'];
  $save['threads_last_time'] = $last_time;
  $save['threads_comments'] = $comments_old;

  $cells = array_keys($save);
  $values = array_values($save);

  cs_sql_update(__FILE__,'threads',$cells,$values,$old_threads_id);

  // Update board information

  include_once 'mods/board/repair.php';

  $board_id = (int) $_POST['board_id'];

  cs_board_comments($board_id);
  cs_board_last($board_id);
  cs_board_threads($board_id);

  $thread = cs_sql_select(__FILE__, 'threads', 'board_id', 'threads_id = "' . $old_threads_id . '"');

  if ($thread['board_id'] != $board_id) {

    $board_id = $thread['board_id'];

    cs_board_comments($board_id);
    cs_board_last($board_id);
    cs_board_threads($board_id);
  }  

  cs_redirect($cs_lang['success'] . ' ' . cs_link($cs_lang['to_old_thread'],'board','thread','where=' . $comment['comments_fid']),'board','thread','where=' . $threads_id);
}
else {

  $data = array();

  $data['url']['board_thread_cut'] = cs_url('board','thread_cut');

  if (empty($error)) {
    $tables = 'comments cms INNER JOIN {pre}_users usr ON cms.users_id = usr.users_id';
    $cells  = 'cms.comments_text AS comments_text, cms.comments_fid AS comments_fid, ';
    $cells .= 'usr.users_id AS users_id, usr.users_nick AS users_nick, ';
    $cells .= 'usr.users_active AS users_active, usr.users_country AS users_country';
    $data['comment'] = cs_sql_select(__FILE__,$tables,$cells,'comments_id = \'' . $comments_id . '\'');
    $data['comment']['comments_id'] = $comments_id;
  } else {
    $tables = 'comments cms INNER JOIN {pre}_users usr ON cms.users_id = usr.users_id';
    $cells  = 'cms.comments_fid AS comments_fid, ';
    $cells .= 'usr.users_id AS users_id, usr.users_nick AS users_nick, ';
    $cells .= 'usr.users_active AS users_active, usr.users_country AS users_country';
    $data['comment'] = cs_sql_select(__FILE__,$tables,$cells,'comments_id = \'' . $comments_id . '\'');
    $data['comment']['comments_text'] = $_POST['threads_text'];
    $data['lang']['errors_here'] = $cs_lang['error_occured'] . $error;
  }
  $data['abcode']['features'] = cs_abcode_features('threads_text');

  $tables = 'categories cat INNER JOIN {pre}_board b ON cat.categories_id = b.categories_id';
  $cells = 'cat.categories_name AS categories_name, b.board_name AS board_name, b.board_id AS board_id';
  $boards = cs_sql_select(__FILE__,$tables,$cells,0,0,0,0);

  $data['board']['select'] = cs_html_select(1, 'board_id');
  $data['board']['select'] .= cs_html_option('----', 0);
  foreach ($boards AS $board) {
    $data['board']['select'] .= cs_html_option($board['categories_name'] . ': ' . $board['board_name'], $board['board_id'], 0);
  }
  $data['board']['select'] .= cs_html_select(0);

  $data['comment']['text'] = cs_secure($data['comment']['comments_text'],1,1);
  $data['comment']['user'] = cs_user($data['comment']['users_id'], $data['comment']['users_nick'], $data['comment']['users_active']);

  $tables = 'comments cms INNER JOIN {pre}_users usr ON cms.users_id = usr.users_id';
  $cells  = 'usr.users_nick AS users_nick, usr.users_id AS users_id, cms.comments_text AS comments_text, ';
  $cells .= 'usr.users_active AS users_active, usr.users_country AS users_country, cms.comments_id AS comments_id';
  $cond = 'cms.comments_fid = \''.$data['comment']['comments_fid'].'\' AND comments_mod = \'board\' AND cms.comments_id > \'' . $comments_id . '\'';
  $data['comments'] = cs_sql_select(__FILE__,$tables,$cells,$cond,'comments_time',0,0);
  $comments_count = count($data['comments']);

  for ($run = 0; $run < $comments_count; $run++) {
    $data['comments'][$run]['user'] = cs_user($data['comments'][$run]['users_id'], $data['comments'][$run]['users_nick'], $data['comments'][$run]['users_active']);
    $data['comments'][$run]['comments_text'] = cs_secure($data['comments'][$run]['comments_text'],1,1);
    $data['comments'][$run]['checked'] = !empty($_POST) && in_array($data['comments'][$run]['comments_id'],$_POST['comments']) ? ' checked="checked"' : '';
  }

  echo cs_subtemplate(__FILE__,$data,'board','thread_cut');
}