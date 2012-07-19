<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$files_gl = cs_files();

$check_pw = 1;
$board_id = empty($_REQUEST['id']) ? '' : $_REQUEST['id'];
if(!empty($_REQUEST['where']))
  $board_id = $_REQUEST['where'];
settype($board_id,'integer');

include('mods/board/functions.php');

$from = 'board frm INNER JOIN {pre}_categories cat ON frm.categories_id = cat.categories_id';
#$from .= " INNER JOIN {pre}_members mem ON frm.squads_id = mem.squads_id AND mem.users_id = '" . $account['users_id'] . "'";
$select = 'frm.board_pwd AS board_pwd, frm.board_name AS board_name, cat.categories_name AS categories_name, ';
$select .= 'frm.board_id AS board_id, cat.categories_id AS categories_id, frm.board_access AS board_access, frm.squads_id AS squads_id';
$where = "frm.board_id = '" . $board_id . "'";
$cs_thread = cs_sql_select(__FILE__,$from,$select,$where,0,0,1);
if(!empty ($cs_thread['board_pwd'])) {
  $where = "users_id = '" . $account['users_id'] . "' AND board_id = '" . $cs_thread['board_id'] . "'";
  $check_pw = cs_sql_count(__FILE__,'boardpws',$where);
}
if(!empty($cs_thread['squads_id'])) {
  $where = "squads_id = '" . $cs_thread['squads_id'] . "' AND users_id = '" .$account['users_id'] . "'";
  $check_sq = cs_sql_count(__FILE__,'members',$where);
}

//Sicherheitsabfrage Beginn
$errorpage = 0;
if(empty($board_id) || (count($cs_thread) == 0)) { $errorpage++; }
if($account['access_board'] < $cs_thread['board_access'] OR empty($check_pw)) { 
  $errorpage = empty($check_sq) ? 1 : 0;
}
if(!empty($errorpage)) {
  return errorPage('thread_add', $cs_lang);
}
//Sicherheitsabfrage Ende


#check mod
$acc_mod = 0;
$check_mod = cs_sql_select(__FILE__,'boardmods','boardmods_modpanel','users_id = "' . $account['users_id'] . '"',0,0,1);
if(!empty($check['boardmods_modpanel']) OR $account['access_board'] == 5) {
  $acc_mod = 1;
}

$head  = cs_link($cs_lang['board'],'board','list','normalb') .' -> ';
$head .= cs_link($cs_thread['categories_name'],'board','list','where=' .$cs_thread['categories_id'],'normalb') .' -> ';
$head .= cs_link($cs_thread['board_name'],'board','listcat','where=' .$cs_thread['board_id'],'normalb');
$data['head']['boardlinks'] = $head;

$bv['boardvotes_question'] = '';
$cs_board_opt = cs_sql_option(__FILE__,'board');
$max_size = $cs_board_opt['file_size'];
$filetypes = explode(',',$cs_board_opt['file_types']);

$board['board_id'] = $board_id;
$board['users_id'] = $account['users_id'];
$board['threads_last_user'] = $account['users_id'];
$board['threads_time'] = cs_time();
$board['threads_last_time'] = cs_time();
$board['threads_headline'] = '';
$board['threads_text'] = '';
$board['threads_important'] = 0;
$board['threads_close'] = 0;

$votes = 0;

if(isset($_POST['submit']) OR isset($_POST['preview']) OR isset($_POST['new_votes']) OR isset($_POST['election']) OR isset($_POST['files+']) OR isset($_POST['new_file']))
{

  $board['threads_headline'] = $_POST['threads_headline'];
  $board['threads_text'] = $_POST['threads_text'];
  
  if(!empty($acc_mod)) {
    $board['threads_important'] = isset($_POST['threads_important']) ? $_POST['threads_important'] : 0;
    $board['threads_close'] = isset($_POST['threads_close']) ? $account['users_id'] : 0;
  }

  $bv['boardvotes_access'] = isset($_POST['votes_access']) ? $_POST['votes_access'] : '0';
  $bv['boardvotes_question'] = isset($_POST['votes_question']) ? $_POST['votes_question'] : '';
  $bv['boardvotes_several'] = isset($_POST['votes_several']) ? '1' : '0';
  $cs_vote_tpl['several']['checked'] = empty($votes_several) ? '' : 'checked';
  if(cs_datepost('votes_end','unix')) {
    $bv['boardvotes_end'] = cs_datepost('votes_end','unix');
  }else{
    $bv['boardvotes_end'] = time() + 604800;
  }
  $votes = isset($_POST['votes']) ? $_POST['votes'] : 0;
  if(isset($_POST['new_votes'])) {
    $votes = '1';
  }

  $error = '';

  if(empty($board['threads_headline']))
    $error .= $cs_lang['no_headline'] . cs_html_br(1);
  
  if(!empty($board['threads_text'])) {
    $count_figures = strlen($board['threads_text']);
    if($count_figures >= $cs_board_opt['max_text']) {
      $diff = $count_figures - $cs_board_opt['max_text'];
      $error .= sprintf($cs_lang['text_to_long_sprint'],$count_figures,$diff) . cs_html_br(1);
    }
    $board['threads_text'] = preg_replace_callback("=\[img\](.*?)\[/img\]=si","cs_abcode_resize",$board['threads_text']);
    $board['threads_text'] = preg_replace_callback("=\[img width\=(.*?) height\=(.*?)\](.*?)\[/img\]=si","cs_abcode_resize",$board['threads_text']);
  }else{
    $error .= $cs_lang['no_text'] . cs_html_br(1);
  }

  $run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 0;
  $cs_votes['votes_election'] = '';
  $votes_loop = '';

  if(isset($_POST['votes_question'])) {
    if(!empty($bv['boardvotes_question']))
    {
      for($run=0; $run < $run_loop; $run++) {
        $num = $run+1;
        if(!empty($_POST["votes_election_$num"])) {
          $cs_votes["votes_election"] = $cs_votes["votes_election"] . "\n" . $_POST["votes_election_$num"];
          $votes_loop++;
        }
      }
      if(!empty($bv['boardvotes_question'])) {
        if(!empty($cs_votes['votes_election']) AND $votes_loop >= '2') {
          $bv['boardvotes_election'] = $cs_votes['votes_election'];
        }else{
          $error .= $cs_lang['error_election'] . cs_html_br(1);
        }
      }
    }
    else {
      $votes = 0;
    }
  }
}

$files = isset($_POST['files']) ? $_POST['files'] : 0;
if(isset($_POST['new_file'])) {
  $files = '1';
}
$run_loop_files = isset($_POST['run_loop_files']) ? $_POST['run_loop_files'] : 0;
$a = '0';
$b = '1';
for($run=0; $run < $run_loop_files; $run++) {
  $num = $run+1;
  if(!empty($files_gl["file_$num"]['name'])) {
    $board_files_name = $cs_files[$run]['boardfiles_name'] = $files_gl["file_$num"]['name'];
    $ext = substr($board_files_name,strlen($board_files_name)+1-strlen(strrchr($board_files_name,'.')));
    if($files_gl["file_$num"]['size'] > $max_size) {
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
    for($i=0;$i<8;$i++)
    {
      $hash .= $pattern{rand(0,25)};
    }
    $file_upload_name[$num] = $hash . '.' . $ext;
    if (cs_upload('board/files', $file_upload_name[$num], $files_gl["file_$num"]['tmp_name'])) {
      $a++;
    }  else {
      $error .= $cs_lang['error_fileupload'] . cs_html_br(1);
    }
  }
  if(!empty($_POST["file_name_$num"]) AND empty($file_error[$num])) {
    $file_name[$num] = $_POST["file_name_$num"];
    $file_upload_name[$num] = $_POST["file_upload_name_$num"];
    if(isset($_POST["remove_file_$num"])) {
      cs_unlink('board', $file_upload_name[$num], 'files');
      $file_name[$num] = '';
    }  else {
      $file_name[$b] = $file_name[$num];
      $file_upload_name[$b] = $file_upload_name[$num];
      $a++;
      $b++;
    }
  }
}
$run_loop_files = $a;
if(isset($_POST['files+'])) {
  $run_loop_files++;
}

$data['if']['error'] = FALSE;
if(!empty($error)) {
  $data['if']['error'] = TRUE;
  $data['show']['errors'] = $error;
}

$data['if']['preview'] = FALSE;

//////////// PREVIEW ////////////
if(isset($_POST['preview']) AND empty($error)) {

  $data['if']['preview'] = TRUE;
  $data['if']['pre_votes'] = FALSE;

  if($votes == 1) {
    $data['if']['pre_votes'] = TRUE;
    $data['preview']['question'] = $bv['boardvotes_question'];

    $run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 0;
    for($run=0; $run < $run_loop; $run++) {
      $num = $run+1;
      $cs_files["votes_election_$num"] = isset($_POST["votes_election_$num"]) ? $_POST["votes_election_$num"] : '';
      $data['pre_answers'][$run]['run'] = $run;
      $data['pre_answers'][$run]['answer'] = cs_secure($cs_files["votes_election_$num"],0,1);
    }
  }
  $data['preview']['text'] = cs_secure($board['threads_text'],1,1);
}

if(isset($_POST['election'])) {
    $_POST['run_loop']++;
}

if(!empty($error) OR !isset($_POST['submit']) OR isset($_POST['preview'])) {

  $data['data'] = $board;

  $data['abcode']['smileys'] = cs_abcode_smileys('threads_text');
  $data['abcode']['features'] = cs_abcode_features('threads_text');
  $data['max']['text'] = $cs_board_opt['max_text'];

  //////////// VOTES ////////////
  $data['if']['vote'] = FALSE;

  if($votes == 1)
  {
    $data['if']['vote'] = TRUE;
    $data['if']['vote_several'] = empty($bv['boardvotes_several']) ? false : true;

    $data['time']['select'] = cs_dateselect('votes_end','unix',$bv['boardvotes_end'],2005);

    $data['access']['options'] = '';
    $levels = 0;
    while($levels < 6) {
      $bv['boardvotes_access'] == $levels ? $sel = 1 : $sel = 0;
      $data['access']['options'] .= cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
      $levels++;
    }

    $data['data']['votes_question'] = $bv['boardvotes_question'];
    $data['several']['checked'] = empty($bv['boardvotes_several']) ? '' : 'checked="checked"';

    $run_loop = isset($_POST['run_loop']) ? $_POST['run_loop'] : 1;
    for($run=0; $run < $run_loop; $run++)
    {
      $num = $run+1;
      $cs_files["votes_election_$num"] = isset($_POST["votes_election_$num"]) ? $_POST["votes_election_$num"] : '';

      $data['answers'][$run]['num'] = $num;
      $data['answers'][$run]['answer'] = $cs_files["votes_election_$num"];
    }
  }

  //////////// FILES ////////////
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
          $matches[2] = $cs_lang['max_size'] . cs_filesize($max_size) . cs_html_br(1);
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

  $data['if']['new_votes'] = FALSE;
  $data['if']['add_answer'] = FALSE;
  $data['if']['add_file'] = FALSE;
  $data['if']['new_file'] = FALSE;
  $data['if']['advanced'] = FALSE;

  if(!empty($acc_mod)) {
    $data['if']['advanced'] = TRUE;
    $data['check']['important'] = !empty($board['threads_important']) ? 'checked="checked"' : '';
    $data['check']['close'] = !empty($board['threads_close']) ? 'checked="checked"' : ''; 
  }

  if($votes == 0 AND $account['access_board'] >= '2') {
    $data['if']['new_votes'] = TRUE;
  }
  if($votes == 1 AND $account['access_board'] >= '2') {
    $data['if']['add_answer'] = TRUE;
    $data['hidden']['votes_loop'] = $run_loop;
  }
  if($files == '1' AND $account['access_board'] >= '2') {
    $data['if']['add_file'] = TRUE;
    $data['hidden']['files_loop'] = $run_loop_files;
  }
  if($files == '0' AND $account['access_board'] >= '2') {
    $data['if']['new_file'] = TRUE;
  }

  $data['board']['id'] = $board_id;
  $data['data']['threads_headline'] = cs_secure($data['data']['threads_headline']);
  $data['data']['threads_text'] = cs_secure($data['data']['threads_text']);

 echo cs_subtemplate(__FILE__,$data,'board','thread_add');
}
else {

  #save thread
  $thread_cells = array_keys($board);
  $thread_save = array_values($board);
 cs_sql_insert(__FILE__,'threads',$thread_cells,$thread_save);

  $thread_now = cs_sql_select(__FILE__,'threads','threads_id','threads_id = \'' . cs_sql_insertid(__FILE__). '\'');

  #if thread voting -> save vote to boardvotes
  if($votes == 1) {
    $bv['users_id'] = $board['users_id'];
    $bv['threads_id'] = $thread_now['threads_id'];
    $bv['boardvotes_time'] = $board['threads_time'];

    $bv_cells = array_keys($bv);
    $bv_save = array_values($bv);
   cs_sql_insert(__FILE__,'boardvotes',$bv_cells,$bv_save);
  }

  for($run=0; $run < $run_loop_files; $run++) {
    $num = $run+1;
    $files_cells = array('users_id','threads_id','boardfiles_time','boardfiles_name');
    $files_save = array($board['users_id'],$thread_now['threads_id'],$board['threads_time'],$file_name[$num]);
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

  # Update board entry to get correct threads and comments count
  include_once('mods/board/repair.php');
  cs_board_threads($board_id);

  cs_redirect($cs_lang['create_done'],'board','thread','where=' .$thread_now['threads_id']);
}