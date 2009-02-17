<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_search'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_search'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

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

echo cs_html_form(1,'board_search','board','search');
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'leftb');
echo cs_icon('cell_edit') . $cs_lang['keywords'];
echo cs_html_roco(2,'leftc');
echo cs_html_input('keywords',$keywords,'text',200,50);
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_icon('completion') . $cs_lang['searchmode'];
echo cs_html_roco(2,'leftc');
$checked = $searchmode == 1 ? array(1 => 1, 2 => 0) : array(1 => 0, 2 => 1);
echo cs_html_vote('searchmode',1,'radio',$checked[1]) . ' ';
echo $cs_lang['match_exact'];
echo cs_html_vote('searchmode',2,'radio',$checked[2]) . ' ';
echo $cs_lang['match_keywords'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_icon('kcmdf') . $cs_lang['searcharea'];
echo cs_html_roco(2,'leftc');
$checked = $searcharea == 'threads' ? array(1 => 1, 2 => 0) : array(1 => 0, 2 => 1);
echo cs_html_vote('searcharea','threads','radio',$checked[1]) . ' ';
echo $cs_lang['titles_and_text'];
echo cs_html_vote('searcharea','comments','radio',$checked[2]) . ' ';
echo $cs_lang['comments'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_icon('tutorials') . $cs_lang['board'];
echo cs_html_roco(2,'leftc');
$tables = "board boa INNER JOIN {pre}_categories cat ON boa.categories_id = cat.categories_id";
$select = "boa.board_id AS board_id, boa.board_name AS board_name, cat.categories_name AS categories_name";
$axx_where = "boa.board_access <= '" . $account['access_board'] . "'";
$sorting = "cat.categories_name ASC, boa.board_name ASC";
$board_data = cs_sql_select(__FILE__,$tables,$select,$axx_where,$sorting,0,0);
echo cs_html_select(1,'board_id');
echo cs_html_option('----',0,0);
if (!empty($board_data)) {
  foreach($board_data AS $board) {
    $sel = $board_id == $board['board_id'] ? 1 : 0;
    $content = $board['categories_name'] . ' -> ' . $board['board_name'];
    echo cs_html_option($content,$board['board_id'],$sel);
  }
}
echo cs_html_select(0);
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_icon('ksysguard') . $cs_lang['options'];
echo cs_html_roco(2,'leftc');
echo cs_html_vote('search',$cs_lang['search'],'submit');
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_form(0);

if(!empty($go_search)) {

  echo cs_html_br(1);
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
    echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'leftc');
    echo $cs_lang['too_short'];
    echo cs_html_roco(0);
    echo cs_html_table(0);
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
    $count = cs_sql_count(__FILE__,$from,$conditions);

    if(empty($count)) {
      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'leftc');
      echo $cs_lang['not_found'];
      echo cs_html_roco(0);
      echo cs_html_table(0);
    }
    else {
      echo cs_html_form(1,'board_search2','board','search');
      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'leftb');
      echo cs_html_vote('keywords',$keywords,'hidden');
      echo cs_html_vote('searchmode',$searchmode,'hidden');
      echo cs_html_vote('searcharea',$searcharea,'hidden');
      echo cs_html_vote('board_id',$board_id,'hidden');
      echo cs_html_vote('page',$page,'hidden');
      $all_pages = floor($count / $account['users_limit']);
      echo cs_html_vote('max_page',$all_pages,'hidden');
      echo $cs_lang['page'] . ' ' . ($page + 1) . ' ' . $cs_lang['of'] . ' ' . ($all_pages + 1);
      echo cs_html_roco(2,'centerb');
      echo cs_html_vote('first','<<','submit');
      echo cs_html_vote('back','<','submit');
      echo cs_html_vote('next','>','submit');
      echo cs_html_vote('last','>>','submit');
      echo cs_html_roco(3,'rightb');
      echo sprintf($cs_lang['found_matches'],$count);
      echo cs_html_roco(0);
      echo cs_html_table(0);
      echo cs_html_form(0);
      echo cs_html_br(1);

      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'headb');
      echo $cs_lang['board'];
      echo cs_html_roco(2,'headb');
      echo $cs_lang['topic'];
      echo cs_html_roco(3,'headb',0,0,'180px');
      echo $cs_lang['lastpost'];
      echo cs_html_roco(0);

      $start = $page * $account['users_limit'];
      $result = cs_sql_select(__FILE__,$from,$select,$conditions,$order,$start,$account['users_limit']);
      foreach($result AS $thread) {

        echo cs_html_roco(1,'leftb');
        echo cs_link(cs_secure($thread['categories_name']),'board','list','id=' . $thread['categories_id']);
        echo cs_html_br(1) . ' -> ';
        echo cs_link(cs_secure($thread['board_name']),'board','listcat','id=' . $thread['board_id']);
        echo cs_html_roco(2,'leftb');
        echo cs_html_big(1);
        $headline = cs_secure($thread['threads_headline']);
        echo cs_link($headline,'board','thread','where=' . $thread['threads_id']);
        echo cs_html_big(0);
        if(!empty($thread['comments_id'])) {
          echo cs_html_br(1);
          $start = cs_sql_count(__FILE__,'comments',"comments_fid = '" . $thread['threads_id'] . "' AND comments_id < '" . $thread['comments_id'] . "' AND comments_mod = 'board'");
          $page = floor(++$start / $account['users_limit']) * $account['users_limit'];
          $go_target = 'where=' . $thread['threads_id'] . '&amp;start=' . $page . '#com' . $start;
          echo cs_link($cs_lang['go_target'],'board','thread',$go_target);
        }
        echo cs_html_roco(3,'leftb');
        if(!empty($thread['last_action'])) {
          echo cs_date('unix',$thread['last_action'],1);
        }
        if(!empty($thread['users_nick'])) {
          echo cs_html_br(1);
          echo $cs_lang['from'] . ' ';
          $user = cs_secure($thread['users_nick']);
          $cs_users = cs_sql_select(__FILE__,'users','users_active');
          echo cs_user($thread['users_id'],$user, $cs_users['users_active']);
        }
        echo cs_html_roco(0);
      }
      echo cs_html_table(0);
    }
  }
}

?>