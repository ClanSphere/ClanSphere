<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$data = array();
$iconcache = array();
$postscache = array();
$time_now = cs_time();

$cs_usertime = cs_sql_select(__FILE__,'users','users_readtime','users_id = "' . $account["users_id"] . '"');
$cs_readtime = $time_now - $cs_usertime['users_readtime'];

$check_pw = 1;
$check_sq = 0;
$class = 'leftc';
$start = isset($_REQUEST['start']) ? (int) $_REQUEST['start'] : 0;

$options = cs_sql_option(__FILE__,'board');

$board_sort = $options['sort'];

require_once 'mods/board/functions.php';

$id = empty($_REQUEST['where']) ? 0 : (int) $_REQUEST['where'];

if(empty($id) || (cs_sql_count(__FILE__,'threads','threads_id = "' .$id . '"') == 0))
return errorPage('thread', $cs_lang);
 

// Comments

$mod = 'board';
$action = 'thread';
$where_com = "comments_mod = 'board' AND comments_fid = \"" . $id . "\"";
$sum= cs_sql_count(__FILE__,'comments',$where_com);

// --- $cs_thread = cs_sql_select(__FILE__,'threads','*',"threads_id = '" . $id . "'");
// --- $cs_thread_cat = cs_sql_select(__FILE__,'categories','categories_name',"categories_id = '" . $data['thread']['categories_id'] . "'");

$from = 'threads thr INNER JOIN {pre}_board frm ON thr.board_id = frm.board_id ';
$from .= 'LEFT JOIN {pre}_users usr ON thr.users_id = usr.users_id ';
$from .= 'INNER JOIN {pre}_categories cat ON frm.categories_id = cat.categories_id';
$select = 'frm.board_pwd AS board_pwd, frm.board_access AS board_access, frm.board_read AS board_read, frm.board_name AS board_name, frm.board_id AS board_id, thr.threads_time AS threads_time, thr.threads_text AS threads_text, thr.threads_important AS threads_important, thr.threads_headline AS threads_headline, thr.threads_view AS threads_view, thr.threads_last_time AS threads_last_time, thr.threads_id AS threads_id, thr.threads_edit AS threads_edit, thr.threads_close AS threads_close, cat.categories_name AS categories_name, cat.categories_id AS categories_id, usr.users_id AS users_id, usr.users_country AS users_country, usr.users_nick AS users_nick, usr.users_delete AS users_delete, usr.users_avatar AS users_avatar, usr.users_place AS users_place, usr.users_hidden AS users_hidden, usr.users_signature AS users_signature, usr.users_laston AS users_laston, usr.users_email AS users_email, usr.users_icq AS users_icq, usr.users_jabber AS users_jabber, usr.users_url AS users_url, usr.users_skype AS users_skype, usr.users_active AS users_active, usr.users_invisible AS users_invisible, frm.squads_id AS squads_id, thr.threads_ghost AS threads_ghost, thr.threads_ghost_thread AS threads_ghost_thread';
$where = 'thr.threads_id = "' . $id . '"';
$data['thread'] = cs_sql_select(__FILE__,$from,$select,$where);

//Sicherheitsabfrage Beginn
if(!empty($data['thread']['board_pwd'])) {
  $where = 'users_id = "' . $account['users_id'] . '" AND board_id = "' . $data['thread']['board_id'] . '"';
  $check_pw = cs_sql_count(__FILE__,'boardpws',$where);
}

if(!empty($data['thread']['threads_ghost'])) {
  cs_redirect(NULL, 'board', 'thread','where=' . $data['thread']['threads_ghost_thread']);
}

if(!empty($data['thread']['squads_id']) AND $account['access_board'] < $data['thread']['board_access']) {
  $sq_where = 'users_id = "' . $account['users_id'] . '" AND squads_id = "' . $data['thread']['squads_id'] . '"';
  $check_sq = cs_sql_count(__FILE__,'members',$sq_where);
}

//Sicherheitsabfrage
if($account['access_board'] < $data['thread']['board_access'] AND empty($check_sq) OR empty($check_pw)) {
  errorPage('thread', $cs_lang);
} else {
  $ranks = cs_sql_select(__FILE__,'boardranks','boardranks_min, boardranks_name',0,'boardranks_min ASC',0,0);


  // Update view
  $thread_cells = array('threads_view');
  $thread_save = array($data['thread']['threads_view'] +1);
  cs_sql_update(__FILE__,'threads',$thread_cells,$thread_save,$id, 0, 0);

  // Update read
  if(!empty($account['users_id']) AND $data['thread']['threads_last_time'] > $cs_readtime) {
    $read_where = 'threads_id = "' . $data['thread']['threads_id'] . '" AND users_id = "' . $account['users_id'] . '"';
    $read_set = cs_sql_select(__FILE__,'read','read_id',$read_where);
    if(empty($read_set['read_id'])) {
      $read_cells = array('threads_id','users_id','read_since');
      $read_save = array($data['thread']['threads_id'],$account['users_id'],$time_now);
      cs_sql_insert(__FILE__,'read',$read_cells,$read_save);
    } else {
      cs_sql_update(__FILE__,'read',array('read_since'),array($time_now),$read_set['read_id'], 0, 0);
    }
  }

  // Check abos
  $cs_abo = cs_sql_select(__FILE__,'abonements','abonements_id','threads_id = "' .$data['thread']['threads_id'] . '" AND users_id = "' . $account['users_id'] . '"');

  if (!empty($account['users_id'])) {
    if(empty($cs_abo)) {
      $abo_lang = $cs_lang['abonnement'];
      $m_action = '&amp;newabo';
    }else{
      $abo_lang = $cs_lang['del_abo'];
      $m_action = '&amp;delabo';
    }
    $data['thread']['abo'] = cs_link($abo_lang,'board','thread','where=' .$id . $m_action);

    if(isset($_GET['newabo']) AND empty($cs_abo)) {
      $abonements_cells = array('users_id','threads_id');
      $abonements_save = array($account['users_id'],$id);
      cs_sql_insert(__FILE__,'abonements',$abonements_cells,$abonements_save);
      cs_redirect($cs_lang['abo_done'],'board','thread','where='.$id);
    }
    elseif(isset($_GET['delabo']) AND !empty($cs_abo['abonements_id'])) {
      cs_sql_delete(__FILE__,'abonements',$cs_abo['abonements_id']);
      cs_redirect($cs_lang['abo_del_done'],'board','thread','where='.$id);
    }
  }
  else {
    $data['thread']['abo'] = '';
  }

  $thread_mods = cs_sql_select(__FILE__,'boardmods','boardmods_modpanel, boardmods_edit, boardmods_del','users_id = "' . $account['users_id'] . '"',0,0,1);
  $boardmods = cs_sql_select(__FILE__,'boardmods','users_id',0,0,0,0);
  $i = 1;
  $mods = array();

  if(!empty($boardmods)){
    foreach($boardmods AS $value) {
      $mods[$i] = $value['users_id'];
      $i++;
    }
  }

  // Reports
  if($account['access_board'] >= 4) {
    $from = 'boardreport bdr INNER JOIN {pre}_users usr ON bdr.users_id = usr.users_id';
    $select = 'bdr.comments_id AS comments_id, bdr.boardreport_id AS boardreport_id, bdr.boardreport_time AS boardreport_time, bdr.boardreport_text AS boardreport_text, bdr.users_id AS users_id, usr.users_nick AS users_nick, usr.users_delete AS users_delete, usr.users_active AS users_active, bdr.boardreport_done AS boardreport_done';
    $where = 'bdr.threads_id = "' . $id . '"';
    $cs_report = cs_sql_select(__FILE__,$from,$select,$where,'bdr.comments_id ASC',0,0);
  }
  else {
    $cs_report = array();
  }

  $rpno = 0;

  $votes_cells = 'boardvotes_access, boardvotes_end, boardvotes_question, boardvotes_election, boardvotes_several';
  $cs_thread_votes = cs_sql_select(__FILE__,'boardvotes',$votes_cells,'threads_id = "' . $id . '"');

  $files_cells = 'comments_id, boardfiles_name, boardfiles_id, boardfiles_downloaded';
  $cs_thread_files = cs_sql_select(__FILE__,'boardfiles',$files_cells,'threads_id = "' . $id . '" AND comments_id = "0"','boardfiles_id ASC',0,0);

  $loop_files = count($cs_thread_files);

  $pnthread = getNextThread($data['thread']['board_id'], $data['thread']['threads_time']);
  $data['thread']['prev'] = '';
  $data['thread']['next'] = '';
  $data['thread']['prev_empty'] = '';
  if($pnthread[1] != -1) {
    $data['thread']['prev'] = cs_link("&laquo; " . $cs_lang['prev_thread'],'board','thread',"where=" .$pnthread[1]);
    $data['thread']['prev_empty'] = ' | ';
  }
  if($pnthread[0] != -1){
    $data['thread']['next'] = cs_link($cs_lang['next_thread'] . " ->",'board','thread',"where=" .$pnthread[0]);
  }
  else {
    $data['thread']['prev_empty'] = '';
  }
  /*if($account['access_id'] >= 5 OR !empty($thread_mods['boardmods_modpanel']))
   {
   echo ' - ' .cs_link($cs_lang['modpanel'],'board','modpanel','id=' .$id);
   }*/
  //vorheriges - letztes thema
  $data['thread']['categories_link'] = cs_link($data['thread']['categories_name'],'board','list','id=' .$data['thread']['categories_id']);
  $data['thread']['board_link'] = cs_link(cs_secure($data['thread']['board_name']),'board','listcat','id=' .$data['thread']['board_id']);
  #$arimportant = array('',$cs_lang['important']);
  $important = $data['thread']['threads_important'];
  #$data['thread']['abo'] = cs_secure($arimportant[$important],1) . ' ';

  $cs_main['page_title'] = $data['thread']['threads_headline'];
  $data['thread']['thread_link'] = cs_secure($data['thread']['threads_headline']);

  $data['thread']['getmessage'] = cs_getmsg();

  $data['thread']['sum'] = $sum;
  $data['thread']['pages'] = cs_pages($mod,$action,$sum,$start,$id);
  $data['if']['vote'] = false;
  $data['if']['vote_result'] = false;
  $data['if']['vote_several'] = false;
  if(!empty($cs_thread_votes))
  {
    if($account['access_board'] >= $cs_thread_votes['boardvotes_access'] OR $time_now <= $cs_thread_votes['boardvotes_end'])
    {
      $votes_error = '';
      $users_ip = cs_getip();
      $users_id = $account['users_id'];
      $where = "voted_mod = 'board' AND voted_fid = '" . $id . "' AND voted_ip = '" . cs_sql_escape($users_ip) . "'";
      if($users_id > 0)
        $where = "voted_mod = 'board' AND voted_fid = '" . $id . "' AND users_id = '" . $users_id . "'";

      $checkit_userip = cs_sql_count(__FILE__,'voted',$where);
      if(!empty($checkit_userip))
      $votes_error++;

      $data['thread']['vote_question'] = $cs_thread_votes['boardvotes_question'];
      if(empty($votes_error))
      {
        $data['if']['vote'] = true;
        $data['if']['vote_several'] = empty($cs_thread_votes['boardvotes_several']) ? false : true;
        $temp = explode("\n", $cs_thread_votes['boardvotes_election']);
        $votes_loop = count($temp) - 1;

        for ($run = 0; $run < $votes_loop; $run++) {
          $run2 = $run + 1;
          $data['votes'][$run]['run'] = $run2;
          $data['votes'][$run]['vote_election_text'] = $temp[$run2];
        }

        if(isset($_POST['submit_v'])) {

          !empty($_POST['voted_election']) ? $voted_election = $_POST['voted_election'] : $votes_error++;

          if(empty($votes_error)) {
            $votes_cells = array('voted_fid','users_id','voted_time','voted_answer','voted_ip','voted_mod');
            if ($data['if']['vote_several'] && is_array($voted_election)) {
                foreach ($voted_election as $key => $election) {
                    $votes_save = array($id,$account['users_id'],$time_now,$election,$users_ip,'board');
                    cs_sql_insert(__FILE__,'voted',$votes_cells,$votes_save);
                }
            }
            else {
            $votes_save = array($id,$account['users_id'],$time_now,$voted_election,$users_ip,'board');
            cs_sql_insert(__FILE__,'voted',$votes_cells,$votes_save);
            }
            cs_redirect(NULL, 'board', 'thread','where=' . $id);
          }
        }
      }
      else
      {
        $data['if']['vote_result'] = true;

        $select = 'voted_id, users_id, voted_ip, voted_answer';
        $where = "voted_fid = \"$id\" AND voted_mod = 'board'";
        $cs_voted = cs_sql_select(__FILE__,'voted',$select,$where,'','0','0');
        $voted_loop = count($cs_voted);
        $temp = explode("\n", $cs_thread_votes['boardvotes_election']);
        $loop_votes = count($temp) - 1;
        for ($run = 0; $run < $loop_votes; $run++)
        {
          $run2 = $run + 1;
          $answer_count = 0;
          for ($run_2 = 0; $run_2 < $voted_loop; $run_2++)
          {
            $voted_answer = $cs_voted[$run_2]['voted_answer'];
            if($voted_answer == $run2)
            $answer_count++;

          }

          $data['votes_r'][$run]['answer'] = $temp[$run2];
          $answer_percent = !empty($answer_count) ? $answer_count / $voted_loop * 100 : '0';

          $answer_percent = round($answer_percent,1);
          $data['votes_r'][$run]['answer_percent'] = $answer_percent;
          $data['votes_r'][$run]['dirname'] = $cs_main['php_self']['dirname'];
          $data['votes_r'][$run]['answer_count'] = $answer_count;
          $data['votes_r'][$run]['no_vote_percent'] = '';
          if(!empty($answer_count))
          $data['votes_r'][$run]['no_vote_percent'] = cs_html_img('symbols/votes/vote02.png','13','2');

        }
        $data['votes']['all_count'] = $voted_loop;
      }
    }
  }
  $data['if']['asc'] = false;
  $data['if']['moderator'] = false;
  $data['if']['no_moderator'] = false;
  $data['if']['thread_report'] = false;
  $data['if']['thread_asc_files'] = false;
  $data['if']['thread_asc_edited'] = false;
  $data['thread_asc']['remove'] = '';
  $data['thread_asc']['edit'] = '';
  $data['thread_asc']['quote'] = '';
  $data['thread_asc']['report'] = '';
  if($start <! 0 AND $board_sort=='ASC')
  {
    $data['if']['asc'] = true;
    $userid = $data['thread']['users_id'];
    if(!isset($count_com[$userid]))
    {
      $count_com[$userid] = getUserPosts($userid);
      $postscache[$userid] = $count_com[$userid];
    }
    $data['thread_asc']['country'] = $data['thread']['users_country'];
    $data['thread_asc']['users_link'] = cs_user($userid, $data['thread']['users_nick'], $data['thread']['users_active'], $data['thread']['users_delete']);
    $key = array_search($userid, $mods);
    if(!empty($key))
    {
      $data['if']['moderator'] = true;
      $f_user = 'users_id = "' . $userid . '"';
      $boardmod = cs_sql_select(__FILE__,'boardmods','categories_id, users_id',$f_user);
      $f_cat = 'categories_id = "' . $boardmod['categories_id'] . '"';
      $bm_cat = cs_sql_select(__FILE__,'categories','categories_id, categories_name',$f_cat);
      $data['thread_asc']['boardmod'] = $bm_cat['categories_name'];
    }
    else
    {
      $data['if']['no_moderator'] = true;
      $data['thread_asc']['users_rank'] = getUserRank($count_com[$userid], $ranks);
      $data['thread_asc']['users_title'] = getRankTitle($count_com[$userid], $ranks);
    }
    $data['thread_asc']['avatar'] = getUserAvatar($data['thread']['users_avatar']);
    $content = cs_secure($data['thread']['users_place']);
    $hidden = explode(',',$data['thread']['users_hidden']);
    if(in_array('users_place',$hidden)) {
      $content = ($account['access_users'] > 4 OR $data['thread']['users_id'] == $account['users_id']) ?
      cs_html_italic(1) . $content . cs_html_italic(0) : '';
    }
    $data['thread_asc']['place'] = empty($content) ? '' : $cs_lang['place'] . ': ' . $content;
    $data['thread_asc']['posts'] = $count_com[$userid];
    $data['thread_asc']['date'] = cs_date('unix',$data['thread']['threads_time'],1);
    if(isset($cs_report[0]) AND empty($cs_report[0]['comments_id'])) {
      $data['if']['thread_report'] = true;
      $matches[1] = $cs_lang['report'];
      $matches[2] = '<div style="float: right">' . cs_link(cs_icon('special_paste',16,$cs_lang['reports']),'board','reportlist');
      $rid = 'id=' . $cs_report[0]['boardreport_id'];
      if(!empty($cs_report[0]['boardreport_done'])) {
        $matches[1] .= ' - ' . $cs_lang['done'];
      }
      else {
        $matches[2] .= ' ' . cs_link(cs_icon('submit',16,$cs_lang['done']),'board','reportdone',$rid);
      }
      $matches[2] .= ' ' . cs_link(cs_icon('cancel',16,$cs_lang['remove']),'board','reportdel',$rid) . '</div>';
      $matches[2] .= cs_date('unix',$cs_report[0]['boardreport_time'],1) . ' - ';
      $matches[2] .= cs_user($cs_report[0]['users_id'],$cs_report[0]['users_nick'],$cs_report[0]['users_active'],$cs_report[0]['users_delete']);
      $matches[2] .= cs_html_br(2) . cs_secure($cs_report[0]['boardreport_text'],1);
      $data['report']['thread_clip'] = cs_abcode_clip($matches);
      $rpno++;
    }
    $data['thread_asc']['text'] = cs_secure($data['thread']['threads_text'],1,1);
    //Files Start
    if(!empty($loop_files)) {
      $data['if']['thread_asc_files'] = true;
      $check_files = 0;
      for($run = 0; $run < $loop_files; $run++) {
        if($cs_thread_files[$run]['comments_id'] == 0)
        $check_files++;
      }
      if(!empty($check_files)) {
        for($run = 0; $run < $loop_files; $run++) {
          $file = $cs_thread_files[$run]['boardfiles_name'];
          $extension = strlen(strrchr($file,"."));
          $name = strlen($file);
          $ext = substr($file,$name - $extension + 1,$name);
          $cs_thread_files[$run]['boardfiles_typ'] = $ext;
        }
         
        require_once 'mods/clansphere/filetype.php';
         
        for($run = 0; $run < $loop_files; $run++){
          $ext = $cs_thread_files[$run]['boardfiles_typ'];
          $file = $cs_thread_files[$run]['boardfiles_name'];
          $ext_lower = strtolower($ext);
          if(file_exists('uploads/board/files/'.$cs_thread_files[$run]['boardfiles_id'].'.'.$ext)) {
            $file_file = filesize('uploads/board/files/'.$cs_thread_files[$run]['boardfiles_id'].'.'.$ext);
            $data['files'][$run]['file'] = cs_filetype($ext_lower) . ' ' . cs_html_link($cs_main['php_self']['dirname'].'mods/board/attachment.php?id='.$cs_thread_files[$run]['boardfiles_id'],$file,1).' ('.cs_filesize($file_file).' - '.$cs_thread_files[$run]['boardfiles_downloaded'].' '.$cs_lang['times'].' )';
          } elseif (file_exists('uploads/board/files/'.$file)) {
            $file_file = filesize('uploads/board/files/'.$file);
            $data['files'][$run]['file'] = cs_filetype($ext_lower) . ' ' . cs_html_link($cs_main['php_self']['dirname'].'mods/board/attachment.php?name='.$file,$file,1).' ('.cs_filesize($file_file).' - '.$cs_thread_files[$run]['boardfiles_downloaded'].' '.$cs_lang['times'].' )';
          } else {
            $data['files'][$run]['file'] = $cs_lang['no_att_file'];
          }
        }
      }
    }
    //Files Ende
    $data['thread_asc']['signature'] = '';
    $data['thread_asc']['signature'] = getUserSignature($data['thread']['users_signature']);
    if (!empty($data['thread']['threads_edit']))
    {
      $data['if']['thread_asc_edited'] = true;
      $data['thread_asc']['checkedit'] = checkLastEdit($data['thread']['threads_edit'],$cs_lang);
    }
    //board_safemode($data['thread']['users_nick'], $data['thread']['threads_time'], $options);
    $data['thread_asc']['laston'] = cs_userstatus($data['thread']['users_laston'],$data['thread']['users_invisible'],1);
    $iconcache[$data['thread']['users_id']] = getUserIcons($cs_lang,$data['thread']['users_id'],$data['thread']['users_nick'],$data['thread']['users_hidden'],$data['thread']['users_email'],$data['thread']['users_icq'],$data['thread']['users_jabber'], $data['thread']['users_url'], $data['thread']['users_skype']);
    $data['thread_asc']['usericons'] = $iconcache[$data['thread']['users_id']];
    if(!empty($account['users_id']))
    {
      $img_report = cs_icon('special_paste',16,$cs_lang['report']);
      $data['thread_asc']['report'] = cs_link($img_report,$mod,'report','tid=' . $data['thread']['threads_id'],0,$cs_lang['report']);

      $img_quote = cs_icon('xchat',16,$cs_lang['quote']);
      $data['thread_asc']['quote'] = cs_link($img_quote,'board','com_create','id=' . $id .'&amp;quote=t-' .$data['thread']['threads_id'],0,$cs_lang['quote']);
    }
    if($userid == $account['users_id'] OR $account['access_comments'] >= 4 OR !empty($thread_mods['boardmods_edit']))
    {
      $img_edit = cs_icon('edit',16,$cs_lang['edit']);
      $data['thread_asc']['edit'] = cs_link($img_edit,$mod,'thread_edit','id=' . $data['thread']['threads_id'],0,$cs_lang['edit']);
    }
    if($account['access_comments'] >= 5 || !empty($thread_mods['boardmods_del']) || ($data['thread']['users_id'] == $account['users_id'] AND empty($sum)))
    {
      $img_del = cs_icon('editdelete',16,$cs_lang['remove']);
      $data['thread_asc']['remove'] = cs_link($img_del,$mod,'thread_remove','id=' . $data['thread']['threads_id'],0,$cs_lang['remove']);
    }

  }
  // Antworten
  $from = 'comments com LEFT JOIN {pre}_users usr ON com.users_id = usr.users_id ';
  $where = "comments_mod = 'board' AND comments_fid = \"" . $id . "\"";
  $select = 'users_nick, users_country, com.users_id AS users_id, users_avatar, users_delete, users_laston, users_invisible, users_place, users_hidden, comments_time, comments_edit, comments_fid, comments_text, users_signature, users_email ,users_jabber, users_icq, users_skype,users_active,users_url, comments_id';
  $order = 'comments_id '.$board_sort;

  $cs_comments = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);

  $comments_loop = count($cs_comments);
  $data['if']['comments'] = false;

  if($comments_loop != 0)
  $data['if']['comments'] = true;

  $run_2 = 0;
  for($run = 0; $run < $comments_loop; $run++)
  {
    $comments_fid = $cs_comments[$run]['comments_fid'];
    if($comments_fid == $id)
    {
      $cs_com[$run_2]['users_nick']    = $cs_comments[$run]['users_nick'];
      $cs_com[$run_2]['users_country']  = $cs_comments[$run]['users_country'];
      $cs_com[$run_2]['users_id']      = $cs_comments[$run]['users_id'];
      $cs_com[$run_2]['users_avatar']    = $cs_comments[$run]['users_avatar'];
      $cs_com[$run_2]['users_laston']    = $cs_comments[$run]['users_laston'];
      $cs_com[$run_2]['users_invisible']  = $cs_comments[$run]['users_invisible'];
      $cs_com[$run_2]['users_place']    = $cs_comments[$run]['users_place'];
      $cs_com[$run_2]['users_hidden']    = $cs_comments[$run]['users_hidden'];
      $cs_com[$run_2]['comments_time']  = $cs_comments[$run]['comments_time'];
      $cs_com[$run_2]['comments_text']  = $cs_comments[$run]['comments_text'];
      $cs_com[$run_2]['users_signature']  = $cs_comments[$run]['users_signature'];
      $cs_com[$run_2]['users_email']     = $cs_comments[$run]['users_email'];
      $cs_com[$run_2]['users_jabber']    = $cs_comments[$run]['users_jabber'];
      $cs_com[$run_2]['users_icq']    = $cs_comments[$run]['users_icq'];
      $cs_com[$run_2]['users_skype']  = $cs_comments[$run]['users_skype'];
      $cs_com[$run_2]['users_active']  = $cs_comments[$run]['users_active'];
      $cs_com[$run_2]['users_delete']  = $cs_comments[$run]['users_delete'];
      $cs_com[$run_2]['users_url']    = $cs_comments[$run]['users_url'];
      $cs_com[$run_2]['comments_id']    = $cs_comments[$run]['comments_id'];
      $cs_com[$run_2]['comments_edit']    = $cs_comments[$run]['comments_edit'];
      $run_2++;
    }
  }

  if(!empty($cs_com))
  {
    $com_loop = count($cs_com);

    if($board_sort=='DESC') {
      $current = cs_sql_count(__FILE__, 'comments', 'comments_mod = \'board\' AND comments_fid = "' . $id . '"') + 1;
      if (!empty($start)) {
        $current -= $start;
      }
    } else
    $current = $start;
    $limit = $start + $account['users_limit'];
    if ($com_loop > $limit) $com_loop = $limit;
  }
  else
  {
    $com_loop = 0;
  }
  
  for($run = 0; $run<$com_loop; $run++)
  {
    $data['comment'][$run]['if']['com_moderator'] = false;
    $data['comment'][$run]['if']['no_com_moderator'] = false;
    $data['comment'][$run]['if']['c_files'] = false;
    $data['comment'][$run]['if']['com_report'] = false;
      $data['comment'][$run]['if']['com_user'] = false;
      $data['comment'][$run]['if']['com_admin'] = false;
    
    $data['comment'][$run]['cut'] = '';
    $data['comment'][$run]['edit'] = '';
    $data['comment'][$run]['remove'] = '';
    $data['comment'][$run]['checkedit'] = '';

    if($board_sort=='ASC')
    $current++;
    else
    $current--;

    $data['comment'][$run]['if']['thread_author'] = $data['thread']['users_id'] == $cs_com[$run]['users_id'] ? TRUE : FALSE;
    $data['comment'][$run]['country'] = $cs_com[$run]['users_country'];
    $data['comment'][$run]['users_link'] = cs_user($cs_com[$run]['users_id'], $cs_com[$run]['users_nick'], $cs_com[$run]['users_active'], $cs_com[$run]['users_delete']);
    if (empty($postscache[$cs_com[$run]['users_id']])) $postscache[$cs_com[$run]['users_id']] = getUserPosts($cs_com[$run]['users_id']);
    $user_posts = $postscache[$cs_com[$run]['users_id']];
    $key = array_search($cs_com[$run]['users_id'], $mods);
    if(!empty($key))
    {
      $data['comment'][$run]['if']['com_moderator'] = true;
      $f_user = 'users_id = "' . $cs_com[$run]['users_id'] . '"';
      $boardmod = cs_sql_select(__FILE__,'boardmods','categories_id, users_id',$f_user);
      $f_cat = 'categories_id = "' . $boardmod['categories_id'] . '"';
      $bm_cat = cs_sql_select(__FILE__,'categories','categories_id, categories_name',$f_cat);
      $data['comment'][$run]['boardmod'] = $bm_cat['categories_name'];
    }
    else
    {
      $data['comment'][$run]['if']['no_com_moderator'] = true;
      $data['comment'][$run]['users_rank'] = getUserRank($user_posts, $ranks);
      $data['comment'][$run]['users_title'] = getRankTitle($user_posts, $ranks);
    }
    $data['comment'][$run]['avatar'] = getUserAvatar($cs_com[$run]['users_avatar']);
    $content = cs_secure($cs_com[$run]['users_place']);
    $hidden = explode(',',$cs_com[$run]['users_hidden']);
    if(in_array('users_place',$hidden)) {
      $content = ($account['access_users'] > 4 OR $cs_com[$run]['users_id'] == $account['users_id']) ?
      cs_html_italic(1) . $content . cs_html_italic(0) : '';
    }
    $data['comment'][$run]['place'] = empty($content) ? '' : $cs_lang['place'] . ': ' . $content;
    $data['comment'][$run]['posts'] = $user_posts;
    $data['comment'][$run]['current'] = $current;
    $data['comment'][$run]['date'] = cs_date('unix',$cs_com[$run]['comments_time'],1);
    $data['comment'][$run]['current_anchor'] = cs_html_anchor('com' . $current);
    if(isset($cs_report[$rpno]['comments_id']) AND $cs_report[$rpno]['comments_id'] == $cs_com[$run]['comments_id']) {
      $data['comment'][$run]['if']['com_report'] = true;
      $matches[1] = $cs_lang['report'];
      $matches[2] = '<div style="float: right">' . cs_link(cs_icon('special_paste',16,$cs_lang['reports']),'board','reportlist');
      $rid = 'id=' . $cs_report[$rpno]['boardreport_id'];
      if(!empty($cs_report[$rpno]['boardreport_done'])) {
        $matches[1] .= ' - ' . $cs_lang['done'];
      }
      else {
        $matches[2] .= ' ' . cs_link(cs_icon('submit',16,$cs_lang['done']),'board','reportdone',$rid);
      }
      $matches[2] .= ' ' . cs_link(cs_icon('cancel',16,$cs_lang['remove']),'board','reportdel',$rid) . '</div>';
      $matches[2] .= cs_date('unix',$cs_report[$rpno]['boardreport_time'],1) . ' - ';
      $matches[2] .= cs_user($cs_report[$rpno]['users_id'],$cs_report[$rpno]['users_nick'],$cs_report[$rpno]['users_active'], $cs_report[$rpno]['users_delete']);
      $matches[2] .= cs_html_br(2) . cs_secure($cs_report[$rpno]['boardreport_text'],1);
      $data['comment'][$run]['com_clip'] = cs_abcode_clip($matches);
      $rpno++;
    }
    $data['comment'][$run]['text'] = cs_secure($cs_com[$run]['comments_text'],1,1);
    //Files Start
    // Comment Files auslesen
    $where_com_file = 'threads_id = "' . $id . '" AND comments_id = "' . $cs_com[$run]['comments_id'] .'"';
    $cells = 'boardfiles_name, boardfiles_id, boardfiles_downloaded';
    $cs_comments_files = cs_sql_select(__FILE__,'boardfiles',$cells,$where_com_file,'boardfiles_id ASC',0,0);
    $loop_com_files = count($cs_comments_files);
    if(!empty($loop_com_files)) {
      $data['comment'][$run]['if']['c_files'] = true;

      require_once 'mods/clansphere/filetype.php';

      for($run2 = 0; $run2 < $loop_com_files; $run2++) {
        $file = $cs_comments_files[$run2]['boardfiles_name'];
        $extension = strlen(strrchr($file,"."));
        $name = strlen($file);
        $ext = substr($file,$name - $extension + 1,$name);
        $cs_comments_files[$run2]['boardfiles_typ'] = $ext;
        $ext_lower = strtolower($ext);
        if(file_exists('uploads/board/files/'.$cs_comments_files[$run2]['boardfiles_id'].'.'.$ext)) {
          $file_file = filesize('uploads/board/files/'.$cs_comments_files[$run2]['boardfiles_id'].'.'.$ext);
          $data['comment'][$run]['com_files'][$run2]['file'] = cs_filetype($ext_lower) . ' ' . cs_html_link($cs_main['php_self']['dirname'].'mods/board/attachment.php?id='.$cs_comments_files[$run2]['boardfiles_id'],$file,1).' ('.cs_filesize($file_file).' - '.$cs_comments_files[$run2]['boardfiles_downloaded'].' '.$cs_lang['times'].' )';
        } elseif (file_exists('uploads/board/files/'.$file)) {
          $file_file = filesize('uploads/board/files/'.$file);
          $data['comment'][$run]['com_files'][$run2]['file'] = cs_filetype($ext_lower) . ' ' . cs_html_link($cs_main['php_self']['dirname'].'mods/board/attachment.php?name='.$file,$file,1).' ('.cs_filesize($file_file).' - '.$cs_comments_files[$run2]['boardfiles_downloaded'].' '.$cs_lang['times'].' )';
        } else {
          $data['comment'][$run]['com_files'][$run2]['file'] = $cs_lang['no_att_file'];
        }
      }
    }
    //Files Ende
    $data['comment'][$run]['signature'] = getUserSignature($cs_com[$run]['users_signature']);
    if (!empty($cs_com[$run]['comments_edit']))
    {
      $data['comment'][$run]['checkedit'] = checkLastEdit($cs_com[$run]['comments_edit'],$cs_lang);
    }
    //board_safemode($cs_com[$run]['users_nick'], $cs_com[$run]['comments_time'], $options);
    $data['comment'][$run]['laston'] = cs_userstatus($cs_com[$run]['users_laston'],$cs_com[$run]['users_invisible'],1);
    //  echo cs_html_hr('100%');
    if (empty($iconcache[$cs_com[$run]['users_id']]))
    $iconcache[$cs_com[$run]['users_id']] = getUserIcons($cs_lang,$cs_com[$run]['users_id'],$cs_com[$run]['users_nick'],$cs_com[$run]['users_hidden'],$cs_com[$run]['users_email'],$cs_com[$run]['users_icq'],$cs_com[$run]['users_jabber'],$cs_com[$run]['users_url'],$cs_com[$run]['users_skype']);
    $data['comment'][$run]['usericons'] = $iconcache[$cs_com[$run]['users_id']];
    if(!empty($account['users_id']))
    {
      $data['comment'][$run]['if']['com_user'] = true;
      $img_report = cs_icon('special_paste',16,$cs_lang['report']);
      $data['comment'][$run]['report'] = cs_link($img_report,$mod,'report','cid=' . $cs_com[$run]['comments_id'],0,$cs_lang['report']);

      $img_quote = cs_icon('xchat',16,$cs_lang['quote']);
      $data['comment'][$run]['quote'] = cs_link($img_quote,'board','com_create','id=' . $id .'&amp;quote=c-' .$cs_com[$run]['comments_id'],0,$cs_lang['quote']);
    }
    if($cs_com[$run]['users_id'] == $account['users_id'] OR $account['access_comments'] >= 5 OR !empty($thread_mods['boardmods_edit']))
    {
      $data['comment'][$run]['if']['com_admin'] = true;
      if ($account['access_comments'] >= 5 OR !empty($thread_mods['boardmods_edit'])) {
        $img_cut = cs_icon('editcut',16,$cs_lang['cut_comment_as_thread']);
        $data['comment'][$run]['cut'] = cs_link($img_cut,'board','thread_cut','id=' . $cs_com[$run]['comments_id'],0,$cs_lang['cut_comment_as_thread']);
      }

      $img_edit = cs_icon('edit',16,$cs_lang['edit']);
      $data['comment'][$run]['edit'] = cs_link($img_edit,$mod,'com_edit','id=' . $cs_com[$run]['comments_id'],0,$cs_lang['edit']);
    }
    if($account['access_comments'] >= 5 OR !empty($thread_mods['boardmods_del']))
    {
      $data['comment'][$run]['if']['com_admin'] = true;
      $img_del = cs_icon('editdelete',16,$cs_lang['remove']);
      $data['comment'][$run]['remove'] = cs_link($img_del,$mod,'com_remove','id=' . $cs_com[$run]['comments_id'],0,$cs_lang['remove']);
    }
    $data['comment'][$run]['anch'] = ' | ' . cs_html_link('#threadanch',cs_icon('up'),0);

  }
  //Thema Neu
  $data['if']['sort_desc'] = false;
  $data['if']['sort_desc'] = false;
  $data['if']['thread_desc_files'] = false;
  $data['thread_desc']['signature'] = '';
  $data['thread_desc']['checkedit'] = '';

  if($board_sort=='DESC')
  {
    $data['if']['sort_desc'] = true;
    $userid = $data['thread']['users_id'];

    if(!isset($count_com[$userid]))
    {
      $count_com[$userid] = getUserPosts($userid);
    }
    $user = cs_secure($data['thread']['users_nick']);
    $data['thread_desc']['country'] = $data['thread']['users_country'];
    $data['thread_desc']['users_link'] = cs_user($data['thread']['users_id'],$data['thread']['users_nick'],$data['thread']['users_active'],$data['thread']['users_delete']);
    $key = array_search($userid, $mods);
    if(!empty($key))
    {
      $data['if']['moderator'] = true;
      $f_user = "users_id = '" . $userid . "'";
      $boardmod = cs_sql_select(__FILE__,'boardmods','categories_id, users_id',$f_user);
      $f_cat = "categories_id = '" . $boardmod['categories_id'] . "'";
      $bm_cat = cs_sql_select(__FILE__,'categories','categories_id, categories_name',$f_cat);
      $data['thread_desc']['boardmod'] = $bm_cat['categories_name'];
    }
    else
    {
      $data['if']['no_moderator'] = true;
      $data['thread_desc']['users_rank'] = getUserRank($count_com[$userid], $ranks);
      $data['thread_desc']['users_title'] = getRankTitle($count_com[$userid], $ranks);
    }
    $data['thread_desc']['avatar'] = getUserAvatar($data['thread']['users_avatar']);
    $content = cs_secure($data['thread']['users_place']);
    $hidden = explode(',',$data['thread']['users_hidden']);
    if(in_array('users_place',$hidden)) {
      $content = ($account['access_users'] > 4 OR $data['thread']['users_id'] == $account['users_id']) ?
      cs_html_italic(1) . $content . cs_html_italic(0) : '';
    }
    $data['thread_desc']['place'] = empty($content) ? '' : $cs_lang['place'] . ': ' . $content;
    $data['thread_desc']['posts'] = $count_com[$userid];
    $data['thread_desc']['date'] = cs_date('unix',$data['thread']['threads_time'],1);
    $data['thread_desc']['text'] = cs_secure($data['thread']['threads_text'],1,1);
    //Files Start
    if(!empty($loop_files)) {
      $data['if']['thread_desc_files'] = true;
      $check_files = 0;

      for($run = 0; $run < $loop_files; $run++) {
        if($cs_thread_files[$run]['comments_id'] == 0) {
          $check_files++;
        }
      }
      if(!empty($check_files)) {
        for($run = 0; $run < $loop_files; $run++) {
          $file = $cs_thread_files[$run]['boardfiles_name'];
          $extension = strlen(strrchr($file,"."));
          $name = strlen($file);
          $ext = substr($file,$name - $extension + 1,$name);
          $cs_thread_files[$run]['boardfiles_typ'] = $ext;
        }
         
        require_once 'mods/clansphere/filetype.php';
         
        for($run = 0; $run < $loop_files; $run++){
          $ext = $cs_thread_files[$run]['boardfiles_typ'];
          $file = $cs_thread_files[$run]['boardfiles_name'];

          if(file_exists('uploads/board/files/'.$cs_thread_files[$run]['boardfiles_id'].'.'.$ext)) {
            $file_file = filesize('uploads/board/files/'.$cs_thread_files[$run]['boardfiles_id'].'.'.$ext);
            $data['files'][$run]['file'] = cs_filetype($ext) . ' ' . cs_html_link($cs_main['php_self']['dirname'].'mods/board/attachment.php?id='.$cs_thread_files[$run]['boardfiles_id'],$file,1).' ('.cs_filesize($file_file).' - '.$cs_thread_files[$run]['boardfiles_downloaded'].' '.$cs_lang['times'].' )';
          } elseif (file_exists('uploads/board/files/'.$file)) {
            $file_file = filesize('uploads/board/files/'.$file);
            $data['files'][$run]['file'] = cs_filetype($ext) . ' ' . cs_html_link($cs_main['php_self']['dirname'].'mods/board/attachment.php?id='.$file,$file,1).' ('.cs_filesize($file_file).' - '.$cs_thread_files[$run]['boardfiles_downloaded'].' '.$cs_lang['times'].' )';
          } else {
            $data['files'][$run]['file'] = $cs_lang['no_att_file'];
          }
        }
      }
    }
    //Files Ende
    $data['thread_desc']['signature'] = getUserSignature($data['thread']['users_signature']);
    if (!empty($data['thread']['threads_edit']))
    {
      $data['thread_desc']['checkedit'] = checkLastEdit($data['thread']['threads_edit'],$cs_lang);
    }
    //board_safemode($data['thread']['users_nick'], $data['thread']['threads_time'], $options);
    $data['thread_desc']['laston'] = cs_userstatus($data['thread']['users_laston'],$data['thread']['users_invisible'],1);
    //echo cs_html_hr('100%');
    $data['thread_desc']['users_icons'] = getUserIcons($cs_lang,$data['thread']['users_id'],$data['thread']['users_nick'],$data['thread']['users_hidden'],$data['thread']['users_email'],$data['thread']['users_icq'],$data['thread']['users_jabber'], $data['thread']['users_url'], $data['thread']['users_skype']);
    $data['thread_desc']['remove'] = '';
    $data['thread_desc']['edit'] = '';
    $data['thread_desc']['quote'] = '';
    $data['thread_desc']['report'] = '';

    if(!empty($account['users_id']))
    {
      $img_report = cs_icon('special_paste',16,$cs_lang['report']);
      $data['thread_desc']['report'] = cs_link($img_report,$mod,'report','tid=' . $data['thread']['threads_id'],0,$cs_lang['report']);

      $img_quote = cs_icon('xchat',16,$cs_lang['quote']);
      $data['thread_desc']['quote'] = cs_link($img_quote,'board','com_create','id=' . $id .'&amp;quote=t-' .$data['thread']['threads_id'],0,$cs_lang['quote']);
    }
    if($userid == $account['users_id'] OR $account['access_comments'] >= 4 OR !empty($thread_mods['boardmods_edit']))
    {
      $img_edit = cs_icon('edit',16,$cs_lang['edit']);
      $data['thread_desc']['edit'] = cs_link($img_edit,$mod,'thread_edit','id=' . $data['thread']['threads_id'],0,$cs_lang['edit']);
    }
    if($account['access_comments'] >= 5 OR !empty($thread_mods['boardmods_del']))
    {
      $img_del = cs_icon('editdelete',16,$cs_lang['remove']);
      $data['thread_desc']['remove'] = cs_link($img_del,$mod,'thread_remove','id=' . $data['thread']['threads_id'],0,$cs_lang['remove']);
    }
    elseif($data['thread']['users_id'] == $account['users_id'] AND empty($sum))
    {
      $img_del = cs_icon('editdelete',16,$cs_lang['remove']);
      $data['thread_desc']['remove'] = cs_link($img_del,$mod,'thread_remove','id=' . $data['thread']['threads_id'],0,$cs_lang['remove']);
    }
  }

  $data['if']['closed'] = false;

  if (!empty($data['thread']['threads_close'])) {
    $data['if']['closed'] = true;

    if ($data['thread']['threads_close'] == -1) {
      $message = $cs_lang['thread_closed1'];
    } else {
      $user = cs_sql_select(__FILE__,'users','users_nick,users_active','users_id = "'.$data['thread']['threads_close'].'"');
      $user_lnk = cs_user($data['thread']['threads_close'],$user['users_nick'],$user['users_active']);
      $user_lnk .= ' ' . cs_link(cs_icon('mail_send',16,'PM'),'messages','create','to_id='.$data['thread']['threads_close']);
      $message = sprintf($cs_lang['thread_closed2'],$user_lnk);
    }

    $data['thread']['closed_img'] = cs_icon('lockoverlay',48);
    $data['thread']['closed'] = $message;

  }

  $data['if']['modpanel'] = false;
  $data['if']['modp_close'] = false;
  $data['if']['modp_open'] = false;
  $data['if']['modp_delpin'] = false;
  $data['if']['modp_addpin'] = false;
  $allow_close_now = 0;

  //Anfang Modpanel
  if($account['access_board'] >= 5 OR !empty($thread_mods['boardmods_modpanel']))
  {
    $allow_close_now = 1;
    $data['if']['modpanel'] = true;

    if(empty($data['thread']['threads_close']))
    $data['if']['modp_close'] = true;
    elseif(!empty($data['thread']['threads_close']))
    $data['if']['modp_open'] = true;
    if(empty($data['thread']['threads_important']))
    $data['if']['modp_addpin'] = true;
    elseif(!empty($data['thread']['threads_important']))
    $data['if']['modp_delpin'] = true;
  }

  //Ende Modpanel
  $data['if']['no_user'] = false;
  $data['if']['last_own'] = false;
  $data['if']['write_comment'] = false;

  if(empty($data['thread']['threads_close'])) {
    if(empty($data['thread']['board_read']) || $account['access_clansphere'] > 5) {

      $where = 'comments_mod = \'' . $mod . '\' AND comments_fid = "' . $id . '"';
      $last_from = cs_sql_select(__FILE__,'comments','users_id, comments_time',$where,'comments_id DESC');
      if (empty($last_from)) {
        $last_from['users_id'] = $data['thread']['users_id'];
        $last_from['comments_time'] = $data['thread']['threads_time'];
      }
      $time = $time_now;

      if(empty($account['users_id'])) {
        $data['if']['no_user'] = true;
      }
      elseif($account['users_id'] == $last_from['users_id'] && ($options['doubleposts'] == -1 || $last_from['comments_time'] + $options['doubleposts'] > $time)) {
        $data['if']['last_own'] = true;

        if($options['doubleposts'] != -1) {
          $wait_days = round(($last_from['comments_time'] + $options['doubleposts'] - $time) / 86400, 1);
          $data['thread']['doublepost'] = ' ' . sprintf($cs_lang['wait_after_comment'],$wait_days);
        } else {
          $data['thread']['doublepost']  = '';
        }

      }
      else {
        $data['if']['write_comment'] = true;
        $cs_abcode = cs_sql_option(__FILE__,'abcode');

        if(empty($cs_abcode['def_abcode'])) {
          $data['wcomment']['smileys'] = '';
          $data['wcomment']['abcode'] = '';
        } else {
          $data['wcomment']['smileys'] = cs_abcode_smileys('comments_text');
          $data['wcomment']['abcode'] = cs_abcode_features('comments_text');
        }

        $data['if']['allow_close'] = !empty($allow_close_now) ? TRUE : FALSE;

      }
    }
  }
  //Ende Sicherheitsabfrage
  echo cs_subtemplate(__FILE__,$data,'board','thread');
}