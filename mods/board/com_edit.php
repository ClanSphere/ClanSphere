<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

$files_gl = cs_files();

$comments_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $comments_id = $cs_post['id'];

$check_pw = 1;
$check_sq = 0;
include('mods/board/functions.php');

$cells = 'users_id, comments_text, comments_time, comments_fid';
$cs_comments = cs_sql_select(__FILE__,'comments',$cells,"comments_id = '" . $comments_id . "'");
$fid = $cs_comments['comments_fid'];

$options = cs_sql_option(__FILE__,'board');
$max_text = $options['max_text'];
$filetypes = explode(',',$options['file_types']);
$error = '';
$ori_text = $cs_comments['comments_text'];


$from = 'comments com INNER JOIN {pre}_threads thr ON com.comments_fid = thr.threads_id INNER JOIN {pre}_board frm ON thr.board_id = frm.board_id INNER JOIN {pre}_categories cat ON frm.categories_id = cat.categories_id';
$select = 'thr.threads_headline AS threads_headline, frm.board_name AS board_name, cat.categories_name AS categories_name, thr.threads_id AS threads_id, frm.board_id AS board_id, cat.categories_id AS categories_id, com.comments_edit AS comments_edit, com.users_id AS users_id, frm.board_pwd AS board_pwd, frm.board_access AS board_access, frm.squads_id AS squads_id';
$where = "com.comments_id = '" . $comments_id . "'";
$cs_thread = cs_sql_select(__FILE__,$from,$select,$where,0,0,1);

$thread_mods = cs_sql_select(__FILE__,'boardmods','boardmods_edit',"users_id = '" . $account['users_id'] . "'",0,0,1);

//Sicherheitsabfrage Beginn
if(!empty($cs_thread['board_pwd'])) {
  $where = 'users_id = "' . $account['users_id'] . '" AND board_id = "' . $cs_thread['board_id'] . '"';
  $check_pw = cs_sql_count(__FILE__,'boardpws',$where);
}

if(!empty($cs_thread['squads_id']) AND $account['access_board'] < $cs_thread['board_access']) {
  $sq_where = "users_id = '" . $account['users_id'] . "' AND squads_id = '" . $cs_thread['squads_id'] . "'";
  $check_sq = cs_sql_count(__FILE__,'members',$sq_where);
}

if(empty($fid) || (count($cs_thread) == 0))
  return errorPage('com_edit', $cs_lang);

if($account['access_board'] >= $cs_thread['board_access'] OR !empty($check_sq))
{
  $allowed = 0;
  if(($cs_thread['users_id'] == $account['users_id'] OR $account['access_comments'] >= 4 OR !empty($thread_mods['boardmods_edit'])) AND !empty($check_pw))
    $allowed = 1;
  else
     return errorPage('com_edit', $cs_lang);
}
else if(empty($allowed))
  return errorPage('com_edit', $cs_lang);
//Sicherheitsabfrage Ende

// Boardfiles Berechnung Start
$run_loop_files = '0';
$check = cs_sql_count(__FILE__,'boardfiles','threads_id =' . $cs_thread['threads_id'] . ' AND comments_id=' .  $comments_id);
if(!empty($check) AND empty($_POST)) {
  $from = 'boardfiles';
  $select = 'boardfiles_id, threads_id, users_id, boardfiles_name';
  $where = 'threads_id=' . $cs_thread['threads_id'] . ' AND comments_id=' . $comments_id;
  $cs_boardfiles = cs_sql_select(__FILE__,$from,$select,$where,'','','');
  $run_loop_files = count($cs_boardfiles);
  $files = '1';
} else {
  $files = isset($_POST['files']) ? $_POST['files'] : 0;
}

if(isset($_POST['new_file'])) {
  $files = '1';
}

$thread_error = 0;
$file_error = array();

$run_loop_files = isset($_POST['run_loop_files']) ? $_POST['run_loop_files'] + $run_loop_files : 0 + $run_loop_files;
$a = '0';
$b = '0';
for($run=0; $run < $run_loop_files; $run++) {
  $num = $run+1;
  if(!empty($files_gl['file_'.$num]['name'])) {
    $board_files_name = $cs_boardfiles[$run]['boardfiles_name'] = $files_gl['file_'.$num]['name'];

    $ext = strtolower(substr(strrchr($board_files_name,'.'),1));

    if($files_gl['file_'.$num]['size'] > $options['file_size']) {
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
  $check = '0';
  if(!empty($files_gl["file_$num"]['name']) AND !isset($file_error[$num])) {
    $cs_boardfiles[$run]['boardfiles_id'] = '';
    $cs_boardfiles[$run]['users_id'] = $account['users_id'];
    $cs_boardfiles[$run]['boardfiles_name'] = $files_gl["file_$num"]['name'];
    $cs_boardfiles[$run]['boardfiles_del'] = '0';

    $hash = '';
    $pattern = "abcdefghijklmnopqrstuvwxyz";
    for($i=0;$i<8;$i++)
    {
      $hash .= $pattern{rand(0,25)};
    }
    $file_upload_name[$run] = $hash . '.' . $ext;

    if (cs_upload('board/files', $file_upload_name[$run], $files_gl["file_$num"]['tmp_name'])) {
      $a++;
      $check = '1';
    } else {
      $error .= $cs_lang['error_fileupload'] . cs_html_br(1);
      $file_error[$num]++;
    }
  }
  if(!empty($_POST["file_name_$num"]) AND !isset($file_error[$num])) {
    $cs_boardfiles[$run]['boardfiles_id'] = $_POST["file_id_$num"];
    $cs_boardfiles[$run]['users_id'] = $_POST["file_user_$num"];
    $cs_boardfiles[$run]['boardfiles_name'] = $_POST["file_name_$num"];
    $cs_boardfiles[$run]['boardfiles_del'] = !empty($_POST["file_del_$num"]) ? $_POST["file_del_$num"] : '0';
    $file_upload_name[$run] = $_POST["file_upload_name_$num"];
    if(isset($_POST["remove_file_$num"])) {
      if(!empty($cs_boardfiles[$run]['boardfiles_id'])) {
        $cs_boardfiles[$run]['boardfiles_del'] = '1';
        $a++;
        $b++;
        $check = '1';
      } else {
        $ext = substr($cs_boardfiles[$run]['boardfiles_name'],strlen($cs_boardfiles[$run]['boardfiles_name'])+1-strlen(strrchr($cs_boardfiles[$run]['boardfiles_name'],'.')));
        $del_file_x = $cs_boardfiles[$run]['boardfiles_id'] . '.' . $ext;
        cs_unlink('board', $del_file_x, 'files');
        $cs_boardfiles[$run]['boardfiles_name'] = '';
      }
    } else {
      $cs_boardfiles[$b]['boardfiles_name'] = $cs_boardfiles[$run]['boardfiles_name'];
      $a++;
      $b++;
      $check = '1';
    }
  }
  if(!empty($cs_boardfiles[$run]['boardfiles_name']) AND !isset($file_error[$num]) AND $check == '0') {
    if(isset($_POST["remove_file_$num"])) {
      $cs_boardfiles[$run]['boardfiles_del'] = '1';
      $a++;
      $b++;
    } else {
      $cs_boardfiles[$b]['boardfiles_id'] = $cs_boardfiles[$run]['boardfiles_id'];
      $cs_boardfiles[$b]['users_id'] = $cs_boardfiles[$run]['users_id'];
      $cs_boardfiles[$b]['boardfiles_name'] = $cs_boardfiles[$run]['boardfiles_name'];
      $cs_boardfiles[$b]['boardfiles_del'] = !empty($cs_boardfiles[$run]['boardfiles_del']) ? $cs_boardfiles[$run]['boardfiles_del'] : '0';
      $a++;
      $b++;
    }
  }
}
$run_loop_files = $a;
if(isset($_POST['files+'])) {
  $run_loop_files++;
}
// Boardfiles Berechnung Ende


$head  = cs_link($cs_lang['board'],'board','list','normalb') .' -> ';
$head .= cs_link($cs_thread['categories_name'],'board','list','where=' .$cs_thread['categories_id'],'normalb') .' -> ';
$head .= cs_link($cs_thread['board_name'],'board','listcat','where=' .$cs_thread['board_id'],'normalb') .' -> ';
$head .= cs_link($cs_thread['threads_headline'],'board','thread','where=' .$cs_thread['threads_id'],'normalb');
$data['head']['links'] = $head;


if(isset($_POST['submit']) OR isset($_POST['preview']) OR isset($_POST['files+']) OR isset($_POST['new_file'])) {

  $cs_comments['comments_text'] = $_POST['comments_text'];

  $error = '';

  //check text
  if(!empty($cs_comments['comments_text'])) {
    $text_count = strlen($cs_comments['comments_text']);
    $ori_text = $cs_comments['comments_text'];
    if($text_count >= $max_text) {
      $diff = $text_count - $max_text;
      $error .= sprintf($cs_lang['text_to_long_sprint'],$text_count,$diff) . cs_html_br(1);
    }
    $cs_comments['comments_text'] = preg_replace_callback("=\[img\](.*?)\[/img\]=si","cs_abcode_resize",$cs_comments['comments_text']);
    $cs_comments['comments_text'] = preg_replace_callback("=\[img width\=(.*?) height\=(.*?)\](.*?)\[/img\]=si","cs_abcode_resize",$cs_comments['comments_text']);  
  }
  else{
    $error .= $cs_lang['no_text'] . cs_html_br(1);
  }
}


$data['if']['error'] = empty($error) ? false : true;
$data['show']['error'] = $error;

$data['if']['preview'] = FALSE;
if(isset($_POST['preview']) AND empty($error)) {
  $data['if']['preview'] = true;
  $data['prev']['text'] = cs_secure($cs_comments['comments_text'],1,1);
}


if(!empty($error) OR isset($_POST['preview']) OR !isset($_POST['submit'])) {

  $data['thread']['text_size'] = $max_text;
  $data['abcode']['smileys'] = cs_abcode_smileys('comments_text');
  $data['abcode']['features'] = cs_abcode_features('comments_text');
  $data['data']['comments_text'] = cs_secure($ori_text,0,0,0,0,0);
  
  
  //files
  $data['if']['file'] = FALSE;

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
      
      if(empty($cs_boardfiles[$run]['boardfiles_name']) OR !empty($file_error[$num]))
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
        if(empty($_POST)) {
          $file_x = $cs_boardfiles[$run]['boardfiles_name'];
          $ext = substr($file_x,strlen($file_x)+1-strlen(strrchr($file_x,'.')));
          $file_upload_name[$run] = $cs_boardfiles[$run]['boardfiles_id'] . '.' . $ext;
        }
        $data['files'][$run]['if']['file_exists'] = TRUE;
      
        $data['files'][$run]['name'] = $cs_boardfiles[$run]['boardfiles_name'];
        $data['files'][$run]['up_name'] = $file_upload_name[$run];
        $data['files'][$run]['b_id'] = $cs_boardfiles[$run]['boardfiles_id'];
        $data['files'][$run]['user'] = $cs_boardfiles[$run]['users_id'];
        $data['files'][$run]['del'] = $cs_boardfiles[$run]['boardfiles_del'];
        
        $file = $cs_boardfiles[$run]['boardfiles_name'];
        $extension = strlen(strrchr($file,"."));
        $name = strlen($file);
        $ext = substr($file,$name - $extension + 1,$name);
        $ext_lower = strtolower($ext);
                
        $data['files'][$run]['ext'] = cs_filetype($ext_lower);
        
        $data['files'][$run]['if']['del_button'] = FALSE;
        $data['files'][$run]['file_del'] = '';
        if($cs_boardfiles[$run]['boardfiles_del'] == '0') {
          $data['files'][$run]['if']['del_button'] = TRUE;
        } elseif($cs_boardfiles[$run]['boardfiles_del'] == '1') {
          $data['files'][$run]['file_del'] = $cs_lang['file_del'];
        }
        
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

  $data['comments']['id'] = $comments_id;


 echo cs_subtemplate(__FILE__,$data,'board','com_edit');
}
else {
  $opt = "comments_mod = 'board' AND comments_fid = \"" . $fid . "\"";
  $opt .= " AND comments_id <= \"" . $comments_id . "\"";
  $count_com = cs_sql_count(__FILE__,'comments',$opt);
  
  if ($options['sort'] == 'ASC') {
    $remainder = $count_com % $account['users_limit'];
    $start = $count_com % $account['users_limit'] == 0 ? $count_com - $remainder - $account['users_limit'] : $count_com - $remainder;
  } else {
    $where = "comments_fid = \"" . $fid . "\" AND comments_mod = 'board' AND comments_id > \"" . $comments_id . "\"";
    $after = cs_sql_count(__FILE__,'comments',$where);
    $start = $after - $after % $account['users_limit'];
  }

  if(!empty($cs_thread['comments_edit']))
    $comments_edits_now = explode('/',$cs_thread['comments_edit']);
  else
    $comments_edits_now[3] = 0;
    $new_count = 1 + $comments_edits_now[3];
    $comments_edit = $account['users_id'].'/'.$account['users_nick'].'/'.cs_time().'/'.$new_count;

  $com_cells = array('comments_text','comments_edit');
  $com_save = array($cs_comments['comments_text'],$comments_edit);
  cs_sql_update(__FILE__,'comments',$com_cells,$com_save,$comments_id);

  for($run=0; $run < $run_loop_files; $run++) {
    if($cs_boardfiles[$run]['boardfiles_del'] == 1) {
        $ext = substr($cs_boardfiles[$run]['boardfiles_name'],strlen($cs_boardfiles[$run]['boardfiles_name'])+1-strlen(strrchr($cs_boardfiles[$run]['boardfiles_name'],'.')));
        $del_file_x = $cs_boardfiles[$run]['boardfiles_id'] . '.' . $ext;
      cs_unlink('board', $del_file_x, 'files');
      $sql_id = $cs_boardfiles[$run]['boardfiles_id'];
      cs_sql_delete(__FILE__,'boardfiles',$sql_id);
    }
    if($cs_boardfiles[$run]['boardfiles_id'] == '') {
      $files_cells = array('users_id','threads_id','comments_id','boardfiles_time','boardfiles_name');
      $files_save = array($cs_boardfiles[$run]['users_id'],$cs_thread['threads_id'],$comments_id,cs_time(),$cs_boardfiles[$run]['boardfiles_name']);
      cs_sql_insert(__FILE__,'boardfiles',$files_cells,$files_save);
      $files_select_new_id = cs_sql_insertid(__FILE__);
      $ext = substr($cs_boardfiles[$run]['boardfiles_name'],strlen($cs_boardfiles[$run]['boardfiles_name'])+1-strlen(strrchr($cs_boardfiles[$run]['boardfiles_name'],'.')));
      $path = $cs_main['def_path'] . '/uploads/board/files/';
      $target = $path . $file_upload_name[$run];
      $target2 = $path . $files_select_new_id . '.' . $ext;
      $fileHand = fopen($target, 'r');
      fclose($fileHand);
      rename( $target, $target2 );
    }
  }

  $add_start = empty($start) ? '' : '&start=' . $start;
  $more = 'where=' . $fid . $add_start . '#com' . $count_com;
  
  cs_redirect($cs_lang['changes_done'],'board','thread',$more);
}