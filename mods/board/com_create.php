<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$cs_post = cs_post('id');
$cs_get = cs_get('id');
$files_gl = cs_files();

$data = array();

$fid = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $fid = $cs_post['id'];
if (!empty($cs_get['where']))  $fid = $cs_get['where'];

include 'mods/board/functions.php';

$check_pw = 1;
$check_sq = 0;
$quote = '';
$options = cs_sql_option(__FILE__,'board');
$max_text = $options['max_text'];
$filetypes = explode(',',$options['file_types']);
$a = '0';
$b = '1';
$text = '';
$ori_text = '';
$error = '';
$files = '0';

$cond = 'comments_mod = \'board\' AND comments_fid = \''.$fid.'\'';
$last_comment = cs_sql_select(__FILE__,'comments','users_id, comments_time',$cond,'comments_id DESC');

$from = 'threads thr INNER JOIN {pre}_board frm ON thr.board_id = frm.board_id INNER JOIN {pre}_categories cat ON frm.categories_id = cat.categories_id';
$select  = 'thr.threads_headline AS threads_headline, frm.board_name AS board_name, frm.board_read AS board_read, ';
$select .= 'cat.categories_name AS categories_name, thr.threads_id AS threads_id, frm.board_id AS board_id, ';
$select .= 'cat.categories_id AS categories_id, frm.board_pwd AS board_pwd, frm.board_access AS board_access, frm.squads_id AS squads_id';
if (empty($last_comment)) $select .= ', thr.users_id AS users_id, thr.threads_time AS threads_time';
$where = "thr.threads_id = '" . $fid . "'";
$data['thread'] = cs_sql_select(__FILE__,$from,$select,$where);

if (empty($last_comment)) {
  $last_comment['users_id'] = $data['thread']['users_id'];
  $last_comment['comments_time'] = $data['thread']['threads_time'];
}

//Sicherheitsabfrage Beginn 
if(!empty($data['thread']['board_pwd'])) {
  $where = 'users_id = "' . $account['users_id'] . '" AND board_id = "' . $data['thread']['board_id'] . '"';
  $check_pw = cs_sql_count(__FILE__,'boardpws',$where);
}

if(!empty($data['thread']['squads_id']) AND $account['access_board'] < $data['thread']['board_access']) {
  $sq_where = "users_id = '" . $account['users_id'] . "' AND squads_id = '" . $data['thread']['squads_id'] . "'";
  $check_sq = cs_sql_count(__FILE__,'members',$sq_where);
}
if(empty($fid) || (count($data['thread']) == 0)) {
  return errorPage('com_create', $cs_lang);
}
if($account['access_board'] < $data['thread']['board_access'] AND empty($check_sq) OR empty($check_pw)) {
  return errorPage('com_create', $cs_lang);
}
if($account['users_id'] == $last_comment['users_id'] && ( $options['doubleposts'] == -1 || ($last_comment['comments_time'] + $options['doubleposts']) > cs_time() )) {
  return errorPage('com_create', $cs_lang, $cs_lang['last_own']);
}
//ende sicherheits abfrage

#check mod
$acc_close = 0;
$check_mod = cs_sql_select(__FILE__,'boardmods','boardmods_modpanel','users_id = "' . $account['users_id'] . '"',0,0,1);
if(!empty($check_mod['boardmods_modpanel']) OR $account['access_board'] == 5) {
  $acc_close = 1;
}

$head  = cs_link($cs_lang['board'],'board','list','normalb') .' -> ';
$head .= cs_link($data['thread']['categories_name'],'board','list','where=' .$data['thread']['categories_id'],'normalb') .' -> ';
$head .= cs_link($data['thread']['board_name'],'board','listcat','where=' .$data['thread']['board_id'],'normalb') .' -> ';
$head .= cs_link($data['thread']['threads_headline'],'board','thread','where=' .$data['thread']['threads_id'],'normalb');
$data['thread']['head_link'] = $head;

//quote
if(isset($_REQUEST['quote']) OR isset($_POST['fquote'])) {
  if(!empty($_POST['fquote'])) {
    $def[0] = 'c';
    $def[1] = (int) $_POST['fquote'];
  }elseif(!empty($_REQUEST['quote'])) {
    $def = explode('-', $_REQUEST['quote']);
  }

  #comment
  if($def[0]=='c') {
    $joins = 'comments cmt INNER JOIN {pre}_threads thr ON cmt.comments_fid = thr.threads_id INNER JOIN {pre}_board brd ON '
           . 'thr.board_id = brd.board_id LEFT JOIN {pre}_members mem ON brd.squads_id = mem.squads_id AND mem.users_id = ' . $account['users_id'];
    $fields = 'cmt.users_id AS users_id, cmt.comments_text AS comments_text, cmt.comments_time AS comments_time, '
            . 'cmt.comments_fid AS comments_fid, thr.threads_id AS threads_id, brd.board_access AS board_access';
    $conditions = "cmt.comments_id = '" . cs_sql_escape($def[1]) . "' AND (brd.board_access <= '" . $account['access_board'] . "' OR mem.users_id = " . $account['users_id'] . ")";
    $quote = cs_sql_select($file, $joins, $fields, $conditions);
    $cs_users = cs_sql_select(__FILE__,'users','users_id, users_nick', "users_id = '" . $quote['users_id'] . "'");
    $ori_text = '[quote]' .$quote['comments_text']. '[/quote]';
    $url = cs_url('users', 'view', 'id=' . $cs_users['users_id']);
    $ori_text = cs_date('unix',$quote['comments_time'],1) . ' - [url=' . $url . ']';
    $ori_text .= $cs_users['users_nick'] . "[/url]:\n[quote]" . $quote['comments_text'] . '[/quote]';
  }
  #thread
  else if($def[0]=='t') {
    $select = "threads thr INNER JOIN {pre}_board brd ON thr.board_id = brd.board_id LEFT JOIN {pre}_members mem ON brd.squads_id = mem.squads_id AND mem.users_id = " . $account['users_id'];
    $cells = "thr.users_id AS users_id, thr.threads_text AS threads_text, thr.threads_time AS threads_time, brd.board_access AS board_access";
    $where = "thr.threads_id = '" . cs_sql_escape($def[1]) . "' AND (brd.board_access <= '" . $account['access_board'] . "' OR mem.users_id = " . $account['users_id'] . ")";
    $quote = cs_sql_select($file,$select,$cells,$where);
    $cs_users = cs_sql_select(__FILE__,'users','users_id, users_nick',"users_id = '" . $quote['users_id'] . "'");
    $url = $_SERVER['PHP_SELF'] . '?mod=users&action=view&id=' . $cs_users['users_id'];
    $ori_text = cs_date('unix',$quote['threads_time'],1) . ' - [url=' . $url . ']';
    $ori_text .= $cs_users['users_nick'] . "[/url]:\n[quote]" . $quote['threads_text'] . '[/quote]';
  }
}

if(isset($_POST['submit']) OR isset($_POST['preview']) OR isset($_POST['advanced']) OR isset($_POST['new_file']) OR isset($_POST['files']) OR isset($_POST['fquote'])) {

  $quote_in = !empty($ori_text) ? "\n" . $ori_text : '';
  $text = $_POST['comments_text'] . $quote_in ;
  $close_now = !empty($_POST['close_now']) ? 1 : 0; ## hier

  //check text
  if(!empty($text)) {
    $text_count = strlen($text);
    $ori_text = $text;
    if($text_count >= $max_text) {
      $diff = $text_count - $max_text;
      $error .= sprintf($cs_lang['text_to_long_sprint'],$text_count,$diff) . cs_html_br(1);
    }
    $text = preg_replace_callback("=\[img\](.*?)\[/img\]=si","cs_abcode_resize",$text);
    $text = preg_replace_callback("=\[img width\=(.*?) height\=(.*?)\](.*?)\[/img\]=si","cs_abcode_resize",$text);  
  }
  elseif(empty($com['commtents_text']) AND !isset($_POST['advanced'])){
    $error .= $cs_lang['no_text'] . cs_html_br(1);
  }

  //check doublepost
  $find = 'comments_mod = \'board\' AND comments_fid = "' . $fid . '"';
  $last_from = cs_sql_select(__FILE__,'comments','users_id, comments_time',$find,'comments_id DESC');
  $time = cs_time();

  if($account['users_id'] == $last_from['users_id'] && $last_from['comments_time'] + $options['doubleposts'] > $time) {
    $error .= $cs_lang['last_own'];

    if($options['doubleposts'] != -1) {
      $wait_days = round(($last_from['comments_time'] + $options['doubleposts'] - $time) / 86400, 1);
      $error .=  ' ' . sprintf($cs_lang['wait_after_comment'],$wait_days);
    }
    $error .= cs_html_br(1);
  }

  //check flood
  $where = 'users_id = "' . $account['users_id'] . '" AND comments_mod = \'board\'';
  $flood = cs_sql_select(__FILE__,'comments','comments_time',$where,'comments_time DESC');
  $maxtime = $flood['comments_time'] + $cs_main['def_flood'];

  if($maxtime > cs_time()) {
    $diff = $maxtime - cs_time();
    $error .= sprintf($cs_lang['flood_on'], $diff) . cs_html_br(1);
  }

  //check close
  $board = cs_sql_select(__FILE__,'threads','threads_close',"threads_id = '" . $fid . "'");
  if(!empty($board['threads_close'])) {
    $error .= $cs_lang['not_able'] . cs_html_br(1);
  }

  //check board read
  if(!empty($data['thread']['board_read']) AND $account['access_clansphere'] < 5) {
    $error = $cs_lang['thread_only_read'];
  }

  //files
  $files = isset($_POST['files']) ? $_POST['files'] : 0;
  if(isset($_POST['new_file'])) {
    $files = '1';
  }
  $run_loop_files = isset($_POST['run_loop_files']) ? $_POST['run_loop_files'] : 0;
  for($run=0; $run < $run_loop_files; $run++) {
    $num = $run+1;
    if(!empty($files_gl["file_$num"]['name'])) {
      $board_files_name = $cs_files[$run]['boardfiles_name'] = $files_gl["file_$num"]['name'];
      $ext = substr($board_files_name,strlen($board_files_name)+1-strlen(strrchr($board_files_name,'.')));

      if($files_gl["file_$num"]['size'] > $options['file_size']) {
        $error .= $cs_lang['error_filesize'] . cs_html_br(1);
        $file_error[$num] = '1';
      }
      $check_type = '';
      $count_filetypes = count($filetypes);
      for($run_a=0; $run_a < $count_filetypes; $run_a++) {
        if($filetypes[$run_a] == $ext) {
          $check_type = 1;
        }
      }
      if($check_type != 1) {
        $error .= $cs_lang['error_filetype'] . cs_html_br(1);
        $file_error[$num] = '1';
      }
    }
    if(!empty($files_gl["file_$num"]['name']) AND empty($file_error[$num])) {
      $file_name[$num] = $files_gl["file_$num"]['name'];

      $hash = '';
      $pattern = "abcdefghijklmnopqrstuvwxyz";
      for($i=0;$i<8;$i++) {
        $hash .= $pattern{rand(0,25)};
      }
      $file_upload_name[$num] = $hash . '.' . $ext;
      if (cs_upload('board/files', $file_upload_name[$num], $files_gl["file_$num"]['tmp_name'])) {
        $a++;
      } else {
        $error .= $cs_lang['error_fileupload'] . cs_html_br(1);
      }
    }
    if(!empty($_POST["file_name_$num"]) AND empty($file_error[$num])) {
      $file_name[$num] = $_POST["file_name_$num"];
      $file_upload_name[$num] = $_POST["file_upload_name_$num"];
      if(isset($_POST["remove_file_$num"])) {
        cs_unlink('board', $file_upload_name[$num], 'files');
        $file_name[$num] = '';
      } else {
        $file_name[$b] = $file_name[$num];
        $file_upload_name[$b] = $file_upload_name[$num];
        $a++;
        $b++;
      }
    }
  }
}

$data['if']['error'] = empty($error) ? false : true;
$data['show']['error'] = $error;

$data['if']['preview'] = FALSE;
if(isset($_POST['preview']) AND empty($error)) {
  $data['if']['preview'] = true;
  $data['thread']['preview_text'] = cs_secure($text,1,1);
}

$run_loop_files = $a;
if(isset($_POST['files+'])) {
  $run_loop_files++;
}

if(!empty($error) OR isset($_POST['preview']) OR !isset($_POST['submit']) OR isset($_POST['files+']) OR isset($_POST['new_file'])) {

  $data['thread']['text_size'] = $max_text;
  $data['abcode']['smileys'] = cs_abcode_smileys('comments_text');
  $data['abcode']['features'] = cs_abcode_features('comments_text');
  $data['data']['comments_text'] = cs_secure($ori_text,0,0,0,0,0);

  //files
  $data['if']['file'] = FALSE;

  $a = $run_loop_files;
  $run_loop_files = !empty($run_loop_files) ? $run_loop_files : 1;

  if($files == 1)
  {
    $data['if']['file'] = TRUE;

  require_once 'mods/clansphere/filetype.php';

    for($run=0; $run < $run_loop_files; $run++)
    {
      $num = $run + 1;
      $cs_files["text_$num"] = isset($_POST["text_$num"]) ? $_POST["text_$num"] : '';

      $data['files'][$run]['num'] = $num;

      $data['files'][$run]['if']['empty_file'] = FALSE;
      $data['files'][$run]['if']['file_exists'] = FALSE;

      if(empty($file_name[$num]))
      {
        $data['files'][$run]['if']['empty_file'] = TRUE;

          $matches[1] = $cs_lang['infos'];
          $return_types = '';
          foreach($filetypes AS $add) {
             $return_types .= empty($return_types) ? $add : ', ' . $add;
          }
          $matches[2] = $cs_lang['max_size'] . cs_filesize($options['file_size']) . cs_html_br(1);
          $matches[2] .= $cs_lang['filetypes'] . ': ' . $return_types;
        $data['files'][$run]['clip'] = cs_abcode_clip($matches);
      }
      else {
        $data['files'][$run]['if']['file_exists'] = TRUE;

        $data['files'][$run]['name'] = $file_name[$num];
        $data['files'][$run]['up_name'] = $file_upload_name[$num];

        $file = $file_name[$num];
        $extension = strlen(strrchr($file,"."));
        $name = strlen($file);
        $ext = substr($file,$name - $extension + 1,$name);
        $ext_lower = strtolower($ext);
                
        $data['files'][$run]['ext'] = cs_filetype($ext_lower);        
        $data['files'][$run]['if']['file_is_picture'] = FALSE;
        $data['files'][$run]['if']['file_is_other'] = FALSE;
        
        #check if file is picture
        if(strcasecmp($ext,'jpg') == '0' OR strcasecmp($ext,'jpeg') == '0' OR strcasecmp($ext,'gif') == '0' OR strcasecmp($ext,'png') == '0') {
          $data['files'][$run]['if']['file_is_picture'] = TRUE;
        } else {
          $data['files'][$run]['if']['file_is_other'] = TRUE;
        }
      }
    }
  }

  $data['if']['add_file'] = FALSE;
  $data['if']['new_file'] = FALSE;

  if($files == '1' AND $account['access_board'] >= '2') {
    $data['if']['add_file'] = TRUE;
    $data['hidden']['files_loop'] = $run_loop_files;
  }
  if($files == '0' AND $account['access_board'] >= '2') {
    $data['if']['new_file'] = TRUE;
  }

  if(!empty($acc_close)) {
    $data['if']['allow_close'] = TRUE;
    $data['check']['close_now'] = !empty($close_now) ? 'checked="checked"' : '';
  }else{
    $data['if']['allow_close'] = FALSE;
  }

  $data['com']['fid'] = $fid;

  $where = "comments_mod = 'board' AND comments_fid = '" . $fid . "'";
  $count_com = cs_sql_count(__FILE__,'comments',$where);
  if(!empty($count_com)) {
    $data['if']['com_form'] = FALSE;
  }else{
    $data['if']['com_form'] = TRUE;
  }

 echo cs_subtemplate(__FILE__,$data,'board','com_create');
}
else {
  $opt = "comments_mod = 'board' AND comments_fid = '" . $fid . "'";
  $count_com = cs_sql_count(__FILE__,'comments',$opt);

  $options = cs_sql_option(__FILE__,'board');
  if($options['sort'] == 'DESC') {
    $start = 0;
  } else {
    $start = floor($count_com / $account['users_limit']) * $account['users_limit'];
    $count_com = $count_com % $account['users_limit'];
  }

  $user_ip = cs_getip();
  $users_id = $account['users_id'];
  $time = cs_time();

  $com_cells = array('users_id', 'comments_fid', 'comments_mod', 'comments_ip', 'comments_time', 'comments_text');
  $com_save = array($users_id, $fid, 'board', $user_ip, $time, $text);
  cs_sql_insert(__FILE__,'comments',$com_cells,$com_save);
  $idnow = cs_sql_insertid(__FILE__);
  
  $thread_cells = array('threads_last_time','threads_last_user');
  $thread_save = array(cs_time(),$account['users_id']);
  cs_sql_update(__FILE__,'threads',$thread_cells,$thread_save,$fid);

  for($run=0; $run < $run_loop_files; $run++) {
    $num = $run+1;
    $files_cells = array('users_id','threads_id','comments_id','boardfiles_time','boardfiles_name');
    $files_save = array($users_id,$fid,$idnow,cs_time(),$file_name[$num]);
    cs_sql_insert(__FILE__,'boardfiles',$files_cells,$files_save);
    $files_select_new_id = cs_sql_insertid(__FILE__);
    $ext = substr($file_name[$num],strlen($file_name[$num])+1-strlen(strrchr($file_name[$num],'.')));
    $path = $cs_main['def_path'] . '/uploads/board/files/';
    $target = $path . $file_upload_name[$num];
    $target2 = $path . $files_select_new_id . '.' . $ext;
    $fileHand = fopen($target, 'r');
    fclose($fileHand);
    rename( $target, $target2 );
  }
  
  include_once('mods/board/repair.php');
  cs_board_comments($data['thread']['board_id']);
  cs_threads_comments($data['thread']['threads_id']);

  if(!empty($close_now) AND !empty($acc_close)) {
    $close_cells = array('threads_close');
    $close_save = array($account['users_id']);
    cs_sql_update(__FILE__,'threads',$close_cells,$close_save,$data['thread']['threads_id']);
  }
  // START Abo-Mail
  $from = "abonements abo LEFT JOIN {pre}_read red ON (abo.users_id = red.users_id AND abo.threads_id = red.threads_id)
                               INNER JOIN {pre}_users usr ON abo.users_id = usr.users_id";
  $where = 'abo.threads_id = '.$data['thread']['threads_id'].'
            AND abo.users_id != '.$account['users_id'].'
            AND usr.users_delete != 1
            AND usr.users_abomail = 1';
  $abo_users = cs_sql_select(__FILE__,$from,'abo.abonements_id, usr.users_lang, usr.users_email',$where,0,0,0);
  
  $abo['count'] = empty($abo_users) ? 0 : count($abo_users);
  $abo_lang[$account['users_lang']]['text'] = $cs_lang['abo_mail_text'];
  $abo_lang[$account['users_lang']]['subject'] = $cs_lang['mod2'];
  $pattern1 = '/abo_mail_text\'\](\s*)=(\s*)\'(?<value>.*)\';/';
  $pattern2 = '/mod2\'\](\s*)=(\s*)\'(?<value>.*)\';/';
  $abo['new_time'] = array(cs_time());
  
  for($run=0; $run < $abo['count']; $run++) {
    $abo['lang'] = empty($abo_users[$run]['users_lang']) ? 'English' : $abo_users[$run]['users_lang'];
    if (empty($abo_lang[$abo['lang']]['text'])) {
      $abo_lang[$abo['lang']] = cs_cache_load('lang_abo_'.$abo['lang']);
      if ($abo_lang[$abo['lang']] === FALSE) {
        // read lang-file and search for text- & subject-placeholder
        $fp   = fopen($cs_main['def_path'].'/lang/'.$abo['lang'].'/board.php', 'r');
        $file_content = '';
        while ( !feof($fp) ) {
            $file_content .= fgets($fp, 4096);
        }
        preg_match($pattern1, $file_content, $match);
          $abo_lang[$abo['lang']]['text'] = $match['value'];
        preg_match($pattern2, $file_content, $match);
          $abo_lang[$abo['lang']]['subject'] = $match['value'];
        cs_cache_save('lang_abo_'.$abo['lang'], $abo_lang[$abo['lang']]);
      }
    }
    
    if (empty($abo_text[$abo['lang']]['text']))
      $abo_text[$abo['lang']]['text'] = sprintf($abo_lang[$abo['lang']]['text'],$data['thread']['threads_headline'],$account['users_nick']);
    
    cs_mail($abo_users[$run]['users_email'],$abo_lang[$abo['lang']]['subject'],$abo_text[$abo['lang']]['text']);
  }
  // END Abo-Mail

  $where = "comments_mod = 'board' AND comments_fid = '" . $fid . "'";
  $count_com = cs_sql_count(__FILE__,'comments',$where);

  $add_start = empty($start) ? '' : '&start=' . $start;
  $more = 'where=' . $fid . $add_start . '#com' . $count_com;
  cs_redirect($cs_lang['create_done'],'board','thread',$more);
}

if(!empty($data['thread']['board_read']) AND $account['access_clansphere'] < 5) {
  # this part seems to need some rework
}
else {
  require_once('mods/comments/functions.php');
  cs_comments_view($fid,'board','com_create',$count_com,false,5);  
}