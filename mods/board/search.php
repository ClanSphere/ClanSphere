<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');
$data = array();


$keywords = empty($_POST['keywords']) ? '' : $_POST['keywords'];
$searchmode = empty($_POST['searchmode']) ? 1 : $_POST['searchmode'];
$searcharea = empty($_POST['searcharea']) ? 'threads' : $_POST['searcharea'];
$board_id = empty($_POST['board_id']) ? 0 : $_POST['board_id'];
settype($board_id,'integer');
$page = empty($_POST['page']) ? 0 : $_POST['page'];
settype($page,'integer');
$max_page = empty($_POST['max_page']) ? 0 : $_POST['max_page'];
settype($max_page,'integer');
$go_search = isset($_POST['search']) ? 1 : 0;

if (!empty($_GET['search'])) {
  $keywords = $_GET['search'];
  $go_search = 1;
}

if(isset($_POST['first'])) {
  $page = 0;
  $go_search = 1;
}
elseif(isset($_POST['back'])) {
  $page = $page > 0 ? $page - 1 : $page;
  $go_search = 1;
}
elseif(isset($_POST['next'])) {
  $page = $page < $max_page ? $page + 1 : $page;
  $go_search = 1;
}
elseif(isset($_POST['last'])) {
  $page = $max_page;
  $go_search = 1;
}

$data['data']['keywords'] = $keywords;

$checked = $searchmode == 1 ? array(1 => 1, 2 => 0) : array(1 => 0, 2 => 1);
$check_it = 'checked="checked"';
$data['check']['exact'] = empty($checked[1]) ? '' : $check_it;
$data['check']['keywords'] = empty($checked[2]) ? '' : $check_it;

$checked = $searcharea == 'threads' ? array(1 => 1, 2 => 0) : array(1 => 0, 2 => 1);
$data['check']['threads'] = empty($checked[1]) ? '' : $check_it;
$data['check']['comments'] = empty($checked[2]) ? '' : $check_it;


$tables = "board boa INNER JOIN {pre}_categories cat ON boa.categories_id = cat.categories_id";
$select = "boa.board_id AS board_id, boa.board_name AS board_name, cat.categories_name AS categories_name";
$axx_where = "boa.board_access <= '" . $account['access_board'] . "' AND boa.board_pwd = ''";
$sorting = "cat.categories_name ASC, boa.board_name ASC";
$board_data = cs_sql_select(__FILE__,$tables,$select,$axx_where,$sorting,0,0);

$data['board']['options'] = '';
if (!empty($board_data)) {
  foreach($board_data AS $board) {
    $sel = $board_id == $board['board_id'] ? 1 : 0;
    $content = $board['categories_name'] . ' -> ' . $board['board_name'];
    $data['board']['options'] .= cs_html_option($content,$board['board_id'],$sel);
  }
}


$data['if']['bottom'] = FALSE;

if(!empty($go_search)) {

  $data['if']['bottom'] = TRUE;
  $data['if']['results'] = FALSE;
  $data['if']['too_short'] = FALSE;
  $data['if']['not_found'] = FALSE;

  $key_check = strlen(trim($keywords));
  $key_esc = cs_sql_escape($keywords);

  if($searchmode == 1 AND $searcharea == 'threads') {
    $conditions = "(thr.threads_headline LIKE '%" . $key_esc . "%' OR thr.threads_text LIKE '%" . $key_esc . "%')";
  }
  elseif($searchmode == 1) {
    $conditions = "com.comments_text LIKE '%" . $key_esc . "%'";
  }
  else {
    $key_array = explode(' ',$key_esc);
    $conditions = '(';
    foreach($key_array AS $key) {
      if(strlen(trim($key)) > 2) {
        $conditions .= $searcharea == 'threads' ? "(thr.threads_headline LIKE '%" . $key . "%' OR thr.threads_text LIKE '%" . $key . "%') AND " : "com.comments_text LIKE '%" . $key . "%' AND ";
      }
    }
    $conditions = substr($conditions,0,-5) . ')';
  }
  if($key_check < 3 OR $conditions == ')' AND $searchmode != 1) {
    $data['if']['too_short'] = TRUE;
  }
  else {
    if(!empty($board_id)) {
      $conditions .= " AND boa.board_id = '" . $board_id . "'";
    }
    $conditions .= " AND boa.board_access <= '" . $account['access_board'] . "'";
    $select = 'cat.categories_name AS categories_name, cat.categories_id AS categories_id, boa.board_id AS board_id, boa.board_name AS board_name, thr.threads_id AS threads_id, thr.threads_headline AS threads_headline';
    if($searcharea == 'threads') {
      $select .= ', thr.threads_last_time AS last_action';
      $from = "threads thr INNER JOIN {pre}_board boa ON thr.board_id = boa.board_id INNER JOIN {pre}_categories cat ON boa.categories_id = cat.categories_id";
      $order = 'thr.threads_last_time DESC';
    }
    else {
      $conditions = "com.comments_mod = 'board' AND " . $conditions;
      $select .= ', com.comments_time AS last_action, com.comments_id AS comments_id';
      $from = "comments com INNER JOIN {pre}_threads thr ON com.comments_fid = thr.threads_id INNER JOIN {pre}_board boa ON thr.board_id = boa.board_id INNER JOIN {pre}_categories cat ON boa.categories_id = cat.categories_id";
      $order = 'com.comments_id DESC';
    }
    $conditions = $conditions . " AND boa.board_pwd = ''";
    $count = cs_sql_count(__FILE__,$from,$conditions);

    if(empty($count)) {
      $data['if']['not_found'] = TRUE;
    }
    else {
      $data['if']['results'] = TRUE;

      $data['hidden']['keywords'] = $keywords;
      $data['hidden']['searchmode'] = $searchmode;
      $data['hidden']['searcharea'] = $searcharea;
      $data['hidden']['board_id'] = $board_id;
      $data['hidden']['page'] = $page;
      $all_pages = floor($count / $account['users_limit']);
      $data['hidden']['max_page'] = $all_pages;

      $data['page']['of'] = $cs_lang['page'] . ' ' . ($page + 1) . ' ' . $cs_lang['of'] . ' ' . ($all_pages + 1);
      $data['count']['results'] = sprintf($cs_lang['found_matches'],$count);


      $start = $page * $account['users_limit'];
      $result = cs_sql_select(__FILE__,$from,$select,$conditions,$order,$start,$account['users_limit']);
      $result = is_array($result) ? $result : array();
      $run = 0;
      foreach($result AS $thread) {

        $data['res'][$run]['category'] = cs_link(cs_secure($thread['categories_name']),'board','list','id=' . $thread['categories_id']);
        $data['res'][$run]['board'] = cs_link(cs_secure($thread['board_name']),'board','listcat','id=' . $thread['board_id']);

        $headline = cs_secure($thread['threads_headline']);
        $data['res'][$run]['thread'] = cs_link($headline,'board','thread','where=' . $thread['threads_id']);

        $data['res'][$run]['target'] = '';
        if(!empty($thread['comments_id'])) {
          $start = cs_sql_count(__FILE__,'comments',"comments_fid = '" . $thread['threads_id'] . "' AND comments_id < '" . $thread['comments_id'] . "' AND comments_mod = 'board'");
          $page = floor(++$start / $account['users_limit']) * $account['users_limit'];
          $go_target = 'where=' . $thread['threads_id'] . '&amp;start=' . $page . '#com' . $start;
          $data['res'][$run]['target'] = cs_html_br(1) . cs_link($cs_lang['go_target'],'board','thread',$go_target);
        }

        $data['res'][$run]['date'] = '';
        if(!empty($thread['last_action'])) {
          $data['res'][$run]['date'] = cs_date('unix',$thread['last_action'],1);
        }
        $data['res'][$run]['user'] = '';
        if(!empty($thread['users_nick'])) {
          $user = cs_secure($thread['users_nick']);
          $cs_users = cs_sql_select(__FILE__,'users','users_active');
          $data['res'][$run]['user'] = cs_html_br(1) . $cs_lang['from'] .' '. cs_user($thread['users_id'],$user, $cs_users['users_active']);
        }
        $run++;
      }
    }
  }
}

echo cs_subtemplate(__FILE__,$data,'board','search');