<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

include_once('mods/board/functions.php');
$class = 'leftc';

$thread_id = $_REQUEST['id'];
settype($thread_id,'integer');

$from = 'threads thr INNER JOIN {pre}_board frm ON thr.board_id = frm.board_id ';
$from .= 'INNER JOIN {pre}_categories cat ON frm.categories_id = cat.categories_id';
$select = 'thr.threads_headline AS threads_headline, frm.board_name AS board_name, cat.categories_name AS categories_name, thr.users_id AS users_id, thr.threads_id AS threads_id, thr.threads_edit AS threads_edit, frm.board_id AS board_id, frm.board_access AS board_access, cat.categories_id AS categories_id, frm.squads_id AS squads_id';
$where = "thr.threads_id = '" . $thread_id . "'";
$cs_thread = cs_sql_select(__FILE__,$from,$select,$where);
$thread_mods = cs_sql_select(__FILE__,'boardmods','boardmods_edit',"users_id = '" . $account['users_id'] . "'",0,0,1);
if(!empty($cs_thread['squads_id'])) {
  $where = "squads_id = '" . $cs_thread['squads_id'] . "' AND users_id = '" .$account['users_id'] . "'";
  $check_sq = cs_sql_count(__FILE__,'members',$where);
}
//Sicherheitsabfrage Beginn
$allowed = 0;
if(empty($thread_id) || (count($cs_thread) == 0))
  return errorPage('thread_edit');

if($account['access_board'] >= $cs_thread['board_access']) {
  if($cs_thread['users_id'] == $account['users_id'] OR $account['access_comments'] >= 5 OR !empty($thread_mods['boardmods_edit']))
    $allowed = 1;
  else
     return errorPage('thread_edit');
} elseif(!empty($check_sq)) {
  $allowed = 1;  
} else if(empty($allowed)) {
  return errorPage('thread_edit');
}
//Sicherheitsabfrage Ende

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] .' - '. $cs_lang['thread_edit'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
$head  = cs_link($cs_lang['board'],'board','list','normalb') .' -> ';
$head .= cs_link($cs_thread['categories_name'],'board','list','where=' .$cs_thread['categories_id'],'normalb') .' -> ';
$head .= cs_link($cs_thread['board_name'],'board','listcat','where=' .$cs_thread['board_id'],'normalb') .' -> ';
$head .= cs_link($cs_thread['threads_headline'],'board','thread','where=' .$cs_thread['threads_id'],'normalb');
echo $head;
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$thread_error = 2;
$thread_form = 1;
$thread_edit = cs_sql_select($file,'threads','*',"threads_id = '" . $thread_id . "'");
$thread_headline = $thread_edit['threads_headline'];
$thread_text = $thread_edit['threads_text'];
$thread_time = $thread_edit['threads_time'];
$thread_userid = $thread_edit['users_id'];
$cs_board_opt = cs_sql_option(__FILE__,'board');
$max_text = $cs_board_opt['max_text'];
$max_size = $cs_board_opt['file_size'];
$filetypes = explode(',',$cs_board_opt['file_types']);
$message = '';

// Boardfiles Berechnung Start
$run_loop_files = '0';
$check = cs_sql_count(__FILE__,'boardfiles','threads_id =' . $thread_id . ' AND comments_id=0');
if(!empty($check) AND empty($_POST)) {
  $from = 'boardfiles';
  $select = 'boardfiles_id, threads_id, users_id, boardfiles_name';
  $where = "threads_id = '" . $thread_id . "' AND comments_id = 0";
  $cs_boardfiles = cs_sql_select(__FILE__,$from,$select,$where,'','','');
  $run_loop_files = count($cs_boardfiles);
//  print_r($cs_boardfiles);
  $files = '1';
} else {
  $files = isset($_POST['files']) ? $_POST['files'] : 0;
}

if(isset($_POST['new_file'])) {
  $files = '1';
}
$run_loop_files = isset($_POST['run_loop_files']) ? $_POST['run_loop_files'] + $run_loop_files : 0 + $run_loop_files;
$a = '0';
$b = '0';
for($run=0; $run < $run_loop_files; $run++) {
  $num = $run+1;
  if(!empty($_FILES['file_'.$num]['name']))  {
    $board_files_name = $cs_boardfiles[$run]['boardfiles_name'] = $_FILES['file_'.$num]['name'];

    $ext = substr($board_files_name,strlen($board_files_name)+1-strlen(strrchr($board_files_name,'.')));

    if($_FILES["file_$num"]['size'] > $max_size) {
      $message .= $cs_lang['error_filesize'] . cs_html_br(1);
      $thread_error++;
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
      $message .= $cs_lang['error_filetype'] . cs_html_br(1);
      $thread_error++;
      $file_error[$num] = '1';
    }
    if(!empty($file_error[$num])) {
      echo cs_html_table(1,'forum',1);
      echo cs_html_roco(1,'leftc');
      echo cs_icon('important');
      echo $cs_lang['error_subheader'];
      echo cs_html_roco(0);
      echo cs_html_roco(1,'leftb');
      echo $message;
      echo cs_html_roco(0);
      echo cs_html_table(0);
      echo cs_html_br(1);
    }
  }
  $check = '0';
  if(!empty($_FILES["file_$num"]['name']) AND !isset($file_error[$num])) {
    $cs_boardfiles[$run]['boardfiles_id'] = '';
    $cs_boardfiles[$run]['users_id'] = $account['users_id'];
    $cs_boardfiles[$run]['boardfiles_name'] = $_FILES["file_$num"]['name'];
    $cs_boardfiles[$run]['boardfiles_del'] = '0';

    $hash = '';
    $pattern = "abcdefghijklmnopqrstuvwxyz";
    for($i=0;$i<8;$i++)
    {
      $hash .= $pattern{rand(0,25)};
    }
    $file_upload_name[$run] = $hash . '.' . $ext;

    if (cs_upload('board/files', $file_upload_name[$run], $_FILES["file_$num"]['tmp_name'])) {
      $a++;
      $check = '1';
    } else {
      $message .= $cs_lang['error_fileupload'] . cs_html_br(1);
      $thread_error++;
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
      }  else {
        $ext = substr($cs_boardfiles[$run]['boardfiles_name'],strlen($cs_boardfiles[$run]['boardfiles_name'])+1-strlen(strrchr($cs_boardfiles[$run]['boardfiles_name'],'.')));
        $del_file_x = $cs_boardfiles[$run]['boardfiles_id'] . '.' . $ext;
        cs_unlink('board', $del_file_x, 'files');
        $cs_boardfiles[$run]['boardfiles_name'] = '';
      }
    }  else {
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

if(!empty($_POST['thread_headline'])) {
  $thread_headline = $_POST['thread_headline'];
  $thread_error--;
}
if(!empty($_POST['thread_text']))
{
  $thread_text = $_POST['thread_text'];
  $thread_text_count = strlen($thread_text);
  if($thread_text_count <= $max_text)
  {
    $thread_text = $_POST['thread_text'];
    $thread_error--;
  }
  else
  {
    $thread_text = $_POST['thread_text'];
    $count = $thread_text_count - $max_text;
    $message .= $cs_lang['text_to_long'] . $thread_text_count . $cs_lang['text_to_long_2'] . $count . $cs_lang['text_to_long_3'] . cs_html_br(1);
  }
  $thread_text = preg_replace_callback("=\[img\](.*?)\[/img\]=si","cs_abcode_resize",$thread_text);
  $thread_text = preg_replace_callback("=\[img width\=(.*?) height\=(.*?)\](.*?)\[/img\]=si","cs_abcode_resize",$thread_text);
}

if(isset($_POST['submit'])) {
  if(empty($thread_error)) {
    $thread_form = 0;
    if(!empty($cs_thread['threads_edit']))
        $threads_edits_now = explode('/',$cs_thread['threads_edit']);
      else
        $threads_edits_now[3] = 0;
    $new_count = 1 + $threads_edits_now[3];
    $threads_edit = $account['users_id'].'/'.$account['users_nick'].'/'.cs_time().'/'.$new_count;
    $thread_cells = array('threads_headline','threads_text','threads_edit');
    $thread_save = array($thread_headline,$thread_text,$threads_edit);
    cs_sql_update(__FILE__,'threads',$thread_cells,$thread_save,$thread_id);

    for($run=0; $run < $run_loop_files; $run++)
    {
      if($cs_boardfiles[$run]['boardfiles_del'] == 1)
      {
        $ext = substr($cs_boardfiles[$run]['boardfiles_name'],strlen($cs_boardfiles[$run]['boardfiles_name'])+1-strlen(strrchr($cs_boardfiles[$run]['boardfiles_name'],'.')));
        $del_file_x = $cs_boardfiles[$run]['boardfiles_id'] . '.' . $ext;
        cs_unlink('board', $del_file_x, 'files');
        $sql_id = $cs_boardfiles[$run]['boardfiles_id'];
        cs_sql_delete(__FILE__,'boardfiles',$sql_id);
      }
      if($cs_boardfiles[$run]['boardfiles_id'] == '')
      {
        $thread_time = cs_time();
        $files_cells = array('users_id','threads_id','boardfiles_time','boardfiles_name');
        $files_save = array($cs_boardfiles[$run]['users_id'],$thread_id,$thread_time,$cs_boardfiles[$run]['boardfiles_name']);
//        $files_cells = array_keys($cs_boardfiles[$run]);
//        $files_save = array_values($cs_boardfiles[$run]);
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
    # Update board entry to get correct threads and comments count
    include_once('mods/board/repair.php');
    cs_board_threads($cs_thread['board_id']);
    cs_redirect($cs_lang['changes_done'],'board','thread','action=thread&where=' .$thread_id);
  }
  else {
    echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'leftc');
    echo cs_icon('important');
    echo $cs_lang['error_occurred'];
    echo ' - ';
    echo cs_secure ($thread_error).' '.$cs_lang['error_count'];
    echo cs_html_br(1);
    echo $message;
    echo cs_html_roco(0);
    echo cs_html_table(0);
    echo cs_html_br(1);
  }
}

if(isset($_POST['preview'])) {
  if(empty($thread_error)) {

     echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'headb');
    echo $cs_lang['preview'];
    echo cs_html_roco(1,'leftc');
    echo cs_secure($thread_text,1,1);
    echo cs_html_roco(0);
    echo cs_html_table(0);
    echo cs_html_br(1);
  }
else {
    echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'leftc');
    echo cs_icon('important');
    echo $cs_lang['error_occurred'];
    echo ' - ';
    echo cs_secure ($thread_error).' '.$cs_lang['error_count'];
    echo cs_html_br(1);
    echo $message;
    echo cs_html_roco(0);
    echo cs_html_table(0);
    echo cs_html_br(1);
  }
}

if(!empty($thread_form)) {

  echo cs_html_form (1,'thread_create','board','thread_edit',1);
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'leftc');
  echo cs_icon('kedit') . $cs_lang['headline']. ' *';
  echo cs_html_roco(2,'leftb');
  echo cs_html_input('thread_headline',$thread_headline,'text',200,50);
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('kate') . $cs_lang['text']. ' *';
    echo cs_html_br(2);
    echo cs_abcode_smileys('thread_text');
  echo cs_html_br(2);
  echo 'max. ' . $max_text . $cs_lang['indi'];

  echo cs_html_roco(2,'leftb');
  echo cs_abcode_features('thread_text');
  echo cs_html_textarea('thread_text',$thread_text,'50','20');
  echo cs_html_roco(0);

  $run_loop_files = !empty($run_loop_files) ? $run_loop_files : 1;
  if($files == 1)
  {
    echo cs_html_roco(1,'headb',0,2);
    echo $cs_lang['uploads'];
    echo cs_html_roco(0);
    for($run=0; $run < $run_loop_files; $run++)
    {
        $num = $run + 1;
        $cs_files["text_$num"] = isset($_POST["text_$num"]) ? $_POST["text_$num"] : '';
      echo cs_html_roco(1,'leftc');
      echo cs_icon('download') . $cs_lang['file'] . ' ' . $num;
      echo cs_html_roco(2,'leftb');
      if(empty($cs_boardfiles[$run]['boardfiles_name']) OR !empty($file_error[$num]))
      {
        echo cs_html_input("file_$num",'','file');
        $matches[1] = $cs_lang['infos'];
        $return_types = '';
        foreach($filetypes AS $add)
        {
          $return_types .= empty($return_types) ? $add : ', ' . $add;
        }
        $matches[2] = $cs_lang['max_size'] . cs_filesize($max_size) . cs_html_br(1);
        $matches[2] .= $cs_lang['filetypes'] . ': ' . $return_types;
        echo ' ' . cs_abcode_clip($matches);
      }
      else
      {
        if(empty($_POST)) {
          $file_x = $cs_boardfiles[$run]['boardfiles_name'];
          $ext = substr($file_x,strlen($file_x)+1-strlen(strrchr($file_x,'.')));
          $file_upload_name[$run] = $cs_boardfiles[$run]['boardfiles_id'] . '.' . $ext;
        }
        echo cs_html_vote("file_id_$num",$cs_boardfiles[$run]['boardfiles_id'],'hidden');
        echo cs_html_vote("file_user_$num",$cs_boardfiles[$run]['users_id'],'hidden');
        echo cs_html_vote("file_name_$num",$cs_boardfiles[$run]['boardfiles_name'],'hidden');
        echo cs_html_vote("file_upload_name_$num",$file_upload_name[$run],'hidden');
        echo cs_html_vote("file_del_$num",$cs_boardfiles[$run]['boardfiles_del'],'hidden');
        $file = $cs_boardfiles[$run]['boardfiles_name'];
        $extension = strlen(strrchr($file,"."));
        $name = strlen($file);
        $ext = substr($file,$name - $extension + 1,$name);
        if($ext == 'JPG' OR $ext == 'jpg' OR $ext == 'JPEG' OR $ext == 'jpeg' OR $ext == 'png' OR $ext == 'PNG' OR $ext == 'gif' OR $ext == 'GIF')
        {
          $cs_lap = cs_html_img('mods/gallery/image.php?boardpic=' . $file . '&boardthumb');
          echo cs_html_div(1,'float:left;padding:3px;border:1px solid black;background:gainsboro;');
          echo cs_html_link('mods/gallery/image.php?boardpic=' . $file,$cs_lap);
          echo cs_html_div(0);
          echo cs_html_div(1,'float:left;padding:3px;margin-left:10px;');
          echo cs_html_img('symbols/files/filetypes/' . $ext . '.gif',0,0,0,$ext);
          echo ' ' . $file;
          if($cs_boardfiles[$run]['boardfiles_del'] == '0')
          {
            echo cs_html_vote('remove_file_' . $num,$cs_lang['remove'],'submit');
          }
          elseif($cs_boardfiles[$run]['boardfiles_del'] == '1')
          {
            echo ' - ' . $cs_lang['file_del'];
          }
          echo cs_html_div(0);
        }
        else
        {
          echo cs_html_div(1,'float:left;padding:3px;margin-left:0px;');
          echo cs_html_img('symbols/files/filetypes/' . $ext . '.gif',0,0,0,$ext);
          echo ' ' . $cs_boardfiles[$run]['boardfiles_name'];

          if($cs_boardfiles[$run]['boardfiles_del'] == '0')
          {
            echo cs_html_vote('remove_file_' . $num,$cs_lang['remove'],'submit');
          }
          elseif($cs_boardfiles[$run]['boardfiles_del'] == '1')
          {
            echo ' - ' . $cs_lang['file_del'];
          }
          echo cs_html_div(0);
        }
      }
      echo cs_html_roco(0);
    }
  }

  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options+'];
  echo cs_html_roco(2,'leftb');
  if($files == '1' AND $account['access_board'] >= '2')
  {
      echo cs_html_vote('run_loop_files',$run_loop_files,'hidden');
    echo cs_html_vote('files','1','hidden');
    echo cs_html_vote('files+',$cs_lang['add_file'],'submit');
  }
  if($files == '0' AND $account['access_board'] >= '2')
  {
    echo cs_html_vote('new_file',$cs_lang['add_file'],'submit');
  }
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftc');
  echo cs_icon('ksysguard') . $cs_lang['options'];
  echo cs_html_roco(2,'leftb');
  echo cs_html_vote('id',$thread_id,'hidden');
  echo cs_html_vote('submit',$cs_lang['editbutton'],'submit');
  echo cs_html_vote('preview',$cs_lang['preview'],'submit');
  echo cs_html_vote('reset',$cs_lang['reset'],'reset');
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_form (0);
}
?>